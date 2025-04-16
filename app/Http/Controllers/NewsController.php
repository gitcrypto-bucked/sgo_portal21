<?php

namespace App\Http\Controllers;
use App\Policies\PagePolicy;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\NewsModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class NewsController extends Controller
{

    public function dashboard()
    {
        $news = $this->getAllNews();
        return view('news')->with('news', $news);
    }

    protected function getAllNews()
    {
        $paginate = Config::get('pagination.NEWS');
        $model = new NewsModel();
        return $model->getAllNews(intval($paginate));
    }


    public function registerNews(Request $request)
    {
        $request->validate([
            'thumb' => 'required|mimes:jpg,png,webp|max:2048',
            'webrul' => 'required|url',
            'sinopse' => 'required|string|min:20',
            'title' => 'required|string|min:8',
        ]);

        if(parse_url($request->webrul, PHP_URL_SCHEME)==false |
            parse_url($request->webrul, PHP_URL_HOST)==false)
        {
            return redirect('/register-news')->with('error', 'A url informada não é valida.');
        }
        if ($request->file('thumb')->isValid())
        {
            $file = $request->file('thumb');
            $path = $request->file('thumb')->storeAs('thumb_', $file->hashName());
        }
        else
        {
            return redirect('/add_news')->with('error', 'O arquivo de imagem tem que ser jpg, png, jpeg ou webp.');
        }
        $hora = time();
        $news = [
            'created_at'=>date('Y-m-d H:i:s', $hora),
            'thumb'=>$file->hashName(),
            'intro' => $request->sinopse,
            'active' => '1',
            'title' => $request->title,
            'url' => $request->webrul,
        ];
        $newsModel = new NewsModel();
        if($newsModel->insert($news))
        {
            event(new \App\Events\NewsPublished($news));

            return redirect('/add_news')->with('success', 'Noticia cadastrada com sucesso!');
        }
        return redirect('/add_news')->with('error', 'Houve um erro ao cadastrar a noticia!.');

    }
    public function add_News()
    {
        return view('add_news');
    }

    public function newsManager()
    {
        $news = $this->getAllNews();
        return view('news-manager')->with('news', $news);
    }

    public function newsAction(Request $request)
    {
        switch ($request->submitbutton)
        {
            case 'excluir':
               return $this->deleteNews($request);
            break;
            case 'desativar':default:
                return  $this->deactivateNews($request);
            break;
        }
    }
    /** função que deleta a noticia  */
    public function deleteNews(Request $request)
    {
        $id= $request->newsID;
        $model = new NewsModel();
        $files = $model->getFIles($id)[0]->thumb;
        if(Storage::exists('thumb_/'.$files))
        {
            Storage::delete('thumb_/'.$files);
        }
        if($model->deleteNews($id))
        {
            return redirect('/news-manager')->with('success', 'Noticia excuida com sucesso!');
        }
        return redirect('/news-manager')->with('error', 'Houve um erro ao excluir a noticia!.');
    }
    /** função que desativa a noticia  */
    public function deactivateNews(Request $request)
    {
        $id= $request->newsID;
        $model = new NewsModel();
        if($model->deactivate($id))
        {
            return redirect('/news-manager')->with('success', 'Noticia desativada com sucesso!');
        }
        return redirect('/news-manager')->with('error', 'Houve um erro ao desativar a noticia!.');
    }
}
