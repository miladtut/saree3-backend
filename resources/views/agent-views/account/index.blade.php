@extends('layouts.agent.app')

@section('title',translate('messages.account_transaction'))

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('agent.dashboard')}}">{{translate('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{translate('messages.account_transaction')}}  </li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <!-- <h4 class=" mb-0 text-black-50">{{translate('messages.account_transaction')}}</h4> -->
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="text-capitalize">{{translate('messages.add')}} {{translate('messages.account_transaction')}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('agent.account-transaction.store')}}" method='post' id="add_transaction">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="input-label" for="type">{{translate('messages.type')}}<span class="input-label-secondary"></span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="deliveryman">{{translate('messages.deliveryman')}}</option>
{{--                                <option value="store">{{translate('messages.store')}}</option>--}}
{{--                                <option value="agent">{{translate('messages.agent')}}</option>--}}
{{--                                <option value="broker">{{translate('messages.broker')}}</option>--}}
                            </select>
                        </div>
                    </div>
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="input-label" for="store">{{translate('messages.store')}}<span class="input-label-secondary"></span></label>--}}
{{--                            <select id="store" name="store_id" data-placeholder="{{translate('messages.select')}} {{translate('messages.store')}}" onchange="getAccountData('{{url('/')}}/admin/vendor/get-account-data/',this.value,'store')" class="form-control" title="Select Restaurant" disabled>--}}

{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="deliveryman">{{translate('messages.deliveryman')}}<span class="input-label-secondary"></span></label>
                            <select id="deliveryman" name="deliveryman_id" data-placeholder="{{translate('messages.select')}} {{translate('messages.deliveryman')}}" onchange="getAccountData('{{url('/')}}/admin/delivery-man/get-account-data/',this.value,'deliveryman')" class="form-control" title="Select deliveryman">

                            </select>
                        </div>
                    </div>

{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="input-label" for="agent">{{translate('messages.agent')}}<span class="input-label-secondary"></span></label>--}}
{{--                            <select id="agent" name="agent_id" data-placeholder="{{translate('messages.select')}} {{translate('messages.agent')}}" onchange="getAccountData('{{url('/')}}/admin/agent/get-account-data/',this.value,'agent')" class="form-control" title="Select agent" disabled>--}}

{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="input-label" for="broker">{{translate('messages.broker')}}<span class="input-label-secondary"></span></label>--}}
{{--                            <select id="broker" name="broker_id" data-placeholder="{{translate('messages.select')}} {{translate('messages.broker')}}" onchange="getAccountData('{{url('/')}}/admin/broker/get-account-data/',this.value,'broker')" class="form-control" title="Select broker" disabled>--}}

