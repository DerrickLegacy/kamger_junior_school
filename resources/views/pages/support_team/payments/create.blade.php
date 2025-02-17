@extends('layouts.master')
@section('page_title', 'Create Payment')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Create Payment</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="ajax-store" method="post" action="{{ route('payments.record') }}">
                        @csrf
                        
                        <!-- Payment Type Dropdown -->
                        <div class="form-group row">
                            <label for="payment_type" class="col-lg-3 col-form-label font-weight-semibold">Payment Type <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-control select" name="payment_type" id="payment_type">
                                    <option value="school_fees" selected>School Fees</option>
                                    <option value="functional_fees">Functional Fees</option>
                                    <option value="uniform">Uniform</option>
                                    <option value="farm">Farm Contributions</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Common Fields -->
                        <div class="form-group row">
                            <label for="receipt_number" class="col-lg-3 col-form-label font-weight-semibold">Receipt Number <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" name="receipt_number" id="receipt_number" type="text" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_date" class="col-lg-3 col-form-label font-weight-semibold">Payment Date <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" name="payment_date" id="payment_date" type="date" required>
                            </div>
                        </div>

                        <!-- Student ID (Not for Farm Contributions) -->
                        <div class="form-group row" id="student_id_field">
                            <label  for="student_id" class="col-lg-3 col-form-label font-weight-semibold">Student ID <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" name="student_id" id="student_id" type="text">
                            </div>
                        </div>

                        <!-- Amount & Balance (Balance Hidden for Farm Contributions) -->
                        <div class="form-group row">
                            <label  for="amount" class="col-lg-3 col-form-label font-weight-semibold">Amount (<del style="text-decoration-style: double">N</del>) <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input class="form-control" name="amount" id="amount" type="number" required>
                            </div>
                            <label for="balance" class="col-lg-2 col-form-label font-weight-semibold text-right" id="balance_label">Balance</label>
                            <div class="col-lg-3" id="balance_field">
                                <input class="form-control" name="balance" id="balance" type="number">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="method" class="col-lg-3 col-form-label font-weight-semibold">Payment Method</label>
                            <div class="col-lg-9">
                                <select class="form-control select" name="method" id="method">
                                    <option selected value="Cash">Cash</option>
                                    <option value="Online">Mobile money</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-lg-3 col-form-label font-weight-semibold">Description</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="description" id="description" type="text">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const paymentType = document.getElementById("payment_type");
            const studentIDField = document.getElementById("student_id_field");
            const balanceField = document.getElementById("balance_field");
            const balanceLabel = document.getElementById("balance_label");

            function updateFields() {
                if (paymentType.value === "farm") {
                    studentIDField.style.display = "none";
                    balanceField.style.display = "none";
                    balanceLabel.style.display = "none";
                } else {
                    studentIDField.style.display = "flex";
                    balanceField.style.display = "block";
                    balanceLabel.style.display = "block";
                }
            }

            paymentType.addEventListener("change", updateFields);
            updateFields(); // Ensure correct state on load
        });
    </script>

@endsection
