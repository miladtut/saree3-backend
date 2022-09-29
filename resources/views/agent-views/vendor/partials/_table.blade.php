@foreach($stores as $key=>$store)
<tr>
    <td>{{$key+1}}</td>
    <td>
        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
            <a href="{{route('admin.vendor.view', $store->id)}}" alt="view store">
            <img width="60" style="border-radius: 50%; height:100%;"
                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                    src="{{asset('public/storage/store')}}/{{$store['logo']}}"></a>
        </div>
    </td>
    <td>
        <a href="{{route('admin.vendor.view', $store->id)}}" alt="view store">
            <span class="d-block font-size-sm text-body">
                {{Str::limit($store->name,20,'...')}}<br>
                {{translate('messages.id')}}:{{$store->id}}
            </span>
        </a>
    </td>
    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($store->module->module_name,20,'...')}}
        </span>
    </td>
    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($store->vendor->f_name.' '.$store->vendor->l_name,20,'...')}}
        </span>
    </td>
    <td>
        {{$store->vendor->agency}}
    </td>
    <td>
        {{$store->zone?$store->zone->name:translate('messages.zone').' '.translate('messages.deleted')}}
        {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
    </td>
    <td>
        {{$store['phone']}}
    </td>
    <td>
        @if($store->featured)
            <div class="badge badge-success">{{translate('messages.yes')}}</div>
        @else
            <div class="badge badge-secondary">{{translate('messages.no')}}</div>
        @endif
    </td>

    <td>
        @if(isset($store->vendor->status))
            @if($store->vendor->status)
                <div class="badge badge-success">{{translate('messages.active')}}</div>
            @else
                <div class="badge badge-secondary">{{translate('messages.inactive')}}</div>
            @endif
        @else
            <span class="badge badge-soft-danger">{{translate('messages.pending')}}</span>
        @endif
    </td>


</tr>
@endforeach
