<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Schedule;
use PhpParser\Node\Stmt\TryCatch;

class DashboardController extends Controller
{
    //
    public function admin_schedule_list(){

        $schdule = Schedule::get();

        return view('admin.schedule.schedule-list',compact('schdule'));
    }

    public function admin_schedule_add()
    {
        return view('admin.schedule.schedule-add');
    }

    public function admin_schedule_edit(Schedule $id)
    {
        $schedule = $id;
        return view('admin.schedule.schedule-edit', compact('schedule'));
    }
    public function admin_schedule_delete($id)
    {
        dd('yes');
    }

    public function admin_schedule_add_edit(Request $req, Schedule $schedule)
    {
        $create =isset($schedule->id)?0:1;
        $msg =isset($schedule->id)?'Created Successfully':'Updated Successfully';
        $type = isset($schdule->id)?'success':'update';
        $req->validate([
            'shift_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            ]);
        

        $schedule->shift_name = $req->shift_name;
        $schedule->start_time = $req->start_time;
        $schedule->end_time = $req->end_time;
        if($schedule->save())
        {
            return redirect()->back()->with($type, $msg);
        }
    
    }

}
