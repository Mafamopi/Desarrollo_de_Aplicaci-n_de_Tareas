<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- <link href="/resources/css/app.css" rel="stylesheet"> -->

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
