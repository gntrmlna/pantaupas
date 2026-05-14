@extends('layouts.app-dashboard')

@section('content')

<div class="max-w-4xl">

    <div class="mb-6">

        <h1 class="text-2xl font-bold">
            Input Publikasi
        </h1>

        <p class="text-sm text-gray-500">
            Tambahkan data publikasi kegiatan
        </p>

    </div>


    @if(session('success'))

        <div class="mb-4 rounded-xl bg-green-100 p-4 text-green-700">

            {{ session('success') }}

        </div>

    @endif


    <div class="rounded-2xl bg-white p-6 shadow">

        <form
            id="formPublikasi"
            action="{{ route('publikasi.store') }}"
            method="POST"
            class="space-y-4"
        >

            @csrf

            <div class="grid gap-4 md:grid-cols-2">

                <div>

                    <label class="mb-1 block text-sm">
                        UPT
                    </label>

                    @if(auth()->user()->role=='admin')

                    <select
                        name="upt_id"
                        class="w-full rounded-lg border p-3"
                    >

                        <option value="">
                            Pilih UPT
                        </option>

                        @foreach($upts as $upt)

                            <option
                                value="{{ $upt->id }}"
                            >
                                {{ $upt->nama }}
                            </option>

                        @endforeach

                    </select>

                @else

                    <input
                        type="text"
                        value="{{ auth()->user()->upt->nama }}"
                        readonly
                        class="w-full rounded-lg border bg-gray-100 p-3"
                    >

                    <input
                        type="hidden"
                        name="upt_id"
                        value="{{ auth()->user()->upt_id }}"
                    >

                @endif

                </div>


                <div>

                    <label class="mb-1 block text-sm">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="w-full rounded-lg border p-3"
                    >

                </div>

            </div>


            <div>

                <label class="mb-1 block text-sm">
                    Kegiatan
                </label>

                <input
                    type="text"
                    name="kegiatan"
                    class="w-full rounded-lg border p-3"
                >

            </div>


            <div>

                <label class="mb-1 block text-sm">
                    Link Publikasi
                </label>

                <input
                    type="url"
                    name="link"
                    class="w-full rounded-lg border p-3"
                >

            </div>


            <div class="flex justify-end">

                <button
                    class="rounded-xl bg-primary px-5 py-3 text-white"
                >
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

@endsection