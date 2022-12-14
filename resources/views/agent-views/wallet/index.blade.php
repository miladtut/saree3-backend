@extends('layouts.agent.app')

@section('title',translate('messages.store').' '.translate('messages.wallet'))

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="page-header-title text-capitalize">{{translate('messages.store')}} {{translate('messages.wallet')}}</h4>
        </div>
        <div class="card-body row">
        <?php
            $wallet = \App\Models\AgentWallet::where('agent_id',\App\CentralLogics\Helpers::get_agent_id())->first();
            if(isset($wallet)==false){
                \Illuminate\Support\Facades\DB::table('agent_wallets')->insert([
                    'agent_id'=>\App\CentralLogics\Helpers::get_agent_id(),
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
                $wallet = \App\Models\AgentWallet::where('agent_id',\App\CentralLogics\Helpers::get_agent_id())->first();
            }
        ?>
                    <!-- Earnings (Monthly) Card Example -->
            <div class="for-card col-md-4 mb-1">
                <div class="card for-card-body-2 shadow h-100 text-white"  style="background: #8d8d8d;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase for-card-text mb-1">
                                    {{translate('messages.withdraw_able_balance')}}
                                </div>
                                <div
                                    class="for-card-count">{{$wallet->balance}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"  style="background: #8d8d8d; border:none;">
                        @if(\App\CentralLogics\Helpers::get_agent_data()->account_no==null || \App\CentralLogics\Helpers::get_agent_data()->bank_name==null)
                        <a tabindex="0" class="btn btn w-100 btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="{{translate('messages.warning_missing_bank_info')}}" data-content="{{translate('messages.warning_add_bank_info')}}">{{translate('messages.request')}} {{translate('messages.withdraw')}}</a>
                        @else
                        <a class="btn w-100" style="background: #f9fafc;" href="javascript:" data-toggle="modal" data-target="#balance-modal">{{translate('messages.request')}} {{translate('messages.withdraw')}}</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <!-- Panding Withdraw Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card  shadow h-100 for-card-body-3  badge-secondary" >
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" font-weight-bold for-card-text text-uppercase mb-1">{{translate('messages.pending')}} {{translate('messages.withdraw')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->pending_withdraw}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card  shadow h-100 for-card-body-3 text-white"  style="background: #2C2E43;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" font-weight-bold for-card-text text-uppercase mb-1">{{translate('messages.withdrawn')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->total_withdrawn}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collected Cash Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card r shadow h-100 for-card-body-4  badge-dark">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" for-card-text font-weight-bold  text-uppercase mb-1">{{translate('messages.collected_cash')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->collected_cash}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card r shadow h-100 for-card-body-4 text-white" style="background:#362222;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" for-card-text font-weight-bold  text-uppercase mb-1">{{translate('messages.total_earning')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->total_earning}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{translate('messages.withdraw')}} {{translate('messages.request')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('agent.wallet.withdraw-request')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{translate('messages.amount')}}:</label>
                            <input type="number" name="amount" step="0.01"
                                    value="{{$wallet->balance}}"
                                    class="form-control" id="" min="0" max="{{$wallet->balance}}">
{{--                            <label class="col-form-label">{{translate('messages.note')}}:</label>--}}
{{--                            <textarea name="transaction_note" class="form-control">--}}

{{--                            </textarea>--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('messages.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{translate('messages.Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Content Row -->
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ translate('messages.withdraw')}} {{ translate('messages.request')}} {{ translate('messages.table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                style="width: 100%"
                                data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{translate('messages.sl#')}}</th>
                                <th>{{translate('messages.amount')}}</th>
                                <th>{{translate('messages.note')}}</th>
                                <th>{{translate('messages.request_time')}}</th>
                                <th>{{translate('messages.status')}}</th>
                                <th style="width: 5px">Close</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraw_req as $k=>$wr)
                                <tr>
                                    <td scope="row">{{$k+$withdraw_req->firstItem()}}</td>
                                    <td>{{$wr['amount']}}</td>
                                    <td>{{$wr->transaction_note}}</td>
                                    <td>{{date('Y-m-d '.config('timeformat'),strtotime($wr->created_at))}}</td>
                                    <td>
                                        @if($wr->approved==0)
                                            <label class="badge badge-primary">{{translate('messages.pending')}}</label>
                                        @elseif($wr->approved==1)
                                            <label class="badge badge-success">{{translate('messages.approved')}}</label>
                                        @else
                                            <label class="badge badge-danger">{{translate('messages.denied')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($wr->approved==0)
                                            {{-- <a href="{{route('vendor.withdraw.close',[$wr['id']])}}"
                                                class="btn btn-danger btn-sm">
                                                {{translate('messages.Delete')}}
                                            </a> --}}
                                            <a class="btn btn-sm btn-danger" href="javascript:" onclick="form_alert('withdraw-{{$wr['id']}}','Want to delete this  ?')" title="{{translate('messages.delete')}}"><i class="tio-delete-outlined"></i>
                                        </a>

                                            <form action="{{route('agent.wallet.close-request',[$wr['id']])}}"
                                                    method="post" id="withdraw-{{$wr['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        @else
                                            <label>{{translate('messages.complete')}}</label>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$withdraw_req->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
