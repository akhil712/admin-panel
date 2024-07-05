@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h4 class="m-0 header-heading fw-bold text-primary">{{ __('Permission Routes List') }}</h4>
                            {{-- <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add Permission Route</a>
                            </h6> --}}
                        </div>
                        <div class="card-body">
                            <div id="preTable" class="table-responsive">
                                <form action="{{ route('permissions.store') }}" id="mainForm" method="post">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-danger">
                                                <th width="150px">
                                                    Type
                                                </th>
                                                <th>
                                                    Category
                                                </th>
                                                <th>
                                                    Route Name
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="addParent_{{ config('addPages.route.id') }}" class="sortingorder">

                                            @foreach ($permissions as $type => $category)
                                                @if (count($category))
                                                    @foreach ($category as $item)
                                                        @include('components.route', [
                                                            'id' => $item['id'],
                                                            'type' => $item['type'],
                                                            'category' => $item['category'],
                                                            'name' => $item['name'],
                                                            'routes' => $routes
                                                        ])
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" style="text-align: right;">
                                                    <a href="javascript:void(0);"
                                                        class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm addComponent"
                                                        pid="{{ config('addPages.route.id') }}">
                                                        <i class="fas fa-fw fa-cog"></i>
                                                        Add New
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="text-align: center;">
                                                    <button type="button"
                                                        class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm formValidate">
                                                        Save / Update
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
