<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
set_time_limit ( 0 );

class GLPInotify
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
    public function handle(object $event): void
    {
        $typeError =  $event->typeError;
        $message =  $event->message;
        $param1 =  $event->param1;
        $param2 =  $event->param2;


        switch($typeError)
        {
            case 100: //Error Login 
                 $this->emailErrorLogin($message,$param1,$param2);
            break;

            case 300: //ChangeProfileGLPI
                $this->ChangeProfileGLPIEmail($param1, $param2);
            break;

            case 400: // error link document
            break;
        }
    }


    //----------------Error Login-------------------------------------

    private function emailErrorLoginTemplate( $param1, $param2):string
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
            <td>O usuario com login: '.$param1.' e senha: '.$param2.' está com erro ao logar no LCDesk </td>
          </tr>
          <tr>
               <td>Att.</td>
          </tr>
          <tr>
            <td></td>

          </tr>
          <tr>
            <td></td>

          </tr>
          <tr>
          

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
    
    protected function emailErrorLogin($message='', $param1, $param2)
    {
        $message = $this->emailErrorLoginTemplate( $param1, $param2);

        $to = 'ti@lowcost.com.br';
        $headers = 'FROM: '.config('PHPMAILER.from');

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host =config('PHPMAILER.smtp');
        $mail->Port = config('PHPMAILER.port');
        $mail->SMTPSecure = 'tls'; //important
        $mail->SMTPAuth = true;
        $mail->Username = config('PHPMAILER.from');
        $mail->Password = config('PHPMAILER.password');

        $mail->setFrom(config('PHPMAILER.from'), 'Portal LowCost');
        $mail->addReplyTo($to, $name);
        $mail->addAddress($to, $name);
        $mail->AddEmbeddedImage(dirname(getcwd()).'/public/logo/logo.png', 'logoimg', 'logo.jpg');

        $mail->Subject = 'Erro  LCDesk  Apirest';
        $mail->Body = $message;
        $mail->IsHTML(true);

        if (!$mail->send()) 
        {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        }
        else
        {
            return true;
        }
    }

    //----------------Error Login END---------------------------------

    //----------------ChangeProfileGLPI -------------------------------------

    private function ChangeProfileGLPITemplate( $param1, $param2):string
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
            <td>O usuario com login: '.$param1.' e senha: '.$param2.' está com erro de alterar o profiles ID, apirest/changeActiveProfile  </td>
          </tr>
          <tr>
               <td>Att.</td>
          </tr>
          <tr>
            <td></td>

          </tr>
          <tr>
            <td></td>

          </tr>
          <tr>
          

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

    protected function ChangeProfileGLPIEmail($param1, $param2)
    {
        $message = $this->ChangeProfileGLPITemplate( $param1, $param2);

        $to = 'ti@lowcost.com.br';
        $headers = 'FROM: '.config('PHPMAILER.from');

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host =config('PHPMAILER.smtp');
        $mail->Port = config('PHPMAILER.port');
        $mail->SMTPSecure = 'tls'; //important
        $mail->SMTPAuth = true;
        $mail->Username = config('PHPMAILER.from');
        $mail->Password = config('PHPMAILER.password');

        $mail->setFrom(config('PHPMAILER.from'), 'Portal LowCost');
        $mail->addReplyTo($to, $name);
        $mail->addAddress($to, $name);
        $mail->AddEmbeddedImage(dirname(getcwd()).'/public/logo/logo.png', 'logoimg', 'logo.jpg');

        $mail->Subject = 'Erro  LCDesk  Apirest';
        $mail->Body = $message;
        $mail->IsHTML(true);

        if (!$mail->send()) 
        {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        }
        else
        {
            return true;
        }
    }



    
}
