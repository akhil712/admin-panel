@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h4 class="header-heading fw-bold text-primary">
                                {{ isset($current->id) ? __('Edit Role') : __('Create Role') }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('roles.index') }}" class="btn btn-primary">Roles List</a>
                            </h6>
                        </div>

                        <div class="card-body">
                            <form id="mainForm" action="{{ route('roles.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$current->id ?? ''}}">
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('components.input', [
                                            'id' => 'name',
                                            'name' => 'name',
                                            'label' => 'Name',
                                            'type' => 'text',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'maxlength' => '20',
                                            'value' => isset($current->name) ? $current->name : '',
                                            'placeholder' => 'Enter Name',
                                            'otherattr' => '',
                                        ])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" class="btn ms-1 btn-primary formValidate">
                                                <span class="icon">
                                                    <i class="fa-solid fa-floppy-disk"></i>
                                                </span>
                                                <span class="text mx-1">Save</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
