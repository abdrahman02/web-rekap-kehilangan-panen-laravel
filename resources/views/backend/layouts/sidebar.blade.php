<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link  {{ Request::is('dashboard/data*') ? '' : 'collapsed' }}" data-bs-target="#components-nav"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-files"></i><span>Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard/data/kebun*') ? 'active' : '' }}"
                        href="{{ route('kebun.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Data Kebun</span>
                    </a>
                </li>
                <!-- End Data Kebun Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard/data/rekap*') ? 'active' : '' }}"
                        href="{{ route('rekap.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Data Rekap Kehilangan</span>
                    </a>
                </li>
                <!-- End Data Produksi Nav -->
            </ul>
        </li>
        <!-- End Data Nav -->
    </ul>
</aside>
<!-- End Sidebar-->
