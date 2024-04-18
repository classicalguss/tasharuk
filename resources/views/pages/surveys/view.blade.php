<?php
use App\Models\Survey;
/**
 * @var Survey $survey
 */
?>
@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/surveys.js')}}"></script>
@endsection

@section('content')
    @include("components.breadcrumbs", ["breadcrumbs" => [
	    ['text' => 'Surveys', 'url' => route('surveys.index')],
        ['text' => $survey->stakeholder->name.' - '.$survey->receiver_email, 'active' => true]
    ]])
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-items table border-top">
                <thead>
                    <tr>
                        <th>Capability</th>
                        <th>Subcapability</th>
                        <th>Indicator</th>
                        <th>Score</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@once
    @push('scripts')
        <script>
            $(document).ready(function () {
                prepareSurveyScoresTable({{ $survey->id }});
            })
        </script>
    @endpush
@endonce
