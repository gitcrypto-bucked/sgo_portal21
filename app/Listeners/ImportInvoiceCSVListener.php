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
            if(!empty($data[$i]) && gettype($data[$i])!="boolean")
            {
              
                $SQL = "INSERT IGNORE INTO sgo_faturamento  ";
                $SQL.= "(
                        periodo,
                        periodo_cobranca_inicio,
                        periodo_cobranca_fim,
                        uni_faturamento,
                        une_faturamento,
                        departamento_faturamento,
                        cdc_faturamento,
                        nome_faturamento,
                        login_faturamento,
                        id_localidade,
                        id_equipamento,
                        
                        fila_faturamento,
                        codigo_servico_faturamento,
                        descricao_servico_faturamento,
                        grupo_descricao_servico_faturamento,
                        
                        cobrado_faturamento,
                        quantidade_duplex_faturamento,
                        volume_faturamento,
                        
                        tarifado_faturamento,
                        rateado_faturamento,
                        rateio_faturamento,
                        
                        valor_unitario_faturamento,
                        valor_total_faturamento,
                        valor_total_porcento_faturamento,
                        
                        proporcional_faturamento,
                        valor_total_geral_faturamento,
                        data_criacao
                      )";
                $SQL.= " VALUES ('".PHP_EOL.
                          date('Y-m-d', strtotime($data[$i][0]))."' , '".PHP_EOL.
                          date('Y-m-d', strtotime(str_replace('/','-',$data[$i][1])))."' , '".PHP_EOL.
                          date('Y-m-d', strtotime(str_replace('/','-',$data[$i][2])))."' , '".PHP_EOL.
                          ucfirst($data[$i][3])."' , '".PHP_EOL.
                          ucfirst($data[$i][4])."' , '".PHP_EOL.
                          ucfirst($data[$i][5])."' , '".PHP_EOL.
                          strval($data[$i][6])."' , '".PHP_EOL.
                          ucfirst($data[$i][7])."' , '".PHP_EOL.
                          ucfirst($data[$i][8])."' , ".PHP_EOL.
                          $this->getIdlocalidade($data[$i][10])." , ".PHP_EOL.
                          $this->getIdEquipamento($data[$i][11])." , '".PHP_EOL.
                          
                          strval($data[$i][12])."' , '".PHP_EOL.
                          strval($data[$i][13])."' , '".PHP_EOL.
                          strval($data[$i][14])."' , '".PHP_EOL.
                          strval($data[$i][15])."' , '".PHP_EOL.
                          
                          number_format(floatval($this->format($data[$i][16])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][17])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][18])),2)."' , '".PHP_EOL.
                          
                          number_format(floatval($this->format($data[$i][19])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][20])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][21])),2)."' , '".PHP_EOL.
                          
                          number_format(floatval($this->format($data[$i][22])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][23])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][24])),2)."' , '".PHP_EOL.
                          
                          number_format(floatval($this->format($data[$i][25])),2)."' , '".PHP_EOL.
                          number_format(floatval($this->format($data[$i][26])),2)."' , '".PHP_EOL.
                          date('Y-m-d H:i:s')."' ) ".PHP_EOL;
                          ;
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


    function getIdlocalidade($localidade)
    {
      $SQL = "SELECT id_localidade FROM sgo_localidade WHERE nome_localidade LIKE '".$localidade."'";	
      $row = DB::table('sgo_localidade')->where('nome_localidade','LIKE',$localidade)->get(['id_localidade']);
      #var_dump($row["id_localidade"]);exit;
      return intval($row[0]->id_localidade);
    }


    function getIdEquipamento($serial)
    {
        $SQL ="SELECT id_equipamento FROM sgo_equipamento WHERE serial_equipamento LIKE '".$serial."'";
        $row = DB::table('sgo_equipamento')->where('serial_equipamento','LIKE',$serial)->get(['id_equipamento']);
        return intval($row[0]->id_equipamento);

    }

    function format($str)
    {
        $str =str_replace(" R$","",$str);
        $str =str_replace(" * ","",$str);
        $str =str_replace("_-","",$str);
        return $str;
    }

    /** @var string configurações do servidor de email */
    //@config/PHPMAILER
}
