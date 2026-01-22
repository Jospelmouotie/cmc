# TODO: Update EventsCalendar.vue

## Steps to Complete
- [ ] Add loading state management (const loading = ref(true), show spinner in template)
- [ ] Import resourceTimelinePlugin from '@fullcalendar/resource-timeline'
- [ ] Add loadRessources function to load resources (medecins)
- [ ] Add getStatusColor function for status-based colors
- [ ] Update calendarOptions to include resourceTimelinePlugin and resources configuration
- [ ] Modify loadEvents to use status colors and assign resourceId
- [ ] Change data loading to parallel using Promise.all([loadRessources(), loadPatients(), loadEvents()])
- [ ] Update template to show loading spinner when loading is true
- [ ] Test the updated component
