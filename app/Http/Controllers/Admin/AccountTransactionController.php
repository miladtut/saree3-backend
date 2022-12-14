<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Broker;
use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use App\Models\Store;
use App\Models\DeliveryMan;
use App\Models\AdminWallet;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class AccountTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_transaction = AccountTransaction::latest()->paginate(config('default_pagination'));
        return view('admin-views.account.index', compact('account_transaction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:store,deliveryman,agent,broker',
            'method' => 'required',
            'store_id' => 'required_if:type,store',
            'agent_id' => 'required_if:type,agent',
            'broker_id' => 'required_if:type,broker',
            'deliveryman_id' => 'required_if:type,deliveryman',
            'amount' => 'required|numeric',
        ]);

        if ($request['store_id'] && $request['deliveryman_id']) {
            $validator->getMessageBag()->add('from type', 'Can not select both deliveryman and store');
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        if ($request['store_id'] && $request['agent_id']) {
            $validator->getMessageBag()->add('from type', 'Can not select both agent and store');
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        if ($request['store_id'] && $request['broker_id']) {
            $validator->getMessageBag()->add('from type', 'Can not select both broker and store');
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        if ($request['agent_id'] && $request['deliveryman_id']) {
            $validator->getMessageBag()->add('from type', 'Can not select both deliveryman and agent');
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request['agent_id'] && $request['broker_id']) {
            $validator->getMessageBag()->add('from type', 'Can not select both agent and broker');
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        if ($request['broker_id'] && $request['deliveryman_id']) {
            $validator->getMessageBag()->add('from type', 'Can not select both deliveryman and broker');
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }


        if($request['type']=='store' && $request['store_id'])
        {
            $store = Store::findOrFail($request['store_id']);
            $data = $store->vendor;
            $current_balance = $data->wallet?$data->wallet->collected_cash:0;
        }
        else if($request['type']=='deliveryman' && $request['deliveryman_id'])
        {
            $data = DeliveryMan::findOrFail($request['deliveryman_id']);

            $current_balance = $data->wallet?$data->wallet->collected_cash:0;
        }
        else if($request['type']=='agent' && $request['agent_id'])
        {
            $data = Agent::findOrFail($request['agent_id']);

            $current_balance = $data->wallet?$data->wallet->collected_cash:0;
        }
        else if($request['type']=='broker' && $request['broker_id'])
        {
            $data = Broker::findOrFail($request['broker_id']);

            $current_balance = $data->wallet?$data->wallet->collected_cash:0;
        }

        if ($current_balance < $request['amount']) {
            $validator->getMessageBag()->add('amount', translate('messages.insufficient_balance'));
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $account_transaction = new AccountTransaction();
        $account_transaction->from_type = $request['type'];
        $account_transaction->from_id = $data->id;
        $account_transaction->method = $request['method'];
        $account_transaction->ref = $request['ref'];
        $account_transaction->amount = $request['amount'];
        $account_transaction->current_balance = $current_balance;

        try
        {
            DB::beginTransaction();
            $account_transaction->save();
            $data->wallet->decrement('collected_cash', $request['amount']);
            AdminWallet::where('admin_id', Admin::where('role_id', 1)->first()->id)->increment('manual_received', $request['amount']);
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $e;
        }

        return response()->json(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account_transaction=AccountTransaction::findOrFail($id);
        return view('admin-views.account.view', compact('account_transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AccountTransaction::where('id', $id)->delete();
        Toastr::success(translate('messages.account_transaction_removed'));
        return back();
    }
}
