<?php

namespace DirectDigital;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ads';

    protected $fillable = ['id','date','views'];

    public $timestamps = false;

    public function leads()
    {
        return $this->hasMany('DirectDigital\Lead','adId');
    }
}
