@if(Session::has('group_created'))
    <div class="alert alert-success">{{session('group_created')}}</div>
@endif

@if(Session::has('group_deleted'))
    <div class="alert alert-success">{{session('group_deleted')}}</div>
@endif

@if(Session::has('group_updated'))
    <div class="alert alert-success">{{session('group_updated')}}</div>
@endif