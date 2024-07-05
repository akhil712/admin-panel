@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h4 class="m-0 header-heading fw-bold text-primary">{{ __('Roles List') }}</h4>
                            <div class="d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 mx-1 font-weight-bold text-main">
                                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-user-gear"></i>
                                        <span class="mx-1">Create Role</span>
                                    </a>
                                </h6>
                                <h6 class="m-0 mx-1 font-weight-bold text-main">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-primary">
                                        {{-- <i class="fa-solid fa-user-gear"></i> --}}
                                        <i class="fa-solid fa-universal-access fa-lg"></i>
                                        <span class="mx-1">Create Permission</span>
                                    </a>
                                </h6>
                                <h6 class="m-0 mx-1 font-weight-bold text-main">
                                    <a href="{{ route('roles.hierarchy.index') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-sitemap fa-lg"></i>
                                        <span class="mx-1">Roles Hierarchy</span>
                                    </a>
                                </h6>
                            </div>

                        </div>
                        <div class="card-body">
                            <div id="preTable" class="table-responsive">
                                <table id="mainTable" class="table table-bordered tablelist display">
                                    <thead>
                                        <tr>
                                            <th class="light-subtle fw-semibold w-50">Name</th>
                                            <th class="light-subtle fw-semibold">Edit Role</th>
                                            <th class="light-subtle fw-semibold">Edit Permissions</th>
                                            <th class="light-subtle fw-semibold text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($roles) && count($roles))
                                            @foreach ($roles as $val)
                                                <tr>
                                                    <td>{{ $val->name }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('roles.edit', urlencode(base64_encode($val->id))) }}" class="btn btn-info">
                                                            <i class="fa-regular fa-pen-to-square fa-lg"
                                                                style="color: #fff;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('role-permissions.edit', urlencode(base64_encode($val->id))) }}"
                                                            class="btn btn-success">
                                                            <i class="fa-solid fa-universal-access fa-lg"
                                                                style="color: #fff;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" class="btn btn-danger deleteRecord" url="{{route('projects.destroy',urlencode(base64_encode($val->id)))}}">
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
