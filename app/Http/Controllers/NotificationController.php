<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    public function addNewNotification($text, $type, $to=null):bool
    {
        $deve_mostrar_ate = 0; //intervalo em dias

        switch($type)
        {
            case 'news':
                $deve_mostrar_ate = intval(Config::get('notification.NEWS'));
                break;
            case 'system':
                $deve_mostrar_ate = intval(Config::get('notification.SYSTEM'));
             break;
            default:
                $deve_mostrar_ate = intval(Config::get('notification.DEFAULT'));
            break;
        }
        $show_till = date('Y-m-d H:i:s', strtotime('+'.intval($deve_mostrar_ate).' days'));
        $model = new \App\Models\NotificationModel();
        if($model->insert(['notification' => $text, 'show_till' => $show_till,'created_at' => date('Y-m-d H:i:s', time()),'active'=>1,'type'=>$type, 'user_email'=>$to]))
        {
            return true;
        }
        return false;
    }

    public function getNotifications()
    {
        $model = new \App\Models\NotificationModel();
        $list = $model->getAll();
        echo json_encode(['data' => $list]);
    }

    public function disableNotification(Request $request)
    {
        $id= $request->id;
        $model = new \App\Models\NotificationModel();
        return $model->disable($id);
    }
}
