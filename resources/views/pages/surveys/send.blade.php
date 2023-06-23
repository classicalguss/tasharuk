@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/surveys.js')}}"></script>
@endsection

@section('content')
    <div class="card col-md-6">
        <h5 class="card-header">Send Surveys</h5>
        <div class="card-body">
            <form method="POST" action="{{route('sendSurvey')}}">
                @csrf
                <div class="mb-2">
                    <label for="school" class="form-label">School</label>
                    <select name="school_id" id="school" class="selectpicker w-100" data-style="btn-default">
                        @foreach($schools as $school)
                            <option value="{{$school->id}}">{{$school->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="stakeholder" class="form-label">Stakeholder</label>
                    <select name="stakeholder_id" id="stakeholder" class="selectpicker w-100" data-style="btn-default">
                        @foreach($stakeholders as $stakeholder)
                            <option value="{{$stakeholder->id}}">{{$stakeholder->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="mailing-list-input" class="form-label">Mailing list</label>
                    <!-- Users List -->
                    <input id="mailing-list-input" name="mailing-list" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script>
            $(document).ready(function () {
                // tagifyUsersList();
            })
        </script>
    @endpush
@endonce