@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h4 class="m-0 header-heading fw-bold text-primary">{{ __('Users List') }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('users.create') }}" class="btn btn-primary">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <span class="mx-1">Create User</span>
                                </a>
                            </h6>
                        </div>

                        <div class="card-body">
                            <div id="preTable" class="table-responsive">
                                <table id="mainTable" class="table table-bordered tablelist display">
                                    <thead>
                                        <tr>
                                            <th class="light-subtle fw-semibold">Name</th>
                                            <th class="light-subtle fw-semibold">Email</th>
                                            <th class="light-subtle fw-semibold">Role</th>
                                            <th class="light-subtle fw-semibold text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($users) && count($users))
                                            @foreach ($users as $val)
                                                <tr>
                                                    <td>{{ $val->name }}</td>
                                                    <td>{{ $val->email }}</td>
                                                    <td>{{ isset($val->role) ? $val->role->name : '-' }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('users.edit', urlencode(base64_encode($val->id)) }}" class="btn btn-info">
                                                            <i class="fa-regular fa-pen-to-square" style="color: #fff;"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
