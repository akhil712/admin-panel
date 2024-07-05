@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">

                            <h4 class="m-0 header-heading fw-bold text-primary">
                                {{ __('Edit Role For ').$role->name }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('role-permissions.index') }}" class="btn btn-primary">Roles List</a>
                            </h6>
                        </div>
                        @php
                            $rolePermissions = $role->permissions->pluck('name')->toArray();
                        @endphp
                        <div class="card-body">
                            <form id="mainForm" action="{{ route('role-permissions.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                @foreach ($permissions as $type => $categories)
                                    <div class="mb-4">
                                        <h3>{{ $type == config('constants.permissionType.menu.id') ? config('constants.permissionType.menu.name') : config('constants.permissionType.url.name') }}</h3>
                                        @foreach ($categories as $category => $perms)
                                            <div class="form-group ms-3 mb-1 border-bottom">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input parent-checkbox"
                                                        id="category-{{$type}}-{{ Str::slug($category) }}">
                                                    <label class="form-check-label"
                                                        for="category-{{$type}}-{{ Str::slug($category) }}">{{ $category }}</label>
                                                </div>
                                                <div class="ms-4">
                                                    @foreach ($perms as $permission)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input child-checkbox"
                                                                name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->name,$rolePermissions) ? 'checked' : ''}}
                                                                id="permission-{{ $permission->id }}" >
                                                            <label class="form-check-label"
                                                                for="permission-{{ $permission->id }}">{{ ucwords(str_replace(['-', '.','_'], ' ', $permission->name)) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
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
@section('scripts')
    <script src="{{ asset('js/rolePermissions.js') }}"></script>
@endsection
