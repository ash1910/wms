<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_acc_detail extends Model
{
    use HasFactory;
    protected $table = 'tbl_acc_details';

    protected $fillable = ['vr_type','vr_sl','tdate','ahead','opposite_head','debit','credit','narration',
                            'narration2','ch_no','ch_date','b_name'];

}
