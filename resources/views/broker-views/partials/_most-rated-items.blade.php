<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title">
        <i class="tio-star"></i> {{translate('messages.top_rated_items')}}
    </h5>
</div>
<!-- End Header -->

<!-- Body -->
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <table class="table">
                <tbody>
                @foreach($most_rated_items as $key=>$item)
                <tr onclick="location.href='{{route('vendor.item.view',[$item['id']])}}'"
                        style="cursor: pointer">
                        <td scope="row">
                            <img height="35" style="border-radius: 5px"
                                 src="{{asset('public/storage/product')}}/{{$item['image']}}"
                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                 alt="{{$item->name}} image">
                            <span class="ml-2">
                                {{Str::limit($item->name??translate('messages.Item deleted!'),20,'...')}}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 18px">
                                {{round($item['avg_rating'],1)}} <i style="color: gold" class="tio-star"></i>
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 18px">
                            {{$item['rating_count']}} <i class="tio-users-switch text-primary"></i>
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
