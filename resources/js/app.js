import '../assets/js/bootstrap';
import '../assets/sass/app.scss';

import '../../public/admin/js/main.js';
import '../../public/admin/js/script.js';

// Import Font Awesome
import '@fortawesome/fontawesome-free/js/all';

// Import DataTables
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Import Froala Editor
import FroalaEditor from 'froala-editor';
import 'froala-editor/js/plugins.pkgd.min.js';
window.FroalaEditor = FroalaEditor;

// Import Vue
import { createApp } from 'vue';

// Import Vue Components
import EventsCalendar from '../assets/js/components/EventsCalendar.vue';
import FlashMessage from '../assets/js/components/FlashMessage.vue';

// Import Axios for global configuration
import axios from 'axios';

// Define waitForjQuery globally BEFORE any usage
window.waitForjQuery = function(callback) {
    if (window.jQuery) {
        callback();
    } else {
        setTimeout(() => window.waitForjQuery(callback), 50);
    }
};

// Configure Axios globally when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Configure Axios defaults
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    
    // Get CSRF token from meta tag
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        console.log('CSRF token configured successfully for Axios');
    } else {
        console.warn('CSRF token meta tag not found. Make sure it exists in admin.blade.php');
    }

    // Make axios available globally
    window.axios = axios;
});

// Initialize Vue app only if #app exists
document.addEventListener('DOMContentLoaded', function() {
    const appElement = document.getElementById('app');
    
    if (appElement) {
        // Create Vue app instance
        const app = createApp({});
        
        // Register components globally
        app.component('events-calendar', EventsCalendar);
        app.component('flash-message', FlashMessage);
        
        // Mount Vue app to #app div
        app.mount('#app');
        
        console.log('Vue app mounted successfully');
    }
});

// Initialize other components after jQuery is loaded
window.waitForjQuery(function() {
    $(document).ready(function() {
        console.log('jQuery ready, initializing components...');
        
        // Initialize tooltips and popovers
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // DataTables initialization for generic .datatable class
        if ($.fn.DataTable && $('.datatable').length) {
            $('.datatable').each(function() {
                if (!$.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable({
                        pageLength: 25,
                        responsive: true
                    });
                }
            });
        }

        // Toggle password visibility
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });
    });
});
