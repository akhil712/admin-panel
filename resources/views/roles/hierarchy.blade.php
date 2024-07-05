@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">

                            <h4 class="header-heading fw-bold text-primary">
                                {{ __('Role Hierarchy') }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('roles.index') }}" class="btn btn-primary">Roles List</a>
                            </h6>
                        </div>

                        <div class="card-body">
                            <ul id="sortable" class="list-group mb-3 ">
                                @foreach ($roles as $role)
                                    <li class="list-group-item list-group-item-action" role="button" id="role_{{ $role->id }}" name="{{$role->id}}">{{ $role->name }}</li>
                                @endforeach
                            </ul>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" id="saveOrderBtn" class="btn ms-1 btn-primary">
                                            <span class="icon">
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </span>
                                            <span class="text mx-1">Save</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#sortable").sortable();
        $("#sortable").disableSelection();

        $("#saveOrderBtn").click(function() {
            var roleIds = $("#sortable").sortable("toArray", { attribute: "name" });

            $.ajax({
                url: "{{ route('roles.hierarchy.store') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { role_ids: roleIds },
                success: function(response) {
                    if (response.status) {
                        alert(response.msg);
                    } else {
                        alert('Failed to save role order.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });
    </script>
@endsection