import _ from 'lodash-es';
window._ = _;

import $ from 'jquery';
window.$ = window.jQuery = $;

// Setup CSRF token immediately when jQuery is ready
$(function() {
    // Get CSRF token from meta tag
    const token = document.head.querySelector('meta[name="csrf-token"]');
    
    if (token) {
        // Set up CSRF token for jQuery AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token.content
            }
        });
        console.log('CSRF token configured successfully for jQuery');
    } else {
        console.warn('CSRF token meta tag not found in document head. Make sure <meta name="csrf-token" content="{{ csrf_token() }}"> exists in your layout.');
    }
});