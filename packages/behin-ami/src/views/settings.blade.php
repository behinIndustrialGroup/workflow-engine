@extends('behin-layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
        {{-- هدر کارت --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-indigo-600">
            <h1 class="text-lg font-semibold text-white flex items-center">
                ⚙️ AMI Settings
            </h1>
        </div>

        {{-- پیام موفقیت --}}
        @if(session('status'))
            <div class="bg-green-100 text-green-700 px-4 py-2 m-4 rounded-md text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- فرم --}}
        <form method="POST" action="{{ route('ami.settings.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Host --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Host</label>
                <input type="text" 
                       name="host" 
                       value="{{ old('host', $setting->host ?? '127.0.0.1') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            {{-- Port --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Port</label>
                <input type="text" 
                       name="port" 
                       value="{{ old('port', $setting->port ?? 5038) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" 
                       name="username" 
                       value="{{ old('username', $setting->username ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" 
                       name="password" 
                       value="{{ old('password', $setting->password ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            {{-- دکمه --}}
            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg shadow-md transition">
                    💾 Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
