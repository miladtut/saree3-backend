<style>
    .nav-sub{
        background: #213A36!important;
    }
</style>
<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-center" onclick="location.href='{{route('vendor.dashboard')}}'" style="cursor: pointer;font-weight: bold;font-size: 15px">
                <!-- Logo -->

                @php($agent=\App\CentralLogics\Helpers::get_loggedin_user())
                <a class="navbar-brand" href="{{route('agent.dashboard')}}" aria-label="Front" style="padding-top: 0!important;padding-bottom: 0!important;">
                    <img class="navbar-brand-logo"
                         style="border-radius: 50%;height: 55px;width: 55px!important; border: 5px solid #80808012"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('public/storage/agent/'.$agent->image)}}"
                         alt="Logo">
                    <img class="navbar-brand-logo-mini"
                         style="border-radius: 50%;height: 55px;width: 55px!important; border: 5px solid #80808012"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('public/storage/agent/'.$agent->image)}}" alt="Logo">
                </a>
                {{$agent->f_name}} {{$agent->l_name}}
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Content -->
            <div class="navbar-vertical-content text-capitalize"  style="background-color: #213A36;">
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('agent-panel')?'show':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('agent.dashboard')}}" title="{{translate('messages.dashboard')}}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.dashboard')}}
                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->


                    <!-- stores -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('agent-panel/stores*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                           title="{{translate('messages.stores')}}">
                            <i class="tio-category nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.stores')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/employee*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('agent-panel/stores/add-new')?'active':''}}">
                                <a class="nav-link " href="{{route('agent.vendor.add')}}" title="{{translate('messages.add')}} {{translate('messages.new')}} {{translate('messages.Employee')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.add')}} {{translate('messages.new')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('agent-panel/stores/list')?'active':''}}">
                                <a class="nav-link " href="{{route('agent.vendor.list')}}" title="{{translate('messages.stores')}} {{translate('messages.list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.list')}}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- End stores -->


                    <!-- Brokers -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('agent-panel/brokers*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                           title="{{translate('messages.brokers')}}">
                            <i class="tio-user nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.brokers')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/employee*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('agent-panel/brokers/add-new')?'active':''}}">
                                <a class="nav-link " href="{{route('agent.broker.add')}}" title="{{translate('messages.add')}} {{translate('messages.new')}} {{translate('messages.Employee')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.add')}} {{translate('messages.new')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('agent-panel/brokers/list')?'active':''}}">
                                <a class="nav-link " href="{{route('agent.broker.list')}}" title="{{translate('messages.brokers')}} {{translate('messages.list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.list')}}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- End Brokers -->



                    <!-- DeliveryMan -->

                        <li class="nav-item">
                            <small class="nav-subtitle" title="{{ translate('messages.deliveryman') }} {{ translate('messages.section') }}">{{ translate('messages.deliveryman') }}
                                {{ translate('messages.section') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('agent/delivery-man/add') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('agent.delivery-man.add') }}" title="{{ translate('messages.add_delivery_man') }}">
                                <i class="tio-running nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ translate('messages.add_delivery_man') }}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('agent/delivery-man/list') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('agent.delivery-man.list') }}" title="{{ translate('messages.deliveryman') }} {{ translate('messages.list') }}">
                                <i class="tio-filter-list nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ translate('messages.deliverymen') }}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('agent/delivery-man/reviews/list') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('agent.delivery-man.reviews.list') }}" title="{{ translate('messages.reviews') }}">
                                <i class="tio-star-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ translate('messages.reviews') }}
                                </span>
                            </a>
                        </li>

                    <!-- End DeliveryMan -->


                    <!-- account -->

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('agent-panel/account-transaction*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('agent.account-transaction.index') }}" title="{{ translate('messages.collect') }} {{ translate('messages.cash') }}">
                                <i class="tio-money nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.collect') }}
                                    {{ translate('messages.cash') }}</span>
                            </a>
                        </li>

                <!-- End account -->


                    <!-- provide_dm_earning -->

{{--                        <li class="navbar-vertical-aside-has-menu {{ Request::is('agent-panel/provide-deliveryman-earnings*') ? 'active' : '' }}">--}}
{{--                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('agent.provide-deliveryman-earnings.index') }}" title="{{ translate('messages.deliverymen_earning_provide') }}">--}}
{{--                                <i class="tio-send nav-icon"></i>--}}
{{--                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.deliverymen_earning_provide') }}</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}

                <!-- End provide_dm_earning -->




                    <!-- Business Settings -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('agent-panel/profile*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('agent.profile.bankView')}}"
                            title="{{translate('messages.bank_info')}}">
                            <i class="tio-shop nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.bank_info')}}
                            </span>
                        </a>
                    </li>






                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


{{--<script>
    $(document).ready(function () {
        $('.navbar-vertical-content').animate({
            scrollTop: $('#scroll-here').offset().top
        }, 'slow');
    });
</script>--}}
