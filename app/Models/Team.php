<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function project(){
        return $this->belongsToMany(Project::class,ProjectTeam::class);
    }
    // public function teamEmployee(){
    //     return $this->belongsToMany(TeamEmployee::class)->where("delete_status",1);
    // }
}
