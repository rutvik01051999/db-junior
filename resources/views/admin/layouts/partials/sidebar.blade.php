<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <div class="main-sidebar" id="sidebar-scroll" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: -8px 0px -80px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content"
                        style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 8px 0px 80px;">
                            <nav class="main-menu-container nav nav-pills flex-column sub-open open active">
                                <div class="slide-left active d-none" id="slide-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z">
                                        </path>
                                    </svg>
                                </div>
                                <ul class="main-menu">
                                    <!-- Banner Sections -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.banner-sections.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.banner-sections.*') ? 'active' : '' }}">
                                            <i class="bx bx-image side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Banner Sections
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.banner-sections.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Banner Sections
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.banner-sections.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.banner-sections.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.banner-sections.index') ? 'active' : '' }}">
                                                    All Banner Sections
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.banner-sections.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.banner-sections.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <!-- Main Content Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.main-contents.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.main-contents.*') ? 'active' : '' }}">
                                            <i class="bx bx-layout side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Main Content
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.main-contents.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Main Content
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.main-contents.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.main-contents.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.main-contents.index') ? 'active' : '' }}">
                                                    All Main Content
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.main-contents.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.main-contents.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Video Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
                                            <i class="bx bx-video-recording side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Videos
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Videos
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.videos.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.videos.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.videos.index') ? 'active' : '' }}">
                                                    All Videos
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.videos.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.videos.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Process Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.processes.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.processes.*') ? 'active' : '' }}">
                                            <i class="bx bx-list-check side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Processes
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.processes.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Processes
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.processes.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.processes.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.processes.index') ? 'active' : '' }}">
                                                    All Processes
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.processes.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.processes.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Participants Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.participants.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.participants.*') ? 'active' : '' }}">
                                            <i class="bx bx-group side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Participants
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.participants.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Participants
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.participants.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.participants.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.participants.index') ? 'active' : '' }}">
                                                    All Participants
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.participants.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.participants.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Guest Of Honours Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.guest-of-honours.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.guest-of-honours.*') ? 'active' : '' }}">
                                            <i class="bx bx-crown side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Guest Of Honours
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.guest-of-honours.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Guest Of Honours
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.guest-of-honours.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.guest-of-honours.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.guest-of-honours.index') ? 'active' : '' }}">
                                                    All Guest Of Honours
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.guest-of-honours.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.guest-of-honours.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Sliders Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                                            <i class="bx bx-slider side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                Sliders
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    Sliders
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.sliders.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.sliders.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.sliders.index') ? 'active' : '' }}">
                                                    All Sliders
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.sliders.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.sliders.create') ? 'active' : '' }}">
                                                    Add New
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- CMS Pages Section -->
                                    <li class="slide has-sub {{ request()->routeIs('admin.cms-pages.*') ? 'active' : '' }}">
                                        <a href="javascript:void(0);"
                                            class="side-menu__item {{ request()->routeIs('admin.cms-pages.*') ? 'active' : '' }}">
                                            <i class="bx bx-file side-menu__icon"></i>
                                            <span class="side-menu__label">
                                                CMS Pages
                                            </span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu child1 {{ request()->routeIs('admin.cms-pages.*') ? 'active' : '' }}"
                                            data-popper-placement="bottom">
                                            <li class="slide side-menu__label1">
                                                <a href="javascript:void(0)">
                                                    CMS Pages
                                                </a>
                                            </li>
                                            <li class="slide {{ request()->routeIs('admin.cms-pages.index') ? 'active' : '' }}">
                                                <a href="{{ route('admin.cms-pages.index') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.cms-pages.index') ? 'active' : '' }}">
                                                    All Pages
                                                </a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{ route('admin.cms-pages.create') }}"
                                                    class="side-menu__item {{ request()->routeIs('admin.cms-pages.create') ? 'active' : '' }}">
                                                    Add New Page
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

            <!-- Contact Form Submissions Section -->
            <li class="slide has-sub {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="bx bx-message-square-detail side-menu__icon"></i>
                    <span class="side-menu__label">
                        Contact Submissions
                    </span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
                    data-popper-placement="bottom">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">
                            Contact Submissions
                        </a>
                    </li>
                    <li class="slide {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.contacts.index') }}"
                            class="side-menu__item {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
                            All Submissions
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Employee Management Section -->
            <li class="slide has-sub {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="bx bx-user-plus side-menu__icon"></i>
                    <span class="side-menu__label">
                        Employee Management
                    </span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
                    data-popper-placement="bottom">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">
                            Employee Management
                        </a>
                    </li>
                    <li class="slide {{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.employees.index') }}"
                            class="side-menu__item {{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
                            All Employees
                        </a>
                    </li>
                    <li class="slide {{ request()->routeIs('admin.employees.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.employees.create') }}"
                            class="side-menu__item {{ request()->routeIs('admin.employees.create') ? 'active' : '' }}">
                            Add New Employee
                        </a>
                    </li>
                </ul>
            </li>
                                </ul>

                                <div class="slide-right d-none" id="slide-right">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                        </path>
                                    </svg>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 1522px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                style="height: 570px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
</aside>
