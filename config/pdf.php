<?php

return [
    'title' => 'CMCU Facture',

    'author' => 'CMCU',

    /**
     * 'c'  Core - non-embedded fonts only
     * 's'  Subsetting fonts - Embedded Unicode fonts
     */
    'mode' => 's',

    /*
     * Page size A4, A3, latter etc.
     */
    'format' => 'A4',

    /*
     * Default font size for all text
     */
    'default_font_size' => '12',

    /*
     * Default font for all text
     */
    'default_font' => 'dejavusans',

    /*
     * Path for font folder
     *
     * don't forget the trailing slash!
     */
    'custom_font_path' =>public_path('fonts/ttf/'),

    /*
     * Content direction ltr or rtl
     */
    'direction' => 'ltr',

    /*
     * Page left margin
     */
    'margin_left' => 10,

    /*
     * Page right margin
     */
    'margin_right' => 10,

    /*
     * Page top margin
     */
    'margin_top' => 15,

    /*
     * Page bottom margin
     */
    'margin_bottom' => 15,

    /*
     * Page header margin
     */
    'margin_header' => 5,

    /*
     * Page footer margin
     */
    'margin_footer' => 5,

    /*
     * Page orientation L - landscape, P - portrait
     */
    'orientation' => 'P',

    /**
     * Show watermark - DISABLED
     */
    'show_watermark' => false, // Changed to false to remove watermark
    
    /**
     * Allow remote images/resources
     */
    'allow_remote' => true,

    /**
     * Watermark text - Keep but won't show since show_watermark is false
     */
    'watermark' => '',
    'watermark_font' => 'sans-serif',

    /**
     * Set watermark display.
     * 'fullpage', 'fullwidth', 'real', 'default', 'none'
     */
    'display_mode' => 'none', // Changed to none
    // 'display_mode' => 'fullpage',
    /**
     * Set value 0 to 1
     */
    'watermark_text_alpha' => 0, // Set to 0 to make invisible

    /**
     * Image DPI setting
     */
    'img_dpi' => 96,

    /**
     * Enable or disable the built-in caching of images
     */
    'enable_remote_cache' => true,

    /**
     * Timeout for remote requests
     */
    'curlTimeout' => 10,

    'auto_language_detect' => false,
    
    /**
     * Additional mPDF settings
     */
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
    'useSubstitutions' => true,
    
    /**
     * Explicitly disable all watermarks
     */
    'watermark_font_size' => 0,
    'watermark_image' => '',
];