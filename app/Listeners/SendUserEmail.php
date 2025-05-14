<?php

namespace App\Listeners;

use App\Events\RegistredUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
ini_set('memory_limit', '-1');
set_time_limit(0);

class SendUserEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegistredUser $event): void
    {

        $user = $event->user;
        $name = $user['name'];
        $email = $user['email'];
        $user_token = $user['user_token'];
        $url =$user['url'];
        try
        {
            $this->sendNewUserMail($email, $url, $name, $user_token);
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }

    private function getNewUserTemplate( $url, $name, $user_token):string
    {
        return '  <!DOCTYPE html>
            <html>
          <head>
            <meta charset="UTF-8">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <style>
          @import "https://fonts.cdnfonts.com/css/poppins";

          body
          {
            font-family: Poppins, sans-serif;
            font-size: 15px !important;
          }
        #customers {
          font-family: Poppins, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        #customers td, #customers th {
          border: none ;
          padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #F8F8F8;}

        #customers tr{background-color: #F8F8F8;}

        #customers th {
          padding-top: 20px;
          padding-bottom: 20px;
          text-align: left;
          background-color: #cfdadf ;
          color: black;
        }

        table tr th
        {
            font-size:14px;
        }

        th
        {
            width:100%;
        }



        .logo {
            width: 125px;
        }

        .button {
          font: bold 11px Arial;
          text-decoration: none;
          background-color:#0E86D4;
          color: white !important;
          padding: 12px 16px 12px 16px;
          border-radius:5px;
        }
        </style>
        </head>
        <body>


        <table id="customers">
          <tr>
            <th><img src="cid:logoimg" class="logo"  alt="PHPMailer"></th>

          </tr>
          <tr>
            <td></td>


          </tr>
          <tr>
            <td>Caro(a) '.$name.', seu cadastro no Portal LowCost foi realizado com sucesso!</td>
          </tr>
          <tr>
               <td>Para logar-se no portal informe o token: '.$user_token.'</td>
          </tr>
          <tr>
            <td>Clique no botão abaixo, para cadastrar uma senha.</td>

          </tr>
          <tr>
            <td></td>

          </tr>
          <tr>
           <td><a href="'.$url.'" target="_blank" class="button">Criar Senha</a></td>

          </tr>
           <tr>
            <td></td>

          </tr>
          <tr>
            <td>Att</td>

          </tr>

          <tr>
            <td>LowCost</td>

          </tr>
        </table>

        </body>
        </html>
        ';
    }

    private function sendNewUserMail($to, $url, $name, $user_token):bool
    {
        $headers = 'FROM: '.config('PHPMAILER.from');
        $message = self::getNewUserTemplate( $url, $name, $user_token);

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host ='smtp.office365.com'; #config('PHPMAILER.PHPMAILER.smtp');
        $mail->Port = config('PHPMAILER.port');
        $mail->SMTPSecure = 'tls'; //important
        $mail->SMTPAuth = true;
        $mail->Username = config('PHPMAILER.from');
        $mail->Password = config('PHPMAILER.password');

        $mail->setFrom(config('PHPMAILER.from'), 'Portal LowCost');
        $mail->addReplyTo($to, $name);
        $mail->addAddress($to, $name);
        $mail->AddEmbeddedImage(dirname(getcwd()).'/public/logo/logo.png', 'logoimg', 'logo.jpg');

        $mail->Subject = 'Cadastro de usuarios';
        $mail->Body = $message;
        $mail->IsHTML(true);
        dd($mail);
        if (!$mail->send()) {
         echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    /** @var string configurações do servidor de email */
    //@config/PHPMAILER
}
