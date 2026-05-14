@extends('layouts.app-dashboard')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Data Publikasi</h1>
        <p class="text-gray-500">Kelola data publikasi UPT</p>
    </div>

    <a href="{{ route('publikasi.create') }}"
       class="rounded-xl bg-accent px-5 py-3 font-medium">
        + Tambah Data
    </a>
</div>



<div class="overflow-hidden rounded-2xl bg-white shadow">
    <table class="w-full text-center">
        <thead class="bg-gray-50">
            <tr class="border-b">
                <th class="p-4">UPT</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Link</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($publikasis as $item)

        <tr class="border-b hover:bg-gray-50">
            <td class="p-4">{{ $item->upt->nama }}</td>

            <td>
                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
            </td>

            <td>{{ $item->kegiatan }}</td>

            <td>
                <a href="{{ $item->link }}"
                target="_blank"
                class="text-primary">
                    Lihat
                </a>
            </td>

            <td>
                <div class="flex justify-center gap-2">
                    <a href="{{ route('publikasi.edit',$item) }}"
                    class="rounded-lg bg-blue-500 px-3 py-2 text-white">
                        Edit
                    </a>
                    <form action="{{ route('publikasi.destroy',$item) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            onclick="return confirm('Hapus data?')"
                            class="rounded-lg bg-red-500 px-3 py-2 text-white">

                            Hapus

                        </button>
                    </form>
                </div>
            </td>
        </tr>

        @empty

        <tr>
            <td colspan="4" class="p-8 text-gray-500">
                Belum ada data
            </td>
        </tr>

        @endforelse

        </tbody>

    </table>

    <div class="p-4">
        {{ $publikasis->links() }}
    </div>

</div>

@endsection