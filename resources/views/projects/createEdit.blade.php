@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-panel">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">

                            <h4 class="m-0 header-heading fw-bold text-primary">
                                {{ isset($current->id) ? __('Edit Project') : __('Create Project') }}</h4>
                            <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                                    <i class="fa-solid fa-diagram-project"></i>
                                    <span class="mx-1">Projects List</span>
                                </a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="mainForm" action="{{ route('projects.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $current->id ?? '' }}">
                                <div class="row mb-1">
                                    <div class="col-md-3">
                                        @include('components.input', [
                                            'id' => 'name',
                                            'name' => 'name',
                                            'label' => 'Name',
                                            'type' => 'text',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'maxlength' => '50',
                                            'value' => isset($current->name) ? $current->name : '',
                                            'placeholder' => 'Enter Name',
                                            'otherattr' => '',
                                        ])
                                    </div>
                                    <div class="col-md-3">
                                        @include('components.select', [
                                            'id' => 'leader_id',
                                            'name' => 'leader_id',
                                            'label' => 'Leader',
                                            'class' => '',
                                            'mandatory' => true,
                                            'multiple' => false,
                                            'disabled' => false,
                                            'options' => $leaders ?? [],
                                            'selected' => isset($current->leader_id) ? $current->leader_id : '',
                                        ])
                                    </div>
                                    <div class="col-md-3">
                                        @include('components.input', [
                                            'id' => 'date',
                                            'name' => 'date',
                                            'label' => 'Start Date',
                                            'type' => 'date',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'value' => isset($current->date) ? $current->date : '',
                                            'placeholder' => 'Enter Start Date',
                                            'otherattr' => '',
                                        ])
                                    </div>
                                    <div class="col-md-3">
                                        @include('components.input', [
                                            'id' => 'deadline_date',
                                            'name' => 'deadline_date',
                                            'label' => 'Deadline Date',
                                            'type' => 'date',
                                            'mandatory' => true,
                                            'readonly' => false,
                                            'value' => isset($current->deadline_date) ? $current->deadline_date : '',
                                            'placeholder' => 'Enter Deadline Date',
                                            'otherattr' => '',
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.select', [
                                            'id' => 'client_ids',
                                            'name' => 'client_ids[]',
                                            'label' => 'Clients',
                                            'class' => '',
                                            'mandatory' => true,
                                            'multiple' => true,
                                            'disabled' => false,
                                            'options' => $clients ?? [],
                                            'selected' => isset($current->clients) ? $current->clients->pluck('user_id')->toArray() : '',
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.select', [
                                            'id' => 'developer_ids',
                                            'name' => 'developer_ids[]',
                                            'label' => 'Developers',
                                            'class' => '',
                                            'mandatory' => true,
                                            'multiple' => true,
                                            'disabled' => false,
                                            'options' => $developers ?? [],
                                            'selected' => isset($current->developers) ? $current->developers->pluck('user_id')->toArray() : '',
                                        ])
                                    </div>
                                    <div class="col-md-12">
                                        @include('components.select', [
                                            'id' => 'tester_ids',
                                            'name' => 'tester_ids[]',
                                            'label' => 'Testers',
                                            'class' => '',
                                            'mandatory' => true,
                                            'multiple' => true,
                                            'disabled' => false,
                                            'options' => $testers ?? [],
                                            'selected' => isset($current->testers) ? $current->testers->pluck('user_id')->toArray() : '',
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
