@extends('layouts.app-dashboard')

@section('content')

<div class="max-w-xl">
    <h1 class="mb-6 text-2xl font-bold">Edit User</h1>

    <form method="POST"
          action="{{ route('users.update',$user) }}"
          class="space-y-5 rounded-2xl bg-white p-6 shadow">

        @csrf
        @method('PUT')

        <input name="name"
               value="{{ old('name',$user->name) }}"
               placeholder="Nama"
               class="w-full rounded-xl border p-3">

        <input name="email"
               value="{{ old('email',$user->email) }}"
               placeholder="Email"
               class="w-full rounded-xl border p-3">

        <input type="password"
               name="password"
               placeholder="Kosongkan jika tidak diubah"
               class="w-full rounded-xl border p-3">

        <select id="role"
                name="role"
                class="w-full rounded-xl border p-3">

            <option value="admin" @selected($user->role=='admin')>
                Admin
            </option>

            <option value="operator" @selected($user->role=='operator')>
                Operator
            </option>
        </select>

        <div id="uptField">
            <select name="upt_id"
                    class="w-full rounded-xl border p-3">

                @foreach($upts as $upt)
                    <option value="{{ $upt->id }}"
                        @selected($user->upt_id==$upt->id)>
                        {{ $upt->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        <button class="rounded-xl bg-accent px-5 py-3">
            Simpan
        </button>

    </form>
</div>

<script>
function toggleUPT(){
    uptField.style.display=
    role.value=='admin'
    ?'none'
    :'block';
}

toggleUPT();
role.onchange=toggleUPT;
</script>

@endsection