@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Schedule-List</h1>
            </div>
            <div>
                <a href="{{route('admin.schedule.add')}}" class="btn btn-outline-gray"><i class="far fa-plus-square mr-1"></i> Add New Schedule</a>
            </div>
        </div>
    </div>

    <div class="card border-light shadow-sm mb-4">
        <div class="card-body">
            @if(Session::has('delete'))
                <div class="alert alert-danger mb-4" id="success-alert">
                    <center><span class="text-white">{{Session::get('delete')}}</span></center>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" id="table_id">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Shift Name</th>
                        <th class="border-0">Shift Start Time</th>
                        <th class="border-0">Shift End Time</th>
                        <th class="border-0">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Item -->
                    <!-- Start of Item -->
                    @foreach($schdule as $key=>$value)
                
                        <tr>
                            <td class="border-0"><a href="#" class="text-primary font-weight-bold">{{$key+1}}</a> </td>
                            <td class="border-0 font-weight-bold">{{$value->shift_name}}</td>
                            <td class="border-0 font-weight-bold">{{$value->start_time}}</td>
                            <td class="border-0 font-weight-bold">{{$value->end_time}}</td>
                            <td class="border-0">
                                <a href="{{route('admin.schedule.edit',['id'=>$value->id])}}" class="text-secondary mr-3"><i class="fas fa-edit"></i>Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    <!-- End of Item -->
                    <!-- Item -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
@endpush
