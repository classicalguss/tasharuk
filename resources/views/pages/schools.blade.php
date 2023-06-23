@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages/schools.js')}}"></script>
@endsection

@section('content')
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="datatables-items table border-top">
        <thead>
          <tr>
            <th>Name</th>
            <th>Owner</th>
            <th>Admins</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection
