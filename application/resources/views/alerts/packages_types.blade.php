@if(Session::has('packages_types_created'))
    <div class="alert alert-success">{{session('packages_types_created')}}</div>
@endif

@if(Session::has('packages_types_deleted'))
    <div class="alert alert-success">{{session('packages_types_deleted')}}</div>
@endif

@if(Session::has('packages_types_updated'))
    <div class="alert alert-success">{{session('packages_types_updated')}}</div>
@endif