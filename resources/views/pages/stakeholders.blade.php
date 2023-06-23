@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/stakeholders.js')}}"></script>
@endsection

@section('content')
    <x-button class="mb-3 me-2" data-bs-toggle="modal" data-bs-target="#createModal">
        Add Stakeholder
    </x-button>
    @include('components.form-modal', [
	    'title' => 'Update Stakeholder',
	    'url' => url('resource/stakeholders'),
	    'fields' => [
			['name' => 'name', 'type'=>'text'],
        ],
        'action' => 'update'
    ])
    @include('components.form-modal', [
	    'title' => 'Add Stakeholder',
	    'url' => url('resource/stakeholders'),
	    'fields' => [
			['name' => 'name', 'type' => 'text']
        ]
    ])
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-items table border-top">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="slider-wrapper" class="card-body hide">
        <div class="slider-dynamic"></div>
    </div>
@endsection