@foreach($agents as $key=>$agent)
<tr>
    <td>{{$key+1}}</td>
    <td>
        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
            <a href="{{route('admin.vendor.view', $agent->id)}}" alt="view store">
            <img width="60" style="border-radius: 50%; height:100%;"
                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                    src="{{asset('public/storage/agent')}}/{{$agent['image']}}"></a>
        </div>
    </td>


    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($agent->f_name.' '.$agent->l_name,20,'...')}}
        </span>
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
        onclick="form_alert('vendor-{{$agent['id']}}','{{translate('messages.You want to remove this store')}}')" title="{{translate('messages.delete')}} {{translate('messages.store')}}"><i class="tio-delete-outlined text-danger"></i>
        </a>
        <form action="{{route('admin.agent.delete',[$agent['id']])}}" method="post" id="vendor-{{$agent['id']}}">
            @csrf @method('delete')
        </form>
    </td>
</tr>
@endforeach
