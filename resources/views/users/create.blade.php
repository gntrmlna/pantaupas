@extends('layouts.app-dashboard')

@section('content')

<div class="max-w-xl">

    <h1 class="mb-6 text-2xl font-bold">

        Tambah User

    </h1>


    <form
        method="POST"
        action="{{ route('users.store') }}"
        class="space-y-5 rounded-2xl bg-white p-6 shadow"
    >

        @csrf


        <input
            name="name"
            placeholder="Nama"
            class="w-full rounded-xl border p-3"
        >


        <input
            name="email"
            placeholder="Email"
            class="w-full rounded-xl border p-3"
        >


        <input
            type="password"
            name="password"
            placeholder="Password"
            class="w-full rounded-xl border p-3"
        >


        <select
            id="role"
            name="role"
            class="w-full rounded-xl border p-3"
        >

            <option value="">

                Pilih Role

            </option>

            <option value="admin">

                Admin

            </option>

            <option value="operator">

                Operator

            </option>

        </select>


        <div id="uptField">

            <select
                name="upt_id"
                class="w-full rounded-xl border p-3"
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

        </div>


        <button
            class="rounded-xl bg-accent px-5 py-3"
        >

            Simpan

        </button>

    </form>

</div>


<script>

role.onchange=()=>{

if(role.value=='admin'){

uptField.style.display='none'

}else{

uptField.style.display='block'

}

}

</script>

@endsection