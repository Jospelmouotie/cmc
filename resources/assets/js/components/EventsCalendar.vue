

<template>
  <div class="calendar-wrapper">
    <!-- Flash Messages Component -->
    <flash-message ref="flashMessage"></flash-message>

    <!-- Main Calendar Area -->
    <div class="calendar-main">
      <!-- Calendar Header -->
      <div class="calendar-header mb-3">
        <!-- First Row: Title + Add Button -->
        <div class="row align-items-center mb-2">
          <div class="col-12 text-start">
            <h3 class="mb-0">
              <i class="fas fa-calendar-alt me-2"></i>
              {{ medecinName ? `Agenda Dr ${medecinName}` : 'Calendrier des Rendez-vous' }}
            </h3>
          </div>
        </div>

        <!-- ROW 2: Add Button -->
        <div class="row align-items-center mb-3">
          <div class="col-12 text-end">
            <button 
              v-if="canCreate"
              class="btn btn-primary"
              @click="openCreateModal"
            >
              <i class="fas fa-plus"></i>
              Nouveau Rendez-vous
            </button>

            <!-- should display only for admin/secretary when viewing a specific medecin -->
            <a 
              v-if="medecinId && userRole !== 2"
              :href="backUrl"
              class="btn btn-success ms-2"
            >
              <i class="fas fa-arrow-left"></i>
              Retour à l'agenda
            </a>
          </div>
        </div>
        
        <!-- Row 3: Navigation + View Buttons -->
        <div class="row align-items-center mb-3">
          <div class="col-md-4 d-flex align-items-center gap-2">
            <div class="btn-group" role="group">
              <button class="btn btn-secondary" @click="navigatePrev">
                <i class="fas fa-chevron-left"></i>
              </button>
              
              <button class="btn btn-secondary" @click="navigateNext">
                <i class="fas fa-chevron-right"></i>
              </button>

              <button class="btn btn-primary" @click="navigateToday">
                Aujourd'hui
              </button>
            </div>
          </div>

          <!-- CENTER: Month Title -->
          <div class="col-md-4 text-center">
            <h4 class="fw-bold text-capitalize mb-0">
              {{ calendarTitle }}
            </h4>
          </div>

          <div class="col-md-4 text-end">
            <div class="btn-group" role="group">
              <button 
                class="btn btn-outline-secondary"
                :class="{ 'active': currentView === 'dayGridMonth' }"
                @click="changeView('dayGridMonth')"
              >
                Mois
              </button>
              <button 
                class="btn btn-outline-secondary"
                :class="{ 'active': currentView === 'listWeek' }"
                @click="changeView('listWeek')"
              >
                Liste
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Status Legend -->
      <div class="status-legend mb-3">
        <h6 class="mb-2">Légende des statuts</h6>
        <div class="d-flex flex-wrap gap-2">
          <div class="status-item">
            <div class="status-box" style="background-color: #4682B4;"></div>
            <span>À venir</span>
          </div>
          <div class="status-item">
            <div class="status-box" style="background-color: #008B8B;"></div>
            <span>Vu</span>
          </div>
          <div class="status-item">
            <div class="status-box" style="background-color: #DDA0DD;"></div>
            <span>Absence excusée</span>
          </div>
          <div class="status-item">
            <div class="status-box" style="background-color: #6A5ACD;"></div>
            <span>Absence non excusée</span>
          </div>
          <div class="status-item">
            <div class="status-box" style="background-color: #FF6347;"></div>
            <span>Reporté</span>
          </div>
        </div>
      </div>

      <!-- Content Row: Sidebar and Calendar -->
      <div class="content-row" :class="{ 'with-sidebar': showSidebar }">
        <!-- Sidebar for Medecins -->
        <div v-if="showSidebar" class="medecin-sidebar">
          <h5 class="sidebar-title">
            <i class="fas fa-user-md"></i>
            Médecins
          </h5>
          <div class="medecin-list">
            <div
              v-for="medecin in medecins"
              :key="medecin.id"
              class="medecin-item"
              :class="{ active: selectedMedecinId === medecin.id }"
              @click="selectMedecin(medecin.id)"
            >
              <div class="medecin-name">
                Dr. {{ medecin.name }} {{ medecin.prenom }}
              </div>
            </div>
          </div>
        </div>

        <!-- Calendar Area -->
        <div class="calendar-area" :class="{ 'with-sidebar': showSidebar }">
          <!-- Loading Skeleton -->
          <div v-if="loading" class="calendar-skeleton">
            <div class="skeleton-header"></div>
            <div class="skeleton-grid">
              <div v-for="n in 35" :key="n" class="skeleton-cell"></div>
            </div>
          </div>

          <!-- Error Message -->
          <div v-if="error" class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            {{ error }}
          </div>

          <!-- FullCalendar -->
          <div v-show="!loading && !error" class="calendar-container">
            <FullCalendar ref="fullCalendar" :options="calendarOptions" />
          </div>
        </div>
      </div>

      <!-- Create/Edit Event Modal -->
      <div 
        class="modal fade" 
        id="eventModal" 
        tabindex="-1" 
        ref="eventModal"
        aria-hidden="true"
        data-bs-backdrop="static"
      >
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                {{ editingEvent ? 'Modifier le statut du' : 'Nouveau' }} Rendez-vous
              </h5>
              <button 
                type="button" 
                class="btn-close" 
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>  
            </div>

            <!-- helpful message when editing  -->
            <div v-if="editingEvent" class="alert alert-info mb-0 mt-2">
              <i class="fas fa-info-circle"></i>
              Vous pouvez uniquement modifier le statut du rendez-vous. Les autres informations sont verrouillées.
            </div>

            <form @submit.prevent="saveEvent">
              <div class="modal-body">
                <!-- Patient Selection with Search -->
                <div class="mb-3">
                  <label class="form-label">
                    Patient 
                    <span v-if="!editingEvent" class="text-danger">*</span>
                  </label>
                  <!-- Add search input -->
                  <input 
                    v-model="patientSearchQuery"
                    type="text"
                    class="form-control mb-2"
                    placeholder="Rechercher un patient..."
                    @focus="loadAllPatients"
                    :disabled="editingEvent"
                  >

                  <select 
                    v-model="eventForm.patient_id" 
                    class="form-select patient-select"
                    :required="!editingEvent"
                    :disabled="editingEvent"
                    @scroll="handlePatientScroll"
                    @focus="loadAllPatients"
                  >
                    <option value="">Sélectionner un patient</option>
                    <option 
                      v-for="patient in filteredPatients" 
                      :key="patient.id" 
                      :value="patient.id"
                    >
                      {{ patient.name }} {{ patient.prenom }}
                    </option>
                    <option v-if="isLoadingPatients" disabled>
                      Chargement...
                    </option>
                  </select>
                  <small class="text-muted d-block mt-1">
                    <i class="fas fa-search"></i>
                    Tapez pour rechercher ou faites défiler pour charger plus
                  </small>
                </div>

                <!-- Medecin Selection -->
                <div class="mb-3" v-if="!medecinId">
                  <label class="form-label">Médecin <span class="text-danger">*</span></label>
                  <select 
                    v-model="eventForm.medecin_id" 
                    class="form-select"
                    :required="!editingEvent"
                    :disabled="editingEvent"
                  >
                    <option value="">Sélectionner un médecin</option>
                    <option 
                      v-for="medecin in medecins" 
                      :key="medecin.id" 
                      :value="medecin.id"
                    >
                      Dr. {{ medecin.name }} {{ medecin.prenom }}
                    </option>
                  </select>
                </div>

                <!-- Objet (Radio Buttons) -->
                <div class="mb-3">
                  <label class="form-label">Objet <span class="text-danger">*</span></label>
                  <div class="d-flex gap-2 flex-wrap">
                    <div class="form-check">
                      <input 
                        v-model="eventForm.objet" 
                        class="form-check-input" 
                        type="radio" 
                        value="Consultation"
                        id="objetConsultation"
                        :required="!editingEvent"
                        :disabled="editingEvent"
                      >
                      <label class="form-check-label" for="objetConsultation">
                        Consultation
                      </label>
                    </div>
                    <div class="form-check">
                      <input 
                        v-model="eventForm.objet" 
                        class="form-check-input" 
                        type="radio" 
                        value="Examen"
                        id="objetExamen"
                        :disabled="editingEvent"
                      >
                      <label class="form-check-label" for="objetExamen">
                        Examen
                      </label>
                    </div>
                    <div class="form-check">
                      <input 
                        v-model="eventForm.objet" 
                        class="form-check-input" 
                        type="radio" 
                        value="Acte"
                        id="objetActe"
                        :disabled="editingEvent"
                      >
                      <label class="form-check-label" for="objetActe">
                        Acte
                      </label>
                    </div>
                    <div class="form-check">
                      <input 
                        v-model="eventForm.objet" 
                        class="form-check-input" 
                        type="radio" 
                        value="Autres"
                        id="objetAutres"
                        :disabled="editingEvent"
                      >
                      <label class="form-check-label" for="objetAutres">
                        Autres
                      </label>
                    </div>
                  </div>
                </div>

                <!-- Title -->
                <div class="mb-3">
                  <label class="form-label">Titre</label>
                  <input 
                    v-model="eventForm.title" 
                    type="text" 
                    class="form-control"
                    placeholder="Généré automatiquement depuis le patient"
                    readonly
                  >
                </div>

                <!-- Date (Only Date, No Time) -->
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">
                      Date de rendez-vous 
                      <span v-if="!editingEvent" class="text-danger">*</span>
                    </label>
                    <input 
                      v-model="eventForm.start_date" 
                      type="date" 
                      class="form-control"
                      :required="!editingEvent"
                      :disabled="editingEvent"
                      :min="getTodayDate()"
                    >
                  </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                  <label class="form-label">Commentaire</label>
                  <textarea 
                    v-model="eventForm.description" 
                    class="form-control" 
                    rows="3"
                    placeholder="Notes ou informations complémentaires..."
                    :readonly="editingEvent"
                  ></textarea>
                </div>

                <!-- Statut - Conditional based on user role -->
                <div class="mb-3" v-if="editingEvent">
                  <label class="form-label">Statut</label>
                  <div class="status-radio-group d-flex gap-10 flex-wrap">
                    <!-- Always available statuses -->
                    <div class="status-radio-item">
                      <input 
                        type="radio" 
                        class="btn-check" 
                        name="statut" 
                        id="statut-a-venir" 
                        v-model="eventForm.statut" 
                        value="a venir"
                        autocomplete="off"
                      >
                      <label class="btn btn-outline-steelblue" for="statut-a-venir">
                        À venir
                      </label>
                    </div>

                    <div class="status-radio-item">
                      <input 
                        type="radio" 
                        class="btn-check" 
                        name="statut" 
                        id="statut-vu" 
                        v-model="eventForm.statut" 
                        value="vu"
                        autocomplete="off"
                      >
                      <label class="btn btn-outline-darkcyan" for="statut-vu">
                        Vu
                      </label>
                    </div>

                    <!-- Restricted statuses for medecins -->
                    <template v-if="userRole !== 2">
                      <div class="status-radio-item">
                        <input 
                          type="radio" 
                          class="btn-check" 
                          name="statut" 
                          id="statut-absence-excuse" 
                          v-model="eventForm.statut" 
                          value="absence excusé"
                          autocomplete="off"
                        >
                        <label class="btn btn-outline-plum" for="statut-absence-excuse">
                          Absence excusée
                        </label>
                      </div>

                      <div class="status-radio-item">
                        <input 
                          type="radio" 
                          class="btn-check" 
                          name="statut" 
                          id="statut-absence-non-excuse" 
                          v-model="eventForm.statut" 
                          value="absence non excusé"
                          autocomplete="off"
                        >
                        <label class="btn btn-outline-slateblue" for="statut-absence-non-excuse">
                          Absence non excusée
                        </label>
                      </div>
                    </template>

                    <div class="status-radio-item">
                      <input 
                        type="radio" 
                        class="btn-check" 
                        name="statut" 
                        id="statut-reporte" 
                        v-model="eventForm.statut" 
                        value="reporté"
                        autocomplete="off"
                      >
                      <label class="btn btn-outline-tomato" for="statut-reporte">
                        Reporté
                      </label>
                    </div>
                  </div>

                  <small class="text-muted d-block mt-2" v-if="userRole === 2">
                    <i class="fas fa-info-circle"></i>
                    En tant que médecin, vous pouvez changer le statut à "à venir", "vu" ou "reporté" uniquement.
                  </small>
                </div>
              </div>

              <!-- New Report Date (shown only when "reporté" is selected) -->
              <div v-if="editingEvent && eventForm.statut === 'reporté'" class="modal-body pt-0">
                <div class="alert alert-info mb-0">
                  <h6 class="alert-heading">
                    <i class="fas fa-calendar-plus"></i>
                    Nouvelle date du rendez-vous
                  </h6>
                  <div class="row">
                    <div class="col-md-6 mb-2">
                      <label class="form-label">Nouvelle date <span class="text-danger">*</span></label>
                      <input 
                        v-model="eventForm.new_report_date" 
                        type="date" 
                        class="form-control"
                        :min="getTodayDate()"
                        required
                      >
                    </div>
                  </div>
                  <small class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    Le rendez-vous sera déplacé à cette nouvelle date.
                  </small>
                </div>
              </div>
              
              <div class="modal-footer">
                <!-- Open Patient File Button -->
                <button 
                  v-if="editingEvent && eventForm.patient_id"
                  type="button"
                  class="btn btn-outline-success me-auto"
                  @click="openPatientFile"
                >
                  <i class="fas fa-folder-open"></i>
                  Ouvrir dossier patient
                </button>

                <button 
                  type="button" 
                  class="btn btn-secondary" 
                  data-bs-dismiss="modal"
                  :disabled="saving"
                >
                  Annuler
                </button>
                <button 
                  v-if="editingEvent && canDelete"
                  type="button"
                  class="btn btn-danger"
                  @click="deleteEvent"
                  :disabled="saving"
                >
                  <i class="fas fa-trash"></i>
                  Supprimer
                </button>
                <button 
                  type="submit"
                  class="btn btn-primary"
                  :disabled="saving"
                >
                  <span v-if="saving">
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    Enregistrement...
                  </span>
                  <span v-else>
                    <i class="fas fa-save"></i>
                    Enregistrer
                  </span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive, watch, nextTick, onBeforeUnmount } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import bootstrap5Plugin from '@fullcalendar/bootstrap5'
