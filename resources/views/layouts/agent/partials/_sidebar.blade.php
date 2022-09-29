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
