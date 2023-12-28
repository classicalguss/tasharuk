@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'School Survey')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="justify-content-center py-5" id="form1">
                    <div class="app-brand justify-content-center mb-3">
                        @include('_partials.macros')
                    </div>
                    @if($isFirst)
                        <div class="row justify-content-center">
                            <div class="card col-4">
                                <div class="card-body">
                                    <p class="mb-5">Welcome to our Survey. Please press Next to proceed with the first question.</p>
                                    <div class="col-12 d-flex justify-content-between">
                                        <div>

                                        </div>
                                        <a href="{{URL::current().'?token='.request()->get('token')}}&begin=true" class="btn btn-primary btn-next"> <span class="d-sm-inline-block d-none">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mb-3">
                            <div class="col-xl-3 col-lg-4 col-md-4"></div>
                            <div class="d-flex flex-column col-xl-9 col-lg-8 col-md-8">
                                <div class="d-flex justify-content-between mb-1">
                                    <p class="mb-0"><strong>Progress</strong></p>
                                </div>
                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar bg-primary" style="width: {{$progress}}%" role="progressbar" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 text-end">
                                <h3>{{$capability}}</h3>
                                <h5>{{$subcapability}}</h5>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-8">
                                <div class="">
                                    <div class="card mb-2">
                                        <div class="card-body pb-1">
                                            <h5>{{$indicator->text}}</h5>
                                        </div>
                                    </div>
                                    @for($i = 0; $i<5;$i++)
                                        <div class="card mb-2">
                                            <div class="card-body p-2">
                                                <div class="card-title mb-2 header-elements">

                                                    <h6 class="m-0 me-2">
                                                        {{$ratings[$i]}}
                                                    </h6>
                                                    <div class="card-title-elements ms-auto">
                                                        <form method="POST" action="{{ route('surveys.rate', ['survey' => $survey])}}">
                                                            @csrf
                                                            <input type="hidden" name="rate" value="{{5-$i}}">
                                                            <x-button style="border-color: #202a5c; background-color: #202a5c" btn-class="warning" class="btn-sm select-button">Select<i class="bx bx-chevron-right"></i></x-button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <p class="card-text">
                                                    @switch(5-$i)
                                                        @case(5)
                                                            {{$indicator->highly_effective}}
                                                            @break
                                                        @case(4)
                                                            {{$indicator->effective}}
                                                            @break
                                                        @case(3)
                                                            {{$indicator->satisfactory}}
                                                            @break
                                                        @case(2)
                                                            {{$indicator->needs_improvement}}
                                                            @break
                                                        @case(1)
                                                            {{$indicator->does_not_meet_standard}}
                                                            @break
                                                    @endswitch
                                                </p>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <x-link-button btn-class="success" href="{{route('survey.close')}}" class="btn float-end mt-2">Save & Exit</x-link-button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .select-button:hover {
       background-color: #26326e !important;
    }
</style>
