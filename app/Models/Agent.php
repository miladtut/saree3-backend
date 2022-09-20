<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public function wallet(){
        return $this->hasOne (AgentWallet::class);
    }

    public function vendors(){
        return $this->hasMany (Vendor::class);
    }

    public function stores(){
        return $this->hasManyThrough (Store::class,Vendor::class);
    }

    public function brokers(){
        return $this->hasMany (Broker::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
