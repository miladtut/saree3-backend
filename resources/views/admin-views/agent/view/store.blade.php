@extends('layouts.admin.app')

@section('title',$agent->f_name. " ".$agent->l_name."'s Stores")

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{translate('messages.agent_view')}}</li>
        </ol>
    </nav>

    @include('admin-views.agent.view.partials._header',['agent'=>$agent])
    <!-- Page Heading -->
    @php($stores = $agent->stores()->latest()->paginate(25))
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3>{{translate('messages.stores')}} <span class="badge badge-soft-dark ml-2">{{$stores->total()}}</span></h3>


                        </div>
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                        "order": [],
                                        "orderCellsTop": true,
                                        "paging": false
                                    }'>
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{translate('messages.#')}}</th>
                                        <th style="width: 20%">{{translate('messages.name')}}</th>
                                        <th>{{translate('messages.vendor_name')}}</th>
                                        <th>{{translate('messages.agent_name')}}</th>
                                        <th>{{translate('messages.action')}}</th>
                                    </tr>
                                </thead>

                                <tbody id="set-rows">
                                @foreach($stores as $key=>$store)

                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <a class="media align-items-center" href="{{route('admin.vendor.view',[$store->id])}}">
                                            <img class="avatar avatar-lg mr-3" src="{{asset('public/storage/store')}}/{{$store->logo}}"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$store->name}} image">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0">{{Str::limit($store->name,20,'...')}}</h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        {{$store->vendor->f_name}} {{$store->vendor->l_name}}
                                    </td>
                                    <td>
                                        {{$agent->f_name}} {{$agent->l_name}}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.vendor.edit',[$store['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.item')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                            onclick="form_alert('food-{{$store['id']}}','Want to delete this item ?')" title="{{translate('messages.delete')}} {{translate('messages.item')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.vendor.delete',[$store['id']])}}"
                                                method="post" id="vendor-{{$store['id']}}">
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
                                    <tfoot class="border-top">
                                    {!! $stores->links() !!}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
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

            $('#column3_search').on('change', function () {
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

        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.item.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
