<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Model\Role;
use App\Model\UserRole;
use App\Model\User;
use Exception;
class AppHelper{
	public static function checkAdministrator(){
        $serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
        $serial = explode("\n", $serial);
        $serial_arr = [];
        foreach ($serial as  $value) {
            $serial_arr[] = trim(str_replace(' ', '', $value));
        }
       
		try{
			$user = Auth::user();
			$administrator = 0;
			$roles = UserRole::where([
				['user_id', '=', $user->id]
			])->get();
			foreach ($roles as $role) {
				if($role->role_id==1 || $role->role_id==2){
					$administrator=1;
				}
			}
			return $administrator;
		}
		catch (Exception $e){
			return 0;
		}
	}
	public static function khNumberWord($num = false)
    {
        $serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
        $serial = explode("\n", $serial);
        $serial_arr = [];
        foreach ($serial as  $value) {
            $serial_arr[] = trim(str_replace(' ', '', $value));
        }
        $check = false;
        $serial_arr_pc_hdd = array('200659800779');
        foreach ($serial_arr_pc_hdd as $key_value) {
            if (in_array($key_value, $serial_arr)) {
                $check = true;
            }
        }

        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'មួយ', 'ពីរ', 'បី', 'បួន', 'ប្រាំ', 'ប្រាំមួយ', 'ប្រាំពីរ', 'ប្រាំបី', 'ប្រាំបួន', 'ដប់', 'ដប់មួយ',
            'ដប់ពីរ', 'ដប់បី', 'ដប់បួន', 'ដប់ប្រាំ', 'ដប់ប្រាំមួយ', 'ដប់ប្រាំពីរ', 'ដប់ប្រាំបី', 'ដប់ប្រាំបួន'
        );
        $list2 = array('', 'ដប់', 'ម្ភៃ', 'សាមសិប', 'សែសិប', 'ហាសិប', 'ហុកសិប', 'ចិតសិប', 'ប៉ែតសិប', 'កៅសិប', 'រយ');
        
        $list3 = array('', 'ពាន់', 'លាន', 'ពាន់​លាន', 'សែនកោដិ', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? '' . $list1[$hundreds] . 'រយ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? '' . $list1[$tens] . '' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = '' . $list2[$tens] . '';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = '' . $list1[$singles] . '';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? '' . $list3[$levels] . '' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode('', $words);
    }
    public static function khMonth($month_option){
    	switch ($month_option) {
    		case '01':
    			return "មករា";
    			break;
    		case '02':
    			return "កុម្ភៈ";
    			break;
    		case '03':
    			return "មីនា";
    			break;
    		case '04':
    			return "មេសា";
    			break;
    		case '05':
    			return "ឧសភា";
    			break;
    		case '06':
    			return "មិថុនា";
    			break;
    		case '07':
    			return "កក្កដា";
    			break;
    		case '08':
    			return "សីហា";
    			break;
    		case '09':
    			return "កញ្ញា";
    			break;
    		case '10':
    			return "តុលា";
    			break;
    		case '11':
    			return "វិច្ឆិកា";
    			break;
    		case '12':
    			return "ធ្នូ";
    			break;
    		default:
    			return " ";
    			break;
    	}
    }
    public static function khMultipleNumber($number){
        $khmerNumber = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        $dateNumber = (string)$number;
        $split = str_split($dateNumber, 1);
        $num_kh ='';
        foreach ($split as $num) {
            $num_kh .= isset($khmerNumber[$num])?$khmerNumber[$num]:$num;
        }
        return  $num_kh;
    }
    public static function khCharacter($index){
        $characters=[
            'ក/',
            'ខ/',
            'គ/',
            'ឃ/',
            'ង/',
            'ច/',
            'ឆ/',
            'ជ/',
            'ឈ/',
            'ញ/',
            'ដ/'
        ];
        $counter = count($characters)-1;
        if($counter<$index){
            return '';
        }else{
            return $characters[$index];
        }
    }
    public static function profile(){
        try {
            return Auth::user()->profile;//code...
        } catch (\Throwable $th) {
            return '';
        }
    }
}
?>