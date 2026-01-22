@extends('layouts.admin') @section('title', $title ?? 'Aperçu Document') @section('link')
{!! $links ?? '' !!}

<style>
/* Main container */
.editor-page {
    background: #f5f6fa;
    min-height: 100vh;
    padding: 20px;
}

.editor-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

.editor-header {
    background: #0056b3;
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.editor-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.editor-title i {
    font-size: 1.6rem;
}

.header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.editor-toolbar {
    background: #f8f9fa;
    padding: 15px 30px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
}

.toolbar-section {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
}

.toolbar-group {
    display: flex;
    gap: 10px;
    align-items: center;
    background: white;
    padding: 8px 15px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* Content area with A4 paper simulation */
.editor-content-wrapper {
    padding: 30px;
    background: #e9ecef;
    min-height: calc(100vh - 250px);
    display: flex;
    justify-content: center;
}

.editor-paper {
    width: 100%;
    max-width: 310mm;  /* A4 width */
    background: white;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    min-height: 297mm;  /* A4 height */
    position: relative;
}

.editor-content {
    width: 100%;
    height: 100%;
}

/* CKEditor customization - PRESERVE ORIGINAL TEMPLATE STYLES */
.ck-editor__editable {
    min-height: 297mm !important;
    padding: 25mm 20mm !important;
    border: none !important;
    border-radius: 0 !important;
    background: white !important;
    /* font-family: 'Times New Roman', Times, serif !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
    color: #000 !important; */
}

/* Inject original template styles into editor */
.ck-editor__editable {
    /* Original template styles will be injected here via <style> tag below */
}

/* Table styling from original templates */
.ck-editor__editable table {
    width: 100% !important;
    border-collapse: collapse !important;
    table-layout: auto !important;
    margin: 6px 0 !important;
}

.ck-editor__editable tr {
    height: auto !important;
}

.ck-editor__editable th,
.ck-editor__editable td {
    padding: 4px 6px !important;
    margin: 0 !important;
    line-height: 1.2 !important;
    vertical-align: middle !important;
    border: 1px solid #000 !important;
    /* font-size: 12px !important; */
}

.ck-editor__editable th {
    font-weight: bold;
    background: #f5f5f5;
    text-align: center;
}

.ck-editor__editable td p,
.ck-editor__editable th p {
    margin: 0 !important;
    padding: 0 !important;
}

.ck-editor__editable figure.table {
    margin: 8px 0 !important;
}

.ck-editor__editable:focus {
    box-shadow: none !important;
}

.ck.ck-editor__main {
    background: transparent;
}

.ck.ck-editor__top {
    position: sticky;
    top: 0;
    z-index: 10;
    background: white;
    border-bottom: 2px solid #e9ecef;
}

.ck.ck-toolbar {
    background: #f8f9fa !important;
    border: 1px solid #dee2e6 !important;
    /* border-radius: 8px !important; */
    padding: 10px !important;
}

.ck.ck-toolbar .ck-toolbar__items {
    flex-wrap: wrap !important;
}

.ck.ck-button {
    margin: 2px !important;
}

.editor-status-bar {
    background: #f8f9fa;
    padding: 12px 30px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
    flex-wrap: wrap;
    gap: 15px;
}

.status-text {
    color: #28a745;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.status-warning {
    color: #ffc107;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    animation: pulse 2s infinite;
}

/* Save status indicator */
.status-saved {
    color: #28a745;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.status-saving {
    color: #17a2b8;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* Buttons */
.btn-action {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.btn-action:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.btn-success:hover:not(:disabled) {
    background: linear-gradient(135deg, #218838 0%, #1ba87e 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.btn-info:hover:not(:disabled) {
    background: linear-gradient(135deg, #138496 0%, #0f6674 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover:not(:disabled) {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-sm {
    padding: 6px 12px;
    font-size: 0.85rem;
}

#hidden-styles {
    display: none;
}

@media (max-width: 1200px) {
    .editor-paper {
        max-width: 100%;
    }
    
    .ck-editor__editable {
        padding: 20px !important;
    }
}

@media (max-width: 768px) {
    .editor-page {
        padding: 10px;
    }
    
    .editor-header {
        padding: 15px 20px;
    }
    
    .editor-title {
        font-size: 1.2rem;
    }
    
    .editor-toolbar {
        padding: 15px 20px;
        flex-direction: column;
        align-items: stretch;
    }
    
    .toolbar-section {
        width: 100%;
        justify-content: space-between;
    }
    
    .toolbar-group {
        flex: 1;
    }
    
    .editor-content-wrapper {
        padding: 15px;
    }
    
    .btn-action {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
    
    .header-actions {
        width: 100%;
    }
}

/* Print styles */
@media print {
    .editor-header,
    .editor-toolbar,
    .editor-status-bar,
    .ck.ck-editor__top {
        display: none !important;
    }
    
    .editor-wrapper {
        box-shadow: none;
        border-radius: 0;
    }
    
    .editor-content-wrapper {
        padding: 0;
        background: white;
    }
    
    .editor-paper {
        box-shadow: none;
        max-width: 100%;
    }
    
    .ck-editor__editable {
        padding: 0 !important;
    }
}

 /* To be removed */
/* Previously here:
   *{!! $links ?? '' !!}
   *{!! '<style>' . ($styles ?? '') . '</style>' !!}
 */

</style>



{{-- Inject original template styles in a dedicated style tag outside the big editor CSS block --}}
@if(!empty($styles))
<style id="original-template-styles">
{!! $styles !!}
</style>
@endif
@endsection

@section('content')
<div class="editor-page">
    <div class="editor-wrapper">
        <!-- Header -->
        <div class="editor-header">
            <h2 class="editor-title">
                <i class="fas fa-file-edit"></i>
                <span>{{ $title }}</span>
            </h2>
            <div class="header-actions">
                <button onclick="saveDocument()" class="btn-action btn-success btn-sm" id="saveBtn">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="{{ url()->previous() }}" style="color: gray;" class="btn-action btn-light btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="editor-toolbar">
            <div class="toolbar-section">
                <div class="toolbar-group">
                    <button onclick="printDocument()" class="btn-action btn-primary btn-sm" id="printBtn">
                        <i class="fas fa-print"></i> Imprimer
                    </button>
                    <button onclick="downloadPdf()" class="btn-action btn-info btn-sm" id="downloadBtn">
                        <i class="fas fa-download"></i> PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="editor-content-wrapper">
            <div class="editor-paper" id="editorPaper">
                <div class="editor-content">
                    <div id="editor">{!! $content !!}</div>
                </div>
            </div>
        </div>

        <!-- Status Bar -->
        <div class="editor-status-bar">
            <span id="statusSaved" class="status-saved" style="display: none;">
                <i class="fas fa-check-circle"></i> 
                Enregistré dans la base de données
            </span>
            <span id="statusSaving" class="status-saving" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> 
                Enregistrement en cours...
            </span>
            <span id="statusText" class="status-text" style="display: none;">
                <i class="fas fa-check-circle"></i> 
                <span id="statusMessage">Prêt</span>
            </span>
            <span id="statusWarning" class="status-warning" style="display: none;">
                <i class="fas fa-exclamation-triangle"></i> 
                Modifications non sauvegardées
            </span>
            <span style="color: #6c757d;">
                <i class="fas fa-info-circle"></i>
                Utilisez Ctrl+S pour sauvegarder rapidement
            </span>
        </div>
    </div>
</div>

<!-- Hidden container for original styles (backup) -->
<div id="hidden-styles">
    <style>{!! $styles ?? '' !!}</style>
</div>
@endsection

@section('script')
<script src="{{ asset('build/ckeditor/ckeditor.js') }}"></script>

<script>
let editorInstance;
let originalContent = '';
let hasUnsavedChanges = false;
let autoSaveTimer = null;

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#editor'), {
        language: 'fr',
        toolbar: {
            items: [
                'undo', 'redo', '|',
                'heading', '|',
                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'subscript', 'superscript', '|',
                'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify', '|',              
                'numberedList', 'bulletedList', '|',
                'outdent', 'indent', '|',
                'link', 'insertTable', 'blockQuote', 'imageInsert', 'mediaEmbed', '|',
                'horizontalLine', 'pageBreak', 'specialCharacters', '|',
                'removeFormat', 'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Titre 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Titre 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Titre 6', class: 'ck-heading_heading6' }
            ]
        },
        fontSize: {
            options: [8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28, 36, 48, 72],
            supportAllValues: true
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif',
                'Comic Sans MS, cursive'
            ],
            supportAllValues: true
        },
        fontColor: {
            colors: [
                { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                { color: 'hsl(0, 0%, 60%)', label: 'Gris' },
                { color: 'hsl(0, 0%, 90%)', label: 'Gris clair' },
                { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true },
                { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
                { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
                { color: 'hsl(90, 75%, 60%)', label: 'Vert clair' },
                { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
                { color: 'hsl(150, 75%, 60%)', label: 'Aigue-marine' },
                { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                { color: 'hsl(210, 75%, 60%)', label: 'Bleu clair' },
                { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
                { color: 'hsl(270, 75%, 60%)', label: 'Violet' }
            ],
            columns: 5
        },
        fontBackgroundColor: {
            colors: [
                { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                { color: 'hsl(0, 0%, 60%)', label: 'Gris' },
                { color: 'hsl(0, 0%, 90%)', label: 'Gris clair' },
                { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true },
                { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
                { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
                { color: 'hsl(90, 75%, 60%)', label: 'Vert clair' },
                { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
                { color: 'hsl(150, 75%, 60%)', label: 'Aigue-marine' },
                { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                { color: 'hsl(210, 75%, 60%)', label: 'Bleu clair' },
                { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
                { color: 'hsl(270, 75%, 60%)', label: 'Violet' }
            ],
            columns: 5
        },
        alignment: {
            options: ['left', 'center', 'right', 'justify']
        },
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells',
                'tableProperties', 'tableCellProperties',
                'toggleTableCaption'
            ]
        },
        link: {
            addTargetToExternalLinks: true
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        typing: {
            transformations: {
                remove: ['quotes', 'typography']
            }
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        }
    })
    .then(editor => {
        editorInstance = editor;
        originalContent = editor.getData();
        
        // Track changes
        editor.model.document.on('change:data', () => {
            const currentContent = editor.getData();
            hasUnsavedChanges = currentContent !== originalContent;
            
            if (hasUnsavedChanges) {
                document.getElementById('statusWarning').style.display = 'flex';
                document.getElementById('statusSaved').style.display = 'none';
                
                // Auto-save after 10 seconds of inactivity
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    saveDocument(true); // Silent auto-save
                }, 40000);
            } else {
                document.getElementById('statusWarning').style.display = 'none';
            }
        });
        
        console.log('CKEditor initialized successfully');
    })
    .catch(error => {
        console.error('CKEditor initialization error:', error);
        alert('Erreur lors de l\'initialisation de l\'éditeur: ' + error.message);
    });






































    @extends('layouts.admin') 
@section('title', $title ?? 'Aperçu Document') 

@section('link')
{!! $links ?? '' !!}

<style>
/* Main container */
.editor-page {
    background: #f5f6fa;
    min-height: 100vh;
    padding: 20px;
}

.editor-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

.editor-header {
    background: #0056b3;
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.editor-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.editor-title i {
    font-size: 1.6rem;
}

.header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.editor-toolbar {
    background: #f8f9fa;
    padding: 15px 30px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
}

.toolbar-section {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
}

.toolbar-group {
    display: flex;
    gap: 10px;
    align-items: center;
    background: white;
    padding: 8px 15px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* Content area with A4 paper simulation */
.editor-content-wrapper {
    padding: 30px;
    background: #e9ecef;
    min-height: calc(100vh - 250px);
    display: flex;
    justify-content: center;
}

.editor-paper {
    width: 100%;
    max-width: 310mm;  /* A4 width */
    background: white;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    min-height: 297mm;  /* A4 height */
    position: relative;
}

.editor-content {
    width: 100%;
    height: 100%;
}

/* CKEditor customization - PRESERVE ORIGINAL TEMPLATE STYLES */
.ck-editor__editable {
    min-height: 297mm !important;
    padding: 25mm 20mm !important;
    border: none !important;
    border-radius: 0 !important;
    background: white !important;
    /* font-family: 'Times New Roman', Times, serif !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
    color: #000 !important; */
}

/* Inject original template styles into editor */
.ck-editor__editable {
    /* Original template styles will be injected here via <style> tag below */
}

/* Table styling from original templates */
.ck-editor__editable table {
    width: 100% !important;
    border-collapse: collapse !important;
    table-layout: auto !important;
    margin: 6px 0 !important;
}

.ck-editor__editable tr {
    height: auto !important;
}

.ck-editor__editable th,
.ck-editor__editable td {
    padding: 4px 6px !important;
    margin: 0 !important;
    line-height: 1.2 !important;
    vertical-align: middle !important;
    border: 1px solid #000 !important;
    /* font-size: 12px !important; */
}

.ck-editor__editable th {
    font-weight: bold;
    background: #f5f5f5;
    text-align: center;
}

.ck-editor__editable td p,
.ck-editor__editable th p {
    margin: 0 !important;
    padding: 0 !important;
}

.ck-editor__editable figure.table {
    margin: 8px 0 !important;
}

.ck-editor__editable:focus {
    box-shadow: none !important;
}

.ck.ck-editor__main {
    background: transparent;
}

.ck.ck-editor__top {
    position: sticky;
    top: 0;
    z-index: 10;
    background: white;
    border-bottom: 2px solid #e9ecef;
}

.ck.ck-toolbar {
    background: #f8f9fa !important;
    border: 1px solid #dee2e6 !important;
    /* border-radius: 8px !important; */
    padding: 10px !important;
}

.ck.ck-toolbar .ck-toolbar__items {
    flex-wrap: wrap !important;
}

.ck.ck-button {
    margin: 2px !important;
}

.editor-status-bar {
    background: #f8f9fa;
    padding: 12px 30px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
    flex-wrap: wrap;
    gap: 15px;
}

.status-text {
    color: #28a745;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.status-warning {
    color: #ffc107;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    animation: pulse 2s infinite;
}

/* Save status indicator */
.status-saved {
    color: #28a745;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.status-saving {
    color: #17a2b8;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* Buttons */
.btn-action {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.btn-action:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.btn-success:hover:not(:disabled) {
    background: linear-gradient(135deg, #218838 0%, #1ba87e 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.btn-info:hover:not(:disabled) {
    background: linear-gradient(135deg, #138496 0%, #0f6674 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover:not(:disabled) {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-sm {
    padding: 6px 12px;
    font-size: 0.85rem;
}

.btn-light {
    background: #f8f9fa;
    color: #6c757d;
}

.btn-light:hover:not(:disabled) {
    background: #e2e6ea;
}

#hidden-styles {
    display: none;
}

@media (max-width: 1200px) {
    .editor-paper {
        max-width: 100%;
    }
    
    .ck-editor__editable {
        padding: 20px !important;
    }
}

@media (max-width: 768px) {
    .editor-page {
        padding: 10px;
    }
    
    .editor-header {
        padding: 15px 20px;
    }
    
    .editor-title {
        font-size: 1.2rem;
    }
    
    .editor-toolbar {
        padding: 15px 20px;
        flex-direction: column;
        align-items: stretch;
    }
    
    .toolbar-section {
        width: 100%;
        justify-content: space-between;
    }
    
    .toolbar-group {
        flex: 1;
    }
    
    .editor-content-wrapper {
        padding: 15px;
    }
    
    .btn-action {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
    
    .header-actions {
        width: 100%;
    }
}

/* Print styles */
@media print {
    .editor-header,
    .editor-toolbar,
    .editor-status-bar,
    .ck.ck-editor__top {
        display: none !important;
    }
    
    .editor-wrapper {
        box-shadow: none;
        border-radius: 0;
    }
    
    .editor-content-wrapper {
        padding: 0;
        background: white;
    }
    
    .editor-paper {
        box-shadow: none;
        max-width: 100%;
    }
    
    .ck-editor__editable {
        padding: 0 !important;
    }
}
</style>

{{-- Inject original template styles in a dedicated style tag --}}
@if(!empty($styles))
<style id="original-template-styles">
{!! $styles !!}
</style>
@endif

@endsection

@section('content')
<div class="editor-page">
    <div class="editor-wrapper">
        <!-- Header -->
        <div class="editor-header">
            <h2 class="editor-title">
                <i class="fas fa-file-edit"></i>
                <span>{{ $title }}</span>
            </h2>
            <div class="header-actions">
                <button onclick="saveDocument()" class="btn-action btn-success btn-sm" id="saveBtn">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="{{ url()->previous() }}" class="btn-action btn-light btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="editor-toolbar">
            <div class="toolbar-section">
                <div class="toolbar-group">
                    <button onclick="printDocument()" class="btn-action btn-primary btn-sm" id="printBtn">
                        <i class="fas fa-print"></i> Imprimer
                    </button>
                    <button onclick="downloadPdf()" class="btn-action btn-info btn-sm" id="downloadBtn">
                        <i class="fas fa-download"></i> PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="editor-content-wrapper">
            <div class="editor-paper" id="editorPaper">
                <div class="editor-content">
                    <div id="editor">{!! $content !!}</div>
                </div>
            </div>
        </div>

        <!-- Status Bar -->
        <div class="editor-status-bar">
            <span id="statusSaved" class="status-saved" style="display: none;">
                <i class="fas fa-check-circle"></i> 
                Enregistré dans la base de données
            </span>
            <span id="statusSaving" class="status-saving" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> 
                Enregistrement en cours...
            </span>
            <span id="statusText" class="status-text" style="display: none;">
                <i class="fas fa-check-circle"></i> 
                <span id="statusMessage">Prêt</span>
            </span>
            <span id="statusWarning" class="status-warning" style="display: none;">
                <i class="fas fa-exclamation-triangle"></i> 
                Modifications non sauvegardées
            </span>
            <span style="color: #6c757d;">
                <i class="fas fa-info-circle"></i>
                Utilisez Ctrl+S pour sauvegarder rapidement
            </span>
        </div>
    </div>
</div>

<!-- Hidden container for original styles (backup) -->
<div id="hidden-styles">
    <style>{!! $styles ?? '' !!}</style>
</div>
@endsection

@section('script')
<script src="{{ asset('build/ckeditor/ckeditor.js') }}"></script>

<script>
let editorInstance;
let originalContent = '';
let hasUnsavedChanges = false;
let autoSaveTimer = null;

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#editor'), {
        language: 'fr',
        toolbar: {
            items: [
                'undo', 'redo', '|',
                'heading', '|',
                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'subscript', 'superscript', '|',
                'alignment', '|',            
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'link', 'uploadImage', 'insertTable', 'mediaEmbed', '|',
                'blockQuote', 'codeBlock', '|',

                'horizontalLine', 'pageBreak', 'specialCharacters', '|',
                'findAndReplace', 'removeFormat', 'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Titre 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Titre 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Titre 6', class: 'ck-heading_heading6' }
            ]
        },
        // Style configuration
        style: {
            definitions: [
                {
                    name: 'Article category',
                    element: 'h3',
                    classes: ['category']
                },
                {
                    name: 'Info box',
                    element: 'p',
                    classes: ['info-box']
                },
                {
                    name: 'Side quote',
                    element: 'blockquote',
                    classes: ['side-quote']
                },
                {
                    name: 'Marker',
                    element: 'span',
                    classes: ['marker']
                },
                {
                    name: 'Spoiler',
                    element: 'span',
                    classes: ['spoiler']
                },
                {
                    name: 'Code (dark)',
                    element: 'pre',
                    classes: ['fancy-code', 'fancy-code-dark']
                },
                {
                    name: 'Code (bright)',
                    element: 'pre',
                    classes: ['fancy-code', 'fancy-code-bright']
                }
            ]
        },
        fontSize: {
            options: [8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28, 36, 48, 72],
            supportAllValues: true
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif',
                'Comic Sans MS, cursive',
                'Impact, Charcoal, sans-serif',
                'Palatino Linotype, Book Antiqua, Palatino, serif'
            ],
            supportAllValues: true
        },
        fontColor: {
            colors: [
                // Grayscale
                { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                { color: 'hsl(0, 0%, 20%)', label: 'Très foncé' },
                { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                { color: 'hsl(0, 0%, 40%)', label: 'Gris' },
                { color: 'hsl(0, 0%, 60%)', label: 'Gris moyen' },
                { color: 'hsl(0, 0%, 80%)', label: 'Gris clair' },
                { color: 'hsl(0, 0%, 90%)', label: 'Très clair' },
                { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true },
                
                // Colors
                { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
                { color: 'hsl(15, 75%, 60%)', label: 'Rouge-orange' },
                { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                { color: 'hsl(45, 75%, 60%)', label: 'Or' },
                { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
                { color: 'hsl(90, 75%, 60%)', label: 'Vert clair' },
                { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
                { color: 'hsl(150, 75%, 60%)', label: 'Aigue-marine' },
                { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                { color: 'hsl(210, 75%, 60%)', label: 'Bleu clair' },
                { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
                { color: 'hsl(270, 75%, 60%)', label: 'Violet' },
                { color: 'hsl(300, 75%, 60%)', label: 'Magenta' },
                { color: 'hsl(330, 75%, 60%)', label: 'Rose' }
            ],
            columns: 8,
            documentColors: 10
        },
        fontBackgroundColor: {
            colors: [
                // Same color palette as fontColor
                { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                { color: 'hsl(0, 0%, 20%)', label: 'Très foncé' },
                { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                { color: 'hsl(0, 0%, 40%)', label: 'Gris' },
                { color: 'hsl(0, 0%, 60%)', label: 'Gris moyen' },
                { color: 'hsl(0, 0%, 80%)', label: 'Gris clair' },
                { color: 'hsl(0, 0%, 90%)', label: 'Très clair' },
                { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true },
                { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
                { color: 'hsl(15, 75%, 60%)', label: 'Rouge-orange' },
                { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                { color: 'hsl(45, 75%, 60%)', label: 'Or' },
                { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
                { color: 'hsl(90, 75%, 60%)', label: 'Vert clair' },
                { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
                { color: 'hsl(150, 75%, 60%)', label: 'Aigue-marine' },
                { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                { color: 'hsl(210, 75%, 60%)', label: 'Bleu clair' },
                { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
                { color: 'hsl(270, 75%, 60%)', label: 'Violet' },
                { color: 'hsl(300, 75%, 60%)', label: 'Magenta' },
                { color: 'hsl(330, 75%, 60%)', label: 'Rose' }
            ],
            columns: 8,
            documentColors: 10
        },
        alignment: {
            options: ['left', 'center', 'right', 'justify']
        },
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells',
                'tableProperties', 'tableCellProperties',
                'toggleTableCaption'
            ],
            tableProperties: {
                borderColors: [
                    { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                    { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                    { color: 'hsl(0, 0%, 60%)', label: 'Gris' },
                    { color: 'hsl(0, 0%, 90%)', label: 'Gris clair' },
                    { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
                    { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                    { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
                    { color: 'hsl(90, 75%, 60%)', label: 'Vert clair' },
                    { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
                    { color: 'hsl(150, 75%, 60%)', label: 'Aigue-marine' },
                    { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                    { color: 'hsl(210, 75%, 60%)', label: 'Bleu clair' },
                    { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
                    { color: 'hsl(270, 75%, 60%)', label: 'Violet' }
                ],
                backgroundColors: [
                    { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                    { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                    { color: 'hsl(0, 0%, 60%)', label: 'Gris' },
                    { color: 'hsl(0, 0%, 90%)', label: 'Gris clair' },
                    { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true },
                    { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
                    { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                    { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
                    { color: 'hsl(90, 75%, 60%)', label: 'Vert clair' },
                    { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
                    { color: 'hsl(150, 75%, 60%)', label: 'Aigue-marine' },
                    { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
                    { color: 'hsl(210, 75%, 60%)', label: 'Bleu clair' },
                    { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
                    { color: 'hsl(270, 75%, 60%)', label: 'Violet' }
                ]
            },
            tableCellProperties: {
                borderColors: [
                    { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                    { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                    { color: 'hsl(0, 0%, 60%)', label: 'Gris' },
                    { color: 'hsl(0, 0%, 90%)', label: 'Gris clair' }
                ],
                backgroundColors: [
                    { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
                    { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
                    { color: 'hsl(0, 0%, 60%)', label: 'Gris' },
                    { color: 'hsl(0, 0%, 90%)', label: 'Gris clair' },
                    { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true }
                ]
            }
        },
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            decorators: {
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Téléchargeable',
                    attributes: {
                        download: 'file'
                    }
                },
                openInNewTab: {
                    mode: 'manual',
                    label: 'Ouvrir dans un nouvel onglet',
                    defaultValue: true,
                    attributes: {
                        target: '_blank',
                        rel: 'noopener noreferrer'
                    }
                }
            }
        },
         // Image configuration
        image: {
            toolbar: [
                'imageTextAlternative', '|',
                'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                'toggleImageCaption', 'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight'
            ],
            upload: {
                types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff']
            }
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },

        // Media embed configuration
        mediaEmbed: {
            previewsInData: true,
            providers: [
                {
                    name: 'youtube',
                    url: /^(?:m\.)?youtube\.com\/watch\?v=([\w-]+)/,
                    html: match => {
                        const id = match[1];
                        return (
                            '<div style="position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;">' +
                                `<iframe src="https://www.youtube.com/embed/${id}" ` +
                                    'style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;" ' +
                                    'frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>' +
                                '</iframe>' +
                            '</div>'
                        );
                    }
                },
                {
                    name: 'vimeo',
                    url: /^vimeo\.com\/(\d+)/,
                    html: match => {
                        const id = match[1];
                        return (
                            '<div style="position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;">' +
                                `<iframe src="https://player.vimeo.com/video/${id}" ` +
                                    'style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;" ' +
                                    'frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>' +
                                '</iframe>' +
                            '</div>'
                        );
                    }
                }
            ]
        },

         // Code block configuration
        codeBlock: {
            languages: [
                { language: 'plaintext', label: 'Plain text' },
                { language: 'javascript', label: 'JavaScript' },
                { language: 'php', label: 'PHP' },
                { language: 'python', label: 'Python' },
                { language: 'java', label: 'Java' },
                { language: 'css', label: 'CSS' },
                { language: 'html', label: 'HTML' },
                { language: 'sql', label: 'SQL' },
                { language: 'xml', label: 'XML' },
                { language: 'json', label: 'JSON' }
            ]
        },
        
        // Find and replace
        findAndReplace: {
            searchOnlyWhenFocused: false
        },
        typing: {
            transformations: {
                remove: [
                    'quotes',
                    'typography',
                    'symbols',
                    'mathematical',
                    'emojis'
                ]
            }
        },

        // Special characters configuration
        specialCharacters: {
            order: [
                'Text',
                'Latin',
                'Mathematical',
                'Currency',
                'Arrows'
            ],
        },

        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        }
    })
    .then(editor => {
        editorInstance = editor;
        originalContent = editor.getData();
        
        // Track changes
        editor.model.document.on('change:data', () => {
            const currentContent = editor.getData();
            hasUnsavedChanges = currentContent !== originalContent;
            
            if (hasUnsavedChanges) {
                document.getElementById('statusWarning').style.display = 'flex';
                document.getElementById('statusSaved').style.display = 'none';
                
                // Auto-save after 40 seconds of inactivity
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    saveDocument(true); // Silent auto-save
                }, 40000);
            } else {
                document.getElementById('statusWarning').style.display = 'none';
            }
        });
        
        console.log('CKEditor initialized successfully');
    })
    .catch(error => {
        console.error('CKEditor initialization error:', error);
        alert('Erreur lors de l\'initialisation de l\'éditeur: ' + error.message);
    });
    console.log('Available plugins:', ClassicEditor.builtinPlugins.map(plugin => plugin.pluginName));

// Save document (with DB persistence)
async function saveDocument(silent = false) {
    if (!editorInstance) {
        if (!silent) alert('L\'éditeur n\'est pas encore prêt');
        return;
    }

    const saveBtn = document.getElementById('saveBtn');
    const originalBtnContent = saveBtn.innerHTML;
    
    if (!silent) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
    }
    
    // Show saving status
    document.getElementById('statusSaving').style.display = 'flex';
    document.getElementById('statusSaved').style.display = 'none';
    document.getElementById('statusWarning').style.display = 'none';

    try {
        const content = editorInstance.getData();
        
        const response = await fetch('{{ route("print.preview.save", ["type" => $type, "id" => $id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ content })
        });

        const data = await response.json();

        if (response.ok) {
            originalContent = content;
            hasUnsavedChanges = false;
            
            // Hide saving, show saved
            document.getElementById('statusSaving').style.display = 'none';
            document.getElementById('statusSaved').style.display = 'flex';
            document.getElementById('statusWarning').style.display = 'none';
            
            if (!silent) {
                showStatus('Document enregistré dans la base de données', 'success');
            }
            
            // Auto-hide saved status after 5 seconds
            setTimeout(() => {
                document.getElementById('statusSaved').style.display = 'none';
            }, 5000);
        } else {
            throw new Error(data.error || 'Erreur lors de la sauvegarde');
        }

    } catch (error) {
        console.error('Save error:', error);
        document.getElementById('statusSaving').style.display = 'none';
        if (!silent) {
            showStatus('Erreur: ' + error.message, 'error');
        }
    } finally {
        if (!silent) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalBtnContent;
        }
    }
}

// Print document
async function printDocument() {
    if (hasUnsavedChanges) {
        const confirmSave = confirm('Vous avez des modifications non sauvegardées. Voulez-vous les sauvegarder avant d\'imprimer ?');
        if (confirmSave) {
            await saveDocument();
        }
    }

    const printBtn = document.getElementById('printBtn');
    const originalBtnContent = printBtn.innerHTML;
    printBtn.disabled = true;
    printBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Impression...';

    try {
        const url = '{{ route("print.preview.print", ["type" => $type, "id" => $id]) }}?delivery=print';
        window.open(url, '_blank');
        showStatus('Document envoyé à l\'impression', 'success');

    } catch (error) {
        console.error('Print error:', error);
        showStatus('Erreur lors de l\'impression', 'error');
    } finally {
        printBtn.disabled = false;
        printBtn.innerHTML = originalBtnContent;
    }
}

// Download PDF
async function downloadPdf() {
    if (hasUnsavedChanges) {
        const confirmSave = confirm('Vous avez des modifications non sauvegardées. Voulez-vous les sauvegarder avant de télécharger ?');
        if (confirmSave) {
            await saveDocument();
        }
    }

    const downloadBtn = document.getElementById('downloadBtn');
    const originalBtnContent = downloadBtn.innerHTML;
    downloadBtn.disabled = true;
    downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Téléchargement...';

    try {
        const url = '{{ route("print.preview.print", ["type" => $type, "id" => $id]) }}?delivery=download';

        const link = document.createElement('a');
        link.href = url;
        link.download = '';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showStatus('Téléchargement du PDF démarré', 'success');

    } catch (error) {
        console.error('Download error:', error);
        showStatus('Erreur lors du téléchargement', 'error');
    } finally {
        downloadBtn.disabled = false;
        downloadBtn.innerHTML = originalBtnContent;
    }
}

// Show status message
function showStatus(message, type = 'info') {
    const statusText = document.getElementById('statusText');
    const statusMessage = document.getElementById('statusMessage');
    
    statusMessage.textContent = message;
    statusText.style.display = 'flex';
    
    if (type === 'success') {
        statusText.style.color = '#28a745';
    } else if (type === 'error') {
        statusText.style.color = '#dc3545';
    }
    
    setTimeout(() => {
        statusText.style.display = 'none';
    }, 4000);
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveDocument();
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printDocument();
    }
});

// Warn before leaving with unsaved changes
window.addEventListener('beforeunload', (e) => {
    if (hasUnsavedChanges) {
        e.preventDefault();
        e.returnValue = 'Vous avez des modifications non sauvegardées. Voulez-vous vraiment quitter ?';
        return e.returnValue;
    }
});

// Cleanup on page unload
window.addEventListener('unload', () => {
    if (autoSaveTimer) {
        clearTimeout(autoSaveTimer);
    }
});
</script>
@endsection