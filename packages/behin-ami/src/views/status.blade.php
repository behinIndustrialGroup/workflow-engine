@extends('behin-layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-indigo-600">
            <h1 class="text-lg font-semibold text-white flex items-center">
                📞 Extension Status
            </h1>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-6 py-3 font-medium">Extension</th>
                        <th class="text-left px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peers as $peer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 border-b">{{ $peer['objectname'] }}</td>
                            <td class="px-6 py-3 border-b">
                                @if(str_contains(strtolower($peer['status']), 'ok'))
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                        ● Online
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                        ● Offline
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                No data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
