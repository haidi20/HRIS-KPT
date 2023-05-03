<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    {{-- <a href="index.html"><img src="./assets/compiled/svg/logo.svg" alt="Logo" srcset=""></a> --}}
                    <h4>HRIS - KPT</h4>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @php
                    $allPermissionSetting = ['lihat dashboard'];
                @endphp
                @can($allPermissionSetting)
                    <li class="sidebar-title">Menu</li>
                @endcan
                @can('lihat dashboard')
                    <li class="sidebar-item {{ isActive('dashboard') }} ">
                        <a href="{{ route('dashboard.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('lihat absensi')
                    <li class="sidebar-item {{ isActive('attendance') }} ">
                        <a href="{{ route('attendance.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Absensi</span>
                        </a>
                    </li>
                @endcan
                @can('lihat roster')
                    <li class="sidebar-item {{ isActive('roster') }} ">
                        <a href="{{ route('roster.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Roster</span>
                        </a>
                    </li>
                @endcan
                @can('lihat kasbon')
                    <li class="sidebar-item {{ isActive('salaryAdvance') }} ">
                        <a href="{{ route('salaryAdvance.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Kasbon</span>
                        </a>
                    </li>
                @endcan
                @can('lihat surat perintah lembur')
                    <li class="sidebar-item {{ isActive('overtime') }} ">
                        <a href="{{ route('overtime.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Surat Perintah Lembur</span>
                        </a>
                    </li>
                @endcan
                @can('lihat slip gaji karyawan')
                    <li class="sidebar-item {{ isActive('payslip') }} ">
                        <a href="{{ route('payslip.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Slip Gaji</span>
                        </a>
                    </li>
                @endcan
                @can('lihat penggajian')
                    <li class="sidebar-item {{ isActive('payroll') }} ">
                        <a href="{{ route('payroll.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Penggajian</span>
                        </a>
                    </li>
                @endcan
                @can('lihat proyek')
                    <li class="sidebar-item {{ isActive('project') }} ">
                        <a href="{{ route('project.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Proyek</span>
                        </a>
                    </li>
                @endcan
                @can('lihat job order')
                    <li class="sidebar-item {{ isActive('jobOrder') }} ">
                        <a href="{{ route('jobOrder.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Job Order</span>
                        </a>
                    </li>
                @endcan
                @php
                    $allPermissionSetting = ['lihat laporan job order'];
                @endphp
                @canany($allPermissionSetting)
                    <li class="sidebar-title has-sub">Data Laporan</li>
                @endcanany
                @can('lihat laporan job order')
                    <li class="sidebar-item {{ isActive('jobOrderReport') }} ">
                        <a href="{{ route('jobOrderReport.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Laporan Job Order</span>
                        </a>
                    </li>
                @endcan
                @php
                    $allPermissionSetting = ['lihat jabatan'];
                @endphp
                @canany($allPermissionSetting)
                    <li class="sidebar-title has-sub">Data Utama</li>
                @endcanany
                @can('lihat perusahaan')
                    <li class="sidebar-item {{ isActive('master/company') }}">
                        <a href="{{ route('master.company.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Perusahaan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat jenis karyawan')
                    <li class="sidebar-item {{ isActive('master/typeEmployee') }}">
                        <a href="{{ route('master.typeEmployee.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Jenis Karyawan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat kapal')
                    <li class="sidebar-item {{ isActive('master/barge') }}">
                        <a href="{{ route('master.barge.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Kapal</span>
                        </a>
                    </li>
                @endcan
                @can('lihat daftar pekerjaan')
                    <li class="sidebar-item {{ isActive('master/job') }}">
                        <a href="{{ route('master.job.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Daftar Pekerjaan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat bahan')
                    <li class="sidebar-item {{ isActive('master/material') }}">
                        <a href="{{ route('master.material.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Bahan</span>
                        </a>
                    </li>
                @endcan
                @can('lihat lokasi')
                    <li class="sidebar-item {{ isActive('master/location') }}">
                        <a href="{{ route('master.location.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Lokasi</span>
                        </a>
                    </li>
                @endcan
                @can('lihat jadwal kerja')
                    <li class="sidebar-item {{ isActive('master/schedule') }}">
                        <a href="{{ route('master.schedule.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Jadwal Kerja</span>
                        </a>
                    </li>
                @endcan
                @can('lihat jabatan')
                    <li class="sidebar-item {{ isActive('master/position') }}">
                        <a href="{{ route('master.position.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Jabatan</span>
                        </a>
                    </li>
                @endcan
                @php
                    $allPermissionSetting = ['lihat penyesuaian gaji', 'lihat jam kerja', 'lihat pengguna', 'lihat grup pengguna', 'lihat fitur'];
                @endphp
                @canany($allPermissionSetting)
                    <li class="sidebar-title has-sub">Pengaturan</li>
                @endcanany
                @can('lihat penyesuaian gaji')
                    <li class="sidebar-item {{ isActive('setting/salary-adjustment') }}">
                        <a href="{{ route('setting.salaryAdjustment.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Penyesuaian Gaji</span>
                        </a>
                    </li>
                @endcan
                @can('lihat jam kerja')
                    <li class="sidebar-item {{ isActive('setting/working-hour') }}">
                        <a href="{{ route('setting.workingHour.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Jam Kerja</span>
                        </a>
                    </li>
                @endcan
                @can('lihat pengguna')
                    <li class="sidebar-item {{ isActive('setting/user') }}">
                        <a href="{{ route('setting.user.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>
                @endcan
                @can('lihat grup pengguna')
                    <li class="sidebar-item {{ isActive('setting/role') }}">
                        <a href="{{ route('setting.role.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Grup Pengguna</span>
                        </a>
                    </li>
                @endcan
                @can('lihat fitur')
                    <li class="sidebar-item {{ isActive('setting/feature') }}">
                        <a href="{{ route('setting.feature.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Fitur</span>
                        </a>
                    </li>
                @endcan
                <li class="sidebar-item">
                    <a href="{{ route('logout') }}" class='sidebar-link'
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-grid-fill"></i>
                        <span>Keluar</span>
                    </a>
                    <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display:none">
                        @csrf
                        <button type="submit" class="">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
