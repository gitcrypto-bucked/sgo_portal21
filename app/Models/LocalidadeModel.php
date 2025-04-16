<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class LocalidadeModel extends Model
{
    public function getLocalidadeById($id_localidade)
    {
        return DB::table('sgo_localidade')->where('id_localidade','=',$id_localidade)->get();
    }
}
