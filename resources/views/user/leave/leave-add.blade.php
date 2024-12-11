@extends('user.layouts.main')
@section('content')

            <div class="row mt-5">
                <div class="col-12 col-xl-12">
                    <div class="card card-body bg-white border-light shadow-sm mb-4">
                       
                        @if(Session::has('oldpass'))
                            <div class="alert alert-danger mb-4" id="success-alert">
                                <center><span class="text-white">{{Session::get('oldpass')}}</span></center>
                            </div>
                        @endif
                        @if(Session::has('reset'))
                            <div class="alert alert-success mb-4" id="success-alert">
                                <center><span class="text-white">{{Session::get('reset')}}</span></center>
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success mb-4" id="success-alert">
                                <center><span class="text-white">{{Session::get('success')}}</span></center>
                            </div>
                        @endif
                        <h2 class="h5 mb-4">Leave Request</h2>
                        <form action="{{route('user_leave_add_edit').'/'.Auth()->user()->id}}" method="POST">@csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="start_date">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" required name="start_date">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="end_date">End Date</label>
                                        <input class="form-control" id="end_date" type="date" required name="end_date">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="leave_reason">Leave Reason</label>
                                        <textarea class="form-control" id="leave_reason" name="leave_reason" required rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="0" name="leave_status">
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <input type="hidden" value="{{Auth::user()->main_department_id}}" name="main_department_id">
                            <input type="hidden" value="{{Auth::user()->sub_department_id}}" name="sub_department_id">
                            <input type="hidden" value="{{Auth::user()->user_designation}}" name="user_designation">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Send Leave Request</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>



@endsection
