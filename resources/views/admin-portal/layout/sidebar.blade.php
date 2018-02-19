<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="" class="site_title"> <span>Portal Admin</span></a>
    </div>

    <div class="clearfix"></div>

    <div class="profile">
      <div class="profile_pic">
        <img src="{{ asset('asset/picture/admin-portal/user/').'/'.Auth::user()->avatar }}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Hai,</span>
        <h2>{{ Auth::user()->name }}</h2>
      </div>
    </div>

    <div class="clearfix"></div>

    <br />

    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <li class="{{ Route::is('adpor.dashboard') ? 'active' : '' }}">
            <a href="{{ route('adpor.dashboard') }}"><i class="fa fa-home"></i> Dashbor </a>
          </li>
          <li><?php // Account ?>
            <a>
              <i class="fa fa-users"></i> Account <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li class="{{ Route::is('adpor.user.index') ? 'current-page' : '' }}">
                <a href="{{ route('adpor.user.index') }}"><i class="fa fa-user"></i>Users</a>
              </li>
              <li class="{{ Route::is('adpor.user.loguser') ? 'current-page' : '' }}">
                <a href="{{ route('adpor.user.loguser') }}"><i class="fa fa-cogs"></i>Users Logs</a>
              </li>
            </ul>
          </li>
          <li><?php // Content Web ?>
            <a>
              <i class="fa fa-globe"></i> Content Web <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li class="{{ Route::is('adpor.albfot*') ? 'active' : '' }}">
                <a href="{{ route('adpor.albfot.index') }}">Album Foto </a>
              </li>
              <li class="{{ Route::is('adpor.banner*') ? 'active' : '' }}">
                <a href="{{ route('adpor.banner.index') }}">Banner </a>
              </li>
              <li class="{{ Route::is('adpor.berkel*') ? 'active' : '' }}">
                <a href="{{ route('adpor.berkel.index') }}">Berita Artikel </a>
              </li>
              <li class="{{ Route::is('adpor.datbaz*') ? 'active' : '' }}">
                <a href="{{ route('adpor.datbaz.index') }}">Data Bazis </a>
              </li>
              <li class="{{ Route::is('adpor.halaman*') ? 'active' : '' }}">
                <a href="{{ route('adpor.halaman.index') }}">Halaman </a>
              </li>
              <li class="{{ Route::is('adpor.iklan*') ? 'active' : '' }}">
                <a href="{{ route('adpor.iklan.index') }}">Iklan </a>
              </li>
              <li class="{{ Route::is('adpor.medsos*') ? 'active' : '' }}">
                <a href="{{ route('adpor.medsos.index') }}">Media Sosial </a>
              </li>
              <li class="{{ Route::is('adpor.penumu*') ? 'active' : '' }}">
                <a href="{{ route('adpor.penumu.index') }}">Pengaturan Umum </a>
              </li>
              <li class="{{ Route::is('adpor.prokam*') ? 'active' : '' }}">
                <a href="{{ route('adpor.prokam.index') }}">Program Bazis </a>
              </li>
              <li class="{{ Route::is('adpor.lapzis*') ? 'active' : '' }}">
                <a href="{{ route('adpor.lapzis.index') }}">Laporan ZIS </a>
              </li>
              <li class="{{ Route::is('adpor.testim*') ? 'active' : '' }}">
                <a href="{{ route('adpor.testim.index') }}">Testimoni </a>
              </li>
              <li class="{{ Route::is('adpor.viyou*') ? 'active' : '' }}">
                <a href="{{ route('adpor.viyou.index') }}">Video Youtube </a>
              </li>
            </ul>
          </li>
          <li><?php // Penerimaan ZIS ?>
            <a>
              <i class="fa fa-archive"></i> Penerimaan ZIS Online <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="{{ Route::is('adpor.penzis*') ? 'display: block;' : '' }}">
              <li class="{{ Route::is('adpor.penzis.banpen.index') ? 'current-page' : '' }}">
                <a href="{{ route('adpor.penzis.banpen.index') }}"><i class="fa fa-university"></i>Bank Penerima</a>
              </li>
              <li class="{{ Route::is('adpor.penzis.rekban.index') ? 'current-page' : '' }}">
                <a href="{{ route('adpor.penzis.rekban.index') }}"><i class="fa fa-money"></i>Rekening Bank</a>
              </li>
              <li class="{{ Route::is('adpor.penzis.riwpen.index') ? 'current-page' : '' }}">
                <a href="{{ route('adpor.penzis.riwpen.index') }}"><i class="fa fa-book"></i>Riwayat Penerimaan</a>
              </li>
              <li class="{{ Route::is('adpor.penzis.riwpen.deleteIndex') ? 'current-page' : '' }}">
                <a href="{{ route('adpor.penzis.riwpen.deleteIndex') }}"><i class="fa fa-trash"></i>ZIS DIhapus</a>
              </li>
            </ul>
          </li>
          <li><?php // Pengunjung Website ?>
            <a>
              <i class="fa fa-child"></i> Pengunjung Web Bazis <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
              <li class="{{ Route::is('adpor.pengunjung*') ? 'active' : '' }}">
                <a href="{{ route('adpor.pengunjung.index') }}"><i class="fa fa-child"></i> Pengunjung </a>
              </li>
              <li class="{{ Route::is('adpor.kotakmasuk*') ? 'active' : '' }}">
                <a href="{{ route('adpor.kotakmasuk.inbox') }}"><i class="fa fa-envelope"></i> Kotak Masukk</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>


    {{--
    <div class="sidebar-footer hidden-small">
      <a 
        href="" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Users"
      >
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
      </a>
      <a 
        href="" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Kotak Masuk"
      >
        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
      </a>
      <a 
        href="" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Profile"
      >
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a 
        href="{{ route('logout')}}" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Logout"
      >
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    --}}

  </div>
</div>
