<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_id',
        'payment_date',
        'actual_payment_date',
        'amount_to_spend',
        'total_commission',
        'status'
    ];
    protected function getReadablePrice($attribute) {
        $currency_symbol = $this->getCurrencySymbol();
        $readable_price = '{$this->attributes[$attribute]} {$currency_symbol}';
        return $readable_price;
    }
    public function getPaymentAmountAttribute() {
        return $this->getReadablePrice($this->attributes["payment_amount"]);
    }
    public function Currency() {
        return $this->belongsTo('App\Model\Currency');
    }
    public function getCurrencySymbol() {
        $currency = $this->Currency();
        return $currency->value('symbol');
    }
    public function handledByEmployee() {
        return $this->belongsTo('App\Model\Employee', 'accepted_by');
    }
    public function saleDetail() {
        return $this->belongsTo('App\Model\SaleDetail', 'sale_detail_id');
    }
    public function sale_info() {
        return $this->belongsTo('App\Model\Sale', 'sale_id');
    }
    public function nextPayItem($sale_id) {
        $payment = $this::where('sale_id', $sale_id)->where('status', 1)->orderby('payment_date', 'asc')->first();
        if($payment) {
            return $payment->id;
        }
        return null;
    }
    public static function boot(){
        parent::boot();
        $model= new Payment();
        static::created(function ($model) {
            $model->preference = date('Ymd').'-'.str_pad($model->id, 6, '0', STR_PAD_LEFT);
            $model->save();
        });
    }
}