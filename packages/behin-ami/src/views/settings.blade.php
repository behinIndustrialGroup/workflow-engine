@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('status'))
        <div class="bg-green-200 p-2 mb-4">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('ami.settings.store') }}" class="space-y-4">
        @csrf
        <div>
            <label>Host</label>
            <input type="text" name="host" value="{{ old('host', $setting->host ?? '127.0.0.1') }}" class="border p-1 w-full"/>
        </div>
        <div>
            <label>Port</label>
            <input type="text" name="port" value="{{ old('port', $setting->port ?? 5038) }}" class="border p-1 w-full"/>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username', $setting->username ?? '') }}" class="border p-1 w-full"/>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" value="{{ old('password', $setting->password ?? '') }}" class="border p-1 w-full"/>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Save</button>
    </form>
</div>
@endsection
