@extends('layouts.admin.app')
@section('title','Withdraw information View')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{translate('messages.agent')}} {{translate('messages.withdraw')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header p-3">
                    <h3 class="text-center text-capitalize">
                        {{translate('messages.agent')}} {{translate('messages.withdraw')}} {{translate('messages.information')}}
                    </h3>

                    <i class="tio-wallet-outlined" style="font-size: 30px"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="text-capitalize">{{translate('messages.amount')}}
                                : {{$wr->amount}}</h5>
                            <h5>{{translate('messages.request_time')}} : {{$wr->created_at}}</h5>
                        </div>
                        <div class="col-4">
                            Note : {{$wr->transaction_note}}
                        </div>
                        <div class="col-4">
                            @if ($wr->approved== 0)
                                <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                        data-target="#exampleModal">{{translate('messages.proceed')}}
                                    <i class="tio-arrow-forward"></i>
                                </button>
                            @else
                                <div class="text-center float-right text-capitalize">
                                    @if($wr->approved==1)
                                        <label class="badge badge-success p-2 rounded-bottom">
                                            {{translate('messages.approved')}}
                                        </label>
                                    @else
                                        <label class="badge badge-danger p-2 rounded-bottom">
                                            {{translate('messages.denied')}}
                                        </label>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="min-height: 260px;">
                <div class="card-header">
                    <h3 class="h3 mb-0 text-capitalize">{{translate('messages.my_bank_info')}} </h3>
                    <i class="tio tio-dollar-outlined"></i>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                        <h4>{{translate('messages.bank_name')}}
                            : {{$wr->agent && $wr->agent->bank_name ? $wr->agent->bank_name : 'No Data found'}}</h4>
                        <h6 class="text-capitalize">{{translate('messages.branch')}}
                            : {{$wr->agent && $wr->agent->branch ? $wr->agent->branch : 'No Data found'}}</h6>
                        <h6>{{translate('messages.holder_name')}}
                            : {{$wr->agent && $wr->agent->holder_name ? $wr->agent->holder_name : 'No Data found'}}</h6>
                        <h6>{{translate('messages.account_no')}}
                            : {{$wr->agent && $wr->agent->account_no ? $wr->agent->account_no : 'No Data found'}}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="min-height: 260px;">
                <div class="card-header">
                    <h3 class="h3 mb-0 "> {{translate('messages.owner')}} {{translate('messages.info')}}</h3>
                    <i class="tio tio-user-big-outlined"></i>
                </div>
                <div class="card-body">
                    @if ($wr->agent)
                        <h5>{{translate('messages.name')}} : {{$wr->agent->f_name}} {{$wr->agent->l_name}}</h5>
                        <h5>{{translate('messages.email')}} : {{$wr->agent->email}}</h5>
                        <h5>{{translate('messages.phone')}} : {{$wr->agent->phone}}</h5>
                    @else
                        <h5>{{translate('messages.store deleted!')}}</h5>
                    @endif

                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{translate('Withdraw request process')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('admin.agent.withdraw_status',[$wr->id])}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">{{translate('messages.request')}}:</label>
                                <select name="approved" class="custom-select" id="inputGroupSelect02">
                                    <option value="1">{{translate('messages.approve')}}</option>
                                    <option value="2">{{translate('messages.deny')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">{{translate('Note about transaction or
                                    request')}}:</label>
                                <textarea class="form-control" name="note" id="message-text"></textarea>
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
    </div>
</div>

@endsection

@push('script')

@endpush
