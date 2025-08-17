@extends('behin-layouts.app')

@section('content')
<div class="container">
    <h1>Messages - {{ $bot->name }}</h1>
    <table class="table table-striped" id="messages-table">
        <thead><tr><th>User</th><th>Message</th><th>Response</th><th>Reply</th></tr></thead>
        <tbody></tbody>
    </table>
    <div class="mt-3">
        <input type="hidden" id="message-id">
        <textarea id="reply-text" class="form-control" placeholder="Reply..."></textarea>
        <button class="btn btn-primary mt-2" onclick="sendReply()">Send</button>
    </div>
</div>
<script>
function loadMessages(){
    send_ajax_get_request('{{ route('telegram.messages', $bot) }}', function(res){
        let tbody=document.querySelector('#messages-table tbody');
        tbody.innerHTML='';
        res.forEach(function(m){
            let tr=document.createElement('tr');
            tr.innerHTML='<td>'+m.user_id+'</td><td>'+m.message+'</td><td>'+(m.response || '')+'</td>'+
                '<td><button class="btn btn-sm btn-info" onclick="prepareReply('+m.id+')">Reply</button></td>';
            tbody.appendChild(tr);
        });
    });
}
function prepareReply(id){
    document.getElementById('message-id').value=id;
}
function sendReply(){
    let id=document.getElementById('message-id').value;
    if(!id) return;
    let fd=new FormData();
    fd.append('text', document.getElementById('reply-text').value);
    send_ajax_formdata_request('/telegram/messages/'+id+'/reply', fd, function(){
        document.getElementById('reply-text').value='';
        loadMessages();
    });
}
loadMessages();
</script>
@endsection
