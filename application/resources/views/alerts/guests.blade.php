@if(Session::has('guest_created'))
    <div class="alert alert-success">{{session('guest_created')}}</div>
@endif

@if(Session::has('guest_deleted'))
    <div class="alert alert-success">{{session('guest_deleted')}}</div>
@endif

@if(Session::has('guest_updated'))
    <div class="alert alert-success">{{session('guest_updated')}}</div>
@endif