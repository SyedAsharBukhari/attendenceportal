@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{route('admin_users')}}">Blog-List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog-Edit</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">User Edit</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-5 mb-4 ml-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-body">
                        <div class="row mb-4">

                            <div class="col-lg-12 col-sm-12">
                                <!-- Form -->
                                @if(Session::has('update'))
                                    <div class="alert alert-warning mb-4" id="success-alert">
                                        <center><span class="text-white">{{Session::get('update')}}</span></center>
                                    </div>
                                @endif
                                <form action="{{route('admin_users_add_edit').'/'.$user->id}}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="mb-4">
                                        <label for="title">Username</label>
                                        <input type="text" class="form-control" required value="{{$user->username}}" name="username">
                                    </div>
                                    <div class="my-4">
                                        <label for="textarea">Email</label>
                                        <input type="email" class="form-control" required value="{{$user->email}}" name="email">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Personal Email</label>
                                        <input type="email" class="form-control" value="{{$user->personal_email}}" name="personal_email">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Phone Number</label>
                                        <input type="number" class="form-control" value="{{$user->phone_number}}" name="phone_number">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Date of Joining</label>
                                        <input type="date" class="form-control" value="{{$user->date_of_joining}}" name="date_of_joining">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Date of Birth</label>
                                        <input type="date" class="form-control" value="{{$user->date_of_birth}}" name="date_of_birth">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">CNIC</label>
                                        <input type="number" class="form-control" value="{{$user->user_cnic}}" name="user_cnic">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Salary</label>
                                        <input type="number" class="form-control" value="{{$user->salary}}" name="salary">
                                    </div>


                                    <div class="my-4">
                                        <label for="textarea">Address</label>
                                        <textarea name="address" class="form-control" id="address">{{$user->address}}</textarea>
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Guardian Detail</label>
                                        <textarea name="guardian_detail" class="form-control" id="guardian_detail">{{$user->guardian_detail}}</textarea>
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Bank Name</label>
                                        <input type="text" class="form-control" value="{{$user->bank_name}}" name="bank_name">
                                    </div>
     
                                    <div class="my-4">
                                        <label for="textarea">Bank A/C</label>
                                        <input type="number" class="form-control" value="{{$user->bank_ac}}" name="bank_ac">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Bank IBN Number</label>
                                        <input type="number" class="form-control" value="{{$user->bank_ibn}}" name="bank_ibn">
                                    </div>

                                    <div class="my-4">
                                        <label for="textarea">Bank Title of Account</label>
                                        <input type="text" class="form-control" value="{{$user->bank_title_of_account}}" name="bank_title_of_account">
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">User Role</label>
                                        <select class="form-select" id="user_role" name="user_role">
                                            <option selected hidden disabled>Select Role</option>
                                            <option value="1" {{$user->user_role == 1 ? 'selected' : ''}}>Admin</option>
                                            <option value="2" {{$user->user_role == 2 ? 'selected' : ''}}>User</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">User Designation</label>
                                        <select class="form-select" id="user_designation" name="user_designation">
                                            <option selected hidden disabled>Select Designation</option>
                                            @foreach($designation as $designation)
                                                <option value="{{ $designation->id }}" {{ $designation->id == $user->user_designation ? 'selected' : '' }}>
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
                                            <option value="{{$main_depart->id}}" {{ $main_depart->id == $user->main_department_id ? 'selected':''}}>{{$main_depart->department_name}}</option>
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
                                            <option value="{{$sub_department->id}}" {{ $sub_department->id == $user->sub_department_id ? 'selected':''}}>{{$sub_department->sub_department_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">Schedule</label>
                                        <select class="form-select" id="user_shift" name="user_shift">
                                            <option  hidden disabled>Select Shift</option>
                                            @if($schedule)
                                            @foreach($schedule as $schedule)
                                            <option value="{{$schedule->id}}" {{ $schedule->id == $user->user_shift ? 'selected':''}}>{{$schedule->shift_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>
                                    <fieldset class="my-4">
                                        <legend class="h6">Status</legend>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" {{ $user->status === 1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" {{ $user->status === 0 ? 'checked' : ''}}>
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
