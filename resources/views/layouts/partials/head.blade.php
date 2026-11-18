<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $titulo ? $titulo.' — ' : '' }}{{ config('app.name', 'RollNacional') }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap">

<link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ is_file(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : 0 }}">
<script defer src="{{ asset('js/alpine.min.js') }}"></script>
