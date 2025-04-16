<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = ['notification','created_at','show_till','active'];

    public function insert(array $notiftion)
    {
        if(DB::table('notification')->insert($notiftion))
        {
            return true;
        }
        else return false;
    }

    public function getAll()
    {
        return DB::table('notification')->whereRaw("active ='1'")->orderBy('show_till', 'desc')->get();
    }

    public function disable($id)
    {
        return DB::table('notification')->where('id',$id)->update(['active'=>'0']);
    }

}
