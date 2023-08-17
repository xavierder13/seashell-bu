@auth
<div class="sidebar" id="sidebar">
    <ul class="list-unstyled components">
    <li class="{{ request()->routeIs('admin::home') ? 'active' : '' }}">
            <a href="/"><i class="ico fa fa-home"></i>Home</a>
        </li>
        <li class="">
            <a href="/"><i class="ico fa fa-upload"></i>Import Data</a>
        </li>
        <li>
            <a href="#ss" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle-sb"><i class="ico fa fa-align-left"></i>Species Management</a>
            <ul class="collapse side-submenu show" id="ss">
                <li class="{{ request()->routeIs('admin::species.index') ? 'active' : '' }}">
                    <a href="{{ route('admin::species.index') }}">Species</a>
                </li>
                <li class="{{ request()->routeIs('admin::species.create') ? 'active' : '' }}">
                    <a href="{{ route('admin::species.create') }}">Add new species</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#users" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle-sb"><i class="ico fa fa-users"></i>User Management</a>
            <ul class="collapse side-submenu show" id="users">
                <li class="">
                    <a href="#">Users</a>
                </li>
                <li class="">
                    <a href="#">Add new user</a>
                </li>
            </ul>
        </li>
        {{-- <li>
            <a href="#"><i class="ico fa fa-share-alt"></i>Shared Forms</a>
        </li> --}}
    </ul>
</div>
@endauth
