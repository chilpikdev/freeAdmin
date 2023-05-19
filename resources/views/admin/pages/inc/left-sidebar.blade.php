<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                {{-- @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item') --}}

                @can('dashboard')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->is('*/dashboard'))) {{ "active" }} @endif">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>Dashboard</p>
                    </a>
                </li>
                @endcan

                @can('manage-users')
                <li class="nav-item @if(request()->is('*/manage/*')) {{ "menu-open" }} @endif">
                    <a href="#" class="nav-link @if(request()->is('*/user/*') || request()->is('*/user/*')) {{ "active" }} @endif">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                        Users management
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item @if(request()->is('*/user/*')) {{ "menu-open" }} @endif">
                            <a href="#" class="nav-link @if(request()->is('*/user/*') || request()->is('*/user/*')) {{ "active" }} @endif">
                              <i class="fas fa-user nav-icon"></i>
                              <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                              </p>
                            </a>
                            <ul class="nav nav-treeview">
                              <li class="nav-item">
                                <a href="{{ route('admin.admins.index') }}" class="nav-link @if(request()->is('*/admins') || request()->is('*/admins/*')) {{ "active" }} @endif">
                                  <i class="far fa-user nav-icon"></i>
                                  <p>Admins</p>
                                </a>
                              </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                  <a href="{{ route('admin.moderators.index') }}" class="nav-link @if(request()->is('*/moderators') || request()->is('*/moderators/*')) {{ "active" }} @endif">
                                    <i class="far fa-user nav-icon"></i>
                                    <p>Moderators</p>
                                  </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                  <a href="{{ route('admin.users.index') }}" class="nav-link @if(request()->is('*/users') || request()->is('*/users/*')) {{ "active" }} @endif">
                                    <i class="far fa-user nav-icon"></i>
                                    <p>Users</p>
                                  </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link @if(request()->is('*/roles') || request()->is('*/roles/*')) {{ "active" }} @endif">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}" class="nav-link @if(request()->is('*/permissions') || request()->is('*/permissions/*')) {{ "active" }} @endif">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('settings')
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link @if(request()->is('*/settings') || request()->is('*/settings/*')) {{ "active" }} @endif">
                      <i class="nav-icon fas fa-cog"></i>
                      <p>Settings</p>
                    </a>
                </li>
                @endcan

            </ul>
        </nav>
    </div>

</aside>
