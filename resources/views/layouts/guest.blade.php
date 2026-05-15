<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>PANTAU PAS</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.webp') }}">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="relative overflow-hidden font-sans antialiased">

    <!-- BASE -->
    <div class="absolute inset-0 bg-slate-100"></div>

    <!-- BLUR ORB 1 -->
    <div
        class="absolute -top-40 -left-32 h-[500px] w-[500px]
        rounded-full bg-primary/20 blur-[120px]">
    </div>

    <!-- BLUR ORB 2 -->
    <div
        class="absolute top-1/2 -right-40 h-[600px] w-[600px]
        rounded-full bg-accent/20 blur-[140px]">
    </div>

    <!-- BLUR ORB 3 -->
    <div
        class="absolute bottom-0 left-1/3 h-80 w-80
        rounded-full bg-blue-400/10 blur-[100px]">
    </div>

    <!-- GRID PATTERN HALUS -->
    <div
        class="absolute inset-0 opacity-[0.03]"
        style="
        background-image:
        linear-gradient(#000 1px, transparent 1px),
        linear-gradient(90deg,#000 1px,transparent 1px);

        background-size:40px 40px;
        ">
    </div>

    <!-- ISI -->
    <div class="relative z-10">

        {{ $slot }}

    </div>

</body>

</html>