{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="method">{{translate('messages.method')}}<span class="input-label-secondary"></span></label>
                            <input class="form-control" type="text" name="method" id="method" required maxlength="191">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="ref">{{translate('messages.reference')}}<span class="input-label-secondary"></span></label>
                            <input  class="form-control" type="text" name="ref" id="ref" maxlength="191">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="amount">{{translate('messages.amount')}}<span class="input-label-secondary" id="account_info"></span></label>
                            <input class="form-control" type="number" min=".01" step="0.01" name="amount" id="amount" max="999999999999.99">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{{translate('messages.save')}}" >
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ translate('messages.account_transaction')}} {{ translate('messages.table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{translate('messages.sl#')}}</th>
                                    <th>{{ translate('messages.received_from') }}</th>
                                    <th>{{ translate('messages.type') }}</th>
                                    <th>{{translate('messages.received_at')}}</th>
                                    <th>{{translate('messages.amount')}}</th>
                                    <th>{{translate('messages.reference')}}</th>
                                    <th style="width: 5px">{{translate('messages.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($account_transaction as $k=>$at)
                                <tr>
                                    <td scope="row">{{$k+$account_transaction->firstItem()}}</td>
                                    <td>
                                        @if($at->store)
                                        <a href="{{route('admin.vendor.view',[$at->store['id']])}}">{{ Str::limit($at->store->name, 20, '...') }}</a>
                                        @elseif($at->deliveryman)
                                        <a href="{{route('agent.delivery-man.preview',[$at->deliveryman->id])}}">{{ $at->deliveryman->f_name }} {{ $at->deliveryman->l_name }}</a>
                                        @elseif($at->agent)
                                        <a href="{{route('admin.agent.view',[$at->agent['id']])}}">{{ $at->agent->f_name }} {{ $at->agent->l_name }}</a>
                                        @elseif($at->broker)
                                        <a href="{{route('admin.broker.view',[$at->broker['id']])}}">{{ $at->broker->f_name }} {{ $at->broker->l_name }}</a>
                                        @else
                                            {{translate('messages.not_found')}}
                                        @endif
                                    </td>
                                    <td><label class="text-uppercase">{{$at['from_type']}}</label></td>
                                    <td>{{$at->created_at->format('Y-m-d '.config('timeformat'))}}</td>
                                    <td>{{$at['amount']}}</td>
                                    <td>{{$at['ref']}}</td>
                                    <td>
                                        <a href="{{route('agent.account-transaction.show',[$at['id']])}}"
                                        class="btn btn-white btn-sm"><i class="tio-visible"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$account_transaction->links()}}
                </div>
            </div>
        </div>
     </div>
</div>
@endsection

@push('script_2')
<script>
    $(document).on('ready', function () {
        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });

        $('#type').on('change', function() {
            if($('#type').val() == 'store')
            {
                $('#store').removeAttr("disabled");
                $('#deliveryman').val("").trigger( "change" );
                $('#deliveryman').attr("disabled","true");
                $('#agent').val("").trigger( "change" );
                $('#agent').attr("disabled","true");
                $('#broker').val("").trigger( "change" );
                $('#broker').attr("disabled","true");
            }
            else if($('#type').val() == 'deliveryman')
            {
                $('#deliveryman').removeAttr("disabled");
                $('#store').val("").trigger( "change" );
                $('#store').attr("disabled","true");
                $('#agent').val("").trigger( "change" );
                $('#agent').attr("disabled","true");
                $('#broker').val("").trigger( "change" );
                $('#broker').attr("disabled","true");
            }
            else if($('#type').val() == 'agent')
            {
                $('#agent').removeAttr("disabled");
                $('#store').val("").trigger( "change" );
                $('#store').attr("disabled","true");
                $('#deliveryman').val("").trigger( "change" );
                $('#deliveryman').attr("disabled","true");
                $('#broker').val("").trigger( "change" );
                $('#broker').attr("disabled","true");
            }
            else if($('#type').val() == 'broker')
            {
                $('#broker').removeAttr("disabled");
                $('#store').val("").trigger( "change" );
                $('#store').attr("disabled","true");
                $('#deliveryman').val("").trigger( "change" );
                $('#deliveryman').attr("disabled","true");
                $('#agent').val("").trigger( "change" );
                $('#agent').attr("disabled","true");
            }
        });
    });
    $('#store').select2({
        ajax: {
            url: '{{url('/')}}/admin/vendor/get-stores',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#deliveryman').select2({
        ajax: {
            url: '{{url('/')}}/agent-panel/delivery-man/get-deliverymen',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#agent').select2({
        ajax: {
            url: '{{url('/')}}/admin/agent/get-agents',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);
                $request.then(success);
                $request.fail(failure);
                return $request;
            }
        }
    });
    $('#broker').select2({
        ajax: {
            url: '{{url('/')}}/admin/broker/get-brokers',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    function getAccountData(route, data_id, type)
    {
        $.get({
                url: route+data_id,
                dataType: 'json',
                success: function (data) {
                    $('#account_info').html('({{'cash in hand'}}: '+data.cash_in_hand+' {{'earning balance'}}: '+data.earning_balance+')');
                },
            });
    }
</script>
<script>
    $('#add_transaction').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '{{route('agent.account-transaction.store')}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success('{{translate('messages.transaction_saved')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setTimeout(function () {
                        location.href = '{{route('agent.account-transaction.index')}}';
                    }, 2000);
                }
            }
        });
    });
</script>
@endpush
