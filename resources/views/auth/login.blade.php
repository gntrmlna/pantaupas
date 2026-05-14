<x-guest-layout>

<div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4">

    <!-- CARD -->

    <div
        class="relative z-10 grid w-full max-w-5xl overflow-hidden rounded-[32px]
        border border-white/20 bg-white/60 shadow-2xl backdrop-blur-xl md:grid-cols-2">


        <!-- PANEL KIRI -->

        <div
            class="hidden flex-col justify-between bg-gradient-to-br from-primary via-secondary to-primary p-10 text-white md:flex">

            <div>

                <h1 class="mb-3 text-5xl font-bold">

                    PANTAU PAS

                </h1>

                <p class="leading-relaxed text-white/80">

                    Sistem Monitoring dan Penilaian
                    Publikasi UPT Pemasyarakatan

                </p>


                <!-- LOGO -->

                <div class="mt-8 flex justify-center">

                    <img
                        src="{{ asset('images/logo.webp') }}"
                        alt="logo"
                        class="w-72 drop-shadow-2xl transition hover:scale-105"
                    >

                </div>

            </div>


            <!-- FITUR -->

            <div class="space-y-4 text-sm text-white/80">

                <div class="flex items-center gap-3">

                    <span>📊</span>

                    Monitoring publikasi UPT

                </div>

                <div class="flex items-center gap-3">

                    <span>🏆</span>

                    Penilaian indikator publikasi

                </div>

                <div class="flex items-center gap-3">

                    <span>📈</span>

                    Dashboard statistik realtime

                </div>

            </div>

        </div>



        <!-- PANEL KANAN -->

        <div
            class="bg-white/40 p-8 backdrop-blur-sm md:p-12">

            <div class="mb-10">

                <h2
                    class="text-4xl font-bold text-gray-800">

                    Selamat Datang

                </h2>

                <p
                    class="mt-2 text-gray-500">

                    Login untuk masuk ke dashboard

                </p>

            </div>


            <form
                method="POST"
                action="{{ route('login') }}"
                class="space-y-6">

                @csrf


                <div>

                    <label
                        class="mb-2 block text-sm font-medium text-gray-700">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus

                        class="w-full rounded-2xl border border-accent/30
                        bg-white/50 px-5 py-4 outline-none
                        backdrop-blur-sm
                        focus:border-accent focus:ring-0"
                    >

                </div>



                <div>

                    <label
                        class="mb-2 block text-sm font-medium text-gray-700">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        required

                        class="w-full rounded-2xl border border-accent/30
                        bg-white/50 px-5 py-4 outline-none
                        backdrop-blur-sm
                        focus:border-accent focus:ring-0"
                    >

                </div>


                <div
                    class="flex items-center justify-between text-sm">

                    <!-- <label
                        class="flex items-center gap-2 text-gray-600">

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        Ingat Saya

                    </label> -->

                </div>


                @if($errors->any())

                    <div
                        class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-500">

                        {{ $errors->first() }}

                    </div>

                @endif


                <button

                    class="w-full rounded-2xl bg-accent py-4 font-semibold text-black transition hover:scale-[1.02] hover:brightness-95">

                    Masuk

                </button>

            </form>

            <p
                class="mt-10 text-center text-sm text-gray-400">

                PANTAU PAS © {{ date('Y') }}

            </p>

        </div>

    </div>

</div>

</x-guest-layout>