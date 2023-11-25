@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/nouislider/nouislider.css')}}" />
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
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('capabilities', [
	            'stakeholder_id' => request()->get('stakeholder_id'),
	            'school_id' => request()->get('school_id')
	          ])}}">Capabilities</a>
        </li>
        <li class="breadcrumb-item active">{{$capability->name}}</li>
    </ol>
    @if(!request()->get('stakeholder_id') && !request()->get('school_id'))
        <x-button class="mb-3 me-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Add Subcapability
        </x-button>
        @include('components.form-modal', [
            'title' => 'Add Subcapability',
            'url' => url('resource/capabilities/'.$capability['id'].'/subcapabilities'),
            'fields' => [
                ['name' => 'name', 'type' => 'text'],
            ]
        ])
    @endif
    <div class="row mt-2 mb-2">
        <div class="col-lg-4">
            <select id="schoolSelect" class="form-select form-select-sm">
                <option value="0">-- No school selected --</option>
                @foreach($schools as $school)
                    <option
                            @if ($school->id == request()->get('school_id'))
                                selected="selected"
                            @endif
                            value="{{$school->id}}">{{$school->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4">
            <select id="stakeholderSelect" class="form-select form-select-sm">
                <option value="0">-- No stakeholder selected --</option>
                @foreach($stakeholders as $stakeholder)
                    <option
                            @if ($stakeholder->id == request()->get('stakeholder_id'))
                                selected="selected"
                            @endif
                            value="{{$stakeholder->id}}">{{$stakeholder->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @include('components.form-modal', [
        'title' => 'Update Capability',
        'url' => url('resource/capabilities/'.$capability['id'].'/subcapabilities'),
        'fields' => [
            ['name' => 'response', 'value' => 'full-reload', 'type' => 'hidden'],
            ['name' => 'stakeholder_id', 'value' => request()->get('stakeholder_id'), 'type' => 'hidden'],
			['name' => 'school_id', 'value' => request()->get('school_id'), 'type' => 'hidden'],
            ['name' => 'name', 'type'=>'text'],
        ],
        'action' => 'update'
    ])
    <x-secondary-button onclick="updateWeights('subcapabilities')" class="mb-3 d-none" id="updateWeightsButton">Update weights</x-secondary-button>
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
    <div id="slider-wrapper" class="card-body hide">
        <div class="slider-dynamic"></div>
    </div>
@endsection

@once
    @push('scripts')
        <script>
            $(document).ready(function() {
                stakeholderId = parseInt({{request()->get('stakeholder_id', 0)}})
                schoolId = parseInt({{request()->get('school_id', 0)}})
                fetchSubcapabilities({{$capability->id}});
            })
            initSchoolSelect($('#schoolSelect'));
            initStakeholdersSelect($('#stakeholderSelect'));
        </script>
    @endpush
@endonce
