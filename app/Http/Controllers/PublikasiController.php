<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use App\Models\Upt;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Publikasi::with('upt');

        /*
        =======================
        FILTER ROLE
        =======================
        */

        if(auth()->user()->role !== 'admin'){

            $query->where(
                'upt_id',
                auth()->user()->upt_id
            );

        }


        /*
        =======================
        FILTER BULAN
        =======================
        */

        if($request->bulan){

            $query->whereMonth(
                'tanggal',
                date(
                    'm',
                    strtotime($request->bulan)
                )
            );

            $query->whereYear(
                'tanggal',
                date(
                    'Y',
                    strtotime($request->bulan)
                )
            );

        }


        /*
        =======================
        SEARCH
        =======================
        */

        if($request->search){

            $query->where(function($q)
            use($request){

                $q->where(
                    'kegiatan',
                    'like',
                    '%'.$request->search.'%'
                )

                ->orWhereHas(
                    'upt',
                    function($upt)
                    use($request){

                        $upt->where(
                            'nama',
                            'like',
                            '%'.$request->search.'%'
                        );

                    }
                );

            });

        }


        $publikasis =
            $query
            ->latest()
            ->get();



        /*
        =======================
        HITUNG SKOR
        =======================
        */

        $skorUPT=[];

        $grouped=
            $publikasis
            ->groupBy('upt_id');


        $maxPublikasi=max(

            $grouped
            ->map(
                fn($item)=>
                $item->count()
            )
            ->toArray()

            ?: [1]

        );


        foreach($grouped as $uptId=>$items){

            $upt=
            Upt::find(
                $uptId
            );


            /*
            =======================
            JUMLAH
            =======================
            */

            $jumlahPublikasi=
            $items->count();


            $skorJumlah=

            (
                $jumlahPublikasi
                /
                $maxPublikasi
            )

            *40;



            /*
            =======================
            KONSISTENSI
            =======================
            */

            $mingguAktif=

            $items
            ->groupBy(function($item){

                return Carbon::parse(
                    $item->tanggal
                )
                ->weekOfMonth;

            })

            ->count();


            $skorKonsistensi=

            (
                $mingguAktif
                /4
            )

            *35;



            /*
            =======================
            KETEPATAN
            =======================
            */

            $nilaiKetepatan=[];


            foreach($items as $item){

                $selisih=

                Carbon::parse(
                    $item->tanggal
                )

                ->diffInDays(

                    Carbon::parse(
                        $item->created_at
                    ),

                    false

                );


                if($selisih<=0){

                    $nilai=100;

                }

                elseif($selisih==1){

                    $nilai=80;

                }

                elseif($selisih==2){

                    $nilai=60;

                }

                else{

                    $nilai=0;

                }

                $nilaiKetepatan[]=
                $nilai;

            }



            $avg=
            collect(
                $nilaiKetepatan
            )->avg();



            $skorKetepatan=

            (
                $avg/100
            )

            *25;



            /*
            =======================
            TOTAL
            =======================
            */

            $total=

            round(

                $skorJumlah+

                $skorKonsistensi+

                $skorKetepatan,

                2

            );



            $skorUPT[]=[

                'upt'=>$upt,

                'jumlah'=>
                $skorJumlah,

                'konsistensi'=>
                $skorKonsistensi,

                'ketepatan'=>
                $skorKetepatan,

                'total'=>
                $total

            ];

        }



        usort(
            $skorUPT,
            fn($a,$b)=>

            $b['total']
            <=>
            $a['total']
        );



        /*
        =======================
        CHART
        =======================
        */

        $chartData=

            $publikasis
            ->groupBy(
                fn($item)=>
                $item->upt->nama
            )

            ->map(
                fn($item)=>
                $item->count()
            );



        /*
        =======================
        TOP UPT
        =======================
        */

        $topUpt=

            $publikasis
            ->groupBy(
                fn($item)=>
                $item->upt->nama
            )

            ->map(
                fn($item)=>
                $item->count()
            )

            ->sortDesc()

            ->take(3);



        $upts=
        Upt::orderBy(
            'nama'
        )->get();



        return view(
            'dashboard',

            compact(

                'publikasis',
                'chartData',
                'topUpt',
                'skorUPT',
                'upts'

            )

        );

    }

    public function create()
    {
        $upts = Upt::orderBy('nama')->get();

        return view(
            'publikasi.create',
            compact('upts')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'upt_id' => 'required',
            'tanggal' => 'required',
            'kegiatan' => 'required',
            'link' => 'required|url'
        ]);

        Publikasi::create([
            'user_id' => auth()->id(),
            'upt_id'=>$request->upt_id,
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'link' => $request->link
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data berhasil disimpan');
    }
}