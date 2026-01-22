<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\CompteRenduBlocOperatoire;
use App\Models\Ordonance;
use App\Models\Prescription;
use App\Models\Devi;
use App\Models\LigneDevi;
use App\Models\FicheIntervention;
use App\Models\Dossier;
use App\Services\PdfService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrintPreviewController extends Controller
{
    /**
     * Show document preview with CKEditor
     */
    
    public function show(Request $request, $type, $id)
    {
        try {
            $documentData = $this->getDocumentData($type, $id, $request->all());
            $filename = $metadata['filename'] ?? null;
            if (!$documentData) {
                return redirect()->back()
                    ->with('error', 'Type de document non reconnu');
            }

            // Render the blade template to HTML
            $html = View::make($documentData['view'], $documentData['data'])->render();
            
            // Extract and separate styles from content
            $processedContent = $this->extractStyles($html);

            return view('admin.print-preview.editor', [
                'content' => $processedContent['content'],
                'styles' => $processedContent['styles'],
                'links' => $processedContent['links'],
                'title' => $documentData['title'],
                'type' => $type,
                'id' => $id,
                'metadata' => $documentData['metadata']
            ]);

        } catch (\Exception $e) {
            Log::error('Print Preview Error', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Erreur lors du chargement du document: ' . $e->getMessage());
        }
    }

    /**
     * Extract styles from HTML content and return separately
     */
    
    private function extractStyles($html)
    {
        $styles = '';
        $content = $html;
        $links = '';

        // 1. Extract raw <style> tags
        if (preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $matches)) {
            foreach ($matches[1] as $styleContent) {
                $styles .= $styleContent . "\n";
            }
            $content = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $content);
        }

        // 2. Extract HTML-encoded style blocks
        if (preg_match_all('/&lt;style[^&]*&gt;(.*?)&lt;\/style&gt;/is', $content, $encodedMatches)) {
            foreach ($encodedMatches[1] as $encodedStyle) {
                $styles .= html_entity_decode($encodedStyle, ENT_QUOTES | ENT_HTML5, 'UTF-8') . "\n";
            }
            $content = preg_replace('/&lt;style[^&]*&gt;.*?&lt;\/style&gt;/is', '', $content);
        }

        // 3. Extract <link> stylesheet tags and READ their content
        if (preg_match_all('/<link[^>]*rel=["\']stylesheet["\'][^>]*href=["\']([^"\']+)["\'][^>]*>/i', $html, $linkMatches)) {
            foreach ($linkMatches[1] as $cssPath) {
                $styles .= $this->readCssFile($cssPath) . "\n";
            }
        }

        // 4. Extract HTML-encoded link tags and READ their content
        if (preg_match_all('/&lt;link[^&]*rel=["\']stylesheet["\'][^&]*href=["\']([^"\']+)["\'][^&]*&gt;/i', $content, $encodedLinkMatches)) {
            foreach ($encodedLinkMatches[1] as $cssPath) {
                $decodedPath = html_entity_decode($cssPath, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $styles .= $this->readCssFile($decodedPath) . "\n";
            }
        }

        // Remove all stylesheet links from content
        $content = preg_replace('/<link[^>]*rel=["\']stylesheet["\'][^>]*>/i', '', $content);
        $content = preg_replace('/&lt;link[^&]*rel=["\']stylesheet["\'][^&]*&gt;/i', '', $content);

        return [
            'styles' => $styles,
            'links' => '',
            'content' => $content
        ];
    }

    /**
     * Read CSS file content
     */

    private function readCssFile($cssPath)
    {
        try {
            $cssPath = preg_replace('/\{\{.*?public_path\(["\']([^"\']+)["\']\).*?\}\}/', '$1', $cssPath);
            $cssPath = preg_replace('/\{\{.*?asset\(["\']([^"\']+)["\']\).*?\}\}/', '$1', $cssPath);
            $cssPath = trim($cssPath, " '\"\t\n\r\0\x0B");
            
            $possiblePaths = [
                public_path($cssPath),
                public_path('/' . ltrim($cssPath, '/')),
                base_path($cssPath),
                base_path('/' . ltrim($cssPath, '/')),
            ];
            
            foreach ($possiblePaths as $path) {
                if (file_exists($path) && is_readable($path)) {
                    return file_get_contents($path);
                }
            }
            
            Log::warning("CSS file not found: {$cssPath}");
            return "/* CSS file not found: {$cssPath} */\n";
            
        } catch (\Exception $e) {
            Log::error("Error reading CSS file: {$cssPath}", ['error' => $e->getMessage()]);
            return "/* Error loading CSS: {$cssPath} */\n";
        }
    }



    /**
     * Save edited content to session and database
     */
    public function save(Request $request, $type, $id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
    
        try {
            $content = $request->input('content');
            
            // Store in session temporarily
            $sessionKey = "edited_doc_{$type}_{$id}_" . Auth::id();
            session([$sessionKey => $content]);

            // Persist to database
            $this->persistEditedContent($type, $id, $content);

            // **NEW: Clear session after successful DB save**
            session()->forget($sessionKey);

            return response()->json([
                'success' => true,
                'message' => 'Document enregistré avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Document Save Error', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Erreur lors de la sauvegarde: ' + $e->getMessage()
            ], 500);
        }
    }



    
    /**
     * Persist edited content to database
     */
    private function persistEditedContent($type, $id, $htmlContent)
    {
        $extractedData = $this->extractEditableFieldsFromHtml($htmlContent, $type);

        DB::transaction(function () use ($type, $id, $extractedData) {
            switch ($type) {
                case 'ordonance':
                    $this->updateOrdonance($id, $extractedData);
                    break;

                case 'prescription':
                    $this->updatePrescription($id, $extractedData);
                    break;

                case 'crbo':
                    $this->updateCRBO($id, $extractedData);
                    break;

                case 'lettre':
                    $this->updateConsultation($id, $extractedData);
                    break;

                case 'fiche_intervention':
                    $this->updateFicheIntervention($id, $extractedData);
                    break;
            }
        });

        // Force clear all caches
        $this->clearRelatedCache($type, $id);
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
    }


    /**
     * Extract editable fields from HTML content
     */
    private function extractEditableFieldsFromHtml($html, $type)
    {
        // Remove HTML tags to get plain text
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $extracted = [];

        switch ($type) {
            case 'ordonance':
                $extracted = $this->extractOrdonanceData($dom);
                break;

            case 'prescription':
                $extracted = $this->extractPrescriptionData($dom);
                break;

            case 'crbo':
                $extracted = $this->extractCRBOData($dom);
                break;

            case 'lettre':
                $extracted = $this->extractLettreData($dom);
                break;

            case 'fiche_intervention':
                $extracted = $this->extractFicheInterventionData($dom);
                break;
        }

        return $extracted;
    }


    /**
     * Extract ordonance data from HTML table
     */
    private function extractOrdonanceData($dom)
    {
        $medicaments = [];
        $quantites = [];
        $descriptions = [];

        $xpath = new \DOMXPath($dom);
        
        // Target tbody rows specifically
        $rows = $xpath->query("//table[@class='ordonance-table']//tbody/tr");
        
        // Fallback if no tbody
        if ($rows->length === 0) {
            $rows = $xpath->query("//table//tbody/tr | //table//tr[position() > 1]");
        }

        foreach ($rows as $row) {
            $cells = $row->getElementsByTagName('td');
            if ($cells->length >= 4) {
                // Skip header rows
                if (strtolower(trim($cells->item(0)->textContent)) === 'sn') {
                    continue;
                }
                
                $medicaments[] = trim($cells->item(1)->textContent);
                $quantites[] = trim($cells->item(2)->textContent);
                $descriptions[] = trim($cells->item(3)->textContent);
            }
        }

        return [
            'medicament' => implode(',', array_filter($medicaments)),
            'quantite' => implode(',', array_filter($quantites)),
            'description' => implode(',', array_filter($descriptions))
        ];
    }


     /**
     * Extract prescription data from HTML
     */
    private function extractPrescriptionData($dom)
    {
        $xpath = new \DOMXPath($dom);
        $data = [];

        $fields = [
            'hematologie', 'hemostase', 'biochimie', 'hormonologie',
            'marqueurs', 'bacteriologie', 'spermiologie', 'urines',
            'serologie', 'examen'
        ];

        foreach ($fields as $field) {
            // Look for h5 headers followed by content
            $nodes = $xpath->query("//p[contains(translate(., 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '{$field}')] | //h5[contains(translate(., 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '{$field}')]/following-sibling::text()[1]");
            
            if ($nodes->length > 0) {
                $text = trim($nodes->item(0)->textContent);
                $data[$field] = $text;
            }
        }

        return $data;
    }


    /**
     * Extract CRBO data from HTML
     */
    private function extractCRBOData($dom)
    {
        $xpath = new \DOMXPath($dom);
        $data = [];

        $sections = [
            'TYPE D\'INTERVENTION' => 'type_intervention',  // ADD THIS
            'INDICATIONS OPERATOIRES' => 'indication_operatoire',
            'COMPTE-RENDU OPERATOIRE' => 'compte_rendu_o',
            'SUITES OPERATOIRES' => 'suite_operatoire',
            'CONCLUSIONS' => 'conclusion',
            'PROPOSITION DE SUIVI' => 'proposition_suivi'
        ];

        foreach ($sections as $title => $field) {
            $nodes = $xpath->query("//h6[contains(text(), '{$title}')]/following-sibling::div[1]//p");
            
            if ($nodes->length > 0) {
                $paragraphs = [];
                foreach ($nodes as $p) {
                    $text = trim($p->textContent);
                    if (!empty($text)) {
                        $paragraphs[] = $text;
                    }
                }
                $data[$field] = implode("\n", $paragraphs);
            }
        }

        return $data;
    }

    /**
     * Extract lettre (consultation) data from HTML
     */
    private function extractLettreData($dom)
    {
        $xpath = new \DOMXPath($dom);
        $data = [];

        // Standard sections
        $sections = [
            'MOTIF DE CONSULTATION' => 'motif_c',
            'EXAMEN(S) COMPLEMENTAIRE(S)' => 'examen_c',
            'PROPOSITION THERAPEUTIQUE' => 'proposition_therapeutique',
            'DIAGNOSTIC' => 'diagnostic'
        ];

        foreach ($sections as $title => $field) {
            $nodes = $xpath->query("//p/span[contains(text(), '{$title}')]/parent::p | //p[contains(., '{$title}')]");
            
            if ($nodes->length > 0) {
                $text = trim($nodes->item(0)->textContent);
                $text = preg_replace('/^.*?' . preg_quote($title, '/') . '\s*:?\s*/i', '', $text);
                $data[$field] = trim($text);
            }
        }

        // Extract antecedents (special handling)
        $antecedentNodes = $xpath->query("//p[contains(., 'Signalons') and contains(., 'antécédents')]");
        if ($antecedentNodes->length > 0) {
            $text = trim($antecedentNodes->item(0)->textContent);
            // Remove the introductory text "Signalons également les antécédents suivants :"
            $text = preg_replace('/^.*?antécédents\s+suivants\s*:?\s*/i', '', $text);
            $data['antecedent_m'] = trim($text);
        }

        return $data;
    }



    /**
     * Extract fiche intervention data from HTML
     */
    private function extractFicheInterventionData($dom)
    {
        $xpath = new \DOMXPath($dom);
        $data = [];

        // Map of field labels to database columns
        $fieldMappings = [
            'Type d\'intervention' => 'type_intervention',
            'Durée intervention' => 'dure_intervention',
            'Position du patient' => 'position_patient',
            'Date intervention' => 'date_intervention',
            'Médecin' => 'medecin',
            'Aide opératoire' => 'aide_op',
            'Hospitalisation' => 'hospitalisation',
            'Ambulatoire' => 'ambulatoire',
            'Anesthésie' => 'anesthesie',
            'Recommandation' => 'recommendation',
            'Décubitus' => 'decubitus',
            'Latérale' => 'laterale',
            'Lombotomie' => 'lombotomie'
        ];

        // Extract from all table cells
        $cells = $xpath->query("//td | //p | //div");
        
        foreach ($cells as $cell) {
            $text = trim($cell->textContent);
            
            foreach ($fieldMappings as $label => $field) {
                if (stripos($text, $label) !== false) {
                    // Extract value after the label
                    $value = preg_replace('/^.*?' . preg_quote($label, '/') . '\s*:?\s*/i', '', $text);
                    $value = trim($value);
                    
                    if (!empty($value) && $value !== $label) {
                        $data[$field] = $value;
                    }
                }
            }
        }

        return $data;
    }


     /**
     * Update Ordonance in database
     */
    private function updateOrdonance($id, $data)
    {
        $ordonance = Ordonance::findOrFail($id);
        
        $ordonance->update([
            'medicament' => $data['medicament'] ?? $ordonance->medicament,
            'quantite' => $data['quantite'] ?? $ordonance->quantite,
            'description' => $data['description'] ?? $ordonance->description,
        ]);

        // ** Force view cache clear**
        \Artisan::call('view:clear');

        Log::info("Ordonance {$id} updated from editor", ['data' => $data]);
    }

    /**
     * Update Prescription in database
     */
    private function updatePrescription($id, $data)
    {
        $prescription = Prescription::findOrFail($id);
        
        $updateData = [];
        $fields = [
            'hematologie', 'hemostase', 'biochimie', 'hormonologie',
            'marqueurs', 'bacteriologie', 'spermiologie', 'urines',
            'serologie', 'examen'
        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $prescription->update($updateData);

             // ** Force view cache clear**
            \Artisan::call('view:clear');

            Log::info("Prescription {$id} updated from editor", ['data' => $updateData]);
        }
    }

    /**
     * Update CRBO in database
     */
    private function updateCRBO($id, $data)
    {
        $patientId = request()->input('patient_id') ?? session("crbo_{$id}_patient_id");
    
        if (!$patientId) {
            \Artisan::call('view:clear');
            Log::warning("Cannot update CRBO {$id}: patient_id not found");
            return;
        }

        // Update CRBO fields
        $crbo = CompteRenduBlocOperatoire::where('patient_id', $patientId)
            ->latest()
            ->firstOrFail();

        $crboFields = array_intersect_key($data, array_flip([
            'indication_operatoire', 'compte_rendu_o', 'suite_operatoire',
            'conclusion', 'proposition_suivi'
        ]));

        if (!empty($crboFields)) {
            $crbo->update($crboFields);
        }

        // Update type_intervention in Consultation table
        if (isset($data['type_intervention'])) {
            $consultation = Consultation::where('patient_id', $patientId)
                ->latest()
                ->first();
            
            if ($consultation) {
                $consultation->update(['type_intervention' => $data['type_intervention']]);
            }
        }

        // Clear cache
        Cache::forget("crbo_patient_{$patientId}");
        Cache::tags(['patients', 'consultations'])->flush();
        \Artisan::call('view:clear');

        Log::info("CRBO updated from editor", ['patient_id' => $patientId, 'data' => $data]);
        
    }

    /**
     * Update Consultation in database
     */
    private function updateConsultation($id, $data)
    {
        $patientId = $id; // For lettre, id is patient_id
        
        $consultation = Consultation::where('patient_id', $patientId)
            ->latest()
            ->firstOrFail();

        $consultation->update(array_filter($data));
        
         // ** Force view cache clear**
        \Artisan::call('view:clear');

        Log::info("Consultation updated from editor", ['patient_id' => $patientId, 'data' => $data]);
    }

    /**
     * Update Fiche Intervention in database
     */
    private function updateFicheIntervention($id, $data)
    {
        $fiche = FicheIntervention::findOrFail($id);
    
        // Filter out empty values
        $updateData = array_filter($data, function($value) {
            return !empty($value);
        });
        
        if (!empty($updateData)) {
            $fiche->update($updateData);
            
            // Clear related cache
            Cache::forget("fiche_intervention_{$id}");
            Cache::tags(['patients'])->flush();
            \Artisan::call('view:clear');
            
            Log::info("Fiche Intervention {$id} updated from editor", ['data' => $updateData]);
        }
    }



    /**
     * Clear related cache after database update
     */
    private function clearRelatedCache($type, $id)
    {
        try {
            switch ($type) {
                case 'ordonance':
                    $ordonance = Ordonance::find($id);
                    if ($ordonance) {
                        \Cache::forget("ordonances_patient_{$ordonance->patient_id}_page_1");
                        \Cache::tags(['patients'])->flush();
                    }
                    break;

                case 'prescription':
                    $prescription = Prescription::find($id);
                    if ($prescription) {
                        \Cache::forget("prescriptions_patient_{$prescription->patient_id}_page_1");
                        \Cache::forget("prescription_{$id}");
                        \Cache::tags(['patients'])->flush();
                    }
                    break;

                case 'crbo':
                case 'lettre':
                    \Cache::tags(['patients', 'consultations'])->flush();
                    break;

                case 'fiche_intervention':
                    $fiche = FicheIntervention::find($id);
                    if ($fiche) {
                        \Cache::tags(['patients'])->flush();
                    }
                    break;
            }

            Log::info("Cache cleared for {$type} {$id}");
        } catch (\Exception $e) {
            Log::warning("Failed to clear cache for {$type} {$id}: {$e->getMessage()}");
        }
    }





    /**
     * Generate PDF from edited or original content
     */
    public function print(Request $request, $type, $id)
    {
        try {
            $orientation = $request->input('orientation', 'portrait');
            $format = $request->input('format', 'A4');
            $delivery = $request->input('delivery', 'stream');

            // Check if there's edited content in session
            // $sessionKey = "edited_doc_{$type}_{$id}_" . Auth::id();
            // $editedContent = session($sessionKey);

            $documentData = $this->getDocumentData($type, $id, $request->all());
            $metadata = $this->getDocumentMetadata($type, $id, $request->all());
            // if ($editedContent) {
            //     // Sanitize edited content
            //     $editedContent = $this->sanitizeEditedContent($editedContent);

            //     // Get original template
            //     $documentData = $this->getDocumentData($type, $id, $request->all());
            //     $originalHtml = View::make($documentData['view'], $documentData['data'])->render();

            //     // Extract styles
            //     $processedOriginal = $this->extractStyles($originalHtml);

            //     // Reconstruct HTML
            //     $fullHtml = $this->reconstructHtmlWithStyles($processedOriginal['styles'], $editedContent);
                
            //     return PdfService::generateFromHtml(
            //         $fullHtml,
            //         $metadata['filename'],
            //         $orientation,
            //         $format,
            //         $delivery
            //     );


            // } else {
            //     // Generate PDF from original template
            //     $documentData = $this->getDocumentData($type, $id, $request->all());

            //     return PdfService::generate(
            //         $documentData['view'],
            //         $documentData['data'],
            //         $metadata['filename'],
            //         $orientation,
            //         $format,
            //         $delivery
            //     );
            // }

            // Clear any output buffers
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Generate PDF from fresh Blade template
        return PdfService::generate(
            $documentData['view'],
            $documentData['data'],
            $metadata['filename'],
            $orientation,
            $format,
            $delivery
        );

        } catch (\Exception $e) {
            Log::error('Document Print Error', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Erreur lors de l\'impression du document');
        }
    }

    /**
     * Reconstruct HTML with styles properly embedded
     */
    // private static function reconstructHtmlWithStyles($styles, $content)
    private static function reconstructHtmlWithStyles($styles, $content)
    {
        $bootstrapPath = public_path('vendor/css/bootstrap.min.css');
        $bootstrapCss = is_file($bootstrapPath) ? @file_get_contents($bootstrapPath) : '';

        $html = '<!DOCTYPE html>
                <html lang="fr">
                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        <title>Document</title>
                        <style>
                        ' . $bootstrapCss . '
                        
                        ' . $styles . '
                        </style>
                    </head>
                    <body>
                        ' . $content . '
                    </body>
                </html>';

        return $html;
    }



    /**
     * Remove style/link tags from edited content so they don't render as text in PDF
     */
    private function sanitizeEditedContent($content)
    {
        $content = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $content);
        $content = preg_replace('/&lt;style[^&]*&gt;.*?&lt;\/style&gt;/is', '', $content);
        $content = preg_replace('/<link[^>]*rel=["\']stylesheet["\'][^>]*>/i', '', $content);
        $content = preg_replace('/&lt;link[^&]*rel=["\']stylesheet["\'][^&]*&gt;/i', '', $content);

        return $content;
    }

    /**
     * Get document data for rendering
     */
    private function getDocumentData($type, $id, $requestParams = [])
    {
        switch ($type) {
            case 'lettre':
                $patientId = $requestParams['patient_id'] ?? $id;
                $patient = Patient::with(['consultations' => function($q) {
                    $q->with('user')->latest()->limit(1);
                }])->findOrFail($patientId);
                
                $consultation = $patient->consultations->first();
                $dossier = $patient->dossiers()->latest()->first();

                // Store patient_id in session for later use
                session(["lettre_{$id}_patient_id" => $patientId]);

                return [
                    'view' => 'admin.etats.lettre',
                    'data' => [
                        'patient' => $patient,
                        'consultations' => $consultation,
                        'dossier' => $dossier
                    ],
                    'title' => "Lettre de Consultation - {$patient->name}",
                    'metadata' => [
                        'patient_id' => $patient->id,
                        'numero_dossier' => $patient->numero_dossier
                    ]
                ];

            case 'crbo':
                $patientId = $requestParams['patient_id'] ?? $id;
                $patient = Patient::findOrFail($patientId);
                $crbo = CompteRenduBlocOperatoire::where('patient_id', $patientId)
                    ->latest()
                    ->firstOrFail();
                $consultation = Consultation::where('patient_id', $patientId)
                    ->latest()
                    ->first();

                // Store patient_id for updates
                session(["crbo_{$id}_patient_id" => $patientId]);

                return [
                    'view' => 'admin.etats.crbo',
                    'data' => [
                        'patient' => $patient,
                        'crbo' => $crbo,
                        'consultations' => $consultation
                    ],
                    'title' => "Compte Rendu Opératoire - {$patient->name}",
                    'metadata' => [
                        'patient_id' => $patient->id,
                        'numero_dossier' => $patient->numero_dossier
                    ]
                ];

            case 'ordonance':
                $ordonance = Ordonance::with(['patient', 'user'])
                    ->findOrFail($id);

                return [
                    'view' => 'admin.etats.ordonance',
                    'data' => [
                        'ordonance' => $ordonance,
                        'patient' => $ordonance->patient,
                        'user' => $ordonance->user
                    ],
                    'title' => "Ordonnance - {$ordonance->patient->name}",
                    'metadata' => [
                        'patient_id' => $ordonance->patient_id,
                        'numero_dossier' => $ordonance->patient->numero_dossier
                    ]
                ];

            case 'prescription':
                $prescription = Prescription::with(['patient', 'user'])
                    ->findOrFail($id);

                return [
                    'view' => 'admin.etats.prescriptions',
                    'data' => [
                        'prescription' => $prescription
                    ],
                    'title' => "Prescription - {$prescription->patient->name}",
                    'metadata' => [
                        'patient_id' => $prescription->patient_id,
                        'numero_dossier' => $prescription->patient->numero_dossier
                    ]
                ];

            case 'devis':
                $sessionKey = "devis_preview_{$id}";
                $devisData = session($sessionKey);
                
                if (!$devisData) {
                    throw new \Exception('Données du devis manquantes ou expirées');
                }

                return $this->buildDevisData($devisData);

            case 'fiche_intervention':
                $fiche = FicheIntervention::with(['patient', 'user'])
                    ->findOrFail($id);

                return [
                    'view' => 'admin.etats.fiche_intervention',
                    'data' => [
                        'fiche_intervention' => $fiche
                    ],
                    'title' => "Fiche Intervention - {$fiche->patient->numero_dossier}",
                    'metadata' => [
                        'patient_id' => $fiche->patient_id,
                        'numero_dossier' => $fiche->patient->numero_dossier
                    ]
                ];

            case 'consentement':
                $patientId = $requestParams['patient_id'] ?? $id;
                $patient = Patient::with([
                    'dossiers' => fn($q) => $q->latest()->limit(1),
                    'fiche_interventions' => fn($q) => $q->latest()->limit(1),
                    'consultation_anesthesistes' => fn($q) => $q->latest()->limit(1)
                ])->findOrFail($patientId);

                return [
                    'view' => 'admin.etats.consentement_eclaire',
                    'data' => [
                        'patient' => $patient,
                        'dossier' => $patient->dossiers->first(),
                        'fiche_intervention' => $patient->fiche_interventions->first(),
                        'consultation_anesthesiste' => $patient->consultation_anesthesistes->first()
                    ],
                    'title' => "Consentement Éclairé - {$patient->name}",
                    'metadata' => [
                        'patient_id' => $patient->id,
                        'numero_dossier' => $patient->numero_dossier
                    ]
                ];

            default:
                return null;
        }
    }

    /**
     * Build devis data from request parameters
     */
    private function buildDevisData($params)
    {
        if (!isset($params['nom_devis']) || !isset($params['ligneDevi'])) {
            throw new \Exception('Données du devis manquantes');
        }

        $prixChambre = ($params['nbr_chambre'] ?? 0) * ($params['pu_chambre'] ?? 0);
        $prixVisite = ($params['nbr_visite'] ?? 0) * ($params['pu_visite'] ?? 0);
        $prixAmiJour = ($params['nbr_ami_jour'] ?? 0) * ($params['pu_ami_jour'] ?? 0);
        $total2 = $prixChambre + $prixVisite + $prixAmiJour;

        $total1 = 0;
        $ligneDevis = [];

        foreach ($params['ligneDevi'] as $ligne) {
            $prixTotal = $ligne["prix_u"] * $ligne["quantite"];
            $total1 += $prixTotal;

            $ligneDevis[] = new LigneDevi([
                'element' => $ligne["element"],
                'quantite' => $ligne["quantite"],
                'prix_u' => $ligne["prix_u"],
                'prix' => $prixTotal,
            ]);
        }

        $devis = new Devi([
            'nom' => $params['nom_devis'],
            'nbr_chambre' => $params['nbr_chambre'] ?? 0,
            'nbr_visite' => $params['nbr_visite'] ?? 0,
            'nbr_ami_jour' => $params['nbr_ami_jour'] ?? 0,
            'pu_chambre' => $params['pu_chambre'] ?? 0,
            'pu_visite' => $params['pu_visite'] ?? 0,
            'pu_ami_jour' => $params['pu_ami_jour'] ?? 0,
            'code' => $params['code_devis'] ?? now()->format('Y-m-d') . '/' . substr($params['nom_devis'], 0, 4),
            'user_id' => Auth::id(),
        ]);

        $devis->total1 = $total1;
        $devis->total2 = $total2;
        $devis->total = $params['montant_en_lettre'] ?? '';

        return [
            'view' => 'admin.etats.devis',
            'data' => [
                'devis' => $devis,
                'ligneDevis' => $ligneDevis,
                'nomPatient' => $params['patient'] ?? '',
                'currentDate' => now()->locale('fr_FR')->isoFormat('DD MMMM YYYY'),
            ],
            'title' => "Devis - {$devis->nom}",
            'metadata' => [
                'code' => $devis->code
            ]
        ];
    }

    /**
     * Get document metadata for PDF generation
     */
    private function getDocumentMetadata($type, $id, $requestParams = [])
    {
        switch ($type) {
            case 'lettre':
                $patientId = $requestParams['patient_id'] ?? $id;
                $patient = Patient::findOrFail($patientId);
                return [
                    'filename' => PdfService::generatePatientFilename('lettre_consultation', $patient)
                ];

            case 'crbo':
                $patientId = $requestParams['patient_id'] ?? $id;
                $patient = Patient::findOrFail($patientId);
                return [
                    'filename' => PdfService::generatePatientFilename('crbo', $patient)
                ];

            case 'ordonance':
                $ordonance = Ordonance::with('patient')->findOrFail($id);
                return [
                    'filename' => PdfService::generatePatientFilename('ordonance', $ordonance->patient, $id)
                ];

            case 'prescription':
                $prescription = Prescription::with('patient')->findOrFail($id);
                return [
                    'filename' => PdfService::generatePatientFilename('prescription', $prescription->patient, $id)
                ];

            case 'fiche_intervention':
                $fiche = FicheIntervention::with('patient')->findOrFail($id);
                return [
                    'filename' => PdfService::generatePatientFilename('fiche_intervention', $fiche->patient)
                ];

            case 'consentement':
                $patientId = $requestParams['patient_id'] ?? $id;
                $patient = Patient::findOrFail($patientId);
                return [
                    'filename' => PdfService::generatePatientFilename('consentement_eclaire', $patient)
                ];

            case 'devis':
                // Devis doesn't have patient, keep original logic
                $code = $requestParams['code_devis'] ?? 'devis';
                return [
                    'filename' => "devis_" . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $code) . ".pdf"
                ];

            default:
                return ['filename' => "document_{$id}.pdf"];
        }
    }
}









































































