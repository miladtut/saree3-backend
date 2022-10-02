<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Broker extends Authenticatable
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function agent(){
        return $this->belongsTo (Agent::class);
    }

    public function getAgencyAttribute(){
        if ($this->agent){
            return $this->agent->f_name.' '.$this->agent->l_name;
        }
        return translate ('messages.agency_not_found');
    }

    public function stores(){
        return $this->hasManyThrough (Store::class,Vendor::class);
    }

    public function wallet(){
        return $this->hasOne (BrokerWallet::class);
    }

    public function scopeOwner($q){
        return $q->where('agent_id',Helpers::get_agent_id ());
    }
}
