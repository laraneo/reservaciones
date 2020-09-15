@extends('layouts.admin', ['title' => __('backend.addon_parameter')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.addon_parameter') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.addon_parameter') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.addon_parameter')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix" style="margin-bottom: 24px; height: 90px;">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.addon_parameter') }}</h4>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group" style="margin-top: 20px;">
                                <select class="form-control" id="category_id" name="category_id" onchange="handleCategoryPackage()">
                                    <option value="">Seleccione Categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $selectedCategory ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>                        
                        </div>
                        
                        @if($selectedCategory !== '')
                            <div class="col-md-4 form-group" style="margin-top: 20px;">
                                <select class="form-control" id="package_id" name="package_id" onchange="handleBookingTimePackage()">
                                    <option value="">Seleccione Paquete</option>
                                    @foreach($packages as $element)
                                        <option value="{{ $element->id }}" {{ $element->id == $selectedPackage ? 'selected' : '' }} >{{ $element->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                            @if($selectedPackage !== '')
                             <div class="col-md-4 form-group" style="margin-top: 20px;">
                                <input type="button" class="btn btn-danger" value="Reestablecer valor por defecto" onclick="handleAddonsParametersDefault()">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.addon') }}</th>
                                    <th>{{ __('backend.booking_min') }}</th>
                                    <th>{{ __('backend.booking_max') }}</th>
                                    <th>{{ __('backend.player_min') }}</th>
                                    <th>{{ __('backend.player_max') }}</th>
                                    <th>{{ __('backend.guest_min') }}</th>
                                    <th>{{ __('backend.guest_max') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.addon') }}</th>
                                    <th>{{ __('backend.booking_min') }}</th>
                                    <th>{{ __('backend.booking_max') }}</th>
                                    <th>{{ __('backend.player_min') }}</th>
                                    <th>{{ __('backend.player_max') }}</th>
                                    <th>{{ __('backend.guest_min') }}</th>
                                    <th>{{ __('backend.guest_max') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($addonsParameters as $element)
                                        <tr>
                                            <td>{{ $element->id }}</td>
                                            <td>{{ $element->addon ? $element->addon()->first()->title : '' }}</td>
                                            <td>{{ $element->booking_min }}</td>
                                            <td>{{ $element->booking_max }}</td>
                                            <td>{{ $element->player_min }}</td>
                                            <td>{{ $element->player_max }}</td>
                                            <td>{{ $element->guest_min }}</td>
                                            <td>{{ $element->guest_max }}</td>
                                            <td>{{ $element->updated_at->diffForHumans() }}</td>
                                            <td><a class="btn btn-primary" data-toggle="modal" data-target="#update_{{ $element->id }}">{{ __('backend.edit') }}</a></td>
                                        </tr>
                                        <div class="modal fade" id="update_{{ $element->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
                                            <div class="modal-dialog">
                                                <form method="post" action="{{ route('addons-parameters.update', $element->id) }}" >
                                                    @csrf
                                                    {{ method_field('PATCH') }}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel"><strong>{{ __('backend.addon') }}: </strong> {{ $element->addon ? $element->addon()->first()->title : '' }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" style="line-height: 2.5;">
                                                                <div class="col-md-12 form-group"> <strong>{{ __('backend.package') }}: </strong> {{ $element->package ? $element->package()->first()->title : '' }} </div>
                                                                <div class="col-md-2 form-group">
                                                                    Reserva
                                                                </div>
                                                                <div class="col-md-10 form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 form-group">Min</div>
                                                                        <div class="col-md-5 form-group">
                                                                            <input type="number" class="form-control" name="booking_min" value="{{$element->booking_min}}">
                                                                        </div>
                                                                        <div class="col-md-1 form-group">Max</div>
                                                                        <div class="col-md-5 form-group">
                                                                            <input type="number" class="form-control" name="booking_max" value="{{$element->booking_max}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 form-group">
                                                                    Usuario
                                                                </div>
                                                                <div class="col-md-10 form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 form-group">Min</div>
                                                                        <div class="col-md-5 form-group">
                                                                            <input type="number" class="form-control" name="player_min" value="{{$element->player_min}}">
                                                                        </div>
                                                                        <div class="col-md-1 form-group">Max</div>
                                                                        <div class="col-md-5 form-group">
                                                                            <input type="number" class="form-control" name="player_max" value="{{$element->player_max}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 form-group">
                                                                    Invitado
                                                                </div>
                                                                <div class="col-md-10 form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-1 form-group">Min</div>
                                                                        <div class="col-md-5 form-group">
                                                                            <input type="number" class="form-control" name="guest_min" value="{{$element->guest_min}}">
                                                                        </div>
                                                                        <div class="col-md-1 form-group">Max</div>
                                                                        <div class="col-md-5 form-group">
                                                                            <input type="number" class="form-control" name="guest_max" value="{{$element->guest_max}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="selectedCategory" id="selectedCategory" value="{{ $selectedCategory }}" >
                                                            <input type="hidden" name="selectedPackage" id="selectedPackage" value="{{ $selectedPackage }}" >
                                                            <button type="submit" class="btn btn-success">{{ __('backend.update') }}</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>    
    
        function handleCategoryPackage() {
            const id = document.getElementById("category_id").value;
            if(id > 0) {
                window.location.href = `/addons-parameters?category=${id}`;
            }
            
        }

        function handleBookingTimePackage() {
            const id = document.getElementById("package_id").value;
            if(id > 0) {
                const category = "{{ $selectedCategory }}";
                window.location.href = `/addons-parameters?category=${category}&package=${id}`;
            }
        }

        function handleAddonsParametersDefault() {
            const BASE_URL = $('meta[name="index"]').attr('content');
            const id = document.getElementById("package_id").value;
            const category = "{{ $selectedCategory }}";
            const package = "{{ $selectedPackage }}";
                $.ajax({
                    type: 'GET',
                    url: `/addons-parameters-generate`,
                    data: { 
                        package: package,
                        category: category,
                    },
                    success: function(response) {
                        window.location.href = `/addons-parameters?category=${category}&package=${id}`;
                    },
                });
        }
    
    </script>
@endsection