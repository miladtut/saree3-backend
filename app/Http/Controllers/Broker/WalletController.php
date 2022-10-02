<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use App\Models\BrokerWallet;
use App\Models\StoreWallet;
use App\Models\WithdrawRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\Helpers;

class WalletController extends Controller
{
    public function index()
    {
        $withdraw_req = WithdrawRequest::with(['vendor'])->where('vendor_id', Helpers::get_vendor_id())->latest()->paginate(config('default_pagination'));
        return view('vendor-views.wallet.index', compact('withdraw_req'));
    }
    public function w_request(Request $request)
    {
        $w = BrokerWallet::where('broker_id', Helpers::get_broker_id())->first();
        if ($w->balance >= $request['amount'] && $request['amount'] > .01) {
            $data = [
                'broker_id' => Helpers::get_broker_id(),
                'vendor_id'=>0,
                'amount' => $request['amount'],
                'transaction_note' => null,
                'approved' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
            DB::table('withdraw_requests')->insert($data);
            BrokerWallet::where('broker_id', Helpers::get_broker_id())->increment('pending_withdraw', $request['amount']);
            Toastr::success('Withdraw request has been sent.');
            return redirect()->back();
        }

        Toastr::error('invalid request.!');
        return redirect()->back();
    }

    public function close_request($id)
    {
        $wr = WithdrawRequest::find($id);
        if ($wr->approved == 0) {
            BrokerWallet::where('broker_id', Helpers::get_broker_id())->decrement('pending_withdraw', $wr['amount']);
        }
        $wr->delete();
        Toastr::success('request closed!');
        return back();
    }
}
