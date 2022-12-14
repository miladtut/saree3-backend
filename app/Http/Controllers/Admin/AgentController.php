<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agent;
use App\Models\AgentWallet;
use App\Models\Zone;
use App\Models\AddOn;
use App\Models\Store;
use App\Models\Module;
use App\Models\Vendor;
use App\Scopes\StoreScope;
use App\Models\StoreWallet;
use Illuminate\Http\Request;
use App\Models\StoreSchedule;
use App\CentralLogics\Helpers;
use App\Models\WithdrawRequest;
use App\CentralLogics\StoreLogic;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class AgentController extends Controller
{
    public function index()
    {
        return view('admin-views.agent.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'email' => 'required|unique:agents',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:agents',
            'password' => 'required|min:6',
            'logo' => 'required',
        ], [
            'f_name.required' => translate('messages.first_name_is_required')
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $agent = new Agent();
        $agent->f_name = $request->f_name;
        $agent->l_name = $request->l_name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->password = bcrypt($request->password);
        $agent->image = Helpers::upload('agent/', 'png', $request->file('logo'));
        $agent->status = 1;
        $agent->save();

        // $store->zones()->attach($request->zone_ids);
        Toastr::success(translate('messages.store').translate('messages.added_successfully'));
        return redirect('admin/agent/list');
    }

    public function edit($id)
    {
        if(env('APP_MODE')=='demo' && $id == 2)
        {
            Toastr::warning(translate('messages.you_can_not_edit_this_store_please_add_a_new_store_to_edit'));
            return back();
        }
        $agent = Agent::findOrFail($id);
        return view('admin-views.agent.edit', compact('agent'));
    }

    public function update($agent,Request $request)
    {
        $agent = Agent::query ()->findOrFail ($agent);
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'email' => 'required|unique:agents,email,'.$agent->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:agents,phone,'.$agent->id,
            'password' => 'nullable|min:6',
        ], [
            'f_name.required' => translate('messages.first_name_is_required')
        ]);


        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $agent->f_name = $request->f_name;
        $agent->l_name = $request->l_name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->password = strlen($request->password)>1?bcrypt($request->password):$agent->password;


        if ($request->hasFile ('logo')){
            $agent->image = Helpers::upload('agent/', 'png', $request->file('logo'));
        }


        $agent->save();


        Toastr::success(translate('messages.store').translate('messages.updated_successfully'));
        return redirect('admin/agent/list');
    }

    public function destroy($agent,Request $request)
    {
        $agent = Agent::query ()->findOrFail ($agent);
        if(env('APP_MODE')=='demo' && $agent->id == 2)
        {
            Toastr::warning(translate('messages.you_can_not_delete_this_agent_please_add_a_new_agent_to_delete'));
            return back();
        }
        if (Storage::disk('public')->exists('agent/' . $agent['image'])) {
            Storage::disk('public')->delete('agent/' .  $agent['image']);
        }
        $agent->delete();

        Toastr::success(translate('messages.agent').' '.translate('messages.removed'));
        return back();
    }

    public function view(Agent $agent, $tab=null, $sub_tab='cash')
    {
        $wallet = $agent->wallet;
        if(!$wallet)
        {
            $wallet= new AgentWallet();
            $wallet->agent_id = $agent->id;
            $wallet->total_earning= 0.0;
            $wallet->total_withdrawn=0.0;
            $wallet->pending_withdraw=0.0;
            $wallet->created_at=now();
            $wallet->updated_at=now();
            $wallet->save();
        }

        if($tab == 'store')
        {
            return view('admin-views.agent.view.store', compact('agent'));
        }
        else if($tab == 'broker')
        {
            return view('admin-views.agent.view.broker', compact('agent'));
        }
        else if($tab == 'dm')
        {
            return view('admin-views.agent.view.dm', compact('agent'));
        }
        else if($tab == 'transaction')
        {
            return view('admin-views.agent.view.transaction', compact('agent', 'sub_tab'));
        }

        return view('admin-views.agent.view.index', compact('agent', 'wallet'));
    }



    public function list(Request $request)
    {
        $agents = Agent::latest()->paginate(config('default_pagination'));
        return view('admin-views.agent.list', compact('agents'));
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $agents=Agent::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })
       ->get();
        $total=$agents->count();
        return response()->json([
            'view'=>view('admin-views.agent.partials._table',compact('agents'))->render(), 'total'=>$total
        ]);
    }

    public function status($agent, Request $request)
    {
        $agent = Agent::query ()->findOrFail ($agent);
        $agent->status = $request->status;
        $agent->save();
        Toastr::success(translate('messages.agent').translate('messages.status_updated'));
        return back();
    }

    //-----------------------------------------------------


    public function view_tab(Store $store)
    {

        Toastr::error(translate('messages.unknown_tab'));
        return back();
    }

    public function get_agents(Request $request){
        $key = explode(' ', $request->q);
        $data=Agent::when($request->earning, function($query){
            return $query->earning();
        })
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%");
                }
            })->active()->limit(8)->get(['id',DB::raw('CONCAT(f_name, " ", l_name) as text')]);
        return response()->json($data);
    }

    public function store_status(Store $store, Request $request)
    {
        if($request->menu == "schedule_order" && !Helpers::schedule_order())
        {
            Toastr::warning(translate('messages.schedule_order_disabled_warning'));
            return back();
        }

        if((($request->menu == "delivery" && $store->take_away==0) || ($request->menu == "take_away" && $store->delivery==0)) &&  $request->status == 0 )
        {
            Toastr::warning(translate('messages.can_not_disable_both_take_away_and_delivery'));
            return back();
        }

        if((($request->menu == "veg" && $store->non_veg==0) || ($request->menu == "non_veg" && $store->veg==0)) &&  $request->status == 0 )
        {
            Toastr::warning(translate('messages.veg_non_veg_disable_warning'));
            return back();
        }
        if($request->menu == "self_delivery_system" && $request->status == '0') {
            $store['free_delivery'] = 0;
        }

        $store[$request->menu] = $request->status;
        $store->save();
        Toastr::success(translate('messages.store').translate('messages.settings_updated'));
        return back();
    }

    public function discountSetup(Store $store, Request $request)
    {
        $message=translate('messages.discount');
        $message .= $store->discount?translate('messages.updated_successfully'):translate('messages.added_successfully');
        $store->discount()->updateOrinsert(
        [
            'store_id' => $store->id
        ],
        [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'min_purchase' => $request->min_purchase != null ? $request->min_purchase : 0,
            'max_discount' => $request->max_discount != null ? $request->max_discount : 0,
            'discount' => $request->discount_type == 'amount' ? $request->discount : $request['discount'],
            'discount_type' => 'percent'
        ]
        );
        return response()->json(['message'=>$message], 200);
    }

    public function updateStoreSettings(Store $store, Request $request)
    {
        $request->validate([
            'minimum_order'=>'required',
            'comission'=>'required',
            'tax'=>'required',
            'minimum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
            'maximum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
        ]);

        if($request->comission_status)
        {
            $store->comission = $request->comission;
        }
        else{
            $store->comission = null;
        }

        $store->minimum_order = $request->minimum_order;
        $store->tax = $request->tax;
        $store->order_place_to_schedule_interval = $request->order_place_to_schedule_interval;
        $store->delivery_time = $request->minimum_delivery_time .'-'. $request->maximum_delivery_time.' '.$request->delivery_time_type;

        $store->save();
        Toastr::success(translate('messages.store').translate('messages.settings_updated'));
        return back();
    }

    public function update_application(Request $request)
    {
        $store = Store::findOrFail($request->id);
        $store->vendor->status = $request->status;
        $store->vendor->save();
        if($request->status) $store->status = 1;
        $store->save();
        try{
            if ( config('mail.status') ) {
                Mail::to($request['email'])->send(new \App\Mail\SelfRegistration($request->status==1?'approved':'denied', $store->vendor->f_name.' '.$store->vendor->l_name));
            }
        }catch(\Exception $ex){
            info($ex);
        }
        Toastr::success(translate('messages.application_status_updated_successfully'));
        return back();
    }

    public function cleardiscount(Store $store)
    {
        $store->discount->delete();
        Toastr::success(translate('messages.store').translate('messages.discount_cleared'));
        return back();
    }

    public function withdraw()
    {
        $all = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all' ? 1 : 0;
        $active = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved' ? 1 : 0;
        $denied = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied' ? 1 : 0;
        $pending = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending' ? 1 : 0;

        $withdraw_req =WithdrawRequest::whereHas('agent')->with(['agent'])
            ->when($all, function ($query) {
                return $query;
            })
            ->when($active, function ($query) {
                return $query->where('approved', 1);
            })
            ->when($denied, function ($query) {
                return $query->where('approved', 2);
            })
            ->when($pending, function ($query) {
                return $query->where('approved', 0);
            })
            ->latest()
            ->paginate(config('default_pagination'));

        return view('admin-views.wallet.agent.withdraw', compact('withdraw_req'));
    }

    public function withdraw_view($withdraw_id, $agent_id)
    {
        $wr = WithdrawRequest::whereHas('agent')->with(['agent'])->where(['id' => $withdraw_id])->first();
        return view('admin-views.wallet.agent.withdraw-view', compact('wr'));
    }

    public function status_filter(Request $request){
        session()->put('withdraw_status_filter',$request['withdraw_status_filter']);
        return response()->json(session('withdraw_status_filter'));
    }

    public function withdrawStatus(Request $request, $id)
    {
        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->approved = $request->approved;
        $withdraw->transaction_note = $request['note'];
        if ($request->approved == 1) {
            AgentWallet::where('agent_id', $withdraw->agent_id)->increment('total_withdrawn', $withdraw->amount);
            AgentWallet::where('agent_id', $withdraw->agent_id)->decrement('pending_withdraw', $withdraw->amount);
            $withdraw->save();
            Toastr::success(translate('messages.agent_payment_approved'));
            return redirect()->route('admin.agent.withdraw_list');
        } else if ($request->approved == 2) {
            AgentWallet::where('agent_id', $withdraw->agent_id)->decrement('pending_withdraw', $withdraw->amount);
            $withdraw->save();
            Toastr::info(translate('messages.agent_payment_denied'));
            return redirect()->route('admin.agent.withdraw_list');
        } else {
            Toastr::error(translate('messages.not_found'));
            return back();
        }
    }

    public function get_addons(Request $request)
    {
        $cat = AddOn::withoutGlobalScope(StoreScope::class)->withoutGlobalScope('translate')->where(['store_id' => $request->store_id])->active()->get();
        $res = '';
        foreach ($cat as $row) {
            $res .= '<option value="' . $row->id.'"';
            if(count($request->data))
            {
                $res .= in_array($row->id, $request->data)?'selected':'';
            }
            $res .=  '>' . $row->name . '</option>';
        }
        return response()->json([
            'options' => $res,
        ]);
    }

    public function get_store_data(Store $store)
    {
        return response()->json($store);
    }

    public function store_filter($id)
    {
        if ($id == 'all') {
            if (session()->has('store_filter')) {
                session()->forget('store_filter');
            }
        } else {
            session()->put('store_filter', Store::where('id', $id)->first(['id', 'name']));
        }
        return back();
    }

    public function get_account_data(Agent $agent)
    {
        $wallet = $agent->wallet;
        $cash_in_hand = 0;
        $balance = 0;

        if($wallet)
        {
            $cash_in_hand = $wallet->collected_cash;
            $balance = $wallet->total_earning - $wallet->total_withdrawn - $wallet->pending_withdraw - $wallet->collected_cash;
        }
        return response()->json(['cash_in_hand'=>$cash_in_hand, 'earning_balance'=>$balance], 200);

    }

    public function bulk_import_index()
    {
        return view('admin-views.vendor.bulk-import');
    }

    public function bulk_import_data(Request $request)
    {
        $request->validate([
            'module_id'=>'required_if:stackfood,1',
            'products_file'=>'required|file'
        ]);
        try {
            $collections = (new FastExcel)->import($request->file('products_file'));
        } catch (\Exception $exception) {
            Toastr::error(translate('messages.you_have_uploaded_a_wrong_format_file'));
            return back();
        }
        $duplicate_phones = $collections->duplicates('phone');
        $duplicate_emails = $collections->duplicates('email');

        // dd(['Phone'=>$duplicate_phones, 'Email'=>$duplicate_emails]);
        if($duplicate_emails->isNotEmpty())
        {
            Toastr::error(translate('messages.duplicate_data_on_column',['field'=>translate('messages.email')]));
            return back();
        }

        if($duplicate_phones->isNotEmpty())
        {
            Toastr::error(translate('messages.duplicate_data_on_column',['field'=>translate('messages.phone')]));
            return back();
        }

        $vendors = [];
        $stores = [];
        $vendor = Vendor::orderBy('id', 'desc')->first('id');
        $vendor_id = $vendor?$vendor->id:0;
        $store = Store::orderBy('id', 'desc')->first('id');
        $store_id = $store?$store->id:0;
        $store_ids = [];
        foreach ($collections as $key=>$collection) {
                if ($collection['ownerFirstName'] === "" || $collection['storeName'] === "" || $collection['phone'] === "" || $collection['email'] === "" || $collection['latitude'] === "" || $collection['longitude'] === "" || $collection['zone_id'] === "" || $collection['module_id'] === "") {
                    Toastr::error(translate('messages.please_fill_all_required_fields'));
                    return back();
                }


            array_push($vendors, [
                'id'=>$vendor_id+$key+1,
                'f_name' => $collection['ownerFirstName'],
                'l_name' => $collection['ownerLastName'],
                'password' => bcrypt(12345678),
                'phone' => $collection['phone'],
                'email' => $collection['email'],
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
            array_push($stores, [
                'id'=>$store_id+$key+1,
                'name' => $request->stackfood?$collection['restaurantName']:$collection['storeName'],
                'logo' => $collection['logo'],
                'phone' => $collection['phone'],
                'email' => $collection['email'],
                'latitude' => $collection['latitude'],
                'longitude' => $collection['longitude'],
                'vendor_id' => $vendor_id+$key+1,
                'zone_id' => $collection['zone_id'],
                'delivery_time' => (isset($collection['delivery_time']) && preg_match('([0-9]+[\-][0-9]+\s[min|hours|days])', $collection['delivery_time'])) ? $collection['delivery_time'] :'30-40 min',
                'module_id' => $request->stackfood?$request->module_id:$collection['module_id'],
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
            if($module = Module::select('module_type')->where('id', $collection['module_id'])->first())
            {
                if(config('module.'.$module->module_type))
                {
                    $store_ids[] = $store_id+$key+1;
                }
            }

        }

        $data = array_map(function($id){
            return array_map(function($item)use($id){
                return     ['store_id'=>$id,'day'=>$item,'opening_time'=>'00:00:00','closing_time'=>'23:59:59'];
            },[0,1,2,3,4,5,6]);
        },$store_ids);

        try{
            DB::beginTransaction();
            DB::table('vendors')->insert($vendors);
            DB::table('stores')->insert($stores);
            DB::table('store_schedule')->insert(array_merge(...$data));
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollBack();
            info($e);
            Toastr::error(translate('messages.failed_to_import_data'));
            return back();
        }

        Toastr::success(translate('messages.store_imported_successfully',['count'=>count($stores)]));
        return back();
    }

    public function bulk_export_index()
    {
        return view('admin-views.vendor.bulk-export');
    }

    public function bulk_export_data(Request $request)
    {
        $request->validate([
            'type'=>'required',
            'start_id'=>'required_if:type,id_wise',
            'end_id'=>'required_if:type,id_wise',
            'from_date'=>'required_if:type,date_wise',
            'to_date'=>'required_if:type,date_wise'
        ]);
        $vendors = Vendor::with('stores')
        ->when($request['type']=='date_wise', function($query)use($request){
            $query->whereBetween('created_at', [$request['from_date'].' 00:00:00', $request['to_date'].' 23:59:59']);
        })
        ->when($request['type']=='id_wise', function($query)use($request){
            $query->whereBetween('id', [$request['start_id'], $request['end_id']]);
        })
        ->get();
        return (new FastExcel(StoreLogic::format_export_stores($vendors)))->download('Stores.xlsx');
    }

    public function add_schedule(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'start_time'=>'required|date_format:H:i',
            'end_time'=>'required|date_format:H:i|after:start_time',
            'store_id'=>'required',
        ],[
            'end_time.after'=>translate('messages.End time must be after the start time')
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $temp = StoreSchedule::where('day', $request->day)->where('store_id',$request->store_id)
        ->where(function($q)use($request){
            return $q->where(function($query)use($request){
                return $query->where('opening_time', '<=' , $request->start_time)->where('closing_time', '>=', $request->start_time);
            })->orWhere(function($query)use($request){
                return $query->where('opening_time', '<=' , $request->end_time)->where('closing_time', '>=', $request->end_time);
            });
        })
        ->first();

        if(isset($temp))
        {
            return response()->json(['errors' => [
                ['code'=>'time', 'message'=>translate('messages.schedule_overlapping_warning')]
            ]]);
        }

        $store = Store::find($request->store_id);
        $store_schedule = StoreLogic::insert_schedule($request->store_id, [$request->day], $request->start_time, $request->end_time.':59');

        return response()->json([
            'view' => view('admin-views.vendor.view.partials._schedule', compact('store'))->render(),
        ]);
    }

    public function remove_schedule($store_schedule)
    {
        $schedule = StoreSchedule::find($store_schedule);
        if(!$schedule)
        {
            return response()->json([],404);
        }
        $store = $schedule->store;
        $schedule->delete();
        return response()->json([
            'view' => view('admin-views.vendor.view.partials._schedule', compact('store'))->render(),
        ]);
    }

    public function featured(Request $request)
    {
        $store = Store::findOrFail($request->store);
        $store->featured = $request->status;
        $store->save();
        Toastr::success(translate('messages.store_featured_status_updated'));
        return back();
    }
}
