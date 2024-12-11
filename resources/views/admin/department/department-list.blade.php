@extends('admin.layouts.main')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Department</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Departments</h1>
            </div>
            <div>
                <a href="{{route('admin_department_add')}}" class="btn btn-outline-gray"><i class="far fa-plus-square mr-1"></i> Add New Main Department</a>
            </div>
            <div>
                <a href="{{route('admin_sub_department_add')}}" class="btn btn-outline-gray"><i class="far fa-plus-square mr-1"></i> Add New Sub Department</a>
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
                        <th class="border-0">Main Department</th>
                        <th class="border-0">Sub Department</th>
                        <th class="border-0">Main Department Status</th>
                        <th class="border-0">Sub Department Status</th>
                        <th class="border-0">Edit Main Department/Sub Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Item -->
                    <!-- Start of Item -->
                    @foreach($department as $key=>$value)
                    
                        <tr>
                            <td class="border-0"><a href="#" class="text-primary font-weight-bold">{{$key+1}}</a> </td>
                            <td class="border-0 font-weight-bold">{{$value->getDepartment->department_name}}</td>
                            <td class="border-0 font-weight-bold">{{$value->sub_department_name}}</td>
                            <td class="border-0 font-weight-bold">
                                
                                <span class="{{$value->getDepartment->status == 1 ? 'text-success' : 'text-danger'}}">{{$value->getDepartment->status == 1 ? 'Active' : 'Inactive'}}</span>
                            </td>
                            <td class="border-0 font-weight-bold">
                            <span class="{{$value->status == 1 ? 'text-success' : 'text-danger'}}">{{$value->status == 1 ? 'Active' : 'Inactive'}}</span> 
                            </td>
                            <td class="border-0">
                                <a href="{{route('admin_department_edit').'/'.$value->getDepartment->id}}" class="text-secondary mr-3"><i class="fas fa-edit"></i>Edit</a>
                                <span class="text-primary"> |  </span>
                                <a href="{{route('admin_sub_department_edit').'/'.$value->id}}" class="text-secondary mr-3"><i class="fas fa-edit"></i>Edit</a>
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
