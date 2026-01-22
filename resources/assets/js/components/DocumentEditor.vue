<template>
  <div class="editor-page">
    <div class="editor-wrapper">
      <!-- Header -->
      <div class="editor-header">
        <h2 class="editor-title">
          <i class="fas fa-file-edit"></i>
          <span>{{ title }}</span>
        </h2>
        <div class="header-actions">
          <button @click="saveDocument" class="btn-action btn-success btn-sm" :disabled="isSaving">
            <i :class="isSaving ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> 
            {{ isSaving ? 'Enregistrement...' : 'Enregistrer' }}
          </button>
          <a :href="backUrl" class="btn-action btn-light btn-sm">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>

      <!-- Toolbar -->
      <div class="editor-toolbar">
        <div class="toolbar-section">
          <div class="toolbar-group">
            <button @click="printDocument" class="btn-action btn-primary btn-sm" :disabled="isPrinting">
              <i :class="isPrinting ? 'fas fa-spinner fa-spin' : 'fas fa-print'"></i> 
              Imprimer
            </button>
            <button @click="downloadPdf" class="btn-action btn-info btn-sm" :disabled="isDownloading">
              <i :class="isDownloading ? 'fas fa-spinner fa-spin' : 'fas fa-download'"></i> 
              PDF
            </button>
          </div>
        </div>
      </div>

      <!-- Content Area -->
      <div class="editor-content-wrapper">
        <div class="editor-paper" id="editorPaper">
          <div class="editor-content">
            <ckeditor 
              v-model="editorData" 
              :editor="editor" 
              :config="editorConfig"
              @ready="onEditorReady"
            />
          </div>
        </div>
      </div>

      <!-- Status Bar -->
      <div class="editor-status-bar">
        <span v-if="saveStatus === 'saved'" class="status-saved">
          <i class="fas fa-check-circle"></i> 
          Enregistré dans la base de données
        </span>
        <span v-else-if="saveStatus === 'saving'" class="status-saving">
          <i class="fas fa-spinner fa-spin"></i> 
          Enregistrement en cours...
        </span>
        <span v-else-if="hasUnsavedChanges" class="status-warning">
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
</template>

