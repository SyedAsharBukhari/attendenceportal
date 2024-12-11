@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{route('admin_users')}}">User-List</a></li>
                <li class="breadcrumb-item active" aria-current="page">User-Add</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Users Add</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-5 mb-4 ml-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-12 col-sm-12">
                                <!-- Form -->
                                @if(Session::has('success'))
                                    <div class="alert alert-success mb-4" id="success-alert">
                                        <center><span class="text-white">{{Session::get('success')}}</span></center>
                                    </div>
                                @endif
                                <form action="{{route('admin_users_add_edit')}}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="mb-4">
                                        <label for="title">Username</label>
                                        <input type="text" class="form-control" required name="username">
                                    </div>
                                    <div class="my-4">
                                        <label for="textarea">Email</label>
                                        <input type="email" class="form-control" required name="email">
                                    </div>
                                    <div class="my-4">
                                        <label for="textarea">Personal Email</label>
                                        <input type="email" class="form-control" name="personal_email">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Phone Number</label>
                                        <input type="number" class="form-control" name="phone_number">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Date of Joining</label>
                                        <input type="date" class="form-control" name="date_of_joining">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">CNIC</label>
                                        <input type="number" class="form-control" name="user_cnic">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Salary</label>
                                        <input type="number" class="form-control" name="salary">
                                    </div>


                                    <div class="my-4">
                                        <label for="textarea">Address</label>
                                        <textarea name="address" class="form-control" id="address"></textarea>
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Guardian Detail</label>
                                        <textarea name="guardian_detail" class="form-control" id="guardian_detail"></textarea>
                                    </div>
                                    
                                    <div class="my-4">
                                        <label for="textarea">Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name">
                                    </div>
     
                                    <div class="my-4">
                                        <label for="textarea">Bank A/C</label>
                                        <input type="number" class="form-control" name="bank_ac">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Bank IBN Number</label>
                                        <input type="number" class="form-control" name="bank_ibn">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Bank Title of Account</label>
                                        <input type="text" class="form-control" name="bank_title_of_account">
                                    </div>

                                    <div class="mb-4">
                                        <label for="title">Password</label>
                                        <input type="password" class="form-control" required name="password">
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">User Role</label>
                                        <select class="form-select" id="user_role" name="user_role">
                                            <option selected hidden disabled>Select Role</option>
                                            <option value="1">Admin</option>
                                            <option value="2">User</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">User Designation</label>
                                        <select class="form-select" id="user_designation" name="user_designation">
                                            <option selected hidden disabled>Select Designation</option>
                                            @foreach($designation as $designation)
                                                <option value="{{ $designation->id }}">
                                                    {{ $designation->designation_name }} 
                                                    - {{ optional($designation->subDepartment)->sub_department_name ?? 'N/A' }} 
                                                    - {{ optional(optional($designation->subDepartment)->mainDepartment)->department_name ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">Main Department</label>
                                        <select class="form-select" id="main_department_id" name="main_department_id">
                                            <option selected hidden disabled>Select Main Department</option>
                                            @if($main_depart)
                                            @foreach($main_depart as $main_depart)
                                            <option value="{{$main_depart->id}}">{{$main_depart->department_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">Sub Department</label>
                                        <select class="form-select" id="sub_department_id" name="sub_department_id">
                                            <option selected hidden disabled>Select Sub Department</option>
                                            @if($main_depart)
                                            @foreach($sub_department as $sub_department)
                                            <option value="{{$sub_department->id}}">{{$sub_department->sub_department_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">Schedule</label>
                                        <select class="form-select" id="user_shift" name="user_shift">
                                            <option selected hidden disabled>Select Shift</option>
                                            @if($schedule)
                                            @foreach($schedule as $schedule)
                                            <option value="{{$schedule->id}}">{{$schedule->shift_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>
                                    <fieldset class="my-4">
                                        <legend class="h6">Status</legend>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" selected >
                                            <label class="form-check-label" for="exampleRadios1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" >
                                            <label class="form-check-label" for="exampleRadios2">
                                                Inactive
                                            </label>
                                        </div>
                                    </fieldset>
                                    <div class="my-4">
                                        <button class="btn btn-pill btn-outline-success" type="submit">Submit</button>
                                    </div>
                                </form>
                                <!-- End of Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
