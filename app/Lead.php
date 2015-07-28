<?php

namespace DirectDigital;

use Illuminate\Database\Eloquent\Model;

/**
 * The ORM Layer to the Orders
 *
 * Class Lead
 * @package DirectDigital
 */
class Lead extends Model
{
    protected $table = 'leads';

    protected $fillable = ['id', 'birthDate', 'adId','state','createdAt'];

    public $timestamps = false;

    public function ad()
    {
        return $this->belongsTo('DirectDigital\Ad','adId');
    }

    public function orders()
    {
        return $this->hasMany('DirectDigital\Order','leadId');
    }
}
