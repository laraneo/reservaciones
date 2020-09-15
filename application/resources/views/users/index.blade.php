@extends('layouts.admin', ['title' => __('backend.all_users')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.all_users') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.users') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.users')
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('users.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.add_new_user') }}</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.all_users') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.name') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.role') }}</th>
                                    <th>{{ __('backend.doc_id') }}</th>
                                    <th>{{ __('backend.group_id') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.name') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.role') }}</th>
                                    <th>{{ __('backend.doc_id') }}</th>
                                    <th>{{ __('backend.group_id') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td><img src="{{ $user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}" class="img-circle avatar" width="40" height="40"></td>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>{{ ucfirst($user->role->name) }}</td>
                                            <td>{{ ucfirst($user->doc_id) }}</td>
                                            <td>{{ ucfirst($user->group_id) }}</td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="label label-success" style="font-size:12px;">{{ __('backend.active') }}</span>
                                                @else
                                                    <span class="label label-danger" style="font-size:12px;">{{ __('backend.blocked') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                @if($user->id != Auth::user()->id)
                                                    <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $user->id }}"><i class="fa fa-trash-o"></i></a>

                                                    <!-- User Delete Modal -->
                                                    <div id="{{ $user->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('backend.delete_user_message') }}</p>
                                                                </div>
                                                                <form method="post" action="{{ route('users.destroy', $user->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection