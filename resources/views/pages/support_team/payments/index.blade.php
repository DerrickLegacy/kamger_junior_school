@extends('layouts.master')
@section('page_title', 'Manage Payments')

@section('custom_css')
    <!-- Bootstrap CSS (Only for this page) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- DataTables CSS (Only for this page) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-cash2 mr-2"></i> Manage payments</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Payment Type</th>
                            <th>Receipt Number</th>
                            <th>Payment Date</th>
                            <th>Student ID</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Method</th>
                            <th>Description</th>
                            <th>Recorded by</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{ dd($payments) }} 
                        @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id}}</td>
                            <td>{{ $payment->payment_type}}</td>
                            <td>{{ $payment->receipt_number}}</td>
                            <td>{{ $payment->payment_date}}</td>
                            <td>{{ $payment->student_id}}</td>
                            <td>{{ $payment->amount}}</td>
                            <td>{{ $payment->balance}}</td>
                            <td>{{ $payment->payment_method}}</td>
                            <td>{{ $payment->description}}</td>
                            <td>{{ $payment->recorded_by}}</td>
                        </tr>
                        
                        @empty
                            <tr>
                                <td colspan="10">No data found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- @if($selected)
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Manage Payments for {{ $year }} Session</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="#all-payments" class="nav-link active" data-toggle="tab">All Classes</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Class Payments</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($my_classes as $mc)
                            <a href="#pc-{{ $mc->id }}" class="dropdown-item" data-toggle="tab">{{ $mc->name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>

            <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-payments">
                        <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Ref_No</th>
                                <th>Class</th>
                                <th>Method</th>
                                <th>Info</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->title }}</td>
                                    <td>{{ $p->amount }}</td>
                                    <td>{{ $p->ref_no }}</td>
                                    <td>{{ $p->my_class_id ? $p->my_class->name : '' }}</td>
                                    <td>{{ ucwords($p->method) }}</td>
                                    <td>{{ $p->description }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-left">
                                                    {{--Edit--}}
                                                <a href="{{ route('payments.edit', $p->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                    {{--Delete--}}
                                                    <a id="{{ $p->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ $p->id }}" action="{{ route('payments.destroy', $p->id) }}" class="hidden">@csrf @method('delete')</form>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @foreach($my_classes as $mc)
                    <div class="tab-pane fade" id="pc-{{ $mc->id }}">
                        <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Ref_No</th>
                                <th>Class</th>
                                <th>Method</th>
                                <th>Info</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments->where('my_class_id', $mc->id) as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->title }}</td>
                                    <td>{{ $p->amount }}</td>
                                    <td>{{ $p->ref_no }}</td>
                                    <td>{{ $p->my_class_id ? $p->my_class->name : '' }}</td>
                                    <td>{{ ucwords($p->method) }}</td>
                                    <td>{{ $p->description }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-left">
                                                    {{--Edit--}}
                                                    <a href="{{ route('payments.edit', $p->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                    {{--Delete--}}
                                                    <a id="{{ $p->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ $p->id }}" action="{{ route('payments.destroy', $p->id) }}" class="hidden">@csrf @method('delete')</form>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    @endforeach
            </div>
        </div>
    </div>
    @endif

    {{--Payments List Ends--}} -->

@endsection

@section('scripts')
    <!-- jQuery (Needed for Bootstrap & DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('.datatable-button-html5-columns').DataTable();
        });
    </script>
@endsection
