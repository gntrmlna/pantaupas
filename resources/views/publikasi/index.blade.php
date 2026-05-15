@extends('layouts.app-dashboard')

@section('content')

<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                Data Publikasi
            </h1>
            <p class="text-gray-500">
                Kelola data publikasi seluruh UPT
            </p>
        </div>


        <div class="flex gap-2">
            <form method="GET">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari..."
                       class="rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm">
            </form>
            <a href="{{ route('publikasi.create') }}"
               class="rounded-2xl bg-accent px-5 py-3 text-sm font-semibold text-black shadow transition hover:-translate-y-1 hover:shadow-lg">
                + Tambah
            </a>
        </div>
    </div>


    <!-- CARD -->
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur">
            <p class="text-sm text-gray-500">
                Total Publikasi
            </p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ $publikasis->total() }}
                </h2>
                <div class="rounded-2xl bg-yellow-100 p-3 text-xl">
                    📄
                </div>
            </div>
        </div>


        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur">
            <p class="text-sm text-gray-500">
                Publikasi Hari Ini
            </p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ $publikasis->where('created_at','>=',now()->startOfDay())->count() }}
                </h2>
                <div class="rounded-2xl bg-blue-100 p-3 text-xl">
                    📅
                </div>
            </div>
        </div>

        @if(auth()->user()->role=='admin')

        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur">
            <p class="text-sm text-gray-500">Total UPT</p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-3xl font-bold">
                    {{ $publikasis->pluck('upt_id')->unique()->count() }}
                </h2>
                <div class="rounded-2xl bg-green-100 p-3 text-xl">
                    🏢
                </div>
            </div>
        </div>

        @endif
    </div>


    <!-- TABLE -->
    <div class="overflow-hidden rounded-3xl bg-white shadow">
        <div class="border-b p-5">
            <h2 class="font-semibold">
                Daftar Publikasi
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead class="border-b bg-gray-50/80 text-xs uppercase tracking-wider text-gray-400">
                    <tr class="text-left">
                        <th class="p-5">
                            UPT
                        </th>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Kegiatan
                        </th>
                        <th>
                            Link
                        </th>
                        <th class="text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>


                <tbody>
                    @forelse($publikasis as $item)
                    <tr class="border-b transition hover:bg-slate-50">
                        <!-- UPT -->
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-sm font-bold text-white shadow-sm">
                                    {{ strtoupper(substr($item->upt->nama,0,1)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-800">
                                        {{ $item->upt->nama }}
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-400">
                                        Upload {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <!-- TANGGAL -->
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </td>

                        <!-- KEGIATAN -->
                        <td class="px-4 py-5">
                            <div class="max-w-sm">
                                <p class="line-clamp-2 text-sm leading-relaxed text-slate-700">
                                    {{ $item->kegiatan }}
                                </p>
                            </div>
                        </td>

                        <!-- LINK -->
                        <td class="px-4 py-5">
                            <a href="{{ $item->link }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200">
                                🔗 Link
                            </a>
                        </td>

                        <!-- AKSI -->
                        <td class="px-4 py-5">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('publikasi.edit',$item) }}"
                                class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-100">
                                    Edit
                                </a>
                                <button type="button"
                                        onclick="openDeleteModal('{{ route('publikasi.destroy',$item) }}')"
                                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5"
                            class="p-10 text-center text-gray-500">
                            Belum ada data publikasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="border-t p-5">
            {{ $publikasis->links() }}
        </div>
    </div>
</div>

<div id="deleteModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-xl">
        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-2xl">
                🗑️
            </div>
            <div>
                <h2 class="text-lg font-bold">
                    Hapus Data
                </h2>
                <p class="text-sm text-gray-500">
                    Data yang dihapus tidak dapat dikembalikan
                </p>
            </div>
        </div>


        <div class="mt-6 flex justify-end gap-3">
            <button onclick="closeDeleteModal()"
                    class="rounded-xl border px-4 py-2 text-sm font-medium">
                Batal
            </button>
            <form id="deleteForm"
                  method="POST">
                @csrf
                @method('DELETE')
                <button class="rounded-xl bg-red-500 px-4 py-2 text-sm font-medium text-white hover:bg-red-600">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>

function openDeleteModal(url){

    document
        .getElementById('deleteModal')
        .classList
        .remove('hidden');

    document
        .getElementById('deleteModal')
        .classList
        .add('flex');

    document
        .getElementById('deleteForm')
        .action=url;

}

function closeDeleteModal(){

    document
        .getElementById('deleteModal')
        .classList
        .remove('flex');

    document
        .getElementById('deleteModal')
        .classList
        .add('hidden');

}

</script>
@endsection