<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class NewsModel extends Model
{
    use HasFactory;
    protected $fillable = ['thumb', 'intro', 'title','created_at','active'];


    public function insert(array $news)
    {
        if(DB::table('sgo_noticia')->insert($news))
        {
            return true;
        }
        else return false;
    }


    public function getAllNews( int $paginate= 18){
        return DB::table('sgo_noticia')->where("active", "=",'1')->orderBy('created_at', 'desc')->get();
    }



    public function deactivate($id)
    {
        return DB::table('sgo_noticia')->where('id','=', $id)->update(['active'=>'0']);
    }

    public function deleteNews($id)
    {
        return DB::table('sgo_noticia')->where('id','=',$id)->delete($id);
    }

    public function getFIles($id)
    {
        return DB::table('sgo_noticia')->select(['thumb'])->where('id','!=',$id)->get();
    }

}
