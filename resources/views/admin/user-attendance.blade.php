@extends('admin.layouts.main')
@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Users Attendance</h1>
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
         <!-- Filter Form -->
         <form method="GET" action="{{ route('admin_users_attendance') }}" class="d-flex flex-wrap mb-4">
            <!-- Year Filter -->
            <div class="form-group mr-3 mb-3">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    <option value="">Select Year</option>
                    @foreach ($years as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                            {{ $yr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Month Filter -->
            <div class="form-group mr-3 mb-3">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    <option value="">Select Month</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ request('month') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- User Filter -->
            <div class="form-group mr-3 mb-3">
                <label for="user">By User:</label>
                <select class="form-control" id="user" name="user">
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                            {{ $user->username }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Absent Late Filter -->
            <div class="form-check mb-3 mr-3">
                <input type="checkbox" class="form-check-input" id="absent_late" name="absent_late" {{ request('absent_late') ? 'checked' : '' }}>
                <label class="form-check-label" for="absent_late">Show Absent and Late</label>
            </div>

            <!-- Submit Button -->
            <div class="form-group mb-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
        
        @if ($dataExists)
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" id="table_id">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">User</th>
                            @foreach ($dates as $date)
                                <th class="border-0">{{ $date }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendanceFormatted as $userId => $days)
                            <tr>
                                <td class="border-0 font-weight-bold">{{ $users[$userId]->username ?? 'Unknown User' }}</td>
                                @foreach ($dates as $date)
                                    <td class="border-0">{{ $days[$date] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="">
                No data found for the selected month and year.
            </div>
        @endif
    </div>
</div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });
    </script>
@endpush
