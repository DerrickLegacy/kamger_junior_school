@extends('layouts.master')
@section('page_title', 'Manage Users')
@section('content')
<style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow */
            border-radius: 8px; /* Rounded corners */
        }
    </style>
<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage Users</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <!-- User Type Selection Dropdown -->
        <div class="form-group">
            <label for="userTypeSelect">Select User Type</label>
            <select id="userTypeSelect" class="form-control">
                @foreach($user_types as $index => $ut)
                    <option value="ut-{{ Qs::hash($ut->id) }}" 
                        {{ strtolower($ut->name) == 'accountant' ? 'selected' : '' }}>
                        {{ $ut->name }}s
                    </option>
                @endforeach
            </select>
        </div>

        <!-- User Type Content Sections -->
        <div class="tab-content">
            @foreach($user_types as $ut)
                <div id="ut-{{ Qs::hash($ut->id) }}" class="user-type-content" style="display: none;">
                    <h6>{{ $ut->name }} Users</h6>                        
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->where('user_type', $ut->title) as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img class="rounded-circle" style="height: 40px; width: 40px;" 
                                            src="{{ Qs::profile_picture($u->photo) }}" alt="photo">
                                    </td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->username }}</td>
                                    <td>{{ $u->phone }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-left">
                                                    <a href="{{ route('users.show', Qs::hash($u->id)) }}" 
                                                       class="dropdown-item"><i class="icon-eye"></i> View Profile</a>
                                                    <a href="{{ route('users.edit', Qs::hash($u->id)) }}" 
                                                       class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                    @if(Qs::userIsSuperAdmin())
                                                        <a href="{{ route('users.reset_pass', Qs::hash($u->id)) }}" 
                                                           class="dropdown-item"><i class="icon-lock"></i> Reset password</a>
                                                        <a id="{{ Qs::hash($u->id) }}" onclick="confirmDelete(this.id)" 
                                                           href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                        <form method="post" id="item-delete-{{ Qs::hash($u->id) }}" 
                                                              action="{{ route('users.destroy', Qs::hash($u->id)) }}" 
                                                              class="hidden">@csrf @method('delete')</form>
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

<!-- JavaScript to Handle Dropdown Change -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let userTypeSelect = document.getElementById("userTypeSelect");
        let userSections = document.querySelectorAll(".user-type-content");

        // Retrieve last selected value from localStorage, defaulting to the first option
        let selectedUserType = localStorage.getItem("selectedUserType") || userTypeSelect.value;

        function showSelectedUserType() {
            userSections.forEach(section => section.style.display = "none");

            let selectedId = userTypeSelect.value;
            localStorage.setItem("selectedUserType", selectedId); // Store selected value
            
            let selectedSection = document.getElementById(selectedId);
            if (selectedSection) {
                selectedSection.style.display = "block";
            }
        }

        // Set previously selected value from localStorage (if it exists in DOM)
        if (document.getElementById(selectedUserType)) {
            userTypeSelect.value = selectedUserType;
        }

        showSelectedUserType(); // Show correct section based on stored value
        userTypeSelect.addEventListener("change", showSelectedUserType);
    });
</script>


@endsection
