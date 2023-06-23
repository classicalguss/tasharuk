@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Login')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="justify-content-center px-5 py-5" id="form1">
                    <div class="app-brand justify-content-center mb-5">
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
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4">
                                <h3>{{$capability}}</h3>
                                <h5 class="text-muted">{{$subcapability}}</h5>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-8">
                                <div class="">
                                    <div class="card mb-2">
                                        <div class="card-body pb-1">
                                            <h5>{{$indicator}}</h5>
                                        </div>
                                    </div>
                                    @for($i = 0; $i<5;$i++)
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="card-title mb-2 header-elements">

                                                    <h6 class="m-0 me-2">
                                                        @for($j = $i; $j < 5; $j++)
                                                            @include('components.star')
                                                        @endfor
                                                        {{$ratings[$i]}}
                                                    </h6>
                                                    <div class="card-title-elements ms-auto">
                                                        <a href="{{URL::current().'?token='.request()->get('token')}}&rate={{5-$i}}" type="button" class="btn btn-sm btn-primary">Select<i class="bx bx-chevron-right"></i></a>
                                                    </div>
                                                </div>
                                                <p class="card-text">Sample card title with switch, select box &amp; button.</p>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
