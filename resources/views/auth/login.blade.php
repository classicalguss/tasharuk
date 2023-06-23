@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Login')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages-auth.js')}}"></script>
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                                @include('_partials.macros')
                            </a>
                        </div>
                        <!-- /Logo -->
                        <p class="mb-4">Please sign-in to your account</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="login-email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       id="login-email" name="email" placeholder="adam@tasharuk.edu" autofocus
                                       value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="login-password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="login-password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check d-flex justify-content-between">
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="remember-me"
                                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember-me">
                                            Remember Me
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            <small>Forgot Password?</small>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection