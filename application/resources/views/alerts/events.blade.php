@if(Session::has('event_created'))
    <div class="alert alert-success">{{session('event_created')}}</div>
@endif

@if(Session::has('event_deleted'))
    <div class="alert alert-success">{{session('event_deleted')}}</div>
@endif

@if(Session::has('event_updated'))
    <div class="alert alert-success">{{session('event_updated')}}</div>
@endif