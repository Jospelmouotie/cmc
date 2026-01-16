<?php
// This view renders raw HTML content passed from the controller for PDF generation.
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Document' }}</title>
    <link href="{{ public_path('vendor/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
    </style>
</head>
<body>
    {!! $html !!}
</body>
</html>