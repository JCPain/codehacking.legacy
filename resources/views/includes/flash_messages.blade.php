
@if(Session::has('msg-created'))
<div class="alert alert-info">
    <p class="text-center">{{session('msg-created')}}</p>
</div>
@elseif(Session::has('msg-created-reply'))
<div class="alert alert-info">
    <p class="text-center">{{session('msg-created-reply')}}</p>
</div>
@endif