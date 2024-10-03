<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_acc_master extends Model
{
    use HasFactory;

    protected $table = 'tbl_acc_masters';

    protected $fillable = ['id','grp_status','acc_name','grp_under','type_id','child_name','acc_lock','cost_center','acc_config'];


    public function childs() {
        return $this->hasMany('App\Models\tbl_acc_master','grp_under','id') ;
    }

}
