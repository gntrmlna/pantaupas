@extends('layouts.app-dashboard')

@section('content')

<div>

    <div
    class="mb-6 flex items-center justify-between">

        <div>

            <h1
            class="text-2xl font-bold">

                Kelola User

            </h1>

            <p
            class="text-gray-500">

                Daftar pengguna sistem

            </p>

        </div>


        <a
        href="{{ route('users.create') }}"

        class="rounded-xl bg-accent px-5 py-3">

            + Tambah User

        </a>

    </div>



    <div
    class="overflow-hidden rounded-2xl bg-white shadow">

        <table
        class="w-full">

            <thead
            class="bg-gray-50">

                <tr>

                    <th class="p-4">

                        Nama

                    </th>

                    <th>

                        Email

                    </th>

                    <th>

                        Role

                    </th>

                    <th>

                        UPT

                    </th>

                    <th>

                        Aksi

                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($users as $user)

                <tr
                class="border-b text-center">

                    <td class="p-4">

                        {{ $user->name }}

                    </td>

                    <td>

                        {{ $user->email }}

                    </td>


                    <td>

                        @if(
                        $user->role=='admin'
                        )

                        <span
                        class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-600">

                            Admin

                        </span>

                        @else

                        <span
                        class="rounded-full bg-blue-100 px-3 py-1 text-sm text-blue-600">

                            Operator

                        </span>

                        @endif

                    </td>


                    <td>

                        {{ $user->upt?->nama ?? '-' }}

                    </td>


                    <td>

                    <div
                    class="flex justify-center gap-2">

                        <a
                        href="{{ route('users.edit',$user) }}"

                        class="rounded-lg bg-blue-500 px-3 py-2 text-white">

                        Edit

                        </a>


                            <form
                            action="{{ route('users.destroy',$user) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                                <button
                                onclick="return confirm('Hapus user?')"

                                class="rounded-lg bg-red-500 px-3 py-2 text-white">

                                Hapus

                                </button>

                            </form>

                    </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection