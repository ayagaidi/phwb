<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', __('admin.app_name') . ' | ' . __('admin.dashboard'))</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('dashbord/style.css') }}" />
  @stack('styles')
  <style>
    .dropdown { position: relative; }
    .dropdown-menu {
      display: none; position: absolute; left: 0; top: 100%;
      background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
      box-shadow: 0 10px 15px rgba(0,0,0,0.1); min-width: 220px; z-index: 1000; padding: 8px 0;
    }
    .dropdown.active .dropdown-menu { display: block; }
    .dropdown-header { padding: 12px 16px; border-bottom: 1px solid #eee; }
    .dropdown-item { display: flex; align-items: center; gap: 8px; padding: 10px 16px; color: #333; text-decoration: none; font-size: 0.875rem; }
    .dropdown-item:hover { background: #f8f9fa; }
    .text-red { color: #e11d48; }

    .lang-switcher {
      display: flex;
      background: #f1f5f9;
      border-radius: 9999px;
      padding: 2px;
      font-size: 12px;
      font-weight: 600;
      margin: 0 4px;
    }
    .lang-btn {
      padding: 4px 10px;
      border-radius: 9999px;
      color: #64748b;
      text-decoration: none;
      transition: all 0.2s;
    }
    .lang-btn.active {
      background: #fff;
      color: #0f172a;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .lang-btn:hover:not(.active) {
      color: #334155;
    }
  </style>
</head>
<body class="dashboard-body">

  <div class="app-layout">
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <img src="{{ asset('logo.png') }}" alt="{{ __('admin.app_name') }}" >
      </div>

      <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <span class="nav-label">{{ __('admin.nav.home') }}</span>
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <span class="nav-label">{{ __('admin.nav.users') }}</span>
        </a>
        <a href="{{ route('admin.programs') }}" class="nav-item {{ request()->routeIs('admin.programs*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2v20m10-10H2"/></svg>
          <span class="nav-label">{{ __('admin.nav.programs') }}</span>
        </a>
        <a href="{{ route('admin.volunteer-content') }}" class="nav-item {{ request()->routeIs('admin.volunteer-content*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
          <span class="nav-label">{{ __('admin.nav.volunteer_content') }}</span>
        </a>
        <a href="{{ route('admin.articles') }}" class="nav-item {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          <span class="nav-label">{{ __('admin.nav.articles') }}</span>
        </a>
        <a href="{{ route('admin.donation-methods') }}" class="nav-item {{ request()->routeIs('admin.donation-methods*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2v20m10-10H2"/></svg>
           <span class="nav-label">{{ __('admin.nav.donation_methods') }}</span>
         </a>
         <a href="{{ route('admin.org-structure') }}" class="nav-item {{ request()->routeIs('admin.org-structure*') ? 'active' : '' }}">
           <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M10 7h4M7 10v4M17 10v4M10 17h4"/></svg>
           <span class="nav-label">{{ __('admin.nav.org_structure') ?? 'الهيكل التنظيمي' }}</span>
         </a>
       </nav>

      <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-item text-danger">
            <span class="nav-label">{{ __('admin.nav.logout') }}</span>
          </button>
        </form>
        <button class="sidebar-toggle-btn" id="sidebar-toggle">
          <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="m9 18 6-6-6-6"></path></svg>
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-area" id="main-area">
      <header class="toolbar">
        <h2 class="toolbar-title">@yield('page-title', __('admin.dashboard'))</h2>
        <div class="toolbar-actions">
          <!-- Search -->
          <div class="toolbar-search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" id="global-search" placeholder="{{ __('admin.toolbar.search_placeholder') }}" />
          </div>

           <!-- Language Switcher -->
           <div class="lang-switcher">
             <a href="{{ route('admin.lang', 'ar') }}" class="lang-btn {{ app()->getLocale() === 'ar' ? 'active' : '' }}" title="{{ __('admin.arabic') }}">AR</a>
             <a href="{{ route('admin.lang', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}" title="{{ __('admin.english') }}">EN</a>
           </div>

           <!-- Notifications -->
          <div class="toolbar-notifications dropdown">
            <button class="toolbar-icon-btn" type="button" aria-label="{{ __('admin.toolbar.notifications') }}">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
              </svg>
              <span class="notif-badge">3</span>
            </button>
          </div>

          <!-- Avatar -->
          <div class="toolbar-avatar dropdown" aria-hidden="true">
            <button class="toolbar-avatar-btn" type="button" aria-label="{{ __('admin.toolbar.profile') }}">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
            </button>
            <div class="dropdown-menu">
              <div class="dropdown-header">
                <strong>Admin</strong>
                <small>admin@pharmacy.com</small>
              </div>
              <div class="dropdown-divider"></div>
              <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="3" width="7" height="7" />
                  <rect x="14" y="3" width="7" height="7" />
                  <rect x="14" y="14" width="7" height="7" />
                  <rect x="3" y="14" width="7" height="7" />
                </svg>
{{ __('admin.toolbar.home') }}
                 </a>
              <div class="dropdown-divider"></div>
              <button style="background-color: #f5f5f7; border: 1px #f5f5f7;" type="button" class="dropdown-item text-red" onclick="document.getElementById('dropdown-logout-form').submit();">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                  <polyline points="16 17 21 12 16 7" />
                  <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
{{ __('admin.toolbar.logout') }}
                </button>
            </div>
          </div>
          <form id="dropdown-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </header>

      <div class="content-scroll">
        <div class="content">
          @yield('content')
        </div>
      </div>
    </main>
  </div>

  @stack('scripts')

  <script>
    // Dropdown functionality (same as facility.blade.php)
    function initDropdowns() {
      document.querySelectorAll('.toolbar-avatar-btn, .toolbar-icon-btn').forEach(button => {
        button.addEventListener('click', function(e) {
          e.stopImmediatePropagation();
          const dropdown = this.closest('.dropdown');
          if (!dropdown) return;

          // Close other dropdowns
          document.querySelectorAll('.dropdown.active').forEach(d => {
            if (d !== dropdown) d.classList.remove('active');
          });

          dropdown.classList.toggle('active');
        });
      });

      // Close dropdowns when clicking outside
      document.addEventListener('click', function(e) {
        document.querySelectorAll('.dropdown.active').forEach(dropdown => {
          if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
          }
        });
      });
    }

    document.addEventListener('DOMContentLoaded', initDropdowns);

    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
      });
    }
  </script>
</body>
</html>
