<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title">
        <i class="tio-medal"></i> {{translate('messages.top_stores')}}
    </h5>
    @php($params=session('dash_params'))
    @if($params['zone_id']!='all')
        @php($zone_name=\App\Models\Zone::where('id',$params['zone_id'])->first()->name)
    @else
        @php($zone_name='All')
    @endif
    <label class="badge badge-soft-primary">( {{translate('messages.zone')}} : {{$zone_name}} )</label>
</div>
<!-- End Header -->

<!-- Body -->
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <table class="table">
                <tbody>
                @foreach($top_restaurants as $key=>$item)
                    <tr onclick="location.href='{{route('admin.vendor.view', $item->id)}}'"
                        style="cursor: pointer">
                        <td scope="row">
                            <img height="35" style="border-radius: 5px"
                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                 src="{{asset('public/storage/store')}}/{{$item['logo']}}">
                            <span class="ml-2">
                                    {{Str::limit($item->name??translate('messages.store deleted!'), 20, '...')}}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 18px">
                                {{$item['order_count']}} <i class="tio-shopping-cart text-primary"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Body -->
