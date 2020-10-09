@php
    $edit = !is_null($address);
    $add  = is_null($address);
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' Address')

@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-location"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' Address' }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="@if($edit){{ route('voyager.address.update', $address->id) }}@else{{ route('voyager.address.create') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if($edit)
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="customer" name="customer"
                                       value="{{ old('customer',  $customer ?? '') }}">
                                <label for="name">Street</label>
                                <input type="text" class="form-control" id="street" name="street" placeholder="Street"
                                       value="{{ old('street',  $address->street ?? '') }}">
                                <label for="name">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="City"
                                       value="{{ old('city',  $address->city ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @section('submit-buttons')
                <button type="submit" class="btn btn-primary pull-right">
                     @if($edit){{ __('voyager::generic.update') }}@else <i class="icon wb-plus-circle"></i> {{ __('voyager::generic.new') }} @endif
                </button>
            @stop
            @yield('submit-buttons')
        </form>
    </div>
@stop

