<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ZoneScope;

class WithdrawRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'amount'=>'float'
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function broker(){
        return $this->belongsTo(Broker::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }
}
