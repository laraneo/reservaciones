@extends('layouts.admin', ['title' => __('backend.package_addons')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.package_addons') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.addons') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.addons')
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('addons.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.create_addon') }}</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.all_addons') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.title') }}</th>
                                    <th>{{ __('backend.price') }}</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.title') }}</th>
                                    <th>{{ __('backend.price') }}</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($addons as $addon)
                                    <tr>
                                        <td>{{ $addon->id }}</td>
                                        <td><img src="{{ asset($addon->photo->file) }}" width="40" height="40"></td>
                                        <td>{{ $addon->title }}</td>
                                        <td>

                                            @if(config('settings.currency_symbol_position')== __('backend.right'))

                                                {!! number_format( (float) $addon->price,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ). '&nbsp;' .
                                                    config('settings.currency_symbol') !!}

                                            @else

                                                {!! config('settings.currency_symbol').
                                                    number_format( (float) $addon->price,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ) !!}

                                            @endif

                                        </td>
                                        <td>{{ $addon->category->title }}</td>
                                        <td>{{ $addon->created_at->diffForHumans() }}</td>
                                        <td>{{ $addon->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('addons.edit', $addon->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $addon->id }}"><i class="fa fa-trash-o"></i></a>
                                            <!-- Addon Delete Modal -->
                                            <div id="{{ $addon->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.delete_addon_message') }}</p>
                                                        </div>
                                                        <form method="post" action="{{ route('addons.destroy', $addon->id) }}">
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