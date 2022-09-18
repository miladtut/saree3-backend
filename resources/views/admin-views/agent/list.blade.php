@extends('layouts.admin.app')

@section('title','Vendor List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('messages.agents')}} <span class="badge badge-soft-dark ml-2" id="itemCount">{{$agents->total()}}</span></h1>
                </div>

            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header pb-1 pt-1" >
                        <h5>{{translate('messages.stores')}} {{translate('messages.list')}}</h5>
                        <form action="javascript:" id="search-form" >
                                        <!-- Search -->
                            @csrf
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{translate('messages.search')}}" aria-label="{{translate('messages.search')}}" required>
                                <button type="submit" class="btn btn-light">{{translate('messages.search')}}</button>

                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false

                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 5%;">{{translate('messages.#')}}</th>
                                <th style="width: 10%;">{{translate('messages.logo')}}</th>
                                <th style="width: 10%;">{{translate('messages.name')}}</th>
                                <th style="width: 10%;">{{translate('messages.phone')}}</th>
                                <th class="text-uppercase" style="width: 10%;">{{translate('messages.active')}}/{{translate('messages.inactive')}}</th>
                                <th style="width: 10%;">{{translate('messages.action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($agents as $key=>$agent)
                                <tr>
                                    <td>{{$key+$agents->firstItem()}}</td>
                                    <td>
                                        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
                                            <a href="{{route('admin.agent.view', $agent->id)}}" alt="view agent">
                                            <img width="60" style="border-radius: 50%; height:100%;"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('public/storage/agent')}}/{{$agent['image']}}"></a>
                                        </div>
                                    </td>

                                    <td>
                                        {{$agent['f_name']}} {{$agent['l_name']}}
                                    </td>


                                    <td>
                                        {{$agent['phone']}}
                                    </td>


                                    <td>
                                        @if(isset($agent->status))
                                            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$agent->id}}">
                                                <input type="checkbox" onclick="status_change_alert('{{route('admin.agent.status',[$agent->id,$agent->status?0:1])}}', '{{translate('messages.you_want_to_change_this_agent_status')}}', event)" class="toggle-switch-input" id="stocksCheckbox{{$agent->id}}" {{$agent->status?'checked':''}}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        @else
                                            <span class="badge badge-soft-danger">{{translate('messages.pending')}}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.agent.view',[$agent['id']])}}" title="{{translate('messages.view')}} {{translate('messages.agent')}}"><i class="tio-visible text-success"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.agent.edit',[$agent['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.agent')}}"><i class="tio-edit text-primary"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                        onclick="form_alert('vendor-{{$agent['id']}}','{{translate('You want to remove this agent')}}')" title="{{translate('messages.delete')}} {{translate('messages.agent')}}"><i class="tio-delete-outlined text-danger"></i>
                                        </a>
                                        <form action="{{route('admin.agent.delete',[$agent['id']])}}" method="post" id="vendor-{{$agent['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $agents->links() !!}
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href=url;
                }
            })
        }
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.vendor.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.total);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
