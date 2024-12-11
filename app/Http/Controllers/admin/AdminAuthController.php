<?php

namespace App\Http\Controllers\admin;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\SubDepartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Schedule;
use App\Models\Leave;
use App\Models\Attendance;

class AdminAuthController extends Controller
{
    function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(){
        return view('admin.index');
    }
    public function login_data(Request $req)
    {
        if(!empty($req->email)&&!empty($req->password)){
            $userfind=User::where('email',$req->email)->first();
          
            if($userfind){
                /*means found user*/
                if(Hash::check($req->password,$userfind->password)){
                
                    /*matched password*/
                    Auth::login($userfind);
                    
                    if(Auth::check()){
                        if(Auth::user()->user_role==1)
                        {
                            return redirect(route('admin_dashboard'));
                        }
                        else
                        {
                            return redirect(route('user.dashboard'));
                        }
                        
                    }else{
                        return redirect(route('admin_login'));
                    }
                    /*matched password end*/
                }else{
                    return redirect(route('admin_login'))->with('Failed_Password','Password is incorrect')->with('email',$req->email);
                }
                /*means found user end*/
            }else{
                return redirect(route('admin_login'))->with('Failed_Email','Email not found');
            }
        }else{
            return redirect(route('admin_login'))->with('Failed_Empty','Please fill required fields');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect(route('admin_login'));
    }
    public function admin_profile(){
        $profile = User::where('id',Auth()->user()->id)->first();
        return view('admin.profile',compact('profile'));
    }
    public function admin_profile_update(User $user, Request $request){
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        return back()->with('update','Updated Successfully');
    }
    public function admin_password_update(User $user,Request $request){
        if($request->old_password !== null And Hash::check($request->old_password ,Auth()->user()->getAuthPassword())){
            $user->password = Hash::make($request->new_password);
            $user->save();
            return back()->with('reset','Reset Successfully');
        }
        else{
            return back()->with('oldpass','Oldpass is incorrect');
        }
    }

    /**-----------------------------------Admin User Functions-------------------------------------------**/
    public function user_list(){
        $user = User::with('getSchedule')->with('getDesignation')->where('user_role',2)->orderBy('id','ASC')->get();
        //$userDesignation = User::with('getDesignation')->orderBy('id','ASC')->get();
        
        return view('admin.users.users-list',compact('user'));
    }
    
    public function leave_approved(){

        $leaves = Leave::orderBy('id','DESC')->get();
        return view('admin.leave.leave-approved',compact('leaves'));
    }
    
    public function leave_edit($id)
    {
        $leave =  Leave::where('id',$id)->first();
        return view('admin.leave.leave-edit', compact('leave'));
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



    public function users_attendance(Request $request)
{
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $attendanceData = Attendance::where('month', $month)
        ->where('year', $year)
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

    return view('admin.user-attendance', compact('attendanceFormatted', 'dates', 'users', 'month', 'year', 'dataExists', 'years'));
}
    
    
    
    function user_add()
    {
        $schedule = Schedule::get();
        $designation = Designation::with(['subDepartment.mainDepartment'])->get();
        $sub_department = SubDepartment::get();
        $main_depart = Department::get();
        return view('admin.users.users-add',compact('schedule','designation','main_depart','sub_department'));
    }
    function user_edit($id)
    {
        $schedule = Schedule::get();
        $designation = Designation::with(['subDepartment.mainDepartment'])->get();
        $sub_department = SubDepartment::get();
        $main_depart = Department::get();
        $user = User ::where('id',$id)->first();
        return view('admin.users.users-edit',compact('user','designation','main_depart','sub_department','schedule'));
    }
    function user_delete(User $user)
    {
        $user->delete();
        return back()->with('delete','Deleted Successfully');
    }
    function user_add_edit_data(Request $request,User $user)
    {
        
        $create = 1;
        (isset($user->id) and $user->id>0)?$create=0:$create=1;
        $user->username = $request->username;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->personal_email = isset($request->personal_email)?$request->personal_email:$user->personal_email;
        $user->phone_number = isset($request->phone_number)?$request->phone_number:$user->phone_number;
        $user->date_of_joining = isset($request->date_of_joining)?$request->date_of_joining:$user->date_of_joining;
        $user->date_of_birth = isset($request->date_of_birth)?$request->date_of_birth:$user->date_of_birth;
        $user->user_cnic = isset($request->user_cnic)?$request->user_cnic:$user->user_cnic;
        $user->salary = isset($request->salary)?$request->salary:$user->salary;
        $user->address = isset($request->address)?$request->address:$user->address;
        $user->guardian_detail = isset($request->guardian_detail)?$request->guardian_detail:$user->guardian_detail;
        

        $user->bank_name = isset($request->bank_name)?$request->bank_name:$user->bank_name;
        $user->bank_ac = isset($request->bank_ac)?$request->bank_ac:$user->bank_ac;
        $user->bank_ibn = isset($request->bank_ibn)?$request->bank_ibn:$user->bank_ibn;
        $user->bank_title_of_account = isset($request->bank_title_of_account)?$request->bank_title_of_account:$user->bank_title_of_account;


        $user->user_role = $request->user_role;
        $user->user_designation = isset($request->user_designation)? $request->user_designation : $user->user_designation;
        $user->main_department_id = isset($request->main_department_id)?$request->main_department_id:$user->main_department_id;
        $user->sub_department_id = isset($request->sub_department_id)?$request->sub_department_id:$user->sub_department_id;
        $user->user_shift = isset($request->user_shift)?$request->user_shift:$user->user_shift;
        $user->status = $request->status;
        $user->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
        else
        {
            $emp_id = "EMP-00".$user->id;
                $user->emp_id = $emp_id;
                $user->save();
            return back()->with('success','Added Successfully');
        }
    }


    /**-----------------------------------Admin Department Functions-------------------------------------------**/
     
    public function department_list(){
        $department = SubDepartment::with('getDepartment')->orderBy('id','ASC')->get();
        return view('admin.department.department-list',compact('department'));
    }
    function department_add()
    {
        return view('admin.department.department-add');
    }
    function department_edit($id)
    {
        //$schedule = Schedule::get();
        $department = Department::where('id',$id)->first();
        return view('admin.department.department-edit',compact('department'));
    }
    function sub_department_add()
    {
        $main_depart = Department::get();
        return view('admin.sub-department.sub-department-add',compact('main_depart'));
    }
    

    function sub_department_edit($id)
    {
        $sub_department = SubDepartment::where('id',$id)->first();
        $main_depart = Department::get();
        return view('admin.sub-department.sub-department-edit',compact('sub_department','main_depart'));
    }
    function department_add_edit_data(Request $request,Department $department)
    {
        
        $create = 1;
        (isset($department->id) and $department->id>0)?$create=0:$create=1;
        $department->department_name = $request->department_name;
        $department->status = $request->status;
        $department->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
        else
        {
            return back()->with('success','Added Successfully');
        }
    }


    function sub_department_add_edit_data(Request $request,SubDepartment $sub_department)
    {
        
        $create = 1;
        (isset($sub_department->id) and $sub_department->id>0)?$create=0:$create=1;
        $sub_department->sub_department_name = $request->sub_department_name;
        $sub_department->main_department_id = $request->main_department_id;
        $sub_department->status = $request->status;
        $sub_department->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
        else
        {
            return back()->with('success','Added Successfully');
        }
    }

    /**-----------------------------------Admin Designation Functions-------------------------------------------**/

    public function designation_list(){
        $designation = Designation::with('getDepartment')->with('getSubDepartment')->orderBy('id','ASC')->get();
        return view('admin.designation.designation-list',compact('designation'));
    }
    
    function designation_add()
    {
        $main_depart = Department::get();
        $sub_depart = SubDepartment::get();
        return view('admin.designation.designation-add',compact('main_depart','sub_depart'));
    }


    function designation_add_edit_data(Request $request, Designation $designation)
    {
        
        $create = 1;
        (isset($designation->id) and $designation->id>0)?$create=0:$create=1;
        $designation->designation_name = $request->designation_name;
        $designation->main_department_id = $request->main_department_id;
        $designation->sub_department_id = $request->sub_department_id;
        $designation->status = $request->status;
        $designation->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
        else
        {
            return back()->with('success','Added Successfully');
        }
    }
    function designation_edit($id)
    {
        $designation = Designation::where('id',$id)->first();
        $sub_department = SubDepartment::get();
        $main_depart = Department::get();
        return view('admin.designation.designation-edit',compact('sub_department','main_depart','designation'));
    }
}
