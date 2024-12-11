<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
class SubDepartment extends Model
{
    protected $table= "sub_dept";
    use HasFactory;

    public function getDepartment()
    {
        return $this->hasOne(Department::class, 'id','main_department_id');
    }

    public function mainDepartment()
    {
        return $this->belongsTo(Department::class, 'main_department_id', 'id');
    }
}