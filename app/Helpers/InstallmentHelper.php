<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Model\PublicHoliday;
use Exception;
use Config;
class InstallmentHelper{
	public static function generate_installment_schedule($loan_type, $amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate){
        $schedules =[];
        if($loan_type==Config::get('app.type_eoc')){ //baloon fix
            $schedules = InstallmentHelper::type_eoc($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate);
        }elseif($loan_type==Config::get('app.type_installment')){//declinging
            $schedules = InstallmentHelper::type_installment($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate);
        }elseif($loan_type==Config::get('app.type_simple')){//flat
            $schedules = InstallmentHelper::type_simple($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate);
        }elseif($loan_type==Config::get('app.type_emi'))
        {
            $schedules = InstallmentHelper::type_emi($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate);
        }
        elseif($loan_type==Config::get('app.type_free_interest'))
        {
            $schedules = InstallmentHelper::type_free_interest($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate);
        }
     

        return $schedules;
    }
    public static function type_emi($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate){
        $loan_date = date('Y-m-d', strtotime($loan_date));
        $payment_start_date = date('Y-m-d', strtotime($payment_start_date));
        $schedules =[];
        $principle = $amount / $loan_term; 
        $principle = floatval(str_replace(',','', number_format($principle,2)));
        $k=0;
        $stored_principle = 0;
        $stored_interest = 0;
        $fixed_interest = $amount * $interest_rate / 100;
        
        


         //native
        for($index=1; $index <= $loan_term; $index++){
            
            $interest_per_installment = $fixed_interest;
            $default_pay_gap = $loan_term_type == 'monthly' ? 30 : 7 ;
            $pay_gap = 0;
            $interest_tobe_paid = $interest_per_installment;
            if($index == 1){
                $previous_paydate = $payment_start_date;
                $pay_gap = InstallmentHelper::day($loan_date, $payment_start_date);
                $principle_tobe_paid = $principle;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = $principle - $principle_for_store_each;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
                $pay_total = $principle_tobe_paid + $integer_interest;
                // $amount -= $principle;
                
                //custom
                $integer_interest1 = $integer_interest; 
                 //custom calculate
                $pay_total1 =  $fixed_interest/(1- pow(1+$interest_rate / 100, -$loan_term));
                $principle1 =  $pay_total1-$integer_interest1;
                $amount1 = $amount - $principle1;
                 
                // $integer_interest = ($interest_rate/100)*$amount;
                $schedules[] = array(
                    'order' => $index,
                    'pay_date'  => $payment_start_date,
                    'pay_gap'   => $pay_gap,
                    'amount'    => $principle1,
                    'interest'  => $integer_interest1,
                    'pay_total' => $pay_total1, 
                    'balance'   => $amount1
                );
               
            }else{
                //custom 
                $integer_interest1 = $amount1*$interest_rate / 100; 
                //custom calculate
                $pay_total1 =  $fixed_interest/(1- pow(1+$interest_rate / 100, -$loan_term));
                $principle1 =  $pay_total1-$integer_interest1;
                $amount1 = $amount1 - $principle1;

                if($loan_term_type != 'monthly'){
                    $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ ".$default_pay_gap." day"));
                }else{
                    $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ 1 month"));
                }
                $pay_date = date('Y-m-d',strtotime("$pay_date -$k day"));
                $j=0;
                $k=0;
                while ($j<=0) {
                    // $public_holiday = PublicHoliday::whereDate('date', date('Y-m-d',strtotime($pay_date)))->first();
                    // if(!empty($public_holiday)){
                    //     $pay_date = date('Y-m-d',strtotime("$pay_date +1 day"));
                    //     $day = InstallmentHelper::find_day($pay_date);
                    //     if($day=='Sat'){
                    //         $pay_date = date('Y-m-d',strtotime("$pay_date +2 day"));
                    //         $k += 2;
                    //     }else if($day=='Sun'){
                    //         $pay_date = date('Y-m-d',strtotime("$pay_date +1 day"));
                    //         $k++;
                    //     }
                    //     $k++;
                    // }else{
                    //     $day = InstallmentHelper::find_day($pay_date);
                    //     if($day=='Sat'){
                    //         $pay_date = date('Y-m-d',strtotime("$pay_date +2 day"));
                    //         $k+=2;
                    //     }else if($day=='Sun'){
                    //         $pay_date = date('Y-m-d',strtotime("$pay_date +1 day"));
                    //         $k++;
                    //     }else{
                            $pay_date = date('Y-m-d',strtotime($pay_date));
                            $j=1;
                    //     }
                    // }
                }
                $pay_gap = InstallmentHelper::day($previous_paydate, $pay_date);
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
                
                //custom
                // $amount = $amount - $principle;
                $schedules[] = array(
                    'order' => $index,
                    'pay_date'  => $pay_date,
                    'pay_gap'   => $pay_gap,
                    'amount'    => $principle1,
                    'interest'  => $integer_interest1,
                    'pay_total' => $pay_total1,
                    'balance'   => $amount1
                );
                $previous_paydate = $pay_date;
            }
        }
        return $schedules;
    }


