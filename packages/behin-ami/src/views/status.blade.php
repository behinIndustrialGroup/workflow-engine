@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl mb-4">Extension Status</h1>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="text-left p-2">Extension</th>
                <th class="text-left p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peers as $peer)
                <tr>
                    <td class="border p-2">{{ $peer['objectname'] }}</td>
                    <td class="border p-2">{{ $peer['status'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="p-2">No data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
