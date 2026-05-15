@extends('layouts.app-dashboard')

@section('content')

<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Kelola User
            </h1>
            <p class="text-gray-500">
                Management pengguna sistem PANTAU PAS
            </p>
        </div>

        <a href="{{ route('users.create') }}"
           class="rounded-2xl bg-accent px-5 py-3 text-sm font-semibold text-black shadow transition hover:-translate-y-1 hover:shadow-lg">
            + Tambah User
        </a>
    </div>


    <!-- CARD -->
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur">
            <p class="text-sm text-gray-500">
                Total User
            </p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ $users->count() }}
                </h2>
                <div class="rounded-2xl bg-blue-100 p-3 text-xl">
                    👤
                </div>
            </div>
        </div>


        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur">
            <p class="text-sm text-gray-500">
                Admin
            </p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ $users->where('role','admin')->count() }}
                </h2>
                <div class="rounded-2xl bg-red-100 p-3 text-xl">
                    🛡️
                </div>
            </div>
        </div>


        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur">
            <p class="text-sm text-gray-500">
                Operator
            </p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ $users->where('role','operator')->count() }}
                </h2>
                <div class="rounded-2xl bg-yellow-100 p-3 text-xl">
                    🏢
                </div>
            </div>
        </div>
    </div>


    <!-- TABLE -->
    <div class="overflow-hidden rounded-[28px] border border-white/50 bg-white/90 shadow-sm backdrop-blur">
        <div class="border-b p-5">
            <h2 class="font-semibold">
                Daftar Pengguna
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[850px] w-full">
                <thead class="border-b bg-gray-50/80 text-xs uppercase tracking-wider text-gray-400">
                    <tr class="text-left">
                        <th class="p-5">
                            User
                        </th>
                        <th>
                            Role
                        </th>
                        <th>
                            UPT
                        </th>
                        <th class="text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b transition hover:bg-slate-50">
                        <!-- USER -->
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-sm font-bold text-white shadow-sm">
                                    {{ strtoupper(substr($user->name,0,1)) }}

                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        {{ $user->name }}
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>


                        <!-- ROLE -->
                        <td>
                            @if($user->role=='admin')
                                <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                    Operator
                                </span>
                            @endif
                        </td>

                        <!-- UPT -->
                        <td class="text-sm text-slate-600">
                            {{ $user->upt?->nama ?? '-' }}
                        </td>

                        <!-- AKSI -->
                        <td>
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('users.edit',$user) }}"
                                class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-100">
                                    Edit
                                </a>
                                <button type="button"
                                        onclick="openDeleteModal('{{ route('users.destroy',$user) }}')"
                                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection