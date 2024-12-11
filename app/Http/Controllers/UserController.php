<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Userbreak;
use App\Models\Leave;
use App\Models\Lock;
use App\Models\Breaklock;

use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    //
    public function dashboard(){

        $logout = Lock::where('user_id',Auth::user()->id)->first();
        $brlog= null;
        if($logout)
        {
            $brlog =  Breaklock::where('atn_id',$logout->atn_id)->first();
        }
        
        return view('user.dashboard',compact('logout','brlog'));
    }

    public function user_profile(){
        $profile = User::where('id',Auth()->user()->id)->first();
        return view('user.profile',compact('profile'));
    }

    public function user_attendance(Request $request)
{
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $attendanceData = Attendance::where('month', $month)
        ->where('year', $year)
        ->where('user_id', Auth()->user()->id)
        ->get();

    // Check if there is any attendance data
    $dataExists = $attendanceData->isNotEmpty();
    
    // Fetch user data to get usernames
    $users = User::all()->keyBy('id');

    $attendanceFormatted = [];
    $dates = [];

    // Get today's date for comparison
    $today = date('Y-m-d');

    if ($dataExists) {
        // Generate an array of dates for the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%02d/%02d/%d', $month, $day, $year); // Format date as MM/DD/YYYY
            $dayOfWeek = date('N', strtotime($date)); // Get day of the week (1 = Monday, 7 = Sunday)
            
            // Set '-' for Saturdays (6) and Sundays (7)
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                $dates[] = $date;
            } else {
                $dates[] = $date;
            }
        }

        foreach ($attendanceData as $attendance) {
            $userId = $attendance->user_id;
            $day = date('j', strtotime($attendance->day)); 
            $dateFormatted = sprintf('%02d/%02d/%d', $month, $day, $year);

            if (!isset($attendanceFormatted[$userId])) {
                $attendanceFormatted[$userId] = array_fill_keys($dates, '-'); 
            }

            // Check if the attendance day is before or after today
            $attendanceDate = sprintf('%04d-%02d-%02d', $year, $month, $day); // Format date as YYYY-MM-DD

            if ($attendance->present) {
                $attendanceFormatted[$userId][$dateFormatted] = 'P'; 
            } elseif ($attendance->late) {
                $attendanceFormatted[$userId][$dateFormatted] = 'L'; 
            } else {
                // Check if it's before today
                if ($attendanceDate < $today) {
                    $attendanceFormatted[$userId][$dateFormatted] = 'A'; 
                } else {
                    $attendanceFormatted[$userId][$dateFormatted] = '-';
                }
            }
        }

        // Fill missing dates with 'A' or '-' based on past or future
        foreach ($attendanceFormatted as $userId => $attendanceArray) {
            foreach ($attendanceArray as $date => $status) {
                $attendanceDate = date('Y-m-d', strtotime($date)); // Convert formatted date back to Y-m-d

                if ($status === '-') {
                    if (date('N', strtotime($attendanceDate)) == 6 || date('N', strtotime($attendanceDate)) == 7) {
                        // Keep '-' for weekends
                        continue;
                    }
                    // Assign 'A' for past dates and '-' for future dates
                    if ($attendanceDate < $today) {
                        $attendanceFormatted[$userId][$date] = 'A';
                    } else {
                        $attendanceFormatted[$userId][$date] = '-';
                    }
                }
            }
        }
    }

    $years = range(date('Y') - 10, date('Y') + 10);
    return view('user.attendance', compact('attendanceFormatted', 'dates', 'users', 'month', 'year', 'dataExists', 'years'));
}
    public function leave_list(){

        $leaves = Leave::with('getApproveUser')->where('user_id',Auth()->user()->id)->orderBy('id','DESC')->get();
        //dd($leaves);
        return view('user.leave.leave-list',compact('leaves'));
    }
    public function leave_approved(){

        $leaves = Leave::orderBy('id','DESC')->get();
        return view('user.leave.leave-approved',compact('leaves'));
    }
    
    public function leave_add(){
        //$user = User::with('getSchedule')->where('user_role',2)->orderBy('id','ASC')->get();
        return view('user.leave.leave-add');
    }

    public function leave_edit($id)
    {
        $leave =  Leave::where('id',$id)->first();
        return view('user.leave.leave-edit', compact('leave'));
    }
    public function check_in()
    {
        date_default_timezone_set("Asia/Karachi");
        $graceTime = 25;
        $schedule = Auth::user()->getSchedule;
        if(empty($schedule))
        {
            return redirect()->back()->with('error','Schedule Not Found');
        }
        $start_time = $schedule->start_time;
        $dateWithGrace = date("d-m-Y H:i", strtotime(date('d-m-Y'). $start_time.'  +25 minutes'));
        $date3HoursAfter = date("d-m-Y H:i", strtotime($dateWithGrace . " +3 hours")); 
        $checkIn = date("d-m-Y H:i", strtotime(date('d-m-Y H:i'))); 
        $day = date('l');
        $month = date('m');
        $year = date('Y');
        $att = new Attendance();
        $att->user_id = Auth::user()->id;
        $att->check_in = $checkIn;
        $att->month = $month;
        $att->day = $day;
        $att->year = $year;
        $att->late = 0;
        $att->half_day = 0;
        $att->present = 0;
        if($checkIn <= $dateWithGrace){
            $att->present = 1;
        }else if($checkIn > $dateWithGrace && $checkIn <= $date3HoursAfter){
            $att->late = 1;
        }else if($checkIn > $date3HoursAfter){
            $att->half_day = 1;
        }


        if($att->save())
        {
            $lock = new Lock();
            $lock->atn_id = $att->id;
            $lock->user_id = Auth::user()->id;
            $lock->save();
            return redirect(route('user.dashboard'));
            
        }

    }


    public function check_out($id)
    {
        date_default_timezone_set("Asia/Karachi");
        $total_break_time = 0;
        $break = Userbreak::where('atn_id',$id)->get();
        if(!empty($break))
        {   
            
            $break = $break->toArray(); 
            foreach($break as $value){
                $break_start_time = date("d-m-Y H:i", strtotime($value['start_time']));
                $break_end_time = date("d-m-Y H:i", strtotime($value['end_time']));
        
                $breakInDateTime = \DateTime::createFromFormat('d-m-Y H:i', $break_start_time);
                $breakOutDateTime = \DateTime::createFromFormat('d-m-Y H:i', $break_end_time); 
        
                $break_interval = $breakInDateTime->diff($breakOutDateTime);
        
                // Convert break time to minutes
                $break_minutes = ($break_interval->h * 60) + $break_interval->i;
                $break_minutes += $break_interval->days * 24 * 60; // Convert days to minutes and add
        
                $total_break_time += $break_minutes;
                
            }
            $breakhours = floor($total_break_time / 60);
            $breakminutes = $total_break_time % 60;

            $total_break_time = sprintf("%d:%02d", $breakhours, $breakminutes);
        }
        //dd($total_break_time);
        $schedule = Auth::user()->getSchedule;
        $end_time = $schedule->end_time;
        $dateWithEndTime = date("d-m-Y H:i", strtotime(date('d-m-Y'). $end_time));
        $checkout = date("d-m-Y H:i", strtotime(date('d-m-Y H:i'))); 
        
        $att = Attendance::where('id',$id)->first();
        //dd($att);
        $checkInTime = $att->check_in;
        $att->check_out = $checkout;
        $att->break = $total_break_time;
        $checkInDateTime = \DateTime::createFromFormat('d-m-Y H:i', $checkInTime);
        $checkOutDateTime = \DateTime::createFromFormat('d-m-Y H:i', $checkout);
        $interval = $checkInDateTime->diff($checkOutDateTime);
        $hours = $interval->h;
        $minutes = $interval->i;
        $hours += $interval->days * 24;
        $att->early_out = 0;
        $att->working_hours = sprintf("%d:%02d", $hours, $minutes);
        if($dateWithEndTime < $checkout){
            $att->early_out = 1;
        }

        //dd($checkInTime,$checkout,sprintf("%d:%02d", $hours, $minutes));
        
        if($att->save())
        {
            $lock = Lock::where('user_id',Auth::user()->id)->first();
            $lock->delete();
            return redirect(route('user.dashboard'));
            
        }

    }

    public function leave_add_edit_data(Request $request){
        $lev = new Leave();
        $lev->start_date = $request->start_date;
        $lev->end_date = $request->end_date;
        $lev->user_id = $request->user_id;
        $lev->reason = $request->leave_reason;
        $lev->main_department_id = $request->main_department_id;
        $lev->sub_department_id = $request->sub_department_id;
        $lev->user_designation = $request->user_designation;
        $lev->status = $request->leave_status;
        $lev->save();
        //dd($user,$request->start_date);
        return back()->with('success','Leave Request Sent Successfully');
    }

    public function leave_user_edit_data(Request $request, Leave $leave){

        $create = 1;
        (isset($leave->id) and $leave->id>0)?$create=0:$create=1;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->reason = $request->leave_reason;
        $leave->status = $request->leave_status;
        $leave->approved_by = Auth::user()->id;
        $leave->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
    }

    public function break_in($id)
    {
        date_default_timezone_set("Asia/Karachi");
        $brk = new Userbreak();
        $brk->user_id = Auth::user()->id;
        $att = Attendance::where('id',$id)->first();
        $brk->atn_id = $att->id;
        $brk->start_time = date('H:i');
        if($brk->save())
        {
            $block = new Breaklock();
            $block->break_id = $brk->id;
            $block->atn_id = $att->id;
            $block->save();
            return redirect(route('user.dashboard'));
            
        }

    }


    public function break_out($id)
    {
        date_default_timezone_set("Asia/Karachi");
        $brk = Userbreak::where('id',$id)->first();

        //dd($brk);
        $brk->end_time = date('H:i');

        if($brk->save())
        {    
            $block = Breaklock::where('break_id',$brk->id)->first();
            $block->delete();
            return redirect(route('user.dashboard'));
            
        }

    }

}
