<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_rep_trial_bal extends Model
{
    use HasFactory;

    public function childs() {
        return $this->hasMany('App\Models\tbl_rep_trial_bal','parent_id','id') ;
    }
}
