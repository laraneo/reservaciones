@if(Session::has('category_created'))
    <div class="alert alert-success">{{session('category_created')}}</div>
@endif

@if(Session::has('category_deleted'))
    <div class="alert alert-success">{{session('category_deleted')}}</div>
@endif

@if(Session::has('category_updated'))
    <div class="alert alert-success">{{session('category_updated')}}</div>
@endif