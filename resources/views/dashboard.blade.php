@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div class="mb-6 p-4 bg-gray-50 rounded">
        <p class="text-lg"><strong>Naam:</strong> {{ $user->name }}</p>
        <p class="text-lg"><strong>E-mail:</strong> {{ $user->email }}</p>
        <p class="text-lg">
            <strong>Rol:</strong>
            @foreach($user->roles as $role)
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $role->name }}</span>
            @endforeach
        </p>
    </div>

    @if($user->hasRole('admin'))
        <div class="mb-4">
            <a href="{{ route('admin.index') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Admin Panel
            </a>
        </div>
    @endif

    <p class="text-gray-600">Ingelogd als <strong>{{ $user->name }}</strong> met rol <strong>{{ $user->roles->first()->name }}</strong>.</p>
</div>
@endsection