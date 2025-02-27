@extends('layouts.master')
@section('page_title', 'User Profile - '.$user->name)
@section('content')
<div class="row mt-3">
    <div class="col-md-4 text-center">
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <div class="profile-image mb-3">
                    <img src="{{ Qs::profile_picture($user->photo) }}"
                        alt="User Photo"
                        class="img-fluid rounded-circle border"
                        style="width: 180px; height: 180px; object-fit: cover;">
                </div>
                <h3 class="mt-3 mb-1" style="font-weight: bold; font-size: 1.5rem;">{{ $user->name }}</h3>
                <h4 class="text-muted" style="font-size: 1rem;">{{ $user->email }}</h4>
                <div class="mt-4">
                    <a href="mailto:{{ $user->email }}">
                        <button class="btn btn-primary btn-sm me-2 mt-1">
                            <i class="icon-envelop"></i> Send Email
                        </button>
                    </a>
                    <a href="{{ route('users.edit', Qs::hash($user->id)) }}">
                        <button class="btn btn-secondary btn-sm mt-1">
                            <i class="icon-user"></i> Edit Profile
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                
                <ul class="nav nav-tabs mb-3" id="user_tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="user-name-tab" data-bs-toggle="tab" data-bs-target="#user-name" type="button" role="tab" aria-controls="user-name" aria-selected="true">
                            <i class="bi bi-person-circle"></i> {{ $user->name }}
                        </button>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    {{--Basic Info--}}
                    <div class="tab-pane fade show active" id="basic-info">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <input type="text" id="gender" class="form-control" value="{{ $user->gender }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Birthday</label>
                                <input type="text" id="dob" class="form-control" value="{{ $user->birth_date }}" readonly>
                            </div>

                            @if($user->nal_id)
                            <div class="col-md-6 mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" id="nationality" class="form-control" value="{{ $user->nationality->name }}" readonly>
                            </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" class="form-control" value="{{ $user->address }}" readonly>
                            </div>

                            @if($user->email)
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                            @endif

                            @if($user->phone)
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" class="form-control" value="{{ $user->phone . ' ' . $user->phone2 }}" readonly>
                            </div>
                            @endif

                            @if($user->username)
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" class="form-control" value="{{ $user->username }}" readonly>
                            </div>
                            @endif

                            

                            

                          {{--   @if($user->bg_id)
                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label">Blood Group</label>
                                <input type="text" id="blood_group" class="form-control" value="{{ $user->blood_group->name }}" readonly>
                            </div>
                            @endif --}}

                          

                           {{--  @if($user->state_id)
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" id="state" class="form-control" value="{{ $user->state->name }}" readonly>
                            </div>
                            @endif --}}

                            {{-- @if($user->lga_id)
                            <div class="col-md-6 mb-3">
                                <label for="lga" class="form-label">LGA</label>
                                <input type="text" id="lga" class="form-control" value="{{ $user->lga->name }}" readonly>
                            </div>
                            @endif --}}

                            @if($user->user_type == 'parent')
                            <div class="col-md-12 mb-3">
                                <label for="children" class="form-label">Children/Ward</label>
                                <div id="children">
                                    @foreach(Qs::findMyChildren($user->id) as $sr)
                                    <input type="text" class="form-control mb-2" value="{{ $sr->user->name . ' - ' . $sr->my_class->name . ' ' . $sr->section->name }}" readonly>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($user->user_type == 'teacher')
                            <div class="col-md-12 mb-3">
                                <label for="subjects" class="form-label">My Subjects</label>
                                <div id="subjects">
                                    @foreach(Qs::findTeacherSubjects($user->id) as $sub)
                                    <input type="text" class="form-control mb-2" value="{{ $sub->name . ' (' . $sub->my_class->name . ')' }}" readonly>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>  
    </div>
</div>
<button class="btn btn-secondary mt-1 float-right" onclick="window.history.back();">
    <i class="bi bi-arrow-left"></i> Previous
</button>


{{--User Profile Ends--}}

@endsection