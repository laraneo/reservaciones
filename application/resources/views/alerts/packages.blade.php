@if(Session::has('package_created'))
    <div class="alert alert-success">{{session('package_created')}}</div>
@endif

@if(Session::has('package_deleted'))
    <div class="alert alert-success">{{session('package_deleted')}}</div>
@endif

@if(Session::has('package_updated'))
    <div class="alert alert-success">{{session('package_updated')}}</div>
@endif