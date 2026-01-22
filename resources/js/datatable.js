// Wait for jQuery to be defined globally
window.waitForjQuery = function(callback) {
    if (window.jQuery) {
        callback();
    } else {
        setTimeout(() => waitForjQuery(callback), 50);
    }
};

// Initialize DataTables
$(document).ready(function() {
    try {
        $('.datatable').DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    } catch (error) {
        console.error('DataTables initialization error:', error);
    }
});