<script>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
  name: 'DocumentEditor',
  
  props: {
    initialContent: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    documentType: {
      type: String,
      required: true
    },
    documentId: {
      type: [String, Number],
      required: true
    },
    saveUrl: {
      type: String,
      required: true
    },
    printUrl: {
      type: String,
      required: true
    },
    backUrl: {
      type: String,
      default: '#'
    }
  },

  setup(props) {
    // Reactive state
    const editorData = ref(props.initialContent);
    const originalContent = ref(props.initialContent);
    const editorInstance = ref(null);
    const isSaving = ref(false);
    const isPrinting = ref(false);
    const isDownloading = ref(false);
    const saveStatus = ref('');
    const autoSaveTimer = ref(null);

    // Computed
    const hasUnsavedChanges = computed(() => {
      return editorData.value !== originalContent.value;
    });

    // CKEditor configuration
    const editor = ClassicEditor;
    const editorConfig = {
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
          { color: 'hsl(0, 0%, 0%)', label: 'Noir' },
          { color: 'hsl(0, 0%, 20%)', label: 'Très foncé' },
          { color: 'hsl(0, 0%, 30%)', label: 'Gris foncé' },
          { color: 'hsl(0, 0%, 40%)', label: 'Gris' },
          { color: 'hsl(0, 0%, 60%)', label: 'Gris moyen' },
          { color: 'hsl(0, 0%, 80%)', label: 'Gris clair' },
          { color: 'hsl(0, 0%, 90%)', label: 'Très clair' },
          { color: 'hsl(0, 0%, 100%)', label: 'Blanc', hasBorder: true },
          { color: 'hsl(0, 75%, 60%)', label: 'Rouge' },
          { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
          { color: 'hsl(60, 75%, 60%)', label: 'Jaune' },
          { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
          { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
          { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
          { color: 'hsl(270, 75%, 60%)', label: 'Violet' },
          { color: 'hsl(300, 75%, 60%)', label: 'Magenta' }
        ],
        columns: 8,
        documentColors: 10
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
          { color: 'hsl(120, 75%, 60%)', label: 'Vert' },
          { color: 'hsl(180, 75%, 60%)', label: 'Turquoise' },
          { color: 'hsl(240, 75%, 60%)', label: 'Bleu' },
          { color: 'hsl(270, 75%, 60%)', label: 'Violet' }
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
        ]
      },
      link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
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
      image: {
        toolbar: [
          'imageTextAlternative', '|',
          'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
        ]
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
    };

    // Methods
    const onEditorReady = (editor) => {
      editorInstance.value = editor;
      console.log('CKEditor initialized successfully');
    };

    const saveDocument = async (silent = false) => {
      if (isSaving.value) return;

      isSaving.value = true;
      saveStatus.value = 'saving';

      try {
        const response = await fetch(props.saveUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ content: editorData.value })
        });

        const data = await response.json();

        if (response.ok) {
          originalContent.value = editorData.value;
          saveStatus.value = 'saved';
          
          if (!silent) {
            showNotification('Document enregistré avec succès', 'success');
          }

          setTimeout(() => {
            saveStatus.value = '';
          }, 5000);
        } else {
          throw new Error(data.error || 'Erreur lors de la sauvegarde');
        }
      } catch (error) {
        console.error('Save error:', error);
        saveStatus.value = '';
        if (!silent) {
          showNotification('Erreur: ' + error.message, 'error');
        }
      } finally {
        isSaving.value = false;
      }
    };

    const printDocument = async () => {
      if (hasUnsavedChanges.value) {
        const confirmSave = confirm('Vous avez des modifications non sauvegardées. Voulez-vous les sauvegarder avant d\'imprimer ?');
        if (confirmSave) {
          await saveDocument();
        }
      }

      isPrinting.value = true;
      try {
        const url = `${props.printUrl}?delivery=print`;
        window.open(url, '_blank');
        showNotification('Document envoyé à l\'impression', 'success');
      } catch (error) {
        console.error('Print error:', error);
        showNotification('Erreur lors de l\'impression', 'error');
      } finally {
        isPrinting.value = false;
      }
    };

    const downloadPdf = async () => {
      if (hasUnsavedChanges.value) {
        const confirmSave = confirm('Vous avez des modifications non sauvegardées. Voulez-vous les sauvegarder avant de télécharger ?');
        if (confirmSave) {
          await saveDocument();
        }
      }

      isDownloading.value = true;
      try {
        const url = `${props.printUrl}?delivery=download`;
        const link = document.createElement('a');
        link.href = url;
        link.download = '';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showNotification('Téléchargement du PDF démarré', 'success');
      } catch (error) {
        console.error('Download error:', error);
        showNotification('Erreur lors du téléchargement', 'error');
      } finally {
        isDownloading.value = false;
      }
    };

    const showNotification = (message, type) => {
      // You can implement a toast notification system here
      console.log(`[${type}] ${message}`);
    };

    const handleKeyboardShortcuts = (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveDocument();
      }
      if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printDocument();
      }
    };

    const handleBeforeUnload = (e) => {
      if (hasUnsavedChanges.value) {
        e.preventDefault();
        e.returnValue = 'Vous avez des modifications non sauvegardées. Voulez-vous vraiment quitter ?';
        return e.returnValue;
      }
    };

    // Watch for changes and setup auto-save
    watch(hasUnsavedChanges, (newVal) => {
      if (newVal) {
        // Clear existing timer
        if (autoSaveTimer.value) {
          clearTimeout(autoSaveTimer.value);
        }
        
        // Auto-save after 40 seconds of inactivity
        autoSaveTimer.value = setTimeout(() => {
          saveDocument(true);
        }, 40000);
      }
    });

    // Lifecycle hooks
    onMounted(() => {
      document.addEventListener('keydown', handleKeyboardShortcuts);
      window.addEventListener('beforeunload', handleBeforeUnload);
    });

    onBeforeUnmount(() => {
      document.removeEventListener('keydown', handleKeyboardShortcuts);
      window.removeEventListener('beforeunload', handleBeforeUnload);
      
      if (autoSaveTimer.value) {
        clearTimeout(autoSaveTimer.value);
      }
    });

    return {
      editorData,
      editor,
      editorConfig,
      isSaving,
      isPrinting,
      isDownloading,
      saveStatus,
      hasUnsavedChanges,
      onEditorReady,
      saveDocument,
      printDocument,
      downloadPdf
    };
  }
};
</script>

<style scoped>
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

.editor-content-wrapper {
  padding: 30px;
  background: #e9ecef;
  min-height: calc(100vh - 250px);
  display: flex;
  justify-content: center;
}

.editor-paper {
  width: 100%;
  max-width: 210mm;
  background: white;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
  min-height: 297mm;
}

.editor-content {
  width: 100%;
  height: 100%;
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

.status-warning {
  color: #ffc107;
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}

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
  text-decoration: none;
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

.btn-light {
  background: #f8f9fa;
  color: #6c757d;
}

.btn-light:hover:not(:disabled) {
  background: #e2e6ea;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 0.85rem;
}

/* CKEditor customizations */
:deep(.ck-editor__editable) {
  min-height: 297mm !important;
  padding: 25mm 20mm !important;
  border: none !important;
  border-radius: 0 !important;
  background: white !important;
}

:deep(.ck-editor__editable:focus) {
  box-shadow: none !important;
}

:deep(.ck.ck-editor__main) {
  background: transparent;
}

:deep(.ck.ck-editor__top) {
  position: sticky;
  top: 0;
  z-index: 10;
  background: white;
  border-bottom: 2px solid #e9ecef;
}

:deep(.ck.ck-toolbar) {
  background: #f8f9fa !important;
  border: 1px solid #dee2e6 !important;
  padding: 10px !important;
}

:deep(.ck.ck-toolbar .ck-toolbar__items) {
  flex-wrap: wrap !important;
}

/* Responsive */
@media (max-width: 1200px) {
  .editor-paper {
    max-width: 100%;
  }
  
  :deep(.ck-editor__editable) {
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

@media print {
  .editor-header,
  .editor-toolbar,
  .editor-status-bar,
  :deep(.ck.ck-editor__top) {
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
  
  :deep(.ck-editor__editable) {
    padding: 0 !important;
  }
}
</style>