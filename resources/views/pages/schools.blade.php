@extends('layouts.layoutMaster')

@section('title', 'Schools Management')

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
  @include('components.form-modal', [
      'title' => 'Add School',
      'url' => route('schools.store'),
      'fields' => [
          ['name' => 'name', 'type'=>'text'],
      ]
  ])
  @include('components.form-modal', [
      'title' => 'Update School',
      'url' => url('/schools'),
      'fields' => [
          ['name' => 'name', 'type'=>'text'],
      ],
      'action' => 'update'
  ])
  <x-button class="mb-3 me-2" data-bs-toggle="modal" data-bs-target="#createModal">
    Add School
  </x-button>
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="datatables-items table border-top">
        <thead>
          <tr>
            <th>Name</th>
            <th>Owner</th>
            <th>Admins</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection
