@php use App\Models\School; @endphp
@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages/users.js')}}"></script>
@endsection

@section('content')
  <x-link-button href="{{route('users.invite')}}" class="mb-3 me-2">
    Invite User
  </x-link-button>
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="datatables-items table border-top">
        <thead>
          <tr>
            <th>User</th>
            <th>School</th>
            <th>Role</th>
            <th>Active</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection
