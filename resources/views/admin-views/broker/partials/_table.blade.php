@foreach($brokers as $key=>$broker)
<tr>
    <td>{{$key+1}}</td>
    <td>
        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
            <a href="{{route('admin.broker.view', $broker->id)}}" alt="view store">
            <img width="60" style="border-radius: 50%; height:100%;"
                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                    src="{{asset('public/storage/broker')}}/{{$broker['image']}}"></a>
        </div>
    </td>


    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($broker->f_name.' '.$broker->l_name,20,'...')}}
        </span>
    </td>
    <td>
        {{$broker->agency}}
    </td>
    <td>
        {{$broker['phone']}}
    </td>


    <td>
        @if(isset($broker->status))
            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$broker->id}}">
                <input type="checkbox" onclick="status_change_alert('{{route('admin.broker.status',[$broker->id,$broker->status?0:1])}}', '{{translate('messages.you_want_to_change_this_agent_status')}}', event)" class="toggle-switch-input" id="stocksCheckbox{{$broker->id}}" {{$broker->status?'checked':''}}>
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
            href="{{route('admin.broker.view',[$broker['id']])}}" title="{{translate('messages.view')}} {{translate('messages.agent')}}"><i class="tio-visible text-success"></i>
        </a>
        <a class="btn btn-sm btn-white"
            href="{{route('admin.broker.edit',[$broker['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.agent')}}"><i class="tio-edit text-primary"></i>
        </a>
        <a class="btn btn-sm btn-white" href="javascript:"
        onclick="form_alert('vendor-{{$broker['id']}}','{{translate('messages.You want to remove this store')}}')" title="{{translate('messages.delete')}} {{translate('messages.store')}}"><i class="tio-delete-outlined text-danger"></i>
        </a>
        <form action="{{route('admin.broker.delete',[$broker['id']])}}" method="post" id="vendor-{{$broker['id']}}">
            @csrf @method('delete')
        </form>
    </td>
</tr>
@endforeach
