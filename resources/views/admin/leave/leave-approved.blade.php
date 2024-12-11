@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Leave List</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Leave-List</h1>
            </div>
            <!-- <div>
                <a href="{{route('user_leave_add')}}" class="btn btn-outline-gray"><i class="far fa-plus-square mr-1"></i> Add New Leave</a>
            </div> -->
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
                        <th class="border-0">Start Date</th>
                        <th class="border-0">End Date</th>
                        <th class="border-0">Reason</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Item -->
                    <!-- Start of Item -->
                    
                    
                        <tr>
                        @foreach($leaves as $key=>$value)
                        
                        <td class="border-0 font-weight-bold">{{$key+1}}</td>
                            <td class="border-0 font-weight-bold">{{$value->start_date}}</td>
                            <td class="border-0 font-weight-bold">{{$value->end_date}}</td>
                            <td class="border-0 font-weight-bold">{{$value->reason}}</td>
                            <td class="border-0 font-weight-bold">
                                {{$value->status == 1 ? 'Approved' : '' }}
                                {{$value->status == 0 ? 'Pending' : ''}}
                                {{$value->status == 2 ? 'Declined' : ''}}
                            </td>
                        <td class="border-0 font-weight-bold"><a href="{{route('admin_leave_edit',['id'=>$value->id])}}" class="text-secondary mr-3"><i class="fas fa-edit"></i>Edit</a></td>
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
