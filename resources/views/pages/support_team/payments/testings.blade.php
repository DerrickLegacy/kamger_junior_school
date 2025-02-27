@extends('layouts.master')
@section('page_title', 'Manage Payments')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title font-weight-bold">Manage Payment Records for {{ $sr->user->name}} </h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="nav-item"><a href="#all-uc" class="nav-link active" data-toggle="tab">Incomplete Payments</a></li>
                    <li class="nav-item"><a href="#all-cl" class="nav-link" data-toggle="tab">Completed Payments</a></li>
                </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="all-uc">
                <table class="table datatable-button-html5-columns table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Exempted</th>
                            <th>Title</th>
                            <th>Term</th>
                            <th>Pay_Ref</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Pay Now</th>
                            <th>Receipt_No</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($uncleared as $uc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <!-- Exempted Checkbox -->
                            <td>
                                @php
                                    $exempted = \App\Models\PaymentExemption::where('student_id', $sr->id)
                                                                            ->where('payment_id', $uc->payment->id)
                                                                            ->exists();
                                @endphp
                                <input type="checkbox" name="exempted" {{ $exempted ? 'checked' : '' }} disabled>
                            </td>
                            
                            <td>{{ $uc->payment->title }}</td>
                            <td>{{ $uc->payment->term }}</td>
                            <td>{{ $uc->payment->ref_no }}</td>
                            {{--Amount--}}
                            <td class="font-weight-bold" id="amt-{{ Qs::hash($uc->id) }}" data-amount="{{ $uc->payment->amount }}">{{ $uc->payment->amount }}</td>
                            {{--Amount Paid--}}
                            <td id="amt_paid-{{ Qs::hash($uc->id) }}" data-amount="{{ $uc->amt_paid ?: 0 }}" class="text-blue font-weight-bold">{{ $uc->amt_paid ?: '0.00' }}</td>
                            {{--Balance--}}
                            <td id="bal-{{ Qs::hash($uc->id) }}" class="text-danger font-weight-bold">{{ $uc->balance ?: $uc->payment->amount }}</td>

                            <td>
                                @if(!$exempted)
                                {{--Pay Now Form--}}
                                    <form id="{{ Qs::hash($uc->id) }}" method="post" class="ajax-pay" action="{{ route('payments.pay_now', Qs::hash($uc->id)) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input min="1" max="{{ $uc->balance ?: $uc->payment->amount }}" id="val-{{ Qs::hash($uc->id) }}" class="form-control" required placeholder="Pay Now" title="Pay Now" name="amt_paid" type="number">
                                            </div>
                                            <div class="col-md-5">
                                                <button data-text="Pay" class="btn btn-danger" type="submit">Pay <i class="icon-paperplane ml-2"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <span class="badge badge-success">Exempted</span>
                                @endif
                            </td>
                            {{--Receipt No--}}
                            <td>{{ $uc->ref_no }}</td>

                            <td>{{ $uc->year }}</td>

                            {{--Action--}}
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">

                                            {{--Reset Payment--}}
                                            <a id="{{ Qs::hash($uc->id) }}" onclick="confirmReset(this.id)" href="#" class="dropdown-item"><i class="icon-reset"></i> Reset Payment</a>
                                            <form method="post" id="item-reset-{{ Qs::hash($uc->id) }}" action="{{ route('payments.reset_record', Qs::hash($uc->id)) }}" class="hidden">@csrf @method('delete')</form>

                                            {{--Receipt--}}
                                                <a target="_blank" href="{{ route('payments.receipts', Qs::hash($uc->id)) }}" class="dropdown-item"><i class="icon-printer"></i> Print Receipt</a>
                                            {{--PDF Receipt--}}
                            {{--                    <a  href="{{ route('payments.pdf_receipts', Qs::hash($uc->id)) }}" class="dropdown-item download-receipt"><i class="icon-download"></i> Download Receipt</a>--}}

                                        </div>
                                    </div>
                                </div>
                            </td>
        
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr id="total-balance-row">
                            <td colspan="5" class="text-right font-weight-bold">Total Balance:</td>
                            <td class="text-danger font-weight-bold" id="total-balance">0.00</td>
                            <td colspan="4">
                                <form id="pay-all-form" method="post">
                                    @csrf
                                    <input type="hidden" name="total_amount" id="total-amount" value="0">
                                    <button type="submit" class="btn btn-success">Pay All <i class="icon-credit-card ml-2"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- Completion Message (Hidden by Default) -->
                        <tr id="completed-message" style="display: none;">
                            <td colspan="10" class="text-center text-success font-weight-bold">
                                {{ $sr->user->name }} has completed all payments. 🎉
                            </td>
                        </tr>
                    </tfoot>

                </table>
            </div>

            <div class="tab-pane fade" id="all-cl">
                <table class="table datatable-button-html5-columns table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Term</th>
                        <th>Pay_Ref</th>
                        <th>Amount</th>
                        <th>Receipt_No</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cleared as $cl)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cl->payment->title }}</td>
                            <td>{{ $cl->payment->term }}</td>
                            <td>{{ $cl->payment->ref_no }}</td>

                            {{--Amount--}}
                            <td class="font-weight-bold">{{ $cl->payment->amount }}</td>
                            {{--Receipt No--}}
                            <td>{{ $cl->ref_no }}</td>

                            <td>{{ $cl->year }}</td>

                            {{--Action--}}
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">

                                            {{--Reset Payment--}}
                                            <a id="{{ Qs::hash($cl->id) }}" onclick="confirmReset(this.id)" href="#" class="dropdown-item"><i class="icon-reset"></i> Reset Payment</a>
                                            <form method="post" id="item-reset-{{ Qs::hash($cl->id) }}" action="{{ route('payments.reset_record', Qs::hash($cl->id)) }}" class="hidden">@csrf @method('delete')</form>

                                            {{--Receipt--}}
                                            <a target="_blank" href="{{ route('payments.receipts', Qs::hash($cl->id)) }}" class="dropdown-item"><i class="icon-printer"></i> Print Receipt</a>

                                            {{--PDF Receipt--}}
                                            {{--                    <a  href="{{ route('payments.pdf_receipts', Qs::hash($uc->id)) }}" class="dropdown-item download-receipt"><i class="icon-download"></i> Download Receipt</a>--}}

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        </div>
    </div>

    {{--Payments Invoice List Ends--}}
    
    <script>
        //calculate total balance
        document.addEventListener("DOMContentLoaded", updateTotalBalance);

        function updateTotalBalance() {
            let totalBalance = 0;

            $("td[id^='bal-']").each(function () {
                totalBalance += parseFloat($(this).text()) || 0;
            });

            $("#total-balance").text(totalBalance.toFixed(2));

            if (totalBalance <= 0) {
                $("#total-balance-row").hide(); // Hide the total balance row
                $("#completed-message").show(); // Show the completion message
            } else {
                $("#total-balance-row").show();
                $("#completed-message").hide();
            }
        }

    </script>

<script>
    document.getElementById("pay-all-btn").addEventListener("click", function () {
        let totalBalance = parseFloat(document.getElementById("total-balance").textContent);

        if (totalBalance <= 0) {
            alert("No outstanding balance to pay.");
            return;
        }

        if (!confirm(`Are you sure you want to pay UGX ${totalBalance}?`)) {
            return;
        }

        fetch("{{ route('payments.pay_all') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ total_amount: totalBalance })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Payment successful!");
                location.reload(); // Refresh the page to update tables
            } else {
                alert("Payment failed! Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tr').forEach(function (row) {
        let exemptedCheckbox = row.querySelector('input[name="exempted"]');
        if (exemptedCheckbox && exemptedCheckbox.checked) {
            let balanceCell = row.querySelector('[id^="bal-"]');
            if (balanceCell) {
                balanceCell.textContent = '0.00';
            }

            let payButton = row.querySelector('.btn-danger');
            let payInput = row.querySelector('input[name="amt_paid"]');
            if (payButton && payInput) {
                payButton.disabled = true;
                payInput.disabled = true;
            }
        }
    });
});
</script>



@endsection

