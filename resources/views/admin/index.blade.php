@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Admin Panel</h1>

    <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">
        <strong>Alleen voor admins.</strong> Hier kunt u alle gebruikers zien.
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">ID</th>
                <th class="border px-4 py-2 text-left">Naam</th>
                <th class="border px-4 py-2 text-left">E-mail</th>
                <th class="border px-4 py-2 text-left">Rol</th>
                <th class="border px-4 py-2 text-left">Geregistreerd</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td class="border px-4 py-2">{{ $u->id }}</td>
                    <td class="border px-4 py-2">{{ $u->name }}</td>
                    <td class="border px-4 py-2">{{ $u->email }}</td>
                    <td class="border px-4 py-2">
                        @foreach($u->roles as $role)
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="border px-4 py-2">{{ $u->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection