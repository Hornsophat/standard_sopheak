<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contract extends Model
{
    protected $guarded =['created_at', 'updated_at', 'deleted_at', 'id'];
}