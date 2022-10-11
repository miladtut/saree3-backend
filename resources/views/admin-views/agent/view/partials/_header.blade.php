    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-6">
                <h1 class="page-header-title text-break">{{$agent->f_name}}</h1>
            </div>
            <div class="col-6">

            </div>
        </div>
        @if($agent->status)
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-left"></i>
                </a>
            </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-right"></i>
                </a>
            </span>

            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{request('tab')==null?'active':''}}" href="{{route('admin.agent.view', $agent->id)}}">{{translate('messages.agent')}}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{request('tab')=='store'?'active':''}}" href="{{route('admin.agent.view', ['agent'=>$agent->id, 'tab'=> 'store'])}}"  aria-disabled="true">{{translate('messages.stores')}}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{request('tab')=='broker'?'active':''}}" href="{{route('admin.agent.view', ['agent'=>$agent->id, 'tab'=> 'broker'])}}"  aria-disabled="true">{{translate('messages.brokers')}}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{request('tab')=='dm'?'active':''}}" href="{{route('admin.agent.view', ['agent'=>$agent->id, 'tab'=> 'dm'])}}"  aria-disabled="true">{{translate('messages.delivery_men')}}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{request('tab')=='transaction'?'active':''}}" href="{{route('admin.agent.view', ['agent'=>$agent->id, 'tab'=> 'transaction'])}}"  aria-disabled="true">{{translate('messages.transaction')}}</a>
                </li>

            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
        @endif
    </div>
    <!-- End Page Header -->
