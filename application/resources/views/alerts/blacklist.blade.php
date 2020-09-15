@if(Session::has('blacklist_created'))
    <div class="alert alert-success">{{session('blacklist_created')}}</div>
@endif

@if(Session::has('blacklist_deleted'))
    <div class="alert alert-success">{{session('blacklist_deleted')}}</div>
@endif

@if(Session::has('blacklist_updated'))
    <div class="alert alert-success">{{session('blacklist_updated')}}</div>
@endif