<?php

namespace App\Services;

use ZanySoft\LaravelPDF\Facades\PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate PDF with standardized error handling (ZanySoft compatible)
     */
    public static function generate(
        $view, 
        $data, 
        $filename = null, 
        $orientation = 'portrait', 
        $format = 'A4', 
        $delivery = 'stream',
        $printOptions = []
    ) {
        try {
            $config = [
                'format' => $format,
                'orientation' => $orientation === 'landscape' ? 'L' : 'P',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 15,
                'margin_bottom' => 15,
                'margin_header' => 5,
                'margin_footer' => 5,
                'default_font_size' => 11,
                'default_font' => 'dejavusans',
                'mode' => 's',
                'allow_remote' => true,
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            ];

            $pdf = PDF::loadView($view, $data, [], $config);
            
            // ADD HEADER GLOBALLY


            // Add:
            $isConsultationInvoice = in_array($view, [
                'admin.etats.consultation',
                'admin.etats.consultation_double_horizontal',
                'admin.etats.consultation_double_vertical'
            ]);

            if (!$isConsultationInvoice) {
                $pdf->SetHTMLHeader('
                <table width="100%" style="font-family: dejavusans; font-size: 10px;">
                    <tr>
                        <td width="20%" style="vertical-align:top;">
                            <img src="' . url("admin/images/logo.jpg") . '" style="width:80px; height:auto;" alt="Logo">
                        </td>
                        <td width="80%" style="text-align:right; vertical-align:top;">
                            <div style="font-weight:bold;">CENTRE MEDICO-CHIRURGICAL D\'UROLOGIE</div>
                            <div>007/10/D/ONMC</div>
                            <div>VALLEE MANGA BELL DOUALA-BALI</div>
                            <div>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</div>
                            <div>www.cmcu-cm.com / cmcu_cmcu@yahoo.fr</div>
                        </td>
                    </tr>
                </table>
                <hr style="border-top:2px solid #4463dc; margin:4px 0;">
                ');
            }


            // CHANGED: call SetHTMLFooter directly on $pdf (ZanySoft forwards to mPDF)
            $pdf->SetHTMLFooter('
                <div style="text-align:center; font-size:10px;">
                    Centre Medico-chirurgical d\'urologie situé à la Vallée Douala Manga Bell Douala-Bali.<br>
                    TEL: (+237) 233 423 389 / 674 068 988 / 698 873 945<br>
                    www.cmcu-cm.com
                </div>
            ');
            $binary = $pdf->output();
            // $safeName = $filename ?: 'document.pdf';
            $safeName = self::normalizeFilename($filename);


            // Choose delivery method
            switch (strtolower($delivery)) {
                case 'download':
                    return response($binary, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $safeName . '"'
                    ]);
                case 'print':
                    return self::renderPrintHtml($binary, $safeName, $printOptions);
                case 'stream':
                default:
                    return response($binary, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $safeName . '"'
                    ]);
            }
        } catch (\Exception $e) {
            Log::error("PDF generation failed for view: {$view}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception("Erreur lors de la génération du PDF: " . $e->getMessage());
        }
    }

    /**
     * Generate PDF directly from HTML content (for edited documents)
     * This method properly handles style tags and ensures they're applied
     */
    public static function generateFromHtml($html, $filename = 'document.pdf', $orientation = 'portrait', $format = 'A4', $delivery = 'stream')
    {
        try {
            $config = [
                'format' => $format,
                'orientation' => $orientation === 'landscape' ? 'L' : 'P',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 15,
                'margin_bottom' => 15,
                'margin_header' => 5,
                'margin_footer' => 5,
                'default_font_size' => 11,
                'default_font' => 'dejavusans',
                'mode' => 'utf-8',
                'allow_remote' => false,
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            ];

            // Clean the HTML to ensure proper structure
            $cleanedHtml = self::ensureProperHtmlStructure($html);
            $cleanedHtml = self::cleanHtmlForPdf($cleanedHtml);
            
            // Generate PDF from HTML
            $pdf = PDF::loadHTML($cleanedHtml, $config);

            
            // <<< Add same footer as 'generate' to keep consistency >>>
            $pdf->SetHTMLFooter('
                <div style="text-align:center; font-size:10px;">
                    Centre Medico-chirurgical d\'urologie situé à la Vallée Douala Manga Bell Douala-Bali.<br>
                    TEL: (+237) 233 423 389 / 674 068 988 / 698 873 945<br>
                    www.cmcu-cm.com
                </div>
            ');

            $binary = $pdf->output();
            // $safeName = $filename ?: 'document.pdf';
            $safeName = self::normalizeFilename($filename);


            switch (strtolower($delivery)) {
                case 'download':
                    return response($binary, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $safeName . '"'
                    ]);
                case 'print':
                    return self::renderPrintHtml($binary, $safeName, ['autoPrint' => true]);
                case 'stream':
                default:
                    return response($binary, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $safeName . '"'
                    ]);
            }
        } catch (\Exception $e) {
            Log::error("PDF generation from HTML failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'html_length' => strlen($html)
            ]);
            throw new \Exception("Erreur lors de la génération du PDF: " . $e->getMessage());
        }
    }

    /**
     * Ensure HTML has proper structure with DOCTYPE, html, head, and body tags
     */
    private static function ensureProperHtmlStructure($html)
    {
        // Check if HTML already has DOCTYPE and structure
        if (stripos($html, '<!DOCTYPE') !== false && stripos($html, '<html') !== false) {
            return $html;
        }

        // If it's a fragment, wrap it properly
        $wrappedHtml = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
</head>
<body>
    ' . $html . '
</body>
</html>';
        
        return $wrappedHtml;
    }

    /**
     * Generate invoice with specific layout options
     */
    public static function generateInvoice($invoice, $layout = 'double-vertical', $autoPrint = false)
    {
        $viewMap = [
            'single' => 'admin.etats.consultation',
            'double-horizontal' => 'admin.etats.consultation_double_horizontal',
            'double-vertical' => 'admin.etats.consultation_double_vertical',
        ];

        $view = $viewMap[$layout] ?? $viewMap['double-vertical'];

        $data = [
            'patient' => $invoice->patient,
            'facture' => $invoice
        ];

        $printOptions = [
            'autoPrint' => $autoPrint,
            'layout' => $layout
        ];

        return self::generate(
            $view,
            $data,
            "facture_{$invoice->numero}.pdf",
            'portrait',
            'A4',
            'stream',
            $printOptions
        );
    }
 
    /**
     * Generate PDF for heavy reports (use queue)
     */
    public static function generateQueued($view, $data, $filename, $orientation = 'portrait', $format = 'A4')
    {
        try {
            \App\Jobs\DownloadPdf::dispatch($view, $data, $filename, $orientation, $format);
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to queue PDF generation: {$filename}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Clean up old PDF files
     */
    public static function cleanupOldFiles($hoursOld = 24)
    {
        try {
            $deletedCount = 0;
            
            if (!Storage::exists('pdfs')) {
                return 0;
            }

            $files = Storage::files('pdfs');

            foreach ($files as $file) {
                $lastModified = Storage::lastModified($file);
                if (\Carbon\Carbon::createFromTimestamp($lastModified)->addHours($hoursOld)->isPast()) {
                    Storage::delete($file);
                    $deletedCount++;
                }
            }

            Log::info("Cleaned up {$deletedCount} old PDF files");
            return $deletedCount;
        } catch (\Exception $e) {
            Log::error("Failed to clean up PDF files", [
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    /**
     * Render a printable HTML page embedding the PDF
     */
    protected static function renderPrintHtml(string $pdfBinary, string $filename, array $options = [])
    {
        $dataUri = 'data:application/pdf;base64,' . base64_encode($pdfBinary);
        $autoPrint = $options['autoPrint'] ?? false;
        $layout = $options['layout'] ?? 'single';

        $printScript = $autoPrint ? '
        setTimeout(function() {
            try {
                if (f && f.contentWindow) { 
                    f.contentWindow.focus(); 
                    f.contentWindow.print(); 
                } else { 
                    window.print(); 
                }
            } catch (e) { 
                window.print(); 
            }
        }, 700);' : '';

        $html = '<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>' . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . '</title>
<style>
html,body{margin:0;height:100%;overflow:hidden}
iframe{border:0;width:100%;height:100%}
.print-controls{
    position:fixed;
    top:10px;
    right:10px;
    z-index:1000;
    background:white;
    padding:10px;
    border:1px solid #ccc;
    border-radius:4px;
    box-shadow:0 2px 4px rgba(0,0,0,0.1);
}
.print-controls button{
    padding:8px 16px;
    margin-left:5px;
    cursor:pointer;
    background:#007bff;
    color:white;
    border:none;
    border-radius:4px;
}
.print-controls button:hover{background:#0056b3}
@media print{.print-controls{display:none}}
</style>
</head>
<body>
<div class="print-controls">
    <button onclick="printPdf()">🖨️ Imprimer</button>
    <button onclick="downloadPdf()">⬇️ Télécharger</button>
</div>
<iframe id="printFrame" src="' . $dataUri . '"></iframe>
<script>
function printPdf() {
    const f = document.getElementById("printFrame");
    try {
        if (f && f.contentWindow) { 
            f.contentWindow.focus(); 
            f.contentWindow.print(); 
        } else { 
            window.print(); 
        }
    } catch (e) { 
        window.print(); 
    }
}
function downloadPdf() {
    const link = document.createElement("a");
    link.href = "' . $dataUri . '";
    link.download = "' . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . '";
    link.click();
}
window.addEventListener("load", function() {
    const f = document.getElementById("printFrame");
    ' . $printScript . '
});
</script>
</body>
</html>';

        return response($html, 200, ['Content-Type' => 'text/html']);
    }



    private static function cleanHtmlForPdf($html)
    {
        // Extract all <style> blocks from anywhere in HTML
        $allStyles = [];
        if (preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $styleMatches)) {
            foreach ($styleMatches[1] as $styleContent) {
                $allStyles[] = $styleContent;
            }
            // Remove all style tags from HTML
            $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);
        }
        
        // Combine all styles
        $combinedStyles = implode("\n", $allStyles);
        
        // Inject combined styles into <head> only
        if (preg_match('/<head[^>]*>/i', $html)) {
            $html = preg_replace('/<head([^>]*)>/i', "<head$1>\n<style>{$combinedStyles}</style>", $html, 1);
        } else {
            // If no head tag, add one
            $html = preg_replace('/<body/i', "<head><style>{$combinedStyles}</style></head>\n<body", $html, 1);
        }
        
        return $html;
    }


    /**
 * Generate standardized filename for patient-related documents
 */
    public static function generatePatientFilename($itemType, $patient, $id = null)
    {
        $numeroDossier = $patient->numero_dossier ?? 'unknown';
        $name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $patient->name ?? 'patient');
        
        $parts = [$itemType, $numeroDossier, $name];
        if ($id) {
            $parts[] = $id;
        }
        
        return implode('_', $parts) . '.pdf';
    }


    private static function normalizeFilename(?string $filename): string
    {
        if (!$filename || trim($filename) === '') {
            return 'document_' . now()->format('Ymd_His') . '.pdf';
        }

        if (!str_ends_with(strtolower($filename), '.pdf')) {
            $filename .= '.pdf';
        }

        return $filename;
    }


}


