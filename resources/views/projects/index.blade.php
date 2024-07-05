@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h4 class="m-0 header-heading fw-bold text-primary">{{ __('Projects List') }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                    <i class="fa-solid fa-diagram-project"></i>
                                    <span class="mx-1">Create Project</span>
                                </a>
                            </h6>
                        </div>

                        <div class="card-body">
                            <div id="preTable" class="table-responsive">
                                <table id="mainTable" class="table table-bordered tablelist display">
                                    <thead>
                                        <tr class="table-danger">
                                            <th class="light-subtle fw-semibold">Name</th>
                                            <th class="light-subtle fw-semibold">Leader</th>
                                            <th class="light-subtle fw-semibold">Clients</th>
                                            <th class="light-subtle fw-semibold">Developers</th>
                                            <th class="light-subtle fw-semibold">Testers</th>
                                            <th class="light-subtle fw-semibold">Start Date</th>
                                            <th class="light-subtle fw-semibold">Deadline Date</th>
                                            <th class="light-subtle fw-semibold text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($projects) && count($projects))
                                            @foreach ($projects as $val)
                                                <tr class="table-primary">
                                                    <td>{{ $val->name }}</td>
                                                    <td>{{ isset($val->leader) ? $val->leader->name : 'NA' }}</td>
                                                    <td>
                                                        @if (isset($val->clients) && count($val->clients))
                                                            @foreach ($val->clients as $index => $client)
                                                                {{ $client->user->name }}{{ $index + 1 < count($val->clients) ? ', ' : '' }}
                                                            @endforeach
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($val->developers) && count($val->developers))
                                                            @foreach ($val->developers as $index => $dev)
                                                                {{ $dev->user->name }}{{ $index + 1 < count($val->developers) ? ', ' : '' }}
                                                            @endforeach
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($val->testers) && count($val->testers))
                                                            @foreach ($val->testers as $index => $tester)
                                                                {{ $tester->user->name }}{{ $index + 1 < count($val->testers) ? ', ' : '' }}
                                                            @endforeach
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>{{ $val->date }}</td>
                                                    <td>{{ $val->deadline_date }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('projects.edit', urlencode(base64_encode($val->id))) }}"
                                                            class="btn btn-info">
                                                            <i class="fa-regular fa-pen-to-square" style="color: #fff;"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="btn btn-danger deleteRecord" url="{{route('projects.destroy',urlencode(base64_encode($val->id)))}}"
                                                            data-project-id="{{ $val->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">No projects found.</td>
                                            </tr>
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
