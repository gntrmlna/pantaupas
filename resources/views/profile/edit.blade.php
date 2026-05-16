@extends('layouts.app-dashboard')

@section('content')

<div class="mx-auto max-w-2xl space-y-6">

    <div>

        <h1 class="text-2xl font-bold">
            Profil Saya
        </h1>

        <p class="text-gray-500">
            Kelola akun dan keamanan password
        </p>

    </div>


    <div class="rounded-[28px] border border-white/50 bg-white/90 p-6 shadow-sm backdrop-blur">

        <div class="mb-8 flex items-center gap-4">

            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary text-2xl font-bold text-white">

                {{ strtoupper(substr(auth()->user()->name,0,1)) }}

            </div>

            <div>

                <h2 class="text-lg font-bold">
                    {{ auth()->user()->name }}
                </h2>

                <p class="text-sm text-gray-500">
                    {{ auth()->user()->email }}
                </p>

                <span class="mt-2 inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">

                    {{ ucfirst(auth()->user()->role) }}

                </span>

            </div>

        </div>


        @if(session('success'))

        <div class="mb-5 rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-600">

            {{ session('success') }}

        </div>

        @endif


        @if ($errors->any())

        <div class="mb-5 rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-600">

            <ul class="space-y-1">

                @foreach ($errors->all() as $error)

                    <li>
                        • {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

        @endif


        <form method="POST"
              action="{{ route('profile.password') }}"
              class="space-y-4">

            @csrf
            @method('PUT')

            <div>

                <label class="mb-2 block text-sm font-medium">
                    Password Lama
                </label>

                <div class="relative">

                    <input type="password"
                        id="current_password"
                        name="current_password"
                        class="w-full rounded-2xl border border-gray-200 px-4 py-3 pr-12">

                    <button type="button"
                            onclick="togglePassword('current_password',this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">

                        👁️

                    </button>

                </div>

            </div>


            <div>

                <label class="mb-2 block text-sm font-medium">
                    Password Baru
                </label>

                <div class="relative">

                    <input type="password"
                        id="password"
                        name="password"
                        class="w-full rounded-2xl border border-gray-200 px-4 py-3 pr-12">

                    <button type="button"
                            onclick="togglePassword('password',this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">

                        👁️

                    </button>

                </div>

            </div>


            <div>

                <label class="mb-2 block text-sm font-medium">
                    Konfirmasi Password Baru
                </label>

                <div class="relative">

                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full rounded-2xl border border-gray-200 px-4 py-3 pr-12">

                    <button type="button"
                            onclick="togglePassword('password_confirmation',this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">

                        👁️

                    </button>

                </div>

            </div>


            <button class="rounded-2xl bg-primary px-5 py-3 font-medium text-white shadow transition hover:-translate-y-1 hover:shadow-lg">

                Simpan Password

            </button>

        </form>

    </div>

</div>
<script>

function togglePassword(id,button){

    const input=document.getElementById(id);

    if(input.type==='password'){

        input.type='text';
        button.innerHTML='🙈';

    }else{

        input.type='password';
        button.innerHTML='👁️';

    }

}

</script>
@endsection