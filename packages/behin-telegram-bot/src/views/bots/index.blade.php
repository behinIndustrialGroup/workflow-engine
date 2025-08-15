@extends('behin-layouts.app')

@section('content')
<div class="container">
    <h1>Telegram Bots</h1>
    <form id="bot-form" class="mb-3">
        @csrf
        <div class="row g-2">
            <div class="col"><input type="text" name="name" class="form-control" placeholder="Bot Name"></div>
            <div class="col"><input type="text" name="token" class="form-control" placeholder="Bot Token"></div>
            <div class="col"><button type="button" class="btn btn-primary" onclick="createBot()">Create</button></div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead><tr><th>Name</th><th>Token</th><th>Messages</th></tr></thead>
        <tbody>
            @foreach($bots as $bot)
                <tr>
                    <td>{{ $bot->name }}</td>
                    <td>{{ $bot->token }}</td>
                    <td><a href="{{ route('telegram.messages.view', $bot) }}" class="btn btn-sm btn-info">View Messages</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
function createBot(){
    var fd = new FormData(document.getElementById('bot-form'));
    send_ajax_formdata_request('{{ route('telegram.bot.store') }}', fd, function(){ location.reload(); });
}
</script>
@endsection
