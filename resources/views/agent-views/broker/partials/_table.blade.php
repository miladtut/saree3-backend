@foreach($brokers as $key=>$broker)
<tr>
    <td>{{$key+1}}</td>
    <td>
        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
{{--            <a href="{{route('agent.broker.view', $broker->id)}}" alt="view store">--}}
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
            @if($broker->status == 1)
                <div class="badge badge-success">{{translate('messages.active')}}</div>
            @else
            <div class="badge badge-danger">{{translate('messages.inactive')}}</div>
            @endif
        @else
            <span class="badge badge-soft-danger">{{translate('messages.pending')}}</span>
        @endif
    </td>

</tr>
@endforeach
