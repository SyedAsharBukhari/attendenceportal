<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\SubDepartment;
class Designation extends Model
{
    protected $table= "designation";
    use HasFactory;

    public function getDepartment()
    {
        return $this->hasOne(Department::class, 'id','main_department_id');
    }

    public function getSubDepartment()
    {
        return $this->hasOne(SubDepartment::class, 'id','sub_department_id');
    }

    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id', 'id');
    }
}