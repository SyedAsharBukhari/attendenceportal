@extends('admin.layouts.main')
@section('content')

            <div class="row mt-5">
                <div class="col-12 col-xl-12">
                    <div class="card card-body bg-white border-light shadow-sm mb-4">
                       
                       <!-- Form -->
                       @if(Session::has('update'))
                                    <div class="alert alert-warning mb-4" id="success-alert">
                                        <center><span class="text-white">{{Session::get('update')}}</span></center>
                                    </div>
                        @endif
                        <h2 class="h5 mb-4">Leave Request</h2>
                        <form action="{{route('admin_leave_user_edit',['leave'=>$leave->id])}}" method="POST">@csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="start_date">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" required name="start_date" value="{{$leave->start_date}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="end_date">End Date</label>
                                        <input class="form-control" id="end_date" type="date" required name="end_date" value="{{$leave->end_date}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="leave_reason">Leave Reason</label>
                                        <textarea class="form-control" id="leave_reason" name="leave_reason" required rows="3" readonly>{{$leave->reason}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                    <label class="my-1 mr-2" for="country">Leave Status</label>
                                    <select class="form-select" id="leave_status" name="leave_status">
                                        <option disabled>Select Leave Status</option>
                                        <option value="0" {{ $leave->status == 0 ? 'selected':''}}>Pending</option>
                                        <option value="1" {{ $leave->status == 1 ? 'selected':''}}>Approved</option>
                                        <option value="2" {{ $leave->status == 2 ? 'selected':''}}>Declined</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Save Leave Request</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>



@endsection
