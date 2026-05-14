@extends('layouts.app-dashboard')

@section('content')

<div>

    <h1 class="mb-1 text-2xl font-bold">
        Dashboard Publikasi
    </h1>

    <p class="mb-6 text-gray-500">
        Monitoring publikasi UPT
    </p>

    <!-- FILTER -->

    <div class="mb-5 flex flex-wrap items-center gap-3">

        <input
            type="month"
            name="bulan"
            value="{{ request('bulan') }}"
            class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm shadow-sm"
            form="filterForm"
        >

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="🔍 Cari UPT / kegiatan..."
            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm shadow-sm md:w-80"
            form="filterForm"
        >

        <button
            form="filterForm"
            class="rounded-xl bg-accent px-4 py-2 text-sm font-medium text-black hover:brightness-95"
        >
            Filter
        </button>

        <a
            href="{{ route('dashboard') }}"
            class="rounded-xl bg-white px-4 py-2 text-sm shadow-sm"
        >
            Reset
        </a>

    </div>

    <form
        id="filterForm"
        method="GET"
        action="{{ route('dashboard') }}"
    ></form>


    <!-- CARD -->

    <div class="grid gap-4 md:grid-cols-3">

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Total Publikasi
            </p>

            <div class="mt-2 flex items-center justify-between">

                <h2 class="text-3xl font-bold">

                    {{ $publikasis->count() }}

                </h2>

                <div class="rounded-xl bg-yellow-100 p-3">

                    📊

                </div>

            </div>

        </div>


        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">

                Total UPT Aktif

            </p>

            <div class="mt-2 flex items-center justify-between">

                <h2 class="text-3xl font-bold">

                    {{ $publikasis->groupBy('upt_id')->count() }}

                </h2>

                <div class="rounded-xl bg-blue-100 p-3">

                    🏢

                </div>

            </div>

        </div>


        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">

                UPT Teraktif

            </p>

            <div class="mt-2">

                <h2 class="font-semibold">

                    {{
                        optional(
                            $publikasis
                            ->groupBy('upt_id')
                            ->sortByDesc(fn($q)=>$q->count())
                            ->first()
                            ?->first()
                            ?->upt
                        )->nama ?? '-'
                    }}

                </h2>

                <p class="mt-1 text-sm text-gray-400">

                    publikasi tertinggi

                </p>

            </div>

        </div>

    </div>

    <div class="mt-6 rounded-2xl bg-white p-6 shadow">
        <div class="mb-5">
            <h2 class="text-lg font-semibold">Ranking UPT</h2>
            <p class="text-sm text-gray-500">Berdasarkan total penilaian publikasi</p>
        </div>

        <div class="space-y-3">
            @foreach($skorUPT as $index=>$nilai)
            <div class="flex items-center justify-between rounded-xl border p-4 hover:bg-gray-50">
                <div class="flex items-center gap-4">
                    <div class="w-10 text-center text-2xl">
                        @if($index==0) 🥇
                        @elseif($index==1) 🥈
                        @elseif($index==2) 🥉
                        @else #{{ $index+1 }}
                        @endif
                    </div>

                    <div>
                        <h3 class="font-semibold">{{ $nilai['upt']->nama }}</h3>

                        <p class="text-sm text-gray-500">
                            @if($nilai['total']>=85)
                                Sangat Baik
                            @elseif($nilai['total']>=70)
                                Baik
                            @elseif($nilai['total']>=50)
                                Cukup
                            @else
                                Kurang
                            @endif
                        </p>
                    </div>
                </div>

                <div class="text-right">
                    <h2 class="text-2xl font-bold">{{ $nilai['total'] }}</h2>
                    <p class="text-xs text-gray-400">poin</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <!-- PENILAIAN -->

    <div class="mt-6">

        <h2 class="mb-4 font-semibold">

            Penilaian UPT

        </h2>

        <div class="overflow-hidden rounded-2xl bg-white shadow">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr class="text-center">

                        <th class="p-4">UPT</th>

                        <th>Jumlah</th>

                        <th>Konsistensi</th>

                        <th>Ketepatan</th>

                        <th>Total</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($skorUPT as $nilai)

                    <tr class="border-b text-center">

                        <td class="p-4">

                            {{ $nilai['upt']->nama }}

                        </td>

                        <td>

                            {{ round($nilai['jumlah'],2) }}

                        </td>

                        <td>

                            {{ round($nilai['konsistensi'],2) }}

                        </td>

                        <td>

                            {{ round($nilai['ketepatan'],2) }}

                        </td>

                        <td class="font-bold">

                            {{ $nilai['total'] }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    <!-- CHART -->

    <div class="mt-6 rounded-2xl bg-white p-6 shadow">

        <h2 class="mb-4 font-semibold">

            Statistik Publikasi UPT

        </h2>

        <div class="mx-auto w-full max-w-sm">

            <canvas id="publikasiChart"></canvas>

        </div>

    </div>


    <!-- CARD UPT -->

    <div class="mt-6">

        <h2 class="mb-4 font-semibold">

            Publikasi per UPT

        </h2>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            @foreach($upts as $upt)

                @php

                    $jumlah =
                    $publikasis
                    ->where('upt_id',$upt->id)
                    ->count();

                @endphp

                <div
                    class="rounded-2xl border border-gray-100 bg-white p-5 shadow transition hover:-translate-y-1 hover:shadow-lg"
                >

                    <h3 class="text-sm text-gray-500">

                        {{ $upt->nama }}

                    </h3>

                    <h2 class="mt-2 text-3xl font-bold">

                        {{ $jumlah }}

                    </h2>

                    <p class="text-sm text-gray-400">

                        publikasi

                    </p>

                </div>

            @endforeach

        </div>

    </div>


    <!-- TABEL -->

    <div class="mt-6">

        <h2 class="mb-3 font-semibold">

            Data Publikasi

        </h2>

        <div class="overflow-x-auto rounded-2xl bg-white shadow">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="p-4">

                            UPT

                        </th>

                        <th>Tanggal</th>

                        <th>Kegiatan</th>

                        <th>Link</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($publikasis->take(5) as $item)

                    <tr class="border-b text-center">

                        <td class="p-4">

                            {{ $item->upt->nama }}

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}

                        </td>

                        <td>

                            {{ $item->kegiatan }}

                        </td>

                        <td>

                            <a
                                href="{{ $item->link }}"
                                target="_blank"
                                class="text-primary"
                            >

                                Lihat

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="4"
                            class="p-6 text-center text-gray-500"
                        >

                            Belum ada data

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
        <div class="border-t p-4 text-center">
            <a href="{{ route('publikasi.index') }}"
            class="text-sm font-medium text-primary hover:underline">
                Lihat semua →
            </a>
        </div>

    </div>

</div>


<script>

document.addEventListener("DOMContentLoaded",()=>{

    const ctx=
    document.getElementById(
        'publikasiChart'
    );

    new Chart(ctx,{

        type:'doughnut',

        data:{

            labels:@json($chartData->keys()),

            datasets:[{

                data:@json(
                    $chartData->values()
                ),

                backgroundColor:[

                    "#07213D",
                    "#0F3A66",
                    "#1E5FA8",
                    "#FDC134",
                    "#FFD76A",
                    "#64748B",
                    "#94A3B8",
                    "#334155",
                    "#0F172A",
                    "#475569",
                    "#1E293B"

                ]

            }]

        },

        options:{

            responsive:true,

            maintainAspectRatio:true,

            aspectRatio:1,

            cutout:'65%',

            plugins:{

                legend:{

                    position:'bottom'

                }

            }

        }

    });

});

</script>

@endsection