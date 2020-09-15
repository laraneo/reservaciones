@if(Session::has('addon_created'))
    <div class="alert alert-success">{{session('addon_created')}}</div>
@endif

@if(Session::has('addon_deleted'))
    <div class="alert alert-success">{{session('addon_deleted')}}</div>
@endif

@if(Session::has('addon_updated'))
    <div class="alert alert-success">{{session('addon_updated')}}</div>
@endif