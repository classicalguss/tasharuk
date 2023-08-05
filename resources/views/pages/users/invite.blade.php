@extends('layouts.layoutMaster')

@section('title', 'Invite User')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
@endsection

@section('content')
    <div class="card col-md-6">
        <h5 class="card-header">Invite User</h5>
        <div class="card-body">
            <form method="POST" action="{{route('users.send-invite')}}">
                @csrf
                <div class="mb-3">
                    <x-label class="form-label" for="name" value="{{ __('name') }}" />
                    <x-input id="name" name="name" type="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"/>
                    <x-input-error for="name"></x-input-error>
                </div>
                <div class="mb-3">
                    <x-label class="form-label" for="email" value="{{ __('Email') }}" />
                    <x-input id="email" name="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"/>
                    <x-input-error for="email"></x-input-error>
                </div>
                <div class="mb-2">
                    <label for="school" class="form-label">School</label>
                    <select name="school_id" id="school" class="selectpicker w-100" data-style="btn-default">
                        @foreach($schools as $school)
                            <option value="{{$school->id}}">{{$school->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">role</label>
                    <select name="role_id" id="role" class="selectpicker w-100" data-style="btn-default">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Invite</button>
            </form>
        </div>
    </div>
@endsection