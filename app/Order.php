<?php

namespace DirectDigital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Order
 * @package DirectDigital
 */
class Order extends Model
{
    protected $table  = 'orders';

    protected $fillable = ['id','leadId','unitPrice','quantity','shippingCost'];

    public $timestamps = false;

    public function lead()
    {
        return $this->belongsTo('DirectDigital\Lead', 'leadId');
    }

}
