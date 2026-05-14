@extends('layouts.app-dashboard')

@section('content')

<div class="max-w-2xl">
    <h1 class="mb-6 text-2xl font-bold">
        Edit Publikasi
    </h1>

    <form method="POST"
          action="{{ route('publikasi.update',$publikasi) }}"
          class="space-y-5 rounded-2xl bg-white p-6 shadow">

        @csrf
        @method('PUT')

        @if(auth()->user()->role=='admin')

        <select name="upt_id"
                class="w-full rounded-xl border p-3">

            @foreach($upts as $upt)
                <option value="{{ $upt->id }}"
                    @selected($publikasi->upt_id==$upt->id)>
                    {{ $upt->nama }}
                </option>
            @endforeach

        </select>

        @endif

        <input type="date"
               name="tanggal"
               value="{{ $publikasi->tanggal }}"
               class="w-full rounded-xl border p-3">

        <input name="kegiatan"
               value="{{ $publikasi->kegiatan }}"
               class="w-full rounded-xl border p-3">

        <input name="link"
               value="{{ $publikasi->link }}"
               class="w-full rounded-xl border p-3">

        <button class="rounded-xl bg-accent px-5 py-3">
            Simpan
        </button>

    </form>
</div>

@endsection