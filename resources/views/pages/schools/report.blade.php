@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Js;
	$surveyGraphScores = [];
@endphp
@extends('layouts.layoutMaster')

@section('title', 'Generate report')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"/>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/jquery-sticky/jquery-sticky.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/report.js')}}"></script>
@endsection

@section('content')
    <h2>Generate report for {{$school->name}}</h2>

    <div class="row">
        <div class="col-md-9 p-4">
            <div class="card">
                <div class="card-header px-4 p-3 sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-3">
                    <h5 class="card-title mb-sm-0 me-2">Actions</h5>
                    <div class="action-btns">
                        <button class="btn btn-label-primary me-3">
                            <span class="align-middle">Preview</span>
                        </button>
                        <button class="btn btn-primary">
                            Send
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form>
                            <div class="col-md-2 float-end">
                                <div class="input-group mb-3 col-md-2">
                                    <label class="input-group-text form-label mb-0">Version: </label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <div>
                                <label for="exampleFormControlTextarea1" class="form-label mt-4">About Tasharuk</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                            <div class="row mt-2 gy-2">
                                <div class="col-md-6">
                                    <label class="form-label">School information</label>
                                    <input class="form-control" type="text"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Number of students</label>
                                    <input class="form-control" type="number"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">School name</label>
                                    <input class="form-control" type="text"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Country</label>
                                    <input class="form-control" type="text"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program</label>
                                    <input class="form-control" type="text"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date</label>
                                    <input class="form-control" type="date"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Person</label>
                                    <input class="form-control" type="text"/>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="exampleFormControlTextarea1" class="form-label">Executive Summary</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                            <div class="divider my-4">
                                <div class="divider-text"><h4 style="color: darkblue; margin: 0"><b>Score overview</b></h4></div>
                                <div class="row">
                                    <div class="col-md-8 overall-chart">

                                    </div>
                                    <div style="padding-bottom: 100px" class="d-flex align-items-center col-md-4 overall-score"></div>
                                </div>
                            </div>
                            <div class="divider my-4">
                                <div class="divider-text"><h4 style="color: darkblue; margin: 0"><b>Audit Areas</b></h4></div>
                            </div>
                            @foreach($capabilities as $capability)
                                <h4 class="mt-3">{{$capability->name}}</h4>
                                <div class="mt-2">
                                    <label for="exampleFormControlTextarea1" class="form-label">Summary</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                                </div>
                                <div class="card mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Sub Capability</th>
                                                    <th>Weight</th>
                                                    <th>Final Average</th>
                                                </tr>
                                            </thead>
                                            <?php
												$tempSubcapabilityArray = [];
                                            ?>
                                            @foreach($capability->subcapabilities as $subcapability)
                                                @if (isset($subcapabilitiesScores[$subcapability->id]))
														<?php
														$tempSubcapabilityArray[$subcapability->name] = $subcapabilitiesScores[$subcapability->id] * 20;
														$surveyGraphScores[$capability->id] = $tempSubcapabilityArray;
														?>
                                                    <tr>
                                                        <td>{{$subcapability->name}}</td>
                                                        <td>{{$subcapability->weight}}%</td>
                                                        <td>{{round($subcapabilitiesScores[$subcapability->id]/100 * $subcapability->weight, 2)}}</td>
                                                    </tr>
                                                @endif

                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                @foreach($capability->subcapabilities as $subcapability)
                                    <h6 class="mt-3">{{$subcapability->name}}</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th style="width: 70%">Indicator</th>
                                                    @foreach($stakeholders as $stakeholder)
                                                        <th>{{$stakeholder->name}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            @foreach($subcapability->indicators as $indicator)
                                                <tr>
                                                    <td>{{$indicator->text}}</td>
                                                    @foreach($stakeholders as $stakeholder)
                                                        <td>{{$indicatorStakeholdersAverages[$indicator->id][$stakeholder->id] ?? ""}}</td>
                                                    @endforeach
                                                </tr>

                                            @endforeach
                                        </table>
                                    </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-8 capability-{{$capability->id}}-chart">

                                    </div>
                                    <div style="padding-bottom: 100px" class="d-flex align-items-center col-md-4 capability-{{$capability->id}}-radial"></div>
                                </div>

                                <div class="divider mt-0 mb-4">
                                    <div class="divider-text"><b>Accommodations and Recommendations</b></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="exampleFormControlTextarea1"
                                               class="form-label">Accommodations</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleFormControlTextarea1"
                                               class="form-label">Recommendations</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                                    </div>
                                </div>
                                <hr class="solid" style="border-top: 3px solid #000;">
                            @endforeach

                            <div class="divider my-4">
                                <div class="divider-text"><h4 style="color: darkblue; margin: 0"><b>Report Summary</b></h4></div>
                            </div>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        overallScore = {{$overallScore}};
        renderRadial('overall-score', overallScore);
        capabilities = {{JS::from($capabilities)}};
        surveyScores = {{JS::from($surveyCapabilityScores)}};
        subcapabilityScores = [];
        subcapabilityGraphScores = {{JS::from($surveyGraphScores)}};
        console.log(subcapabilityGraphScores);

        renderHorizontalChart('overall-chart', {{Js::from($capabilityScores)}}, '300px')
        // for (let key in subcapabilityGraphScores)
        // {
        //     renderHorizontalChart('capability-'+key+'-chart', subcapabilityGraphScores[key]);
        // }

        // for (let key in surveyScores)
        // {
        //     renderRadial('capability-'+key+'-radial', surveyScores[key]);
        // }
    </script>
@endpush
