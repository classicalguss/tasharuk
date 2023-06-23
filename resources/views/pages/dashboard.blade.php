@php
$configData = Helper::appClasses();
@endphp

@extends('layouts.layoutMaster')

@section('title', 'Home')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
@endsection

@section('content')
    <div class="row gy-4">
        <div class="col-md-6 col-12">
            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-4 col-md-3 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-user fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Users</span>
                            <h2 class="mb-0">{{$usersCount}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-md-3 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bxs-school fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Schools</span>
                            <h2 class="mb-0">{{$schoolsCount}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-md-3 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-show fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Visits</span>
                            <h2 class="mb-0">40</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Surveys</h5>
                        <small class="text-muted">Completion rate</small>
                    </div>
                </div>
                <div class="card-body">
                    <div id="donutChart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Schools Performance</h5>
                        <small class="text-muted">From 100 surveys</small>
                    </div>
                </div>
                <div class="card-body">
                    <div id="horizontalBarChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
