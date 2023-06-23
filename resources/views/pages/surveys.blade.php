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
    <script src="{{asset('assets/js/pages/surveys.js')}}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-items table border-top">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Stakeholder</th>
                        <th>School</th>
                        <th>Status</th>
                        <th>Sent at</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="slider-wrapper" class="card-body hide">
        <div class="slider-dynamic"></div>
    </div>
@endsection