@extends('layouts.agent.app')

@section('title',translate('messages.deliverymen'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('messages.deliverymen')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header p-1">
                        <h5>{{translate('messages.deliveryman')}} {{translate('messages.list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$delivery_men->total()}}</span></h5>
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
                                <th class="text-capitalize">{{translate('messages.#')}}</th>
                                <th class="text-capitalize">{{translate('messages.name')}}</th>
                                <th class="text-capitalize">{{translate('messages.availability')}} {{translate('messages.status')}}</th>
                                <th class="text-capitalize">{{translate('messages.phone')}}</th>
{{--                                <th class="text-capitalize">{{translate('messages.action')}}</th>--}}
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($delivery_men as $key=>$dm)
                                <tr>
                                    <td>{{$key+$delivery_men->firstItem()}}</td>
                                    <td>
                                        <a class="media align-items-center" href="{{route('agent.delivery-man.preview',[$dm['id']])}}">
                                            <img class="avatar avatar-lg mr-3" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                    src="{{asset('public/storage/delivery-man')}}/{{$dm['image']}}" alt="{{$dm['f_name']}} {{$dm['l_name']}}">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0">{{$dm['f_name'].' '.$dm['l_name']}}</h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        @if($dm->active)
                                        <label class="badge badge-soft-primary">{{translate('messages.online')}}</label>
                                        @else
                                        <label class="badge badge-soft-danger">{{translate('messages.offline')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="deco-none" href="tel:{{$dm['phone']}}">{{$dm['phone']}}</a>
                                    </td>
{{--                                    <td>--}}
{{--                                        <a class="btn btn-sm btn-white" href="{{route('agent.delivery-man.edit',[$dm['id']])}}" title="{{translate('messages.edit')}}"><i class="tio-edit"></i>--}}
{{--                                        </a>--}}
{{--                                        <a class="btn btn-sm btn-white text-danger" href="javascript:" onclick="form_alert('delivery-man-{{$dm['id']}}','Want to remove this deliveryman ?')" title="{{translate('messages.delete')}}"><i class="tio-delete-outlined"></i>--}}
{{--                                        </a>--}}
{{--                                        <form action="{{route('agent.delivery-man.delete',[$dm['id']])}}" method="post" id="delivery-man-{{$dm['id']}}">--}}
{{--                                            @csrf @method('delete')--}}
{{--                                        </form>--}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $delivery_men->links() !!}
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
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.delivery-man.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
