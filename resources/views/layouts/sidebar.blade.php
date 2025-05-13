  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('dist/img/logo-1.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Counsel Connect</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <i class="fas fa-angle-left right"></i>
                {{-- <span class="badge badge-info right">6</span> --}}
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('pendinguser') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending User
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('activeuser') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active User
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rejectuser') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reject User
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Courts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('courts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Main Courts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('subcourts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub Courts</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Drafts Categories

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('drafts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Main Drafts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('subdrafts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub Drafts</p>
                </a>
              </li>
            </ul>
          </li> --}}

          <li class="nav-item">
            <a href="{{ route('forums') }}" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Forum Categories
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('plans') }}" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Premium
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('area.practice') }}" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Areas of Practice
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('skills') }}" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Skill
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('withdrawal.request') }}" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Withdrawal Request
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Requirement Listing
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Set judge
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Recharge Wallet
              </p>
            </a>
          </li> --}}




        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
