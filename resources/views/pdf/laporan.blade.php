<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family:sans-serif;
            font-size:12px;
            color:#111827;
        }

        h1{
            text-align:center;
            margin-bottom:4px;
        }

        .subtitle{
            text-align:center;
            color:#6b7280;
            margin-bottom:30px;
        }

        .section{
            margin-top:28px;
        }

        .section-title{
            font-size:15px;
            font-weight:bold;
            margin-bottom:12px;
        }

        .stats{
            width:100%;
        }

        .stats td{
            padding:8px 0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        th,td{
            border:1px solid #d1d5db;
            padding:10px;
            text-align:left;
        }

        th{
            background:#f3f4f6;
        }

        .top{
            margin-bottom:8px;
        }

        .footer{
            margin-top:40px;
            text-align:center;
            color:#6b7280;
            font-size:11px;
        }

    </style>

</head>

<body>

    <h1>
        LAPORAN MONITORING PUBLIKASI UPT
    </h1>

    <div class="subtitle">
        Sistem PANTAU PAS<br>
        Periode : {{ $periode }}<br>
        Kanwil Ditjenpas Papua Barat
    </div>


    <!-- RINGKASAN -->

    <div class="section">

        <div class="section-title">
            Ringkasan Statistik
        </div>

        <table class="stats">

            <tr>
                <td width="40%">
                    Total Publikasi
                </td>

                <td>
                    : {{ $publikasis->count() }}
                </td>
            </tr>

            <tr>
                <td>
                    Total UPT Aktif
                </td>

                <td>
                    : {{ $publikasis->pluck('upt_id')->unique()->count() }}
                </td>
            </tr>

            <tr>
                <td>
                    UPT Teraktif
                </td>

                <td>
                    : {{
                        optional(
                            $publikasis
                            ->groupBy('upt_id')
                            ->sortByDesc(fn($q)=>$q->count())
                            ->first()
                            ?->first()
                            ?->upt
                        )->nama ?? '-'
                    }}
                </td>
            </tr>

            <tr>
                <td>
                    Rata-rata Nilai
                </td>

                <td>
                    : {{ round(collect($skorUPT)->avg('total'),2) }}
                </td>
            </tr>

        </table>

    </div>



    <!-- TOP 3 -->

    <div class="section">

        <div class="section-title">
            Top 3 UPT Teraktif
        </div>

        @foreach(collect($skorUPT)->take(3) as $index=>$item)

        <div class="top">

            {{ $item['upt']->nama }}
            — {{ $item['total'] }} poin

        </div>

        @endforeach

    </div>



    <!-- REKAP -->

    <div class="section">

        <div class="section-title">
            Rekap Publikasi per UPT
        </div>

        <table>

            <thead>

                <tr>
                    <th>UPT</th>
                    <th>Total Publikasi</th>
                </tr>

            </thead>

            <tbody>

                @foreach($publikasis->groupBy('upt_id') as $group)

                <tr>

                    <td>
                        {{ $group->first()->upt->nama }}
                    </td>

                    <td>
                        {{ $group->count() }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>



    <!-- PENILAIAN -->

    <div class="section">

        <div class="section-title">
            Penilaian Publikasi UPT
        </div>

        <table>

            <thead>

                <tr>
                    <th>UPT</th>
                    <th>Jumlah</th>
                    <th>Konsistensi</th>
                    <th>Ketepatan</th>
                    <th>Total</th>
                </tr>

            </thead>

            <tbody>

                @foreach($skorUPT as $nilai)

                <tr>

                    <td>
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

                    <td>
                        {{ $nilai['total'] }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>



    <!-- ANALISIS -->

    <div class="section">

        <div class="section-title">
            Analisis Singkat
        </div>

        <p style="line-height:1.8">

            Berdasarkan hasil monitoring publikasi melalui sistem PANTAU PAS,
            UPT dengan tingkat publikasi tertinggi adalah
            <b>{{ $skorUPT[0]['upt']->nama ?? '-' }}</b>
            dengan total nilai
            <b>{{ $skorUPT[0]['total'] ?? 0 }}</b>.

            Secara umum, aktivitas publikasi UPT di lingkungan
            Kanwil Ditjenpas Papua Barat menunjukkan tingkat
            konsistensi yang baik dalam mendukung publikasi kegiatan
            dan penyebaran informasi kepada masyarakat.

        </p>

    </div>



    <!-- FOOTER -->

    <div class="footer">

        Generated by PANTAU PAS<br>

        {{ now()->translatedFormat('d F Y H:i') }}

    </div>

</body>
</html>