 public static function type_free_interest($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate){
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
        $interest_per_installment = $amount / $loan_term;
        $default_pay_gap = $loan_term_type == "monthly" ? 30 : 7 ;
        $interest_per_day = $loan_term_type == "monthly" ? $interest_per_installment / $default_pay_gap : $interest_per_installment / $default_pay_gap ;
        $pay_gap = 0;
        $interest_tobe_paid = 0;
        if ($index==1) {
            $previous_paydate = $payment_start_date;
            $pay_gap = InstallmentHelper::day($loan_date, $payment_start_date);
            $interest_tobe_paid = $pay_gap * $interest_per_day;
            $principle_tobe_paid = 0;
            $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
            $stored_interest += $interest_for_store_each;
            $integer_interest = $interest_tobe_paid - $interest_for_store_each;
            $pay_total = $interest_per_installment ;
            $schedules[] = array(
                'order' => $index,
                'pay_date'  => $payment_start_date,
                'pay_gap'   => $pay_gap,
                'amount'    => $interest_per_installment,
                'interest'  => $principle_tobe_paid,
                'pay_total' => $pay_total,
                'balance'   => $amount
            );
        }else{
            if($loan_term_type != "monthly")
            {
                $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ ".$default_pay_gap." day"));
            }else
            {
                $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ 1 month"));
            }
            $pay_date = date('Y-m-d',strtotime("$pay_date -$k day"));
            $k=0;
            $j=0;
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
            $pay_gap = InstallmentHelper::day($previous_paydate, $pay_date);
            $interest_tobe_paid = $pay_gap * $interest_per_day;
            $pay_total =  $interest_tobe_paid;
            $principle_for_store_each = $principle - $principle;
            $stored_principle += $principle_for_store_each;
            $principle_tobe_paid = 0;
            $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
            $stored_interest += $interest_for_store_each;
            $integer_interest = $interest_tobe_paid - $interest_for_store_each;
            if($index==$loan_term){
                $principle_tobe_paid += $stored_principle;
                $integer_interest += $stored_interest;
                // $principle_tobe_paid = $amount;
                $amount = 0;
            }
            $pay_total =  $interest_per_installment;


            $schedules[] = array(
                'order' => $index,
                'pay_date'  => $pay_date,
                'pay_gap'   => $pay_gap,
                'amount'    => $interest_per_installment,
                'interest'  => $principle_tobe_paid,
                'pay_total' => $pay_total,
                'balance'   => $amount
            );
            $previous_paydate = $pay_date;
        }
    }
    return $schedules;
    }

    public static function type_eoc($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate){
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
            $interest_per_installment = $amount * $interest_rate / 100;
            $default_pay_gap = $loan_term_type == "monthly" ? 30 : 7 ;
            $interest_per_day = $loan_term_type == "monthly" ? $interest_per_installment / $default_pay_gap : $interest_per_installment / $default_pay_gap ;
            $pay_gap = 0;
            $interest_tobe_paid = 0;
            if ($index==1) {
                $previous_paydate = $payment_start_date;
                $pay_gap = InstallmentHelper::day($loan_date, $payment_start_date);
                $interest_tobe_paid = $pay_gap * $interest_per_day;
                $principle_tobe_paid = 0;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
                $pay_total = $principle_tobe_paid + $interest_per_installment;
                $schedules[] = array(
                    'order' => $index,
                    'pay_date'  => $payment_start_date,
                    'pay_gap'   => $pay_gap,
                    'amount'    => $principle_tobe_paid,
                    'interest'  => $interest_per_installment,
                    'pay_total' => $pay_total,
                    'balance'   => $amount
                );
            }else{
                if($loan_term_type != "monthly")
                {
                    $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ ".$default_pay_gap." day"));
                }else
                {
                    $pay_date = date('Y-m-d', strtotime($previous_paydate . "+ 1 month"));
                }
                $pay_date = date('Y-m-d',strtotime("$pay_date -$k day"));
                $k=0;
                $j=0;
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
                $pay_gap = InstallmentHelper::day($previous_paydate, $pay_date);
                $interest_tobe_paid = $pay_gap * $interest_per_day;
                $pay_total = $principle + $interest_tobe_paid;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = 0;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
                if($index==$loan_term){
                    $principle_tobe_paid += $stored_principle;
                    $integer_interest += $stored_interest;
                    $principle_tobe_paid = $amount;
                    $amount = 0;
                }
                $pay_total = $principle_tobe_paid + $interest_per_installment;


                $schedules[] = array(
                    'order' => $index,
                    'pay_date'  => $pay_date,
                    'pay_gap'   => $pay_gap,
                    'amount'    => $principle_tobe_paid,
                    'interest'  => $interest_per_installment,
                    'pay_total' => $pay_total,
                    'balance'   => $amount
                );
                $previous_paydate = $pay_date;
            }
        }
        return $schedules;
    }
  
    public static function type_installment($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate){
        $schedules=[];
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
            $interest_per_installment = $amount * $interest_rate / 100;
            $interest_per_installment = floatval(str_replace(',','', number_format($interest_per_installment,2)));
            $default_pay_gap = $loan_term_type == 'monthly' ? 30 : 7 ;
            $interest_per_day = $loan_term_type == 'monthly' ? $interest_per_installment / $default_pay_gap : $interest_per_installment / $default_pay_gap ;
            $pay_gap = 0;
            $interest_tobe_paid = 0;
            if($index==1){
                $previous_paydate = $payment_start_date;
                $pay_gap = InstallmentHelper::day($loan_date, $payment_start_date);
                $interest_tobe_paid = $pay_gap * $interest_per_day;
                $principle_tobe_paid = $principle;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = $principle - $principle_for_store_each;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
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
                if($loan_term_type != 'monthly')
                {
                    $pay_date = date('Y-m-d', strtotime($previous_paydate ." + ".$default_pay_gap." day"));
                }else
                {
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
                $pay_gap = InstallmentHelper::day($previous_paydate, $pay_date);
                $interest_tobe_paid = $pay_gap * $interest_per_day;
                $pay_total = $principle + $interest_tobe_paid;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = $principle - $principle_for_store_each;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
                if($index == $loan_term)
                {
                    $principle_tobe_paid += $stored_principle;
                    $integer_interest += $stored_interest;
                }
                $pay_total = $principle_tobe_paid + $integer_interest;
                if($index == $loan_term)
                {
                    $principle = $amount;
                    $pay_total = $principle + $integer_interest;
                    
                    $amount = 0;
                }else
                {
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
    public static function type_simple($amount ,$loan_term, $loan_term_type, $loan_date, $payment_start_date,$interest_rate){
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
                $pay_gap = InstallmentHelper::day($loan_date, $payment_start_date);
                $principle_tobe_paid = $principle;
                $principle_for_store_each = $principle - $principle;
                $stored_principle += $principle_for_store_each;
                $principle_tobe_paid = $principle - $principle_for_store_each;
                $interest_for_store_each = $interest_tobe_paid - $interest_tobe_paid;
                $stored_interest += $interest_for_store_each;
                $integer_interest = $interest_tobe_paid - $interest_for_store_each;
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
                $pay_gap = InstallmentHelper::day($previous_paydate, $pay_date);
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