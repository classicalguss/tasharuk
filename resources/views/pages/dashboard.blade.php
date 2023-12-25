@php
    use App\Models\Survey;$configData = Helper::appClasses();
	use App\Models\WebsiteMetrics;use Illuminate\Support\Js;
@endphp

@extends('layouts.layoutMaster')

@section('title', 'Home')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"/>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
@endsection
<style>
    .apexcharts-svg {
        overflow: visible;
    }

    .apexcharts-canvas {
        padding-left: 16px;
    }
</style>

@section('content')
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="row gy-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i
                                            class="bx bx-user fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Users</span>
                            <h2 class="mb-0">{{$usersCount}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i
                                            class="bx bxs-school fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Schools</span>
                            <h2 class="mb-0">{{$schoolsCount}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i
                                            class="bx bxs-report fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Reports generated</span>
                            <h2 class="mb-0">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i
                                            class="bx bx-show fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap">Visits</span>
                            <h2 class="mb-0">{{WebsiteMetrics::first()->num_of_visitors}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 col-lg-4">
        <select id="schoolSelect" class="form-select form-select-sm">
            <option value="0">-- All schools --</option>
            @foreach($schools as $school)
                <option
                        @if ($school->id == request()->get('school_id'))
                            selected="selected"
                        @endif
                        value="{{$school->id}}">{{$school->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="row gy-4 mt-0 row-flex">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="height: 300px">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div>
                                <h5 class="card-title mb-0">Overall score</h5>
                                <small class="text-muted">From {{$surveyStats['Completed']}} surveys</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="overall-score"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="height: 300px">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div>
                                <h5 class="card-title mb-0">Surveys</h5>
                                <small class="text-muted">Completion rate</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="surveyStats"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 d-flex justify-content-between flex-column">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center py-3">
                        <div class="avatar mx-auto mb-2">
                            <span class="avatar-initial rounded-circle bg-label-success"><i
                                        class="bx bxs-spreadsheet fs-4"></i></span>
                        </div>
                        <span class="d-block text-nowrap">Total Surveys Sent</span>
                        <h2 class="mb-0">{{Survey::count()}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center py-3">
                        <div class="avatar mx-auto mb-2">
                            <span class="avatar-initial rounded-circle bg-label-success"><i
                                        class="bx bx-time-five fs-4"></i></span>
                        </div>
                        <span class="d-block text-nowrap">Survey Avg Time</span>
                        <h2 class="mb-0">{{$surveyAvgTime}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider my-4">
        <div class="divider-text">Overall school performance</div>
    </div>
    <div class="row gy-4 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                    <div>
                        <h5 class="card-title mb-0">Overall school performance</h5>
                        <small class="text-muted">From {{$surveyStats['Completed']}} surveys</small>
                    </div>
                </div>
                <div style="padding: 1rem;padding-right: 1.7rem;" id="school-performance"></div>
            </div>
        </div>
    </div>
    <div class="divider my-4">
        <div class="divider-text">By Stakeholder</div>
    </div>
    <div class="row gy-4 justify-content-center">
        @foreach($stakeholdersAverages as $stakeholder => $stakeholderAverages)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                        <div>
                            <h5 class="card-title mb-0">{{ucfirst(str_replace('_', ' ',$stakeholder))}}</h5>
                            <small class="text-muted">From {{$surveyStats['Completed']}} surveys</small>
                        </div>
                    </div>
                    <div id="school-stakeholder-performance-{{$stakeholder}}"></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="divider my-4">
        <div class="divider-text">By Capability</div>
    </div>
    <div class="row gy-4 justify-content-center">
        @foreach($capabilitiesStakeholdersAverages as $capability => $capabilityAverages)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                        <div>
                            <h5 class="card-title mb-0">{{ucfirst(str_replace('_', ' ', $capability))}}</h5>
                            <small class="text-muted">From {{$surveyStats['Completed']}} surveys</small>
                        </div>
                    </div>
                    <div id="school-stakeholder-performance-{{$capability}}"></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        overallScore = {{$overallScore}};
        renderRadial('overall-score', overallScore);
        renderDonutChart('surveyStats', {{Js::from($surveyStats)}})
        renderHorizontalChart('school-performance', {{Js::from($capabilitiesPerformance)}}, '300px')
        stakeholdersPerformance = {{Js::from($stakeholdersAverages)}};
        for (let key in stakeholdersPerformance) {
            renderHorizontalChart('school-stakeholder-performance-' + key, stakeholdersPerformance[key], '250px')
        }
        capabilitiesStakeholdersAverages = {{Js::from($capabilitiesStakeholdersAverages)}};
        for (let key in capabilitiesStakeholdersAverages) {
            renderHorizontalChart('school-stakeholder-performance-' + key, capabilitiesStakeholdersAverages[key], '250px')
        }
        initSchoolSelect($('#schoolSelect'));
    </script>
@endpush
