@extends('layouts.layoutMaster')

@section('title', 'Update stakeholder weights')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/nouislider/nouislider.css')}}"/>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/nouislider/nouislider.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/stakeholdersUpdateWeights.js')}}"></script>
@endsection

@section('content')
    <x-secondary-button onclick="updateWeights()" class="mb-3 d-none" id="updateWeightsButton">Update
        weights
    </x-secondary-button>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-items table border-top">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Weight</th>
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
                schoolId = parseInt({{request()->get('school_id', 0)}})
                fetchWeights(schoolId);
            })
        </script>
    @endpush
@endonce
