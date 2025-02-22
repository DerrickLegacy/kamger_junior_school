@extends('layouts.master')
@section('page_title', 'Edit User')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit User Details</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-update" action="{{ route('users.update', Qs::hash($user->id)) }}" data-fouc>
                @csrf @method('PUT')

                <!-- Personal Data Section -->
                <h6 class="mb-4">Personal Data</h6>
                <fieldset>
                    <div class="row">
                        <!-- User Type -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_type" class="d-block">
                                    <i class="icon-user-tie mr-2"></i>User Type: <span class="text-danger">*</span>
                                </label>
                                <select disabled="disabled" class="form-control select">
                                    <option value="">{{ strtoupper($user->user_type) }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="d-block">
                                    <i class="icon-user mr-2"></i>Full Name: <span class="text-danger">*</span>
                                </label>
                                <input value="{{ $user->name }}" required type="text" name="name" placeholder="Full Name" class="form-control">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address" class="d-block">
                                    <i class="icon-location4 mr-2"></i>Address: <span class="text-danger">*</span>
                                </label>
                                <input value="{{ $user->address }}" class="form-control" placeholder="Address" name="address" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="d-block">
                                    <i class="icon-envelope mr-2"></i>Email Address:
                                </label>
                                <input value="{{ $user->email }}" type="email" name="email" class="form-control" placeholder="your@email.com">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone" class="d-block">
                                    <i class="icon-phone mr-2"></i>Phone:
                                </label>
                                <input value="{{ $user->phone }}" type="text" name="phone" class="form-control" placeholder="+1234567890">
                            </div>
                        </div>

                        <!-- Telephone -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone2" class="d-block">
                                    <i class="icon-phone2 mr-2"></i>Telephone:
                                </label>
                                <input value="{{ $user->phone2 }}" type="text" name="phone2" class="form-control" placeholder="+1234567890">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Date of Employment -->
                        @if(in_array($user->user_type, Qs::getStaff()))
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="emp_date" class="d-block">
                                        <i class="icon-calendar mr-2"></i>Date of Employment:
                                    </label>
                                    <input autocomplete="off" name="emp_date" value="{{ $user->staff->first()->emp_date ?? '' }}" type="text" class="form-control date-pick" placeholder="Select Date...">
                                </div>
                            </div>
                        @endif

                        <!-- Gender -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender" class="d-block">
                                    <i class="icon-genderless mr-2"></i>Gender: <span class="text-danger">*</span>
                                </label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    <option {{ ($user->gender == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ ($user->gender == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nationality -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nal_id" class="d-block">
                                    <i class="icon-flag mr-2"></i>Nationality: <span class="text-danger">*</span>
                                </label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ ($user->nal_id == $nal->id) ? 'selected' : '' }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- District of Origin -->
                    <div class="row">
                  {{--       <div class="col-md-4">
                            <div class="form-group">
                                <label for="state_id" class="d-block">
                                    <i class="icon-location3 mr-2"></i>District of Origin: <span class="text-danger">*</span>
                                </label>
                                <select onchange="getLGA(this.value)" required data-placeholder="Choose.." class="select-search form-control" name="state_id" id="state_id">
                                    <option value=""></option>
                                    @foreach($districts as $st)
                                        <option {{ (old('state_id') == $st->id ? 'selected' : '') }} value="{{ $st->id }}">{{ $st->district }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  --}}

                        <!-- Passport Photo -->
                        <div class="col-md-8">                      
                                    <div class="form-group">
                                        <label class="d-block">
                                            <i class="icon-camera mr-2"></i>Upload Passport Photo:
                                        </label>
                                        <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                        <small class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</small>
                                    </div>
                                </div>

                        </div>
                    </div>
                </fieldset>

    </div>

@endsection