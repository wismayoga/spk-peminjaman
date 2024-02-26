
<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('dashboard') }}" class="logo-icon"><span class="logo-text">Dashboard</span></a>
        <div class="sidebar-user-switcher">
            <a href="#">
                <span class="activity-indicator"></span>
                <span class="user-info-text">{{ auth()->user()->name }}<br><span class="user-state-info">{{ auth()->user()->role }}</span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Perhitungan SPK
            </li>

            @if(auth()->user()->role == 'admin')
            <li class="{{ request()->routeIs('dashboard') ? 'active-page' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            dashboard
                        </span>
                    </i>
                    Dashboard
                </a>
            </li>
            <li class="{{ request()->routeIs('alternatif.index', 'alternatif.edit', 'alternatif.create') ? 'active-page' : '' }}">
                <a href="{{ route('alternatif.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            groups
                        </span>
                    </i>
                    Data Nasabah
                </a>
            </li>
            <li class="{{ request()->routeIs('variabel.index', 'variabel.create', 'variabel.edit') ? 'active-page' : '' }}">
                <a href="{{ route('variabel.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            package_2
                        </span>
                    </i>
                    Data Variabel
                </a>
            </li>
            <li class="{{ request()->routeIs('himpunan.index', 'himpunan.edit') ? 'active-page' : '' }}">
                <a href="{{ route('himpunan.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            event_list
                        </span>
                    </i>
                    Himpunan Fuzzy
                </a>
            </li>
            <li class="{{ request()->routeIs('aturan.index', 'aturan.edit', 'aturan.create') ? 'active-page' : '' }}">
                <a href="{{ route('aturan.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            discover_tune
                        </span>
                    </i>
                    Data Aturan
                </a>
            </li>
            <li class="{{ request()->routeIs('penilaian.index') ? 'active-page' : '' }}">
                <a href="{{ route('penilaian.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            stylus
                        </span>
                    </i>
                    Data Penilaian
                </a>
            </li>
            <li class="{{ request()->routeIs('perhitungan.index') ? 'active-page' : '' }}"> 
                <a href="{{ route('perhitungan.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            keyboard_onscreen
                        </span>
                    </i>
                    Data Perhitungan
                </a>
            </li>

            <li class="{{ request()->routeIs('riwayat.index') ? 'active-page' : '' }}"> 
                <a href="{{ route('riwayat.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            history
                        </span>
                    </i>
                    Riwayat Diterima 
                </a>
            </li>

            <li class="{{ request()->routeIs('riwayat2.index') ? 'active-page' : '' }}"> 
                <a href="{{ route('riwayat2.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            history
                        </span>
                    </i>
                    Riwayat Ditolak 
                </a>
            </li>
            @endif

            @if(auth()->user()->role == 'petugas')
            <li class="{{ request()->routeIs('dashboard2') ? 'active-page' : '' }}">
                <a href="{{ route('dashboard2') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            dashboard
                        </span>
                    </i>
                    Dashboard
                </a>
            </li>
            <li class="{{ request()->routeIs('alternatif.index', 'alternatif.edit', 'alternatif.create') ? 'active-page' : '' }}">
                <a href="{{ route('alternatif.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            groups
                        </span>
                    </i>
                    Data Nasabah
                </a>
            </li>
            <li class="{{ request()->routeIs('penilaian.index') ? 'active-page' : '' }}">
                <a href="{{ route('penilaian.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            stylus
                        </span>
                    </i>
                    Data Penilaian
                </a>
            </li>
            <li class="{{ request()->routeIs('perhitungan.index') ? 'active-page' : '' }}"> 
                <a href="{{ route('perhitungan.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            keyboard_onscreen
                        </span>
                    </i>
                    Data Perhitungan
                </a>
            </li>

            <li class="{{ request()->routeIs('riwayat.index') ? 'active-page' : '' }}"> 
                <a href="{{ route('riwayat.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            history
                        </span>
                    </i>
                    Riwayat Diterima 
                </a>
            </li>

            <li class="{{ request()->routeIs('riwayat2.index') ? 'active-page' : '' }}"> 
                <a href="{{ route('riwayat2.index') }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            history
                        </span>
                    </i>
                    Riwayat Ditolak 
                </a>
            </li>
            @endif

            <li class="sidebar-title">
                Other
            </li>
            <li class="{{ request()->routeIs('profile.edit') ? 'active-page' : '' }}">
                <a href="{{ route('profile.edit', auth()->user()->id) }}">
                    <i class="material-icons-two-tone">
                        <span class="material-symbols-outlined">
                            Person
                        </span>
                    </i>
                    Profile
                </a>
            </li>
            
        </ul>
    </div>
</div>
