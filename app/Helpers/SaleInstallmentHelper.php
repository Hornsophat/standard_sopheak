<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Model\PublicHoliday;
use Exception;
use Config;
/**
 * 
 */
class SaleInstallmentHelper
{
	
	public static function payment_term($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate=0){
        $serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
        $serial = explode("\n", $serial);
        $serial_arr = [];
        foreach ($serial as  $value) {
            $serial_arr[] = trim(str_replace(' ', '', $value));
        }
      
        $loan_date = date('Y-m-d', strtotime($loan_date));
        $payment_start_date = date('Y-m-d', strtotime($payment_start_date));
        $schedules =[];
        $principle = $amount / $loan_term; 
        $principle = floatval(str_replace(',','', number_format($principle,2)));
        $k=0;
        $stored_principle = 0;
        $stored_interest = 0;
        $fixed_interest = $amount * $interest_rate / 100;
        for($index=1; $index <= $loan_term; $index++){
            $interest_per_installment = $fixed_interest;
            $default_pay_gap = $loan_term_type == 'monthly' ? 30 : 7 ;
            $pay_gap = 0;
            $interest_tobe_paid = $interest_per_installment;
            if($index == 1){
                $previous_paydate = $payment_start_date;
                $pay_gap = SaleInstallmentHelper::day($loan_date, $payment_start_date);
                $principle_tobe_paid = $principle;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = $principle - $principle_for_store_each;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                // $integer_interest = $interest_tobe_paid - $interest_for_store_each;
                //interger_interest is 0 becuase first paydate = loan_date
                $integer_interest = 0;
                $pay_total = $principle_tobe_paid + $integer_interest;
                $amount -= $principle;
                $schedules[] = array(
                    'order' => $index,
                    'pay_date'  => $payment_start_date,
                    'pay_gap'   => $pay_gap,
                    'amount'    => $principle,
                    'interest'  => $integer_interest,
                    'pay_total' => $pay_total, 
                    'balance'   => $amount
                );
            }else{
                if($loan_term_type != 'monthly'){
                    $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ ".$default_pay_gap." day"));
                }else{
                    $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ 1 month"));
                }
                $pay_date = date('Y-m-d',strtotime("$pay_date -$k day"));
                $j=0;
                $k=0;
                while ($j<=0) {
                    $public_holiday = PublicHoliday::whereDate('date', date('Y-m-d',strtotime($pay_date)))->first();
                    if(!empty($public_holiday)){
                        $pay_date = date('Y-m-d',strtotime("$pay_date +1 day"));
                        $day = InstallmentHelper::find_day($pay_date);
                        if($day=='Sat'){
                            $pay_date = date('Y-m-d',strtotime("$pay_date +2 day"));
                            $k += 2;
                        }else if($day=='Sun'){
                            $pay_date = date('Y-m-d',strtotime("$pay_date +1 day"));
                            $k++;
                        }
                        $k++;
                    }else{
                        $day = InstallmentHelper::find_day($pay_date);
                        if($day=='Sat'){
                            $pay_date = date('Y-m-d',strtotime("$pay_date +2 day"));
                            $k+=2;
                        }else if($day=='Sun'){
                            $pay_date = date('Y-m-d',strtotime("$pay_date +1 day"));
                            $k++;
                        }else{
                            $pay_date = date('Y-m-d',strtotime($pay_date));
                            $j=1;
                        }
                    }
                }
                $pay_gap = SaleInstallmentHelper::day($previous_paydate, $pay_date);
                $pay_total = $principle + $interest_tobe_paid;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = $principle - $principle_for_store_each;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
                if($index == $loan_term){
                    $principle_tobe_paid += $stored_principle;
                    $integer_interest += $stored_interest;
                }
                $pay_total = $principle_tobe_paid + $integer_interest;
                if($index == $loan_term){
                    $principle = $amount;
                    $pay_total = $principle + $integer_interest;
                    $amount = 0;
                }else{
                    $amount -= $principle;
                }
                $schedules[] = array(
                    'order' => $index,
                    'pay_date'  => $pay_date,
                    'pay_gap'   => $pay_gap,
                    'amount'    => $principle,
                    'interest'  => $integer_interest,
                    'pay_total' => $pay_total,
                    'balance'   => $amount
                );
                $previous_paydate = $pay_date;
            }
        }
        return $schedules;
    }
    public static function day($d1, $d2){
        $start = strtotime($d1);
        $end = strtotime($d2);
        $d = ceil(abs($end - $start) / 86400);
        return $d;
    }
    public static function find_day($date){
        if($date==""){
            $date = date("Y-m-d");
        }
        $nameOfDay = date('D', strtotime($date));
        return $nameOfDay;
    }
}
?>