import resourceTimelinePlugin from '@fullcalendar/resource-timeline'
import frLocale from '@fullcalendar/core/locales/fr'
import axios from 'axios'
import { Modal } from 'bootstrap'
import FlashMessage from './FlashMessage.vue'
import debounce from 'lodash/debounce'

// ==================== PROPS ====================
const props = defineProps({
  medecinId: {
    type: [Number, String],
    required: false
  },
  medecinName: {
    type: String,
    required: false
  },
  editable: {
    type: Boolean,
    default: true
  },
  viewMode: {
    type: String,
    default: 'timeline'
  },
  canCreate: {
    type: Boolean,
    default: false
  },
  canUpdate: {
    type: Boolean,
    default: false
  },
  canDelete: {
    type: Boolean,
    default: false
  },
  userRole: {
    type: Number,
    required: true
  }
})

// ==================== REFS ====================
const fullCalendar = ref(null)
const eventModal = ref(null)
const flashMessage = ref(null)
const events = ref([])
const patients = ref([])
const allPatients = ref([])
const medecins = ref([])
const resources = ref([])
const editingEvent = ref(null)
const saving = ref(false)
const loading = ref(true)
const error = ref(null)
const currentView = ref('dayGridMonth')
const calendarTitle = ref('')
const selectedMedecinId = ref(props.medecinId || null)

// Patient search optimization
const patientSearchQuery = ref('')
const isLoadingPatients = ref(false)
const patientPage = ref(1)
const hasMorePatients = ref(true)

// Bootstrap Modal instance
let modalInstance = null

// ==================== COMPUTED ====================
const showSidebar = computed(() => {
  if (props.userRole === 2) {
    return !props.medecinId
  }
  return (props.userRole === 1 || props.userRole === 6) && !props.medecinId
})

const backUrl = computed(() => {
  if (props.medecinId) {
    return '/admin/events'
  }
  return '/admin/events'
})

const filteredPatients = computed(() => {
  if (!patientSearchQuery.value) {
    return allPatients.value
  }
  
  const query = patientSearchQuery.value.toLowerCase()
  return allPatients.value.filter(patient => {
    const fullName = `${patient.name} ${patient.prenom}`.toLowerCase()
    return fullName.includes(query)
  })
})

const calendarOptions = computed(() => {
  const baseOptions = {
    plugins: [
      dayGridPlugin,
      timeGridPlugin,
      interactionPlugin,
      listPlugin,
      bootstrap5Plugin,
      resourceTimelinePlugin
    ],
    themeSystem: 'bootstrap5',
    initialView: 'dayGridMonth',
    headerToolbar: false,
    locale: frLocale,
    locales: [frLocale],
    firstDay: 1,
    aspectRatio: 1.1,
    resourceAreaWidth: '15%',
    events: events.value,
    resources: resources.value,
    editable: false, // Disable drag and drop since we're date-only
    selectable: props.editable && (props.canCreate || props.userRole === 2),
    selectAllow: (selectInfo) => {
      const selectedDate = new Date(selectInfo.start)
      selectedDate.setHours(0, 0, 0, 0)
      const today = new Date()
      today.setHours(0, 0, 0, 0)
      return selectedDate >= today
    },
    select: handleDateSelect,
    eventClick: handleEventClick,
    nowIndicator: true,
    resourceLabelText: 'Médecins',
    contentHeight: 'auto',
  }

  return baseOptions
})

