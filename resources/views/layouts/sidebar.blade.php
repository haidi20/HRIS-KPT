<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            {{-- <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.html"><img src="{{asset('assets/img/logo.png')}}" alt="Logo" srcset=""></a>
                    <!-- <h4>HRIS - KPT</h4> -->
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div> --}}
            <div class=" d-flex flex-column align-items-center logo">
                <div>
                    <img src="{{ asset('assets/img/logo.png') }}" alt="" style="height: 5rem !important;">
                </div>
                <div class="fw-bold mt-2 ms-3" style="font-size: 1.5rem;">HRIS-KPT</div>
                <span style="font-size: 10px;">Human Resource Information System</span>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @php
                    $allPermissionMenus = ['lihat dashboard', 'lihat proyek', 'lihat job order', 'lihat roster', 'lihat absensi'];
                @endphp
                @can($allPermissionMenus)
                    <li class="sidebar-title">Menu</li>
                @endcan
                @can('lihat dashboard')
                    <li class="sidebar-item {{ isActive('dashboard') }} ">
                        <a href="{{ route('dashboard.index') }}" class='sidebar-link'>
                            <i class="bi bi-file-bar-graph"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('lihat proyek')
                    <li class="sidebar-item {{ isActive('project') }} ">
                        <a href="{{ route('project.index') }}" class='sidebar-link'>
                            <i class="bi bi-pencil"></i>
                            <span>Proyek</span>
                        </a>
                    </li>
                @endcan
                @can('lihat job order')
                    <li class="sidebar-item {{ isActive('job-order') }} ">
                        <a href="{{ route('jobOrder.index') }}" class='sidebar-link'>
                            <i class="bi bi-pencil-square"></i>
                            <span>Job Order</span>
                        </a>
                    </li>
                @endcan
                @can('lihat kasbon')
                    <li class="sidebar-item {{ isActive('salary-advance') }} ">
                        <a href="{{ route('salaryAdvance.index') }}" class='sidebar-link'>
                            <i class="bi bi-receipt"></i>
                            <span>Kasbon</span>
                        </a>
                    </li>
                @endcan
                @can('lihat cuti')
                    <li class="sidebar-item {{ isActive('vacation') }} ">
                        <a href="{{ route('vacation.index') }}" class='sidebar-link'>
                            <i class="bi bi-arrow-up-left-circle"></i>
                            <span>Cuti</span>
                        </a>
                    </li>
                @endcan
                {{-- @can('lihat surat perintah lembur')
                    <li class="sidebar-item {{ isActive('overtime') }} ">
                        <a href="{{ route('overtime.index') }}" class='sidebar-link'>
                            <i class="bi bi-cloud-moon"></i>
                            <span>Surat Perintah Lembur</span>
                        </a>
                    </li>
                @endcan --}}
                @can('lihat roster')
                    <li class="sidebar-item {{ isActive('roster') }} ">
                        <a href="{{ route('roster.index') }}" class='sidebar-link'>
                            <i class="bi bi-list-check"></i>
                            <span>Roster</span>
                        </a>
                    </li>
                @endcan
                @can('lihat absensi')
                    <li class="sidebar-item {{ isActive('attendance') }} ">
                        <a href="{{ route('attendance.index') }}" class='sidebar-link'>
                            <i class="bi bi-fingerprint"></i>
                            <span>Absensi</span>
                        </a>
                    </li>
                @endcan
                @php
                    $allPermissionSalary = ['lihat slip gaji karyawan', 'lihat penggajian', 'lihat penyesuaian gaji'];
                @endphp
                @canany($allPermissionSalary)
                    <li
                        class="sidebar-item {{ isActive('payslip') || isActive('payroll') || isActive('setting/salary-adjustment') }} has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-cash-coin"></i>
                            <span>Gaji</span>
                        </a>
                        <ul class="submenu {{ isActive('payslip') || isActive('payroll') || isActive('setting/salary-adjustment') }}"
                            style="{{ Request::is('payslip') || Request::is('payroll') ? 'display: block;' : 'display: none;' }}">
                            @can('lihat slip gaji')
                                <li class="submenu-item {{ isActive('payslip') }}">
                                    <a href="{{ route('payslip.index') }}">Slip Gaji Karyawan</a>
                                </li>
                            @endcan
                            @can('lihat penggajian')
                                <li class="submenu-item {{ isActive('payroll') }}">
                                    <a href="{{ route('payroll.index') }}">Penggajian</a>
                                </li>
                            @endcan
                            @can('lihat penyesuaian gaji')
                                <li class="submenu-item {{ isActive('salary-adjustment') }}">
                                    <a href="{{ route('salaryAdjustment.index') }}">Penyesuaian Gaji</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @php
                    $allPermissionReports = ['lihat laporan job order', 'lihat laporan kasbon', 'lihat surat perintah lembur'];
                @endphp
                @canany($allPermissionReports)
                    <li class="sidebar-title has-sub">Laporan</li>
                @endcanany
                @can('lihat laporan job order')
                    <li class="sidebar-item {{ isActive('job-order-report') }} ">
                        <a href="{{ route('report.jobOrder.index') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Laporan Job Order</span>
                        </a>
                    </li>
                @endcan
                @can('lihat laporan kasbon')
                    <li class="sidebar-item {{ isActive('salary-advance-report') }} ">
                        <a href="{{ route('report.salaryAdvance.index') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Laporan Kasbon</span>
                        </a>
                    </li>
                @endcan
                @can('lihat laporan surat perintah lembur')
                    <li class="sidebar-item {{ isActive('overtime-report') }} ">
                        <a href="{{ route('report.overtime.index') }}" class='sidebar-link'>
                            {{-- <i class="bi bi-cloud-moon"></i> --}}
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Laporan Surat Perintah Lembur</span>
                        </a>
                    </li>
                @endcan
                @php
                    $allPermissionMains = ['lihat departemen', 'lihat karyawan', 'lihat jenis karyawan'];
                @endphp
                @canany($allPermissionMains)
                    <li class="sidebar-title has-sub">Utama</li>
                @endcanany
                <li class="sidebar-item {{ isActive('master/employee') }} has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-people"></i>
                        <span>Karyawan</span>
                    </a>
                    <ul class="submenu {{ isActive('master/employee') }}"
                        style="{{ Request::is('master/employee') || Request::is('master/typeEmployee') ? 'display: block;' : 'display: none;' }}">
                        @can('lihat karyawan')
                            <li class="submenu-item {{ isActive('master/employee') }}">
                                <a href="{{ route('master.employee.index') }}">Daftar Karyawan</a>
                            </li>
                        @endcan
                        @can('lihat jenis karyawan')
                            <li class="submenu-item {{ isActive('master/typeEmployee') }}">
                                <a href="{{ route('master.employeeType.index') }}">Jenis Karyawan</a>
                            </li>
                        @endcan
                        @can('lihat departemen')
                            <li class="submenu-item {{ isActive('master/position') }}">
                                {{-- <a href="{{ route('master.position.index') }}">Jabatan</a> --}}
                                <a href="{{ route('master.position.index') }}">Departemen</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @php
                    $allPermissionWork = ['lihat jenis pekerjaan', 'lihat jadwal kerja', 'lihat jam kerja'];
                @endphp
                @canany($allPermissionWork)
                    <li
                        class="sidebar-item {{ isActive('master/job') || isActive('master/schedule') || isActive('setting/working-hour') }} has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-folder-check"></i>
                            <span>Pekerjaan</span>
                        </a>

                        <ul class="submenu {{ isActive('master/job') || isActive('master/schedule') || isActive('setting/working-hour') }}"
                            style="{{ Request::is('master/job') || Request::is('master/schedule') ? 'display: block;' : 'display: none;' }}">
                            @can('lihat jenis pekerjaan')
                                <li class="submenu-item {{ isActive('master/job') }}">
                                    <a href="{{ route('master.job.index') }}">Jenis Pekerjaan</a>
                                </li>
                            @endcan
                            @can('lihat jadwal kerja')
                                <li class="submenu-item {{ isActive('master/schedule') }}">
                                    <a href="{{ route('master.schedule.index') }}">Jadwal Kerja</a>
                                </li>
                            @endcan
                            @can('lihat jam kerja')
                                <li class="submenu-item {{ isActive('master/working-hour') }}">
                                    <a href="{{ route('master.workingHour.index') }}">Jam Kerja</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @can('lihat perusahaan')
                    <li class="sidebar-item {{ isActive('master/company') }}">
                        <a href="{{ route('master.company.index') }}" class='sidebar-link'>
                            <i class="bi bi-building"></i>
                            <span>Perusahaan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat kapal')
                    <li class="sidebar-item {{ isActive('master/barge') }}">
                        <a href="{{ route('master.barge.index') }}" class='sidebar-link'>
                            <i class="bi bi-wrench-adjustable-circle"></i>
                            <span>Kapal</span>
                        </a>
                    </li>
                @endcan
                @can('lihat pelanggan')
                    <li class="sidebar-item {{ isActive('master/customer') }}">
                        <a href="{{ route('master.customer.index') }}" class='sidebar-link'>
                            <i class="bi bi-wrench-adjustable-circle"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat bahan')
                    <li class="sidebar-item {{ isActive('master/material') }}">
                        <a href="{{ route('master.material.index') }}" class='sidebar-link'>
                            <i class="bi bi-box-seam"></i>
                            <span>Bahan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat lokasi')
                    <li class="sidebar-item {{ isActive('master/location') }}">
                        <a href="{{ route('master.location.index') }}" class='sidebar-link'>
                            <i class="bi bi-geo-alt"></i>
                            <span>Lokasi</span>
                        </a>
                    </li>
                @endcan
                @php
                    $allPermissionUser = ['lihat pengguna', 'lihat grup pengguna'];
                    $allPermissionSetting = ['lihat penyesuaian gaji', 'lihat jam kerja', 'lihat pengguna', 'lihat grup pengguna', 'lihat fitur'];
                @endphp
                @canany($allPermissionSetting)
                    <li class="sidebar-title has-sub">Pengaturan</li>
                @endcanany
                @canany($allPermissionUser)
                    <li class="sidebar-item {{ isActive('setting/user') || isActive('setting/role') }} has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>Pengguna</span>
                        </a>
                        <ul class="submenu {{ isActive('setting/user') || isActive('setting/role') }}"
                            style="{{ Request::is('payslip') || Request::is('payroll') ? 'display: block;' : 'display: none;' }}">
                            @can('lihat pengguna')
                                <li class="submenu-item {{ isActive('setting/user') }}">
                                    <a href="{{ route('setting.user.index') }}">Pengguna</a>
                                </li>
                            @endcan
                            @can('lihat grup pengguna')
                                <li class="submenu-item {{ isActive('setting/role') }}">
                                    <a href="{{ route('setting.role.index') }}">Grup Pengguna</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @can('lihat fitur')
                    <li class="sidebar-item {{ isActive('setting/feature') }}">
                        <a href="{{ route('setting.feature.index') }}" class='sidebar-link'>
                            <i class="bi bi-menu-up"></i>
                            <span>Fitur</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
