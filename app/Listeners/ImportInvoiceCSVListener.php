<?php

namespace App\Listeners;

use App\Events\ImportInvoiceCSV;
use App\Http\Controllers\NotificationController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPUnit\Event\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

ini_set('memory_limit', '-1');
set_time_limit(0);
class ImportInvoiceCSVListener
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
    public function handle(ImportInvoiceCSV $event): void
    {
        $data = $event->data;
        $email = $event->email;

        //data[0] = headers
        $ok = false;
        for($i = 1; $i < count($data); $i++)
        {

            if(!empty($data[$i]))
            {
                $SQL ="INSERT INTO www_portal.faturamento
                    (
                     periodo_inicio,
                     periodo_fim,
                     uni_fat,
                     une,
                     depto,
                     cdc,
                     nome,
                     login,
                     cliente,
                     localidade,
                     serial,
                     fila,
                     cod_servico,
                     servico,
                     grupo_servico,
                     cobrado,
                     qtde_duplex,
                     volume,
                     tarifado,
                     rateado,
                     rateio,
                     valor_unit,
                     valor_total,
                     total_percent,
                     proporcional,
                     total_geral,
                     created_at)";

                $SQL.="VALUES('".$data[$i][0]."','"
                    .$data[$i][1]."','"
                    .$data[$i][2]."','"
                    .$data[$i][3]."','"
                    .$data[$i][4]."','"
                    .$data[$i][5]."','"
                    .$data[$i][6]."','"
                    .$data[$i][7]."','"
                    .$data[$i][8]."','"
                    .$data[$i][9]."','"
                    .$data[$i][10]."','"
                    .$data[$i][11]."','"
                    .$data[$i][12]."','"
                    .$data[$i][13]."','"
                    .$data[$i][14]."','"
                    .$data[$i][15]."','"
                    .$data[$i][16]."','"
                    .$data[$i][17]."','"
                    .$data[$i][18]."','"
                    .$data[$i][19]."','"
                    .$data[$i][20]."','"
                    .floatval($data[$i][21])."','"
                    .floatval($data[$i][22])."','"
                    .$data[$i][23]."','"
                    .$data[$i][24]."','"
                    .floatval($data[$i][25])."','"
                    .date('Y-m-d H:i:s')."')";
                $ok= DB::unprepared($SQL);
            }
            else
            {
                $ok=true;
                break;
            }
        }
        if($ok)
        {
            $notification = new NotificationController();
            $notification->addNewNotification('Seu arquivo foi processado com sucesso','system',Auth::user()->email);
            try {
                $this->sendNewUserMail(Auth::user()->email,Auth::user()->name);
                Artisan::addCommands('optimize:clear');
            }
            catch (\Exception $exception)
            {
                Log::info($exception->getMessage());
            }
        }
    }

    private function getJobDoneTemplate( $name):string
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
            <td>Caro(a) '.$name.',</td>
          </tr>
          <tr>
               <td>Seu arquivo `faturamento.csv` foi processado com sucesso</td>
          </tr>

          <tr>
            <td></td>

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

    private function sendNewUserMail($to, $name):bool
    {
        $headers = 'FROM: '.config('PHPMAILER.from');
        $message = self::getJobDoneTemplate(  $name);

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

        $mail->Subject = 'Arquivo porcessado';
        $mail->Body = $message;
        $mail->IsHTML(true);
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
