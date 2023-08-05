@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/capabilities.js')}}"></script>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('capabilities', ['stakeholder_id' => request()->get('stakeholder_id')])}}">Capabilities</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('subcapabilities', ['capability' => $capability->id, 'stakeholder_id' => request()->get('stakeholder_id')])}}">
                {{$capability->name}}
            </a>
        </li>
        <li class="breadcrumb-item active">
            {{$subcapability->name}}
        </li>
    </ol>
    @if(!request()->get('stakeholder_id'))
        <x-button class="mb-3 me-2" data-bs-toggle="modal" data-bs-target="#createModal">
            Add Indicator
        </x-button>
        @include('components.form-modal', [
            'title' => 'Add Indicator',
            'url' => url('resource/subcapabilities/'.$subcapability->id.'/indicators'),
            'fields' => [
                ['name' => 'text', 'type' => 'text'],
                ['name' => 'highly_effective', 'type' => 'text'],
                ['name' => 'effective', 'type' => 'text'],
                ['name' => 'satisfactory', 'type' => 'text'],
                ['name' => 'needs_improvement', 'type' => 'text'],
                ['name' => 'does_not_meet_standard', 'type' => 'text']
            ]
        ])
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-items table border-top table-bordered">
                        <thead>
                            <tr>
                                <th>Indicator</th>
                                <th>Highly Effective</th>
                                <th>Effective</th>
                                <th>Satisfactory</th>
                                <th>Needs Improvement</th>
                                <th>Does not meet standard</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="cell-actions-wrapper d-none">
        <textarea
                style="resize: none"
                oninput="textareaAutoAdjust(this)"
                class="form-control"></textarea>
        <div style="text-align: center">
            <button onclick="saveIndicator(this,{{$subcapability->id}})" title="Save" class="btn btn-sm btn-icon">
                <i class="me-2 bx bx-check"></i>
            </button>
            <button onclick="resetToEditable(this)" title="Cancel" class="btn btn-sm btn-icon">
                <i class="me-2 bx bx-x"></i>
            </button>
            <button onclick="toggleVisibility(this);resetToEditable()" title="Hide" class="btn btn-sm btn-icon indicator-visibility-action indicator-action">
                <i class="me-2 bx bx-show-alt"></i>
            </button>
            @if(!request()->get('stakeholder_id'))
                <button title="Delete" class="btn btn-sm btn-icon indicator-action delete-record" onclick="deleteRecord(this)">
                    <i class="me-2 bx bx-trash"></i>
                </button>
            @endif
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script>
            $(document).ready(function() {
                stakeholderId = parseInt({{request()->get('stakeholder_id', 0)}})
                schoolId = parseInt({{request()->get('school_id', 0)}})
                fetchIndicators({{$subcapability->id}});
            })
        </script>
    @endpush
@endonce