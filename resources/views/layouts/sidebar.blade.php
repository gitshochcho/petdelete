<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="../index.html" class="brand-link"> <!--begin::Brand Image--> <img src="{{ asset('assets/img/petbd.png') }}" alt="Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span class="brand-text fw-light">PetBD</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}" class="nav-link">
                        <i class="fas fa-dashboard me-2"></i>
                            Dashboard
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{ route('user.pets.index') }}" class="nav-link">
                        <i class="fas fa-paw me-2"></i>
                        Pets
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.appointments.index') }}" class="nav-link">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Appointments
                    </a>
                </li>



                {{-- <li class="nav-header">LABELS</li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-danger"></i>
                        <p class="text">Important</p>
                    </a> </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-warning"></i>
                        <p>Warning</p>
                    </a> </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-info"></i>
                        <p>Informational</p>
                    </a>
                </li> --}}
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside>
