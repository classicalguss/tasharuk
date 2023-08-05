@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'School Survey')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="justify-content-center px-5 py-5" id="form1">
                    <div class="app-brand justify-content-center mb-5">
                        @include('_partials.macros')
                    </div>
                    <div class="row justify-content-center">
                        <div class="card col-4">
                            <div class="card-body">
                                <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                                    <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                                    <div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                                    <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                                </div>
                                <br>
                                <p class="mb-2">Survey is completed. Thank you for your time.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
