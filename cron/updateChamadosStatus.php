<?php

include_once "conf.php";
include_once "DB.php";
include_once "GLPI.php";

include_once "../app/Actions/ChangeProfileGLPI.php";
include_once "../app/Actions/GetTicketGlpi.php";
include_once "../app/Actions/GLPI_ittilSolutions.php";


$conn = getConnction();

$logFile = fopen("logs/command_updateChamadosStatus_".date('y_m_d_h_i_s').'.log', "wb");

$SQL = "SELECT sgo_chamado.* FROM sgo_chamado       
        WHERE sgo_chamado.status ='ABERTO'
        LIMIT 1";

$stmt = $conn->query($SQL);
$chamado = $stmt->fetch();  

$numero_chamado = $chamado['numero_chamado'];

fwrite($logFile, 'numero_chamado: '.$numero_chamado.PHP_EOL);

$session_token = doGLPI_login(GLPI_LOGIN,GLPI_PASSWORD)[ 'session_token'];

$g = new \App\Actions\ChangeProfileGLPI(); 
($g->changeProfile($session_token)['status']);
unset($g);

$t = new \App\Actions\GetTicketGlpi();
$tiket = $t->getTicket($session_token,$numero_chamado);
unset($t);

if(!isset($tiket['links']))
{
    #error
   fwrite($logFile, date("Y-m-d H:i:s").'  Links dont came with ticket.');
}


for($i =0; $i< sizeof($tiket['links']); $i++)
{
    // if(str_contains($tiket['links'][$i]['href'], 'ITILFollowup') !=false)
    // {
    //     $ITILFollowup = $tiket['links'][$i]['href'];
    // }
    // if(str_contains($tiket['links'][$i]['href'], 'ITILSolution') !=false)
    // {
    //     $ITILSolution = $tiket['links'][$i]['href'];
    // }
    if($tiket['links'][$i]['rel']=='ITILSolution')
    {
         $ITILSolution = $tiket['links'][$i]['href'];
    }
    if($tiket['links'][$i]['rel']=='ITILFollowup')
    {
        $ITILFollowup = $tiket['links'][$i]['href'];
    }
 
}

$s = new \App\Actions\GLPI_ittilSolutions();
$solution = $s->getITTLSolution($session_token, $ITILSolution);
unset($s);

if(!empty($solution))
{
       fwrite($logFile, date("Y-m-d H:i:s").' Tiket status updated');

    $data = [
        'status' => "FECHADO",
        'numero_chamado' => $numero_chamado
    ];

    $SQL = "UPDATE sgo_chamado SET status=:status WHERE numero_chamado=:numero_chamado";
    $conn->prepare($SQL)->execute($data);

}
else
{
    fwrite($logFile, date("Y-m-d H:i:s").' Tiket status had not updated');
}
fclose($logFile);
exit;
