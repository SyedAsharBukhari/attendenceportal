<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Leave extends Model
{
    protected $table= "user_leave";
    use HasFactory;


    public function getApproveUser()
    {
        return $this->hasOne(User::class, 'id','approved_by');
    }
    
}