@extends('layouts.master')
@section('page_title', 'Student Profile - '.$sr->user->name)
@section('content')
<style>
    .profile-image img {
        transition: transform 0.3s ease;
    }

    .profile-image img:hover {
        transform: scale(1.1);
    }

    .card {
        border-radius: 1rem;
    }

    .btn {
        border-radius: 20px;
    }
</style>

<div class="row mt-3">
    <div class="col-md-4 text-center">
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <div class="profile-image mb-3">
                    <img src="{{ Qs::profile_picture($sr->user->photo) }}"
                        alt="User Photo"
                        class="img-fluid rounded-circle border"
                        style="width: 180px; height: 180px; object-fit: cover;">
                </div>
                <h3 class="mt-3 mb-1" style="font-weight: bold; font-size: 1.5rem;">{{ $sr->user->name }}</h3>
                <h4 class="text-muted" style="font-size: 1rem;">{{ $sr->user->email }}</h4>
                <div class="mt-4">
                    <button class="btn btn-primary btn-sm me-2 mt-1">
                        <i class="icon-envelop"></i> Send Email
                    </button>
                    <button class="btn btn-secondary btn-sm mt-1">
                        <i class="icon-user"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="my_tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bio-tab" data-bs-toggle="tab" data-bs-target="#bio" type="button" role="tab" aria-controls="bio" aria-selected="true">
                            <i class="bi bi-person-circle"></i> Bio Data
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">
                            <i class="bi bi-cash-coin"></i> Payments
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                        <h5 class="mb-3 text-primary"><strong>Personal Information</strong></h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ $sr->user->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="text" class="form-control" value="{{ $sr->user->dob }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="adm_no" class="form-label">Admission Number</label>
                                <input type="text" class="form-control" value="{{ $sr->adm_no }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="class" class="form-label">Class</label>
                                <input type="text" class="form-control" value="{{ $sr->my_class->name.' '.$sr->section->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="year_admitted" class="form-label">Year of Admission</label>
                                <input type="text" class="form-control" value="{{ $sr->year_admitted }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" value="{{ $sr->user->gender }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" value="{{ $sr->user->address }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="text" class="form-control" value="{{ $sr->user->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $sr->user->phone.' /'.$sr->user->phone2 }}" readonly>
                            </div>
                        </div>

                        <h5 class="mt-4 text-primary"><strong>Parent/Guardian Information</strong></h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="parent_name" class="form-label">Parent Name</label>
                                <a href="{{ route('users.show', Qs::hash($sr->my_parent_id)) }}">
                                    <input type="text" class="form-control text-primary" value="{{ $sr->my_parent->name }}" readonly>
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="parent_email" class="form-label">Parent Email</label>
                                <input type="text" class="form-control" value="{{ $sr->my_parent->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="parent_phone" class="form-label">Parent Phone</label>
                                <input type="text" class="form-control" value="{{ $sr->my_parent->phone }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                        <h5 class="mb-3 text-primary"><strong>Payment History</strong></h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Term</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Receipt Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example row; replace with your dynamic rows -->
                                    <tr>
                                        <td>2024-02-01</td>
                                        <td>Term 1</td>
                                        <td>UGX 200,000</td>
                                        <td>Cash</td>
                                        <td>R12345</td>
                                    </tr>
                                    <!-- Add more rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection