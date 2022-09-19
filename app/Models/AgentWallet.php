<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentWallet extends Model
{
    use HasFactory;

    public function getBalanceAttribute()
    {
        return $this->total_earning - ($this->total_withdrawn + $this->pending_withdraw + $this->collected_cash);
    }
}
