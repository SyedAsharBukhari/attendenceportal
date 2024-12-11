@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{route('admin_designation')}}">Designation-List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Designation-Edit</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Designation Edit</h1>
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
                                <form action="{{route('admin_designation_add_edit').'/'.$designation->id}}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="mb-4">
                                        <label for="title">Designation Name</label>
                                        <input type="text" class="form-control" required value="{{$designation->designation_name}}" name="designation_name">
                                    </div>
                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">Main Department</label>
                                        <select class="form-select" id="main_department_id" name="main_department_id">
                                            <option  hidden disabled>Select Main Department</option>
                                            @if($main_depart)
                                            @foreach($main_depart as $main_depart)
                                            <option value="{{$main_depart->id}}" {{ $main_depart->id == $designation->main_department_id ? 'selected':''}}>{{$main_depart->department_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="my-1 mr-2" for="country">Sub Department</label>
                                        <select class="form-select" id="sub_department_id" name="sub_department_id">
                                            <option  hidden disabled>Select Sub Department</option>
                                            @if($sub_department)
                                            @foreach($sub_department as $sub_department)
                                            <option value="{{$sub_department->id}}" {{ $sub_department->id == $designation->sub_department_id ? 'selected':''}}>{{$sub_department->sub_department_name}}</option>
                                            @endforeach
                                            @endif
                                            
                                        </select>
                                    </div>
                                    <fieldset class="my-4">
                                        <legend class="h6">Status</legend>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" {{ $designation->status === 1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" {{ $designation->status === 0 ? 'checked' : ''}}>
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
