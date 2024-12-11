@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.schedule.list')}}">Schedule-List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule-Edit</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Schedule Edit</h1>
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
                                <form action="{{route('admin.schedule.add.edit',['schedule'=>$schedule->id])}}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="mb-4">
                                        <label for="title">Shift Name</label>
                                        <input type="text" value="{{$schedule->shift_name}}" class="form-control" required name="shift_name" placeholder="Enter your Shift Name...">
                                    </div>
                                    <div class="mb-4">
                                        <label for="title">Shift Start Time</label>
                                        <input type="time" class="form-control" value="{{$schedule->start_time}}" required name="start_time" placeholder="Enter your title...">
                                    </div>
                                    <div class="mb-4">
                                        <label for="title">Shift End Time</label>
                                        <input type="time" class="form-control" value="{{$schedule->end_time}}" required name="end_time" placeholder="Enter your title...">
                                    </div>
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