// ==================== REACTIVE FORM ====================
const eventForm = reactive({
  patient_id: '',
  medecin_id: props.medecinId || '',
  title: '',
  objet: 'Consultation',
  start_date: '',
  description: '',
  statut: 'a venir',
  new_report_date: ''
})

// ==================== AXIOS SETUP ====================
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

// ==================== WATCHERS ====================
watch([() => eventForm.patient_id, () => eventForm.objet], ([newPatientId, newObjet]) => {
  const patient = allPatients.value.find(p => p.id == newPatientId)
  if (patient) {
    eventForm.title = `${patient.name} ${patient.prenom}${newObjet ? ' - ' + newObjet : ''}`
  } else {
    eventForm.title = ''
  }
})

watch(() => eventForm.statut, (newStatut) => {
  if (newStatut !== 'reporté') {
    eventForm.new_report_date = ''
  }
})

watch(patientSearchQuery, (newQuery) => {
  patientPage.value = 1
  searchPatients(newQuery)
})

// ==================== UTILITY FUNCTIONS ====================
const getTodayDate = () => {
  const today = new Date()
  const year = today.getFullYear()
  const month = String(today.getMonth() + 1).padStart(2, '0')
  const day = String(today.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}

const getColorByStatut = (statut) => {
  const colors = {
    'a venir': '#4682B4',
    'vu': '#008B8B',
    'absence excusé': '#DDA0DD',
    'absence non excusé': '#6A5ACD',
    'reporté': '#FF6347'
  }
  return colors[statut] || '#3788d8'
}

const updateCalendarTitle = () => {
  const calendarApi = fullCalendar.value?.getApi()
  if (!calendarApi) return

  const currentDate = calendarApi.getDate()
  const viewType = calendarApi.view.type

  const formatMonthYear = new Intl.DateTimeFormat('fr-FR', {
    year: 'numeric',
    month: 'long'
  })

  const formatFullDate = new Intl.DateTimeFormat('fr-FR', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })

  if (viewType === 'dayGridMonth') {
    calendarTitle.value = formatMonthYear.format(currentDate)
  } else if (viewType === 'listWeek') {
    const start = calendarApi.view.activeStart
    const end = calendarApi.view.activeEnd
    const startStr = new Intl.DateTimeFormat('fr-FR', { day: 'numeric', month: 'long' }).format(start)
    const weekEnd = new Date(end)
    weekEnd.setDate(weekEnd.getDate() - 1)
    const endStr = new Intl.DateTimeFormat('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }).format(weekEnd)
    
    calendarTitle.value = `Semaine du ${startStr} au ${endStr}`
  } else if (viewType === 'timeGridDay') {
    calendarTitle.value = formatFullDate.format(currentDate)
  } else {
    calendarTitle.value = formatMonthYear.format(currentDate)
  }
}

// ==================== NAVIGATION FUNCTIONS ====================
const navigatePrev = () => {
  const calendarApi = fullCalendar.value?.getApi()
  if (calendarApi) {
    calendarApi.prev()
    updateCalendarTitle()
  }
}

const navigateNext = () => {
  const calendarApi = fullCalendar.value?.getApi()
  if (calendarApi) {
    calendarApi.next()
    updateCalendarTitle()
  }
}

const navigateToday = () => {
  const calendarApi = fullCalendar.value?.getApi()
  if (calendarApi) {
    calendarApi.today()
    updateCalendarTitle()
  }
}

const changeView = (viewName) => {
  const calendarApi = fullCalendar.value?.getApi()
  if (calendarApi) {
    calendarApi.changeView(viewName)
    currentView.value = viewName
    updateCalendarTitle()
  }
}

const selectMedecin = (medecinId) => {
  if (props.userRole === 1 || props.userRole === 6) {
    window.location.href = `/admin/events/medecin/${medecinId}`
  }
}

const openPatientFile = () => {
  if (eventForm.patient_id) {
    const url = `/admin/patients/${eventForm.patient_id}`
    window.open(url, '_blank')
  }
}

// ==================== DATA LOADING FUNCTIONS ====================
const searchPatients = debounce(async (query) => {
  if (isLoadingPatients.value) return
  
  isLoadingPatients.value = true
  try {
    const response = await axios.get('/admin/api/patients', {
      params: { q: query, page: patientPage.value },
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    
    if (patientPage.value === 1) {
      allPatients.value = response.data
    } else {
      allPatients.value = [...allPatients.value, ...response.data]
    }
    
    hasMorePatients.value = response.data.length === 50
  } catch (err) {
    console.error('Error searching patients:', err)
    flashMessage.value?.error('Erreur lors de la recherche des patients')
  } finally {
    isLoadingPatients.value = false
  }
}, 300)

const loadAllPatients = async () => {
  if (allPatients.value.length > 0) return
  
  patientPage.value = 1
  await searchPatients('')
}


const handlePatientScroll = (event) => {
  const { scrollTop, scrollHeight, clientHeight } = event.target
  
  if (scrollTop + clientHeight >= scrollHeight - 10 && 
      hasMorePatients.value && 
      !isLoadingPatients.value) {
    patientPage.value++
    searchPatients(patientSearchQuery.value)
  }
}

const loadEvents = async () => {
  try {
    loading.value = true
    error.value = null

    const url = props.medecinId
      ? `/admin/events/medecin/${props.medecinId}`
      : '/admin/events'

    const response = await axios.get(url, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      timeout: 10000
    })

    if (!response.data || !Array.isArray(response.data)) {
      throw new Error('Invalid response format')
    }

    const chunkSize = 100
    const chunks = []
    for (let i = 0; i < response.data.length; i += chunkSize) {
      chunks.push(response.data.slice(i, i + chunkSize))
    }

    events.value = []
    for (const chunk of chunks) {
      const processedChunk = chunk.map(event => ({
          id: event.id,
          title: event.patient ? `${event.patient.name} ${event.patient.prenom}${event.objet ? ' - ' + event.objet : ''}` : (event.title || ''),
          start: event.start,
          end: event.end,
          resourceId: event.medecin_id?.toString(),
          backgroundColor: event.color || getColorByStatut(event.statut || 'a venir'),
          borderColor: event.color || getColorByStatut(event.statut || 'a venir'),
          extendedProps: {
            patient_id: event.patient_id,
            medecin_id: event.medecin_id,
            description: event.description || '',
            objet: event.objet || '',
            statut: event.statut || 'a venir',
            patient: event.patient,
            medecin: event.medecin
          }
        }))
      
      events.value = [...events.value, ...processedChunk]
      await new Promise(resolve => setTimeout(resolve, 0))
    }

  } catch (err) {
    console.error('Error loading events:', err)
    error.value = 'Erreur lors du chargement des événements. ' + 
                  (err.response?.data?.message || err.message)
    flashMessage.value?.error('Erreur lors du chargement des événements')
  } finally {
    loading.value = false
  }
}

const loadPatients = async () => {
  try {
    const response = await axios.get('/admin/api/patients', {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    
    patients.value = Array.isArray(response.data) ? response.data : []
    allPatients.value = patients.value
    
  } catch (err) {
    console.error('Error loading patients:', err)
    error.value = 'Erreur lors du chargement des patients'
    flashMessage.value?.error('Erreur lors du chargement des patients')
  }
}

const loadMedecins = async () => {
  try {
    const response = await axios.get('/admin/api/medecins', {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    
    let filteredMedecins = Array.isArray(response.data) ? response.data : []
    
    if (props.userRole === 2 && props.medecinId) {
      filteredMedecins = filteredMedecins.filter(m => m.id == props.medecinId)
    }
    
    medecins.value = filteredMedecins
    
    resources.value = medecins.value.map(doc => ({
      id: doc.id.toString(),
      title: `Dr. ${doc.name} ${doc.prenom || ''}`
    }))
    
  } catch (err) {
    console.error('Error loading medecins:', err)
    error.value = 'Erreur lors du chargement des médecins'
    flashMessage.value?.error('Erreur lors du chargement des médecins')
  }
}

// ==================== EVENT HANDLERS ====================
const handleDateSelect = (selectInfo) => {
  if (!props.canCreate && props.userRole !== 2) return

  // Get selected date
  const selectedDate = new Date(selectInfo.start)
  selectedDate.setHours(0, 0, 0, 0)
  
  // Get today's date
  const today = new Date()
  today.setHours(0, 0, 0, 0)

  // Check if selected date is in the past (before today)
  if (selectedDate < today) {
    flashMessage.value?.warning('Vous ne pouvez pas créer un rendez-vous pour une date passée.')
    return
  }

  // Reset form
  editingEvent.value = null
  eventForm.patient_id = ''
  eventForm.medecin_id = props.medecinId || ''
  eventForm.title = ''
  eventForm.objet = 'Consultation'
  eventForm.description = ''
  eventForm.statut = 'a venir'
  eventForm.new_report_date = ''

  // Set selected date (format: YYYY-MM-DD)
  eventForm.start_date = selectInfo.startStr.split('T')[0]

  // Set medecin if clicking on resource
  if (selectInfo.resource) {
    eventForm.medecin_id = selectInfo.resource.id
  }

  openModal()
  
  // Unselect in calendar
  const calendarApi = fullCalendar.value?.getApi()
  if (calendarApi) {
    calendarApi.unselect()
  }
}

const handleEventClick = (clickInfo) => {
  const event = clickInfo.event
  editingEvent.value = event
  
  // Set form values (date only, no time)
  eventForm.patient_id = event.extendedProps.patient_id
  eventForm.medecin_id = event.extendedProps.medecin_id
  eventForm.title = event.title
  eventForm.objet = event.extendedProps.objet || 'Consultation'
  eventForm.start_date = event.startStr.split('T')[0]
  eventForm.description = event.extendedProps.description || ''
  eventForm.statut = event.extendedProps.statut || 'a venir'
  
  openModal()
}

const handleEventDrop = async (dropInfo) => {
  if (!props.editable && props.userRole !== 2) {
    dropInfo.revert()
    return
  }
  
  try {
    const event = dropInfo.event
    const updateData = {
      start: event.startStr,
      end: event.endStr
    }
    
    if (event.getResources && event.getResources().length > 0) {
      updateData.medecin_id = event.getResources()[0].id
    }
    
    await axios.put(`/admin/events/${event.id}`, updateData)
    
    event.setExtendedProp('medecin_id', updateData.medecin_id)
    flashMessage.value?.success('Rendez-vous déplacé avec succès')
  } catch (err) {
    console.error('Error updating event:', err)
    dropInfo.revert()
    flashMessage.value?.error(err.response?.data?.message || 'Erreur lors de la mise à jour du rendez-vous')
  }
}

const handleEventResize = async (resizeInfo) => {
  if (!props.editable && props.userRole !== 2) {
    resizeInfo.revert()
    return
  }
  
  try {
    await axios.put(`/admin/events/${resizeInfo.event.id}`, {
      start: resizeInfo.event.startStr,
      end: resizeInfo.event.endStr
    })
    flashMessage.value?.success('Durée du rendez-vous modifiée avec succès')
  } catch (err) {
    console.error('Error resizing event:', err)
    resizeInfo.revert()
    flashMessage.value?.error('Erreur lors de la modification de la durée')
  }
}

// ==================== MODAL FUNCTIONS ====================
const openCreateModal = () => {
  editingEvent.value = null
  resetForm()
  openModal()
}

const openModal = () => {
  if (!modalInstance) {
    modalInstance = new Modal(eventModal.value)
  }
  modalInstance.show()
}

const closeModal = () => {
  if (modalInstance) {
    modalInstance.hide()
  }
}

const resetForm = () => {
  eventForm.patient_id = ''
  eventForm.medecin_id = props.medecinId || ''
  eventForm.title = ''
  eventForm.objet = 'Consultation'
  eventForm.start_date = ''
  // eventForm.start_time = '09:00'
  eventForm.end_date = ''
  // eventForm.end_time = '10:00'
  eventForm.description = ''
  eventForm.statut = 'a venir'
  eventForm.original_start_date = ''
  // eventForm.original_start_time = ''
  eventForm.new_report_date = ''
  // eventForm.new_report_time = ''
}

// ==================== CRUD OPERATIONS ====================
const saveEvent = async () => {
  if (editingEvent.value && !props.canUpdate && props.userRole !== 2) {
    flashMessage.value?.warning('Vous n\'avez pas la permission de modifier ce rendez-vous.')
    return
  }
  
  if (!editingEvent.value && !props.canCreate && props.userRole !== 2) {
    flashMessage.value?.warning('Vous n\'avez pas la permission de créer des rendez-vous.')
    return
  }

  if (!eventForm.patient_id) {
    flashMessage.value?.warning('Veuillez sélectionner un patient')
    return
  }
  
  if (!eventForm.medecin_id && !props.medecinId) {
    flashMessage.value?.warning('Veuillez sélectionner un médecin')
    return
  }
  
  if (!eventForm.objet) {
    flashMessage.value?.warning('Veuillez sélectionner un objet')
    return
  }

  if (eventForm.statut === 'reporté') {
    if (!eventForm.new_report_date) {
      flashMessage.value?.warning('Veuillez choisir une nouvelle date pour le report.')
      return
    }
    
    const newDate = new Date(eventForm.new_report_date)
    newDate.setHours(0, 0, 0, 0)
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    
    if (newDate < today) {
      flashMessage.value?.warning('La nouvelle date de report ne peut pas être dans le passé.')
      return
    }
  }
  
  // Check if creating event for past date
  if (!editingEvent.value) {
    const startDate = new Date(eventForm.start_date)
    startDate.setHours(0, 0, 0, 0)
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    
    if (startDate < today) {
      flashMessage.value?.warning('Vous ne pouvez pas créer un rendez-vous pour une date passée.')
      return
    }
  }
  
  const calendarApi = fullCalendar.value?.getApi()
  const previousViewType = calendarApi?.view.type
  const previousDate = calendarApi ? calendarApi.getDate() : null
  
  saving.value = true
  
  try {
    const patient = allPatients.value.find(p => p.id == eventForm.patient_id)
    const title = patient ? `${patient.name} ${patient.prenom}${eventForm.objet ? ' - ' + eventForm.objet : ''}` : eventForm.title
    
    // For normal events (not being reported)
    let startDateTime = `${eventForm.start_date}T${eventForm.start_time}:00`
    // let endDateTime = `${eventForm.end_date || eventForm.start_date}T${eventForm.end_time}:00`

    const eventData = {
      patient_id: eventForm.patient_id,
      medecin_id: eventForm.medecin_id || props.medecinId,
      title: title,
      objet: eventForm.objet,
      start: eventForm.start_date, // Just date, no time
      description: eventForm.description,
      statut: eventForm.statut
    }

    // Add new date/time if status is "reporté"
    if (eventForm.statut === 'reporté' && eventForm.new_report_date) {
      eventData.new_report_date = eventForm.new_report_date
    }
    
    if (editingEvent.value) {
      const response = await axios.put(`/admin/events/${editingEvent.value.id}`, eventData)
      
      // Update the original event
      editingEvent.value.setProp('title', response.data.event.title)
      editingEvent.value.setStart(response.data.event.start)
      editingEvent.value.setEnd(response.data.event.end)
      editingEvent.value.setProp('backgroundColor', response.data.event.color || getColorByStatut(response.data.event.statut))
      editingEvent.value.setProp('borderColor', response.data.event.color || getColorByStatut(response.data.event.statut))
      editingEvent.value.setExtendedProp('statut', response.data.event.statut)
      
      // Reload all events to show the new reported event
      await loadEvents()
      
      flashMessage.value?.success(response.data.message || 'Rendez-vous modifié avec succès')
    } else {
      const response = await axios.post('/admin/events', eventData)
      await loadEvents()
      flashMessage.value?.success(response.data.message || 'Rendez-vous créé avec succès')
    }
    
    closeModal()
    resetForm()
    
    if (calendarApi && previousViewType) {
      calendarApi.changeView(previousViewType, previousDate || undefined)
      currentView.value = previousViewType
      updateCalendarTitle()
    }
    
  }catch (err) {
    console.error('Error saving event:', err)
    const errorMsg = err.response?.data?.message || err.response?.data?.errors || 'Erreur lors de l\'enregistrement'
    const displayMsg = typeof errorMsg === 'object' ? JSON.stringify(errorMsg) : errorMsg 
    flashMessage.value?.error(displayMsg)
  } finally {
    saving.value = false
  }
}

const deleteEvent = async () => {
  if (!props.canDelete && props.userRole !== 2) {
    flashMessage.value?.warning('Vous n\'avez pas la permission de supprimer ce rendez-vous.')
    return
  }

  if (!confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')) {
    return
  }

  const calendarApi = fullCalendar.value?.getApi()
  const previousViewType = calendarApi?.view.type
  const previousDate = calendarApi ? calendarApi.getDate() : null
  
  saving.value = true
  
  try {
    await axios.delete(`/admin/events/${editingEvent.value.id}`)
    editingEvent.value.remove()
    await loadEvents()
    
    if (calendarApi && previousViewType) {
      calendarApi.changeView(previousViewType, previousDate || undefined)
      currentView.value = previousViewType
      updateCalendarTitle()
    }
    
    closeModal()
    resetForm()
    flashMessage.value?.success('Rendez-vous supprimé avec succès')
  } catch (err) {
    console.error('Error deleting event:', err)
    flashMessage.value?.error('Erreur lors de la suppression')
  } finally {
    saving.value = false
  }
}

// ==================== LIFECYCLE ====================
onMounted(async () => {
  try {
    await loadMedecins()
    await loadEvents()
    
    const calendarApi = fullCalendar.value?.getApi()
    if (calendarApi) {
      calendarApi.today()
      currentView.value = 'dayGridMonth'
      updateCalendarTitle()
    }
  } catch (err) {
    console.error('Error during initialization:', err)
    error.value = 'Erreur lors de l\'initialisation du calendrier'
    loading.value = false
  }
  updateCalendarTitle()
})

// Ensure calendar and sidebar heights stay in sync and increase grid height by ~25%
const adjustHeights = async () => {
  await nextTick()
  try {
    const calendarContainer = document.querySelector('.calendar-container')
    const calendarArea = document.querySelector('.calendar-area')
    const sidebar = document.querySelector('.medecin-sidebar')

    if (!calendarContainer) return

    // Increase the baseline min-height by 25% (for squarer cells)
    const baseMin = 500
    const increasedMin = Math.round(baseMin * 1.5)
    calendarArea && (calendarArea.style.minHeight = `${increasedMin}px`)
    calendarContainer.style.minHeight = `${increasedMin}px`

    // If sidebar exists, make it match the calendar container height
    if (sidebar) {
      sidebar.style.minHeight = `${increasedMin}px`
      // match exact rendered height to avoid mismatches from padding
      const renderedHeight = calendarContainer.getBoundingClientRect().height
      sidebar.style.height = `${renderedHeight}px`
      calendarContainer.style.height = `${renderedHeight}px`
    }
  } catch (e) {
    // silent
  }
}

// call adjust after load and on window resize
const boundAdjust = debounce(() => adjustHeights(), 120)
window.addEventListener('resize', boundAdjust)
watch(loading, (val) => {
  if (!val) {
    // after loading finishes, ensure heights match
    setTimeout(() => adjustHeights(), 50)
  }
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', boundAdjust)
})

// ==================== EXPOSE ====================
defineExpose({
  loadEvents,
  getApi: () => fullCalendar.value?.getApi()
})

</script>

<style scoped>
/* ==================== CSS VARIABLES ==================== */
:root {
  --color-steelblue: #4682B4;
  --color-darkcyan: #008B8B;
  --color-plum: #DDA0DD;
  --color-slateblue: #6A5ACD;
  --color-tomato: #FF6347;
  --color-custom: #3788d8;
}

/* ==================== LAYOUT ==================== */
.calendar-wrapper {
  display: flex;
  padding: 20px;
  align-items: flex-start;
  min-height: calc(100vh - 40px);
}

.calendar-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 20px; 
}
.content-row {
  display: flex;
  gap: 20px;
  align-items: stretch;
  flex: 1;
  min-height: 0;
  height: 100%; /* Add this */
}

.content-row.with-sidebar {
  gap: 20px;
}

.calendar-area {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height:875px;
  height: 100%; 
}

.calendar-area.with-sidebar {
  flex: 1;
  max-height: calc(100vh - 280px); /* Adjust based on header height */
}

.calendar-container {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  flex: 1;
  height: 100%;
  min-height: 875px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.calendar-container > * {
  flex: 1;
  min-height: 0;
}

/* ==================== SIDEBAR ==================== */
.medecin-sidebar {
  width: 250px;
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  align-self: stretch; /* Changed from flex-start to stretch */
  height: 100%; /* Change from max-height calculation */
  min-height: 875px; /* Match calendar-container min-height */
  overflow: hidden;
}

.sidebar-title {
  font-weight: 600;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 2px solid #e9ecef;
  flex-shrink: 0;
}

.medecin-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
  overflow-y: auto;
  flex: 1;
  padding-right: 5px;
  min-height: 0;
}


.medecin-list::-webkit-scrollbar {
  width: 6px;
}

.medecin-list::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.medecin-list::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.medecin-list::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.medecin-item {
  padding: 12px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  border: 1px solid #e9ecef;
}

.medecin-item:hover {
  background-color: #f8f9fa;
  border-color: #0d6efd;
}

.medecin-item.active {
  background-color: #0d6efd;
  color: white;
  border-color: #0d6efd;
}

/* ==================== LOADING SKELETON ==================== */
.calendar-skeleton {
  padding: 20px;
  background: white;
  border-radius: 8px;
}

.skeleton-header {
  height: 40px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: loading 1.5s infinite;
  border-radius: 4px;
  margin-bottom: 20px;
}

.skeleton-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 10px;
}

.skeleton-cell {
  height: 100px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: loading 1.5s infinite;
  border-radius: 4px;
}

@keyframes loading {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* ==================== PATIENT SELECT ==================== */
.patient-select {
  max-height: 300px;
  overflow-y: auto;
}

.patient-select::-webkit-scrollbar {
  width: 8px;
}

.patient-select::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.patient-select::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

.patient-select::-webkit-scrollbar-thumb:hover {
  background: #555;
}
/* ==================== STATUS LEGEND ==================== */
.status-legend {
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 8px;
  margin-bottom: 20px;
}

.status-legend h6 {
  margin-bottom: 12px;
  font-weight: 600;
  color: #495057;
}

.status-legend .d-flex {
  gap: 4 !important;
}

.status-legend .badge {
  border-radius: 0;
  padding: 10px 20px;
  font-weight: 500;
  font-size: 0.9rem;
  border-right: 1px solid rgba(255, 255, 255, 0.3);
  flex: 1;
  text-align: center;
}

.status-item {
  display: flex;
  align-items: center;
}

.status-box {
  width: 15px;
  height: 15px;
  margin-right: 8px;
  border-radius: 3px; /* Optional: to make the corners slightly rounded */
}


.status-legend .badge:first-child {
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
}

.status-legend .badge:last-child {
  border-top-right-radius: 6px;
  border-bottom-right-radius: 6px;
  border-right: none;
}

/* ==================== STATUS BUTTONS (Modal) ==================== */
.status-radio-group {
  display: flex;
  gap: 0;
  flex-wrap: nowrap;
  border-radius: 6px;
  overflow: hidden;
}

.status-radio-item {
  flex: 1;
  min-width: auto;
}

.status-radio-item .btn {
  border-radius: 0;
  width: 100%;
  padding: 10px 15px;
  font-size: 0.9rem;
  font-weight: 500;
}

.status-radio-item:first-child .btn {
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
}

.status-radio-item:last-child .btn {
  border-top-right-radius: 6px;
  border-bottom-right-radius: 6px;
}

/* Update individual button styles */


/* Steel Blue button */

.btn-outline-steelblue {
  color: #2d5475;
  border: 1px solid transparent;
  background-color: #d6e7f5;
  transition: all 0.3s ease;
}

.btn-outline-steelblue:hover,
.btn-outline-steelblue:focus {
  background-color: #3a6d99;
  color: white;
}

.btn-outline-steelblue.active,
.btn-check:checked + .btn-outline-steelblue {
  background-color: #2d5475;
  color: white;
  box-shadow: inset 0 2px 4px rgba(0, 48, 70, 0.2);
}

.btn-check:not(:checked) + .btn-outline-steelblue {
  opacity: 0.8;
}

/* Dark-Cyan button  */


.btn-outline-darkcyan {
  color: #005555;
  border: 1px solid transparent;
  background-color: #d8f7f7;
  transition: all 0.3s ease;
}

.btn-outline-darkcyan:hover,
.btn-outline-darkcyan:focus {
  background-color: #006d6d;
  color: white;
}

.btn-outline-darkcyan.active,
.btn-check:checked + .btn-outline-darkcyan {
  background-color: #005555;
  color: white;
  box-shadow: inset 0 2px 4px rgba(2, 48, 45, 0.2);
}

.btn-check:not(:checked) + .btn-outline-darkcyan {
  opacity: 0.8;
}


/* plum buton  */

.btn-outline-plum {
  color: #961d96;
  border: 1px solid transparent;
  background-color: #f5e2f5;
  transition: all 0.3s ease;
}

.btn-outline-plum:hover,
.btn-outline-plum:focus {
  background-color: #d088d0;
  color: white;
}

.btn-outline-plum.active,
.btn-check:checked + .btn-outline-plum {
  background-color: #8d0f8d;
  color: white;
  box-shadow: inset 0 2px 4px rgba(74, 2, 88, 0.2);
}

.btn-check:not(:checked) + .btn-outline-plum {
  opacity: 0.8;
}


/* Slate-Blue button  */

.btn-outline-slateblue {
  color: #4436a0;
  border: 1px solid transparent;
  background-color: #e1def5;
  transition: all 0.3s ease;
}

.btn-outline-slateblue:hover,
.btn-outline-slateblue:focus {
  background-color: #5747b8;
  color: white;
}

.btn-outline-slateblue.active,
.btn-check:checked + .btn-outline-slateblue {
  background-color: #4436a0;
  color: white;
  box-shadow: inset 0 2px 4px rgba(53, 2, 148, 0.2);
}

.btn-check:not(:checked) + .btn-outline-slateblue {
  opacity: 0.8;
}

/* Tomato button  */

.btn-outline-tomato {
  color: #cc4a34;
  border: 1px solid transparent;
  background-color: #f7e7e4;
  transition: all 0.3s ease;
}

.btn-outline-tomato:hover,
.btn-outline-tomato:focus {
  background-color: #e5573d;
  color: white;
}

.btn-outline-tomato.active,
.btn-check:checked + .btn-outline-tomato {
  background-color: #cc4a34;
  color: white;
  box-shadow: inset 0 2px 4px rgba(65, 29, 1, 0.2);
}

.btn-check:not(:checked) + .btn-outline-tomato {
  opacity: 0.8;
}

/* Additional styles for better spacing in modal */
.modal-body {
  padding: 20px;
}

/* Form labels */
.form-label {
  font-weight: bold;
}

/* Button styles for modal footer */
.modal-footer {
  display: flex;
  justify-content: space-between;
  padding: 15px;
}


/* Add to <style scoped> section */
.form-control:read-only,
.form-select:disabled,
.form-check-input:disabled {
  background-color: #e9ecef;
  cursor: not-allowed;
  opacity: 0.7;
}


</style>
