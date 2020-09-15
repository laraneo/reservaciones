@extends('layouts.admin', ['title' => __('backend.categories')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.manage_booking_categories') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.categories') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">

                @include('alerts.categories')

                <div class="col-md-3">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('backend.add_category') }}</h4>
                        </div>
                        <div class="panel-body">

                            <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">

                                {{csrf_field()}}

                                <div class="form-group{{$errors->has('title') ? ' has-error' : ''}}">
                                    <label class="control-label" for="title">{{ __('backend.title') }}</label>
                                    <input type="text" class="form-control" name="title" value="{{old('title')}}">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{$errors->has('category_type') ? ' has-error' : ''}}">
                                    <label class="control-label" for="category_type">{{ __('backend.category_type') }}</label>
                                    <select class="form-control" name="category_type">
                                        <option value="0">Estandar</option>
                                        <option value="1">Por tiempo</option>
                                    </select>
                                </div>

                                <div class="form-group{{$errors->has('draw') ? ' has-error' : ''}}">
                                    <label class="control-label" for="draw">{{ __('backend.draw') }}</label>
                                    <select class="form-control" name="draw">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>

                                <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                    <select class="form-control" name="is_active">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    @if ($errors->has('is_active'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('is_active') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                    <label for="photo_id" class="control-label">{{ __('backend.select_image') }}</label>
                                    <input type="file" id="photo_id" name="photo_id">
                                    @if ($errors->has('photo_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                        </span>
                                    @endif
                                    <span class="help-block">
                                        <strong class="text-info">{{ __('backend.category_image_info') }}</strong>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.add_category') }}</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('backend.categories') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('backend.image') }}</th>
                                        <th>{{ __('backend.title') }}</th>
                                        <th>{{ __('backend.category_type') }}</th>
                                        <th>{{ __('backend.draw') }}</th>
                                        <th>{{ __('backend.created') }}</th>
                                        <th>{{ __('backend.updated') }}</th>
                                        <th>{{ __('backend.is_active') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('backend.image') }}</th>
                                        <th>{{ __('backend.title') }}</th>
                                        <th>{{ __('backend.category_type') }}</th>
                                        <th>{{ __('backend.draw') }}</th>
                                        <th>{{ __('backend.created') }}</th>
                                        <th>{{ __('backend.updated') }}</th>
                                        <th>{{ __('backend.is_active') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td><img src="{{ asset($category->photo->file) }}" width="40" height="40"></td>
                                            <td>{{ $category->title }}</td>
                                            <td>
                                                @if($category->category_type !== NULL && $category->category_type == 0)
                                                    Estandar
                                                @endif
                                                @if($category->category_type !== NULL && $category->category_type == 1)
                                                    Por Tiempo
                                                @endif
                                            </td>
                                            <td>
                                                @if($category->draw !== NULL && $category->draw == 0)
                                                    NO
                                                @endif
                                                @if($category->draw !== NULL && $category->draw == 1)
                                                    SI
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at->diffForHumans() }}</td>
                                            <td>{{ $category->updated_at->diffForHumans() }}</td>
                                            <td>
                                            @if($category->is_active !== null && $category->is_active == 0)
                                                Inactivo
                                            @endif
                                             @if($category->is_active !== null && $category->is_active == 1)
                                                Activo
                                            @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $category->id }}"><i class="fa fa-trash-o"></i></a>
                                                <!-- Category Delete Modal -->
                                                <div id="{{ $category->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ __('backend.delete_category_message') }}</p>
                                                            </div>
                                                            <form method="post" action="{{ route('categories.destroy', $category->id) }}">
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
    </div>

@endsection