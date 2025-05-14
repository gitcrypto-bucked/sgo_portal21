<?php

namespace Helpers;

use App\Models\ClientesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Helpers
{
   

    public static function getUserCompanyLogo($id)
    {
      return self::getLogo($id);
    }

    public static function getUserCompanyNameFormated()
    {
        $name = self::getUserCompanyName(Auth::user()->id_cliente);
        if(in_array(strtolower($name), ['sp','mg','df','rj','sc','pr','pe','mt','ms','go','ce','ba','pb'])==true)
        {
            return self::showUF($name);
        }
        else
        {
            return  self::camelCase($name);
        }
    }

    public static function getUserCompanyName($id)
    {
        $model = new ClientesModel();
        return str_replace('ç','c',$model->getCLienteNameBiUd($id));
    }

    private static function camelCase($string) {
        $string = strtolower($string);
        return ucwords($string);
    }

    public static function showUF($word)
    {
        if(str_contains($word, 'Sp'))
        {
            return str_replace("Sp",'SP',$word);
        }
        if(str_contains($word, 'Rj'))
        {
            return str_replace("Rj",'RJ',$word);
        }
        return $word;
    }


    protected static  function getLogo($id):string
    {
        $model = new ClientesModel();
        $cliente = $model->getLogo($id)[0];
        if(strlen($cliente->logo_cliente)>0)
        {
            return  asset('./clientes/'.$cliente->logo_cliente);
        }
        else
        {
            return  asset('./clientes/lowcost.svg');
        }
    }


    public static function getDatesFromRange($start, $end, $format = 'M-Y')
    {

        // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new \DateInterval('P1D');
        $realEnd = new \DateTime($end);
        $realEnd->add($interval);
        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach($period as $date){
            $array[] = $date->format($format);

        }

        // Return the array elements
        return $array;

    }


    public static  function  formatCidade($cidade)
    {
        $cidade= str_replace('(sp)','',$cidade);
        $cidade= str_replace('(mg)','',$cidade);
        $cidade= str_replace('(rj)','',$cidade);
        $cidade= str_replace('(rs)','',$cidade);
        $cidade= str_replace('(mt)','',$cidade);
        $cidade= str_replace('(sc)','',$cidade);
        $cidade= str_replace('(pr)','',$cidade);
        $cidade= str_replace('(pa)','',$cidade);
		$cidade= str_replace('(ba)','',$cidade);
		$cidade= str_replace('(sc)','',$cidade);
		$cidade= str_replace('(am)','',$cidade);
		$cidade= str_replace('(ce)','',$cidade);
		$cidade= str_replace('(go)','',$cidade);
		$cidade= str_replace('(df)','',$cidade);
		$cidade= str_replace('(rn)','',$cidade);
		$cidade= str_replace('(ma)','',$cidade);
		$cidade= str_replace('(pb)','',$cidade);
		$cidade= str_replace('(se)','',$cidade);
		$cidade= str_replace('(rn)','',$cidade);
		$cidade= str_replace('(pe)','',$cidade);
        return ucfirst($cidade);
    }

    public  static  function  formatCEP($cep)
    {
        $cep = substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
        return $cep;
    }

    public  static function format($str)
    {
        $str =str_replace("_-R$","",$str);
        $str =str_replace(" * ","",$str);
        $str =str_replace("_-","",$str);
        return $str;
    }

    public  static function sanitizeString($string) {

        // matriz de entrada
        $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á', 'Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

        // matriz de saída
        $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','ã','E','I','O','U','n','n','c','C',' ' );

        // devolver a string
        return str_replace($what, $by, $string);
    }


    public static function  formatDate($date)
    {
        if(str_contains($date, '-'))
        {
            $data = str_replace('-','/',$date);
            $date = strtotime($data);
            return date('d/m/Y',$date);
        }
        if(str_contains($date, '/'))
        {
            $date = str_replace('/','-',$date);
            return date('d/m/Y', strtotime($date));
        }
    }


    public static function getUsernameSurname($name)
    {
        list($firstName, $lastName) = explode(' ', $name);
        
        return ['firstName' => ($firstName), 'lastName' =>$lastName];
    }

    public static function buildUsernameGLPI($name)
    {       
        $randomNum = substr(str_shuffle("0123456789"), 0, 6);
        if(isset(explode(' ', $name)[1]))
        {
            list($firstName, $lastName) = explode(' ', $name);
            return trim(strtolower($firstName).'.'.strtolower(@$lastName));
        }
        else return strtolower($name).'.'.$randomNum;
        
       
    }

    public static function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'lud')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '1234567890';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if(!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public static function generateUserSigmaName($name)
    {
        list($firstName, $lastName) = explode(' ', ltrim($name));
        if($firstName !='' )
        {
            $firstName = str_split($firstName);     
        }
        if($lastName !='')
        {
            $lastName = str_split($lastName);
        }

        if(isset($firstName[0]) && isset($lastName[0]))
        {
            echo strval(strtoupper($firstName[0]).strtoupper($lastName[0]));
        }
        if(isset($firstName[0]) && !isset($lastName[0]))
        {
            echo strval(strtoupper($firstName[0]).strtoupper($firstName[1]));
        }
    }


    public static function  same($arr) {
        return $arr === array_filter($arr, function ($element) use ($arr) {
            return ($element === $arr[0]);
        });
    }


    public static function strip_tags_content($string) {

       // ----- remove HTML TAGs ----- 
        $string = preg_replace ('/<[^>]*>/', ' ', $string); 
        // ----- remove control characters ----- 
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", ' ', $string);
        $string = str_replace("\t", ' ', $string);
        // ----- remove multiple spaces ----- 
        $string = trim(preg_replace('/ {2,}/', ' ', $string));
        return $string; 
        
     }


     public static function fileType($file)
     {
        switch(pathinfo($file, PATHINFO_EXTENSION))
        {
            case 'jpg': case 'png': case 'gif': case 'webp':
                echo 'imagem';
            break;   
            case 'pdf': case 'xls': case 'xlsx': case 'doc': case 'docx':
                echo 'documento';
            break;     
        }
     }


     public static function getHeaderClienteColor($client_ID)
     {
            return strlen(DB::table('sgo_cliente')->where('id_cliente','=',$client_ID)->get(['header'])[0]->header)
                     ? DB::table('sgo_cliente')->where('id_cliente','=',$client_ID)->get(['header'])[0]->header : '#50986';
     }

     
     public static function getTextClienteColor($client_ID)
     {
            return strlen(DB::table('sgo_cliente')->where('id_cliente','=',$client_ID)->get(['text'])[0]->text)
                     ? DB::table('sgo_cliente')->where('id_cliente','=',$client_ID)->get(['text'])[0]->text : '#046b34';
     }


     public static function getItemType($item)
     {
        if(in_array($item,['IMPRESSORA','MULTIFUNCIONAL'])!=false)
        {
            return 'Printer';
        }
     }

}
