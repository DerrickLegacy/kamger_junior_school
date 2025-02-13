@extends('layouts.master')
@section('page_title', 'Student Class Lists - ' . (isset($my_class->name) ? $my_class->name : ''))
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-light border-0">
        <div class="row w-100">
            <!-- Class Dropdown -->
            <div class="col-md-3 mb-2">
                <h6 class="card-title">Class</h6>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="classDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(isset($my_class) && $my_class->id > 0)
                        {{ $my_class->name }}
                        @else
                        -- Select Class --
                        @endif
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="classDropdown">
                        @foreach(App\Models\MyClass::orderBy('name')->get() as $c)
                        <li><a href="{{ route('students.list', $c->id) }}" class="dropdown-item">{{ $c->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Section Dropdown -->
            <div class="col-md-3 mb-2">
                <h6 class="card-title">Section</h6>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="sectionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        -- Select Section --
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="sectionDropdown">
                        @foreach($sections as $s)
                        <li>
                            <a href="#s{{ $s->id }}" class="dropdown-item" data-toggle="tab">{{ $my_class->name.' '.$s->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="card-body mt-1">
        <div class="tab-content">
            <table class="table table-hover  datatable-button-html5-columns">
                <thead class="table-primary">
                    <tr>
                        <th>S/N</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>ADM_No</th>
                        <th>Section</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{Qs::profile_picture($s->user->photo) }}" alt="photo"></td>
                        <td>{{ $s->user->name }}</td>
                        <td>{{ $s->adm_no }}</td>
                        <td>{{ $my_class->name.' '.$s->section->name }}</td>
                        <td>{{ $s->user->email }}</td>
                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-left">
                                        <a href="{{ route('students.show', Qs::hash($s->id)) }}" class="dropdown-item"><i class="icon-eye text-info"></i> View Profile</a>
                                        @if(Qs::userIsTeamSA())
                                        <a href="{{ route('students.edit', Qs::hash($s->id)) }}" class="dropdown-item "><i class="icon-pencil text-warning"></i> Edit</a>
                                        <a href="{{ route('st.reset_pass', Qs::hash($s->user->id)) }}" class="dropdown-item"><i class="icon-lock text-success"></i> Reset password</a>

                                        @endif
                                        <!-- <a target="_blank" href="{{ route('marks.year_selector', Qs::hash($s->user->id)) }}" class="dropdown-item"><i class="icon-check"></i> Marksheet</a> -->

                                        {{--Delete--}}
                                        @if(Qs::userIsSuperAdmin())
                                        <a id="{{ Qs::hash($s->user->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash text-danger"></i> Delete</a>
                                        <form method="post" id="item-delete-{{ Qs::hash($s->user->id) }}" action="{{ route('students.destroy', Qs::hash($s->user->id)) }}" class="hidden">@csrf @method('delete')</form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            @foreach($sections as $se)
            <div class="tab-pane fade" id="s{{$se->id}}">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>ADM_No</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students->where('section_id', $se->id) as $sr)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $sr->user->photo }}" alt="photo"></td>
                            <td>{{ $sr->user->name }}</td>
                            <td>{{ $sr->adm_no }}</td>
                            <td>{{ $sr->user->email }}</td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('students.show', Qs::hash($sr->id)) }}" class="dropdown-item"><i class="icon-eye"></i> View Info</a>
                                            @if(Qs::userIsTeamSA())
                                            <a href="{{ route('students.edit', Qs::hash($sr->id)) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                            <a href="{{ route('st.reset_pass', Qs::hash($sr->user->id)) }}" class="dropdown-item"><i class="icon-lock"></i> Reset password</a>
                                            @endif
                                            <a href="#" class="dropdown-item"><i class="icon-check"></i> Marksheet</a>

                                            {{--Delete--}}
                                            @if(Qs::userIsSuperAdmin())
                                            <a id="{{ Qs::hash($sr->user->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                            <form method="post" id="item-delete-{{ Qs::hash($sr->user->id) }}" action="{{ route('students.destroy', Qs::hash($sr->user->id)) }}" class="hidden">@csrf @method('delete')</form>
                                            @endif

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


@endsection