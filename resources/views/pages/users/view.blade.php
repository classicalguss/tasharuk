@php use App\Models\School;use Spatie\Permission\Models\Role; @endphp
@extends('layouts.layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
@endsection

@section('content')
    @include("components.breadcrumbs", ["breadcrumbs" => [
	    ['text' => 'Users', 'url' => route('users.index')],
        ['text' => $user->name, 'active' => true]
    ]])
    @include('components.form-modal', [
		'url' => route('users.update', ['user' => $user]),
        'fields' => [
            ['name' => 'school_id', 'type'=>'select', 'selected' => $user->school_id, 'options' => array_column(School::all()->toArray(), 'name', 'id')],
            ['name' => 'role_id', 'type'=>'select', 'selected' => $user->roles[0]->id, 'options' => array_column(Role::all()->toArray(), 'name', 'id')],
        ],
        'action' => 'update'
    ])
    <div class="row gy-4">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="my-4 user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <div class="avatar avatar-xxl my-4">
                                <x-avatar :user="$user" class="rounded"></x-avatar>
                            </div>

                            <div class="user-info text-center">
                                <h5 class="mb-2">{{$user->name}}</h5>
                                <span class="badge bg-label-success">{{$user->roles[0]->name}}</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">Email:</span>
                                <span>{{$user->email}}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Verified at:</span>
                                <span>{{$user->email_verified_at}}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Last login:</span>
                                <span>{{$user->email_verified_at}}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Last activity:</span>
                                <span>{{$user->email_verified_at}}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">School:</span>
                                <span>{{$user->school->name}}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Surveys sent:</span>
                                <span>10</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Status:</span>
                                <span class="badge bg-label-success">Active</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center pt-3">
                            <x-button class="col-4 me-2" data-bs-toggle="modal" data-bs-target="#updateModal">Update
                            </x-button>
                            @if($user->is_active)
                                <a href="{{route('users.toggle-active-status', ['user' => $user])}}"
                                   class="btn btn-label-secondary col-4 me-2">Deactivate</a>
                            @else
                                <a href="{{route('users.toggle-active-status', ['user' => $user])}}"
                                   class="btn btn-label-secondary col-4 me-2">Activate</a>
                            @endif
                            <form method="POST" action="{{ route('users.destroy', ['user' => $user])}}">
                                @csrf
                                @method('DELETE')
                                <x-button-danger class="btn-danger">Delete</x-button-danger>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <div class="card mb-4">
                <h5 class="card-header">User Activity Timeline</h5>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Content Modification</h6>
                                    <small class="text-muted">12 min ago</small>
                                </div>
                                <p class="mb-2">Excel import</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Surveys Modification</h6>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                                <p class="mb-2">10 surveys sent</p>
                            </div>
                        </li>
                        <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
