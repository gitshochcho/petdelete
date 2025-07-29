<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="../index.html" class="brand-link">
            <!--begin::Brand Image--> <img src="../../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span
                class="brand-text fw-light">AdminLTE 4</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div>
    <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-border"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('admin/role/permission/*') ? 'menu-open' : '' }}"> <a href="#" class="nav-link {{ request()->is('admin/role/permission/*') ? 'active' : '' }}">  <span class="nav-icon mdi mdi-home"></span>
                        <p>
                           Role & Permission
                            <i class="nav-arrow bi bi-chevron-right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.roleIndex') }}" class="nav-link {{ request()->is('admin/role/permission/role/*') ? 'active' : '' }}"> <i
                                    class="mdi mdi-account-group"></i>
                                <p>Role List</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{ route('admin.permissionIndex') }}" class="nav-link {{ request()->is('admin/role/permission/permission/*') ? 'active' : '' }}"> <i
                                    class="mdi mdi-axis-lock"></i>
                                <p>Permission List</p>
                            </a> </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Forms
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="../forms/general.html" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>General Elements</p>
                            </a> </li>
                    </ul>
                </li>



                <li class="nav-header">DOCUMENTATIONS</li>





                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pet-categories.index') }}">
                                <i class="fas fa-tags me-2"></i>
                                Pet Categories
                            </a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pet-subcategories.index') }}">
                                <i class="fas fa-sitemap me-2"></i>
                                Pet Subcategories
                            </a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pet-breeds.index') }}">
                                <i class="fas fa-dna me-2"></i>
                                Pet Breeds
                            </a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pets.index') }}">
                                <i class="fas fa-paw me-2"></i>
                                Pets
                            </a>
                        </li>


                        <li class="nav-item mt-3">
                            <h6 class="px-3 text-muted">Service Management</h6>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.services.index') }}">
                                <i class="fas fa-cogs me-2"></i>
                                Services
                            </a>
                        </li>


            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside>
