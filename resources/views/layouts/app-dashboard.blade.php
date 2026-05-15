<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PANTAU PAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body{
            font-family:'Inter',sans-serif;
        }
    </style>
</head>

<body class="max-w-full overflow-x-hidden bg-soft">

    <div class="flex min-h-screen max-w-full overflow-x-hidden">

        <!-- Overlay Mobile -->

        <div id="overlay"
             class="fixed inset-0 z-40 hidden bg-black/40"
             onclick="closeSidebar()">
        </div>


        <!-- Sidebar -->

        <aside id="sidebar"
               class="fixed left-0 top-0 z-50 h-screen w-64 shrink-0 overflow-y-auto bg-gradient-to-b from-primary to-secondary p-5 text-white transition-all duration-300 -translate-x-full md:translate-x-0">

            <!-- Header -->

            <div class="mb-8 flex items-center justify-between">

                <div>

                    <h1 id="logoText"
                        class="text-xl font-bold">
                        PANTAU PAS
                    </h1>

                    <p id="logoSub"
                       class="text-sm opacity-70">
                        Monitoring Publikasi
                    </p>

                </div>

                <!-- Desktop -->

                <button class="hidden md:block"
                        onclick="toggleSidebar()">
                    ☰
                </button>

                <!-- Mobile -->

                <button class="md:hidden"
                        onclick="closeSidebar()">
                    ✕
                </button>

            </div>


            <!-- Menu -->

            <nav class="space-y-2">

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-white/80 transition hover:bg-white/10">

                    <span class="text-lg">📊</span>

                    <span class="menu-text">
                        Dashboard
                    </span>

                </a>


                @if(auth()->user()->role=='admin')

                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-white/80 transition hover:bg-white/10">

                    <span class="text-lg">👤</span>

                    <span class="menu-text">
                        Kelola User
                    </span>

                </a>

                @endif


                <a href="{{ route('publikasi.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-white/80 transition hover:bg-white/10">

                    <span class="text-lg">📄</span>

                    <span class="menu-text">
                        Data Publikasi
                    </span>

                </a>


                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-white/80 transition hover:bg-red-500/20">

                        <span class="text-lg">🚪</span>

                        <span class="menu-text">
                            Logout
                        </span>

                    </button>

                </form>

            </nav>

        </aside>


        <!-- Content -->

        <main id="content"
              class="min-w-0 overflow-x-hidden flex-1 p-4 sm:p-6 transition-all duration-300 md:ml-64">

            <!-- Mobile Navbar -->

            <div class="mb-5 flex items-center justify-between md:hidden">

                <button onclick="openSidebar()"
                        class="text-xl">
                    ☰
                </button>

                <h1 class="font-bold">
                    PANTAU PAS
                </h1>

            </div>

            @yield('content')

        </main>

    </div>


    <!-- Loading Modal -->

    <div id="loadingModal"
         class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/40">

        <div class="w-72 rounded-2xl bg-white p-6 text-center shadow-xl">

            <div id="loadingContent">

                <div class="mb-4 flex justify-center">

                    <div class="h-10 w-10 animate-spin rounded-full border-4 border-accent border-t-transparent">
                    </div>

                </div>

                <p class="font-medium">
                    Menyimpan data...
                </p>

            </div>

        </div>

    </div>


    <script>

    const form=document.querySelector('#formPublikasi');

    if(form){

        form.addEventListener('submit',function(){

            const modal=document.getElementById('loadingModal');

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

        const sidebar=document.getElementById('sidebar');
        const content=document.getElementById('content');

        const texts=document.querySelectorAll('.menu-text');

        const logoText=document.getElementById('logoText');
        const logoSub=document.getElementById('logoSub');


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