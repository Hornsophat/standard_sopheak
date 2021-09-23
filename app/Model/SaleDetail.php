<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SaleDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_id',
        'item_id',
        'price',
        'qty',
        'amount',
        'discount',
        'sale_commission'
    ];
    protected function getReadablePrice($attribute) {
        $currency_symbol = $this->getCurrencySymbol();
        $readable_price = '{$this->attributes[$attribute]} {$currency_symbol}';
        return $readable_price;
    }
    // public function getPriceAttribute() {
    //     // return $this->getReadablePrice($this->attributes["price"]);
    // }
    public function Currency() {
        // return $this->belongsTo('App\Model\Currency');
    }
    public function getCurrencySymbol() {
        // $currency = $this->Currency();
        // return $currency->value('symbol');
    }
    public function paymentHistories($order = 'desc') {
        return $this->hasMany(Payment::class, 'sale_detail_id')->orderBy('payment_date', $order);
    }
    public function sale() {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
    public function property() {
        return $this->belongsTo(Property::class, 'item_id', 'id');
    }
}