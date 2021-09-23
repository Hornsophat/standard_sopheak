<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
class Sale extends Model
{
    use SoftDeletes, Sortable;
    protected $fillable = [
        'preference',
        'customer_id',
        'employee_id',
        'sale_date',
        'total_price',
        'description',
        'remark',
        'payment_timeline_id',
        'total_sale_commission',
        'grand_total',
        'total_discount',
        'status',
        'deposit'
    ];
    public function soleToCustomer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function soldByEmployee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function salesDetail() {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
    public function salePayments($order = 'desc') {
        return $this->hasManyThrough(
            'App\Model\Payment', 
            'App\Model\SaleDetail', 
            'sale_id', 
            'sale_detail_id', 
            'id', 
            'id'
        )->orderBy('payment_date', $order);
    }
   public function payment()
   {
       return $this->hasMany(Payment::class, 'sale_id', 'id');
   }
   // public function paymentCommission(){
   //     return $this->hasMany(Payment::class, 'sale_id', 'id')->where('status', '=', 2);
   // }
    public $sortable = ['id',
        'customer_id',
        'employee_id',
        'payment_timeline_id',
        'sale_date',
        'total_price',
        'total_sale_commission',
        'total_discount',
        'grand_total',
        'remark'
    ];
    public static function boot(){
        parent::boot();
        $model= new Sale();
        static::created(function ($model) {
            $model->reference = date('Ymd').'-'.str_pad($model->id, 6, '0', STR_PAD_LEFT);
            $model->save();
        });
    }
}