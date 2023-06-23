@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/nouislider/nouislider.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/nouislider/nouislider.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/capabilities.js')}}"></script>
@endsection

@section('content')
    @if(!request()->get('stakeholder_id'))
        <div class="row mb-4">
            <div class="col-12">
                <livewire:import-capabilities/>
            </div>
        </div>
        <x-button class="mb-3 me-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Add Capability
        </x-button>
        @include('components.form-modal', [
            'title' => 'Add Capability',
            'url' => url('resource/capabilities'),
            'fields' => [
                ['name' => 'name', 'type'=>'text']
            ]
        ])
    @endif
    <x-secondary-button onclick="updateWeights('capabilities')" class="mb-3 d-none" id="updateWeightsButton">Update
        weights
    </x-secondary-button>
    @include('components.form-modal', [
	    'title' => 'Update Capability',
	    'url' => url('resource/capabilities'),
	    'fields' => [
			['name' => 'response', 'value' => 'full-reload', 'type' => 'hidden'],
			['name' => 'stakeholder_id', 'value' => request()->get('stakeholder_id'), 'type' => 'hidden'],
			['name' => 'name', 'type'=>'text'],
        ],
        'action' => 'update'
    ])
    <br/>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-items table border-top">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Weight</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="slider-wrapper" class="card-body hide">
        <div class="slider-dynamic"></div>
    </div>
@endsection

@once
    @push('scripts')
        <script>
            $(document).ready(function () {
                stakeholderId = parseInt({{request()->get('stakeholder_id', 0)}})
                fetchCapabilities();
            })
        </script>
    @endpush
@endonce