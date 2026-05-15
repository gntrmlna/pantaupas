@extends('layouts.app-dashboard')

@section('content')

<div class="min-w-0 space-y-6 overflow-x-hidden">

    <div>
        <h1 class="mb-1 text-2xl font-bold">
            Dashboard Publikasi
        </h1>

        <p class="text-gray-500">
            Monitoring publikasi UPT
        </p>
    </div>


    <!-- FILTER -->

    <div class="flex flex-col gap-3 rounded-3xl bg-white p-4 shadow sm:flex-row sm:items-center">

        <input type="month"
               name="bulan"
               value="{{ request('bulan') }}"
               class="rounded-xl border border-gray-200 px-4 py-2 text-sm"
               form="filterForm">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari UPT / kegiatan..."
               class="flex-1 rounded-xl border border-gray-200 px-4 py-2 text-sm"
               form="filterForm">

        <div class="flex gap-2">

            <button form="filterForm"
                    class="rounded-xl bg-accent px-4 py-2 text-sm font-medium text-black">
                Filter
            </button>

            <a href="{{ route('dashboard') }}"
               class="rounded-xl border px-4 py-2 text-sm">
                Reset
            </a>

        </div>

    </div>

    <form id="filterForm"
          method="GET"
          action="{{ route('dashboard') }}">
    </form>

    <a id="exportPdfBtn"
    href="{{ route('publikasi.export-pdf') }}"
    class="rounded-2xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow transition hover:-translate-y-1 hover:shadow-lg">

        Export PDF

    </a>


    <!-- CARD -->

    <div class="grid min-w-0 gap-4 lg:grid-cols-3">

        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-xl">

            <p class="text-sm text-gray-500">
                Total Publikasi
            </p>

            <div class="mt-3 flex items-center justify-between">

                <div>

                    <h2 class="text-3xl font-bold">
                        {{ $publikasis->count() }}
                    </h2>

                    <p class="mt-1 text-xs text-gray-400">
                        seluruh publikasi
                    </p>

                </div>

                <div class="rounded-2xl bg-yellow-100 p-3 text-xl">
                    📊
                </div>

            </div>

        </div>



        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-xl">

            <p class="text-sm text-gray-500">
                Total UPT Aktif
            </p>

            <div class="mt-3 flex items-center justify-between">

                <div>

                    <h2 class="text-3xl font-bold">
                        {{ $publikasis->groupBy('upt_id')->count() }}
                    </h2>

                    <p class="mt-1 text-xs text-gray-400">
                        UPT aktif publikasi
                    </p>

                </div>

                <div class="rounded-2xl bg-blue-100 p-3 text-xl">
                    🏢
                </div>

            </div>

        </div>



        <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-xl">

            <p class="text-sm text-gray-500">
                UPT Teraktif
            </p>

            <div class="mt-3">

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

                <p class="mt-1 text-xs text-gray-400">
                    publikasi tertinggi
                </p>

            </div>

        </div>

    </div>



    <!-- CHART + RANKING -->

    <div class="grid min-w-0 gap-6 xl:grid-cols-3">

        <!-- CHART -->

        <div class="rounded-3xl bg-white p-6 shadow xl:col-span-2">

            <div class="mb-4">
                <h2 class="font-semibold">
                    Statistik Publikasi UPT
                </h2>

                <p class="text-sm text-gray-500">
                    Distribusi publikasi tiap UPT
                </p>
            </div>

            <div class="mx-auto w-full max-w-sm">
                <canvas id="publikasiChart"></canvas>
            </div>

        </div>



        <!-- RANKING -->

        <div class="rounded-3xl bg-white p-6 shadow">

            <div class="mb-5">
                <h2 class="font-semibold">
                    Ranking UPT
                </h2>

                <p class="text-sm text-gray-500">
                    Berdasarkan total nilai
                </p>
            </div>

            <div class="space-y-3">

                @foreach($skorUPT as $index=>$nilai)

                <div class="flex items-center justify-between rounded-2xl border p-4 transition hover:bg-gray-50">

                    <div class="flex items-center gap-3">

                        <div class="text-2xl">

                            @if($index==0)
                                🥇
                            @elseif($index==1)
                                🥈
                            @elseif($index==2)
                                🥉
                            @else
                                #{{ $index+1 }}
                            @endif

                        </div>

                        <div>

                            <h3 class="truncate font-medium">
                                {{ $nilai['upt']->nama }}
                            </h3>

                            <p class="text-xs text-gray-500">
                                {{ $nilai['total'] }} poin
                            </p>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>



    <!-- PENILAIAN -->

    <div>

        <h2 class="mb-4 font-semibold">
            Penilaian UPT
        </h2>

        <div class="w-full overflow-x-auto rounded-3xl bg-white shadow">

            <table class="w-full min-w-[700px]">

                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">

                    <tr class="text-center">

                        <th class="px-3 py-4">UPT</th>
                        <th>Jumlah</th>
                        <th>Konsistensi</th>
                        <th>Ketepatan</th>
                        <th>Total</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($skorUPT as $nilai)

                    <tr class="border-b text-center transition hover:bg-gray-50">

                        <td class="px-3 py-4">
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



    <!-- CARD UPT -->

    <div>

        <h2 class="mb-4 font-semibold">
            Publikasi per UPT
        </h2>

        <div class="grid min-w-0 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            @foreach($upts as $upt)

            @php
                $jumlah=$publikasis
                    ->where('upt_id',$upt->id)
                    ->count();
            @endphp

            <div class="rounded-3xl border border-white/50 bg-white/80 p-5 shadow-sm backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-xl">

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

    <div>

        <div class="mb-4 flex items-center justify-between">

            <div>
                <h2 class="font-semibold">
                    Data Publikasi
                </h2>

                <p class="text-sm text-gray-500">
                    5 publikasi terbaru
                </p>
            </div>

            <a href="{{ route('publikasi.index') }}"
               class="text-sm font-medium text-primary hover:underline">
                Lihat semua →
            </a>

        </div>

        <div class="w-full overflow-x-auto rounded-3xl bg-white shadow">

            <table class="w-full min-w-[700px]">

                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">

                    <tr class="text-center">

                        <th class="px-3 py-4">UPT</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Link</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($publikasis->take(5) as $item)

                    <tr class="border-b text-center transition hover:bg-gray-50">

                        <td class="px-3 py-4">
                            {{ $item->upt->nama }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}
                        </td>

                        <td>
                            {{ $item->kegiatan }}
                        </td>

                        <td>

                            <a href="{{ $item->link }}"
                               target="_blank"
                               class="font-medium text-primary hover:underline">

                                Lihat

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="p-8 text-center text-gray-500">

                            Belum ada data

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



<script>

document.addEventListener("DOMContentLoaded",()=>{

    const ctx=document.getElementById('publikasiChart');

    new Chart(ctx,{

        type:'doughnut',

        data:{

            labels:@json($chartData->keys()),

            datasets:[{

                data:@json($chartData->values()),

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

            cutout:'68%',

            plugins:{

                legend:{
                    position:'bottom'
                }

            }

        }

    });

});

</script>
<script>

const exportBtn=document.getElementById('exportPdfBtn');

const bulanInput=document.querySelector('input[name="bulan"]');

exportBtn.addEventListener('click',function(e){

    e.preventDefault();

    let url="{{ route('publikasi.export-pdf') }}";

    if(bulanInput.value){

        url+='?bulan='+bulanInput.value;

    }

    window.location.href=url;

});

</script>
@endsection