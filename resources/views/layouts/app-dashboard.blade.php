<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PANTAU PAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-soft">

    <div class="flex min-h-screen">

        <!-- Overlay Mobile -->
        <div
            id="overlay"
            class="fixed inset-0 z-40 hidden bg-black/40"
            onclick="closeSidebar()"
        ></div>

        <!-- Sidebar -->
        <div
            id="sidebar"
            class="fixed top-0 left-0 z-50 h-screen w-64 overflow-y-auto bg-gradient-to-b from-primary to-secondary p-5 text-white
                transition-all duration-300
                -translate-x-full md:translate-x-0"
        >

            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">

                <div id="logoWrapper">

                    <h1
                        id="logoText"
                        class="text-xl font-bold"
                    >
                        PANTAU PAS
                    </h1>

                    <p
                        id="logoSub"
                        class="text-sm opacity-70"
                    >
                        Monitoring Publikasi
                    </p>

                </div>

                <!-- desktop -->
                <button
                    class="hidden md:block"
                    onclick="toggleSidebar()"
                >
                    ☰
                </button>

                <!-- mobile -->
                <button
                    class="md:hidden"
                    onclick="closeSidebar()"
                >
                    ✕
                </button>

            </div>

            <nav class="space-y-2">

                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded p-3 hover:bg-white/10"
                >
                    <span>📊</span>

                    <span class="menu-text">
                        Dashboard
                    </span>
                </a>

                <a
                    href="{{ route('publikasi.create') }}"
                    class="flex items-center gap-3 rounded p-3 hover:bg-white/10"
                >
                    <span>➕</span>

                    <span class="menu-text">
                        Input Data
                    </span>
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        class="flex w-full items-center gap-3 rounded p-3 hover:bg-red-500/20"
                    >
                        <span>🚪</span>

                        <span class="menu-text">
                            Logout
                        </span>
                    </button>

                </form>

            </nav>

        </div>

        <!-- Content -->
        <div
            id="content"
            class="flex-1 p-6 transition-all duration-300 md:ml-64"
        >
            <div class="mb-5 flex items-center justify-between md:hidden">

                <button
                    onclick="openSidebar()"
                    class="text-xl"
                >
                    ☰
                </button>

                <h1 class="font-bold">
                    PANTAU PAS
                </h1>

            </div>
            @yield('content')
        </div>

    </div>
<div
    id="loadingModal"
    class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/40"
>

    <div class="w-72 rounded-2xl bg-white p-6 text-center shadow-xl">

        <div id="loadingContent">

            <div class="mb-4 flex justify-center">
                <div
                    class="h-10 w-10 animate-spin rounded-full border-4 border-accent border-t-transparent"
                ></div>
            </div>

            <p class="font-medium">
                Menyimpan data...
            </p>

        </div>

    </div>

</div>
<script>
    const form = document.querySelector('#formPublikasi');

    if (form) {

        form.addEventListener('submit', function(){

            const modal =
                document.getElementById('loadingModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

        });

    }
</script>
<script>

function openSidebar(){

    document
        .getElementById('sidebar')
        .classList
        .remove('-translate-x-full');

    document
        .getElementById('overlay')
        .classList
        .remove('hidden');

}

function closeSidebar(){

    document
        .getElementById('sidebar')
        .classList
        .add('-translate-x-full');

    document
        .getElementById('overlay')
        .classList
        .add('hidden');

}

function toggleSidebar(){

    if(window.innerWidth<768) return;

    const sidebar=
        document.getElementById('sidebar');

    const content=
        document.getElementById('content');

    const texts=
        document.querySelectorAll('.menu-text');

    const logoText=
        document.getElementById('logoText');

    const logoSub=
        document.getElementById('logoSub');


    if(sidebar.classList.contains('w-64')){

        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');

        content.classList.remove('md:ml-64');
        content.classList.add('md:ml-20');

        texts.forEach(el=>el.classList.add('hidden'));

        logoText.classList.add('hidden');
        logoSub.classList.add('hidden');

    }

    else{

        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');

        content.classList.remove('md:ml-20');
        content.classList.add('md:ml-64');

        texts.forEach(el=>el.classList.remove('hidden'));

        logoText.classList.remove('hidden');
        logoSub.classList.remove('hidden');

    }

}

</script>
</body>
</html>