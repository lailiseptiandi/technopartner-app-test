  <div class="main-sidebar">
      <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
              <a href="#">Test</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
              <a href="#">Test</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown {{ set_active('home') }} ">
                  <a href="{{ route('home') }}" class="nav-link"><i
                          class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
              <li class="menu-header">Fitur</li>
              <li class="nav-item {{ set_active('category.*') }} ">
                  <a href="{{ route('category.index') }}" class="nav-link"><i class="fas fa-columns"></i>
                      <span>Kategori</span></a>
              </li>
              <li class="nav-item {{ set_active(['transaction.*', 'filter.*']) }}">
                  <a href="{{ route('transaction.index') }}" class="nav-link"><i class="fas fa-columns"></i>
                      <span>Transaksi</span></a>
              </li>
          </ul>
      </aside>
  </div>
