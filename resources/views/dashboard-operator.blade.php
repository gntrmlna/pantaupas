@extends('layouts.app-dashboard')

@section('content')

<h1 class="text-2xl font-bold">Dashboard UPT</h1>
<p class="mb-6 text-gray-500">
    {{ auth()->user()->upt->nama }}
</p>

<div class="grid gap-4 md:grid-cols-3">

    <div class="rounded-2xl bg-white p-5 shadow">
        <p class="text-sm text-gray-500">Total Publikasi</p>
        <h2 class="mt-2 text-3xl font-bold">
            {{ $publikasis->count() }}
        </h2>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow">
        <p class="text-sm text-gray-500">Nilai UPT</p>
        <h2 class="mt-2 text-3xl font-bold">
            {{ $nilaiUPT }}
        </h2>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow">
        <p class="text-sm text-gray-500">Status</p>

        <h2 class="mt-2 text-xl font-bold">
            @if($nilaiUPT>=85)
                Sangat Baik
            @elseif($nilaiUPT>=70)
                Baik
            @elseif($nilaiUPT>=50)
                Cukup
            @else
                Kurang
            @endif
        </h2>

    </div>

</div>

<div class="mt-6 rounded-2xl bg-white p-6 shadow">
    <h2 class="mb-4 font-semibold">Indikator Penilaian</h2>

    <div class="space-y-5">

        <div>
            <div class="mb-1 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>Jumlah Publikasi</span>

                    <div class="group relative cursor-pointer">
                        <span class="text-xs text-gray-400">ⓘ</span>

                        <div class="absolute left-5 top-0 z-50 hidden w-64 rounded-xl bg-gray-800 p-3 text-xs text-white group-hover:block">
                            Nilai dihitung dari total publikasi dibanding UPT dengan publikasi tertinggi. Bobot: 40%
                        </div>
                    </div>
                </div>

                <span>{{ round($detail['jumlah'],1) }}/40</span>
            </div>

            <div class="h-3 rounded bg-gray-100">
                <div class="h-3 rounded bg-blue-500"
                     style="width:{{ ($detail['jumlah']/40)*100 }}%">
                </div>
            </div>
        </div>

        <div>
            <div class="mb-1 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>Konsistensi</span>

                    <div class="group relative cursor-pointer">
                        <span class="text-xs text-gray-400">ⓘ</span>

                        <div class="absolute left-5 top-0 z-50 hidden w-64 rounded-xl bg-gray-800 p-3 text-xs text-white group-hover:block">
                            Nilai berdasarkan jumlah minggu aktif publikasi dalam 1 bulan. Semakin rutin upload tiap minggu, nilai semakin tinggi. Bobot: 35%
                        </div>
                    </div>
                </div>

                <span>{{ round($detail['konsistensi'],1) }}/35</span>
            </div>

            <div class="h-3 rounded bg-gray-100">
                <div class="h-3 rounded bg-yellow-500"
                     style="width:{{ ($detail['konsistensi']/35)*100 }}%">
                </div>
            </div>
        </div>

        <div>
            <div class="mb-1 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>Ketepatan Upload</span>

                    <div class="group relative cursor-pointer">
                        <span class="text-xs text-gray-400">ⓘ</span>

                        <div class="absolute left-5 top-0 z-50 hidden w-64 rounded-xl bg-gray-800 p-3 text-xs text-white group-hover:block">
                            Upload di hari kegiatan mendapat nilai maksimal. H+1 dan H+2 nilainya menurun. Bobot: 25%
                        </div>
                    </div>
                </div>

                <span>{{ round($detail['ketepatan'],1) }}/25</span>
            </div>

            <div class="h-3 rounded bg-gray-100">
                <div class="h-3 rounded bg-green-500"
                     style="width:{{ ($detail['ketepatan']/25)*100 }}%">
                </div>
            </div>
        </div>

    </div>
</div>

<div class="mt-6 rounded-2xl bg-white p-5 shadow">
    <h2 class="mb-4 font-semibold">
        Publikasi Saya
    </h2>

    <table class="w-full text-center">
        <thead>
            <tr class="border-b">
                <th class="p-3">Tanggal</th>
                <th>Kegiatan</th>
                <th>Link</th>
            </tr>
        </thead>

        <tbody>

        @foreach($publikasis as $item)
            <tr class="border-b">
                <td class="p-3">
                    {{ $item->tanggal }}
                </td>

                <td>
                    {{ $item->kegiatan }}
                </td>

                <td>
                    <a href="{{ $item->link }}"
                       target="_blank"
                       class="text-primary">
                        Lihat
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>

    </table>
</div>

@endsection