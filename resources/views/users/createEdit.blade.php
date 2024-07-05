@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">

                            <h4 class="m-0 header-heading fw-bold text-primary">
                                {{ isset($current->id) ? __('Edit User') : __('Create User') }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('users.index') }}" class="btn btn-primary">
                                    <i class="fa-solid fa-users"></i>   
                                    <span class="mx-1">Users List</span>
                                </a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="mainForm" action="{{ route('users.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $current->id ?? '' }}">
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
                                    <div class="col-md-4">
                                        @include('components.input', [
                                            'id' => 'email',
                                            'name' => 'email',
                                            'label' => 'Email',
                                            'type' => 'text',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'maxlength' => '50',
                                            'value' => isset($current->email) ? $current->email : '',
                                            'placeholder' => 'Enter Email',
                                            'otherattr' => '',
                                        ])
                                    </div>
                                    <div class="col-md-4">
                                        @include('components.input', [
                                            'id' => 'phone',
                                            'name' => 'phone',
                                            'label' => 'Phone',
                                            'type' => 'text',
                                            'class' => 'isValidMobile',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'maxlength' => '10',
                                            'value' => isset($current->phone) ? $current->phone : '',
                                            'placeholder' => 'Enter Phone',
                                            'otherattr' => '',
                                        ])
                                    </div>
                                    <div class="col-md-4">
                                        @include('components.select', [
                                            'id' => 'role_id',
                                            'name' => 'role_id',
                                            'label' => 'Role',
                                            'class' => '',
                                            'mandatory' => true,
                                            'multiple' => false,
                                            'disabled' => false,
                                            'options' => $roles ?? [],
                                            'selected' => $current->role_id ?? '',
                                        ])
                                    </div>
                                    <div class="col-md-4">
                                        @include('components.input', [
                                            'id' => 'password',
                                            'name' => 'password',
                                            'label' => 'Password',
                                            'type' => 'password',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'maxlength' => '20',
                                            'value' => '',
                                            'placeholder' => 'Enter Password',
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
