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

    .mobile-sidebar-btn {
      display: none;
      background: none;
      border: none;
      padding: 8px;
      margin-left: 4px;
      margin-right: 8px;
      color: var(--text);
      cursor: pointer;
      border-radius: 6px;
    }

    .mobile-sidebar-btn:hover {
      background: #f1f5f9;
    }

    @media (max-width: 768px) {
      .mobile-sidebar-btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
      }

      .toolbar {
        padding-left: 8px;
      }
    }

    /* ==================== RESPONSIVE DASHBOARD ==================== */
    @media (max-width: 767px) {
      .app-layout {
        flex-direction: column;
      }

      .sidebar {
        position: fixed;
        top: 0;
        right: -280px;
        width: 260px;
        height: 100vh;
        z-index: 999;
        transition: right 0.3s ease;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
      }

      .sidebar.mobile-open {
        right: 0;
      }

      .main-area {
        margin-right: 0 !important;
        width: 100%;
      }

      .toolbar {
        flex-wrap: wrap;
        gap: 0.5rem;
      }

      .toolbar-actions {
        width: 100%;
        flex-wrap: wrap;
      }

      .toolbar-search {
        flex: 1;
        min-width: 160px;
      }

      .sidebar-toggle-btn {
        display: flex !important;
      }
    }
  </style>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <i class="nav-icon fas fa-newspaper"></i>
            <span class="nav-label">{{ __('admin.nav.articles') }}</span>
        </a>

        <a href="{{ route('admin.membership-applications') }}" class="nav-item {{ request()->routeIs('admin.membership-applications*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-plus"></i>
            <span class="nav-label">{{ __('admin.nav.membership_applications') }}</span>
        </a>
        <a href="{{ route('admin.donation-methods') }}" class="nav-item {{ request()->routeIs('admin.donation-methods*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2v20m10-10H2"/></svg>
           <span class="nav-label">{{ __('admin.nav.donation_methods') }}</span>
         </a>
         <a href="{{ route('admin.org-structure') }}" class="nav-item {{ request()->routeIs('admin.org-structure*') ? 'active' : '' }}">
           <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M10 7h4M7 10v4M17 10v4M10 17h4"/></svg>
             <span class="nav-label">{{ __('admin.nav.org_structure') }}</span>
          </a>
          <a href="{{ route('admin.contact-settings') }}" class="nav-item {{ request()->routeIs('admin.contact-settings*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
             <span class="nav-label">{{ __('admin.nav.contact_settings') }}</span>
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
        <!-- Mobile Sidebar Toggle -->
        <button id="mobile-sidebar-toggle" class="mobile-sidebar-btn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>

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
                @php
                  $unreadQuery = \App\Models\MembershipApplication::where(function($q){
                      $q->whereNull('status')->orWhere('status', 'pending');
                  })->whereNull('read_at');

                  $pendingCount = $unreadQuery->count();

                  $recentPending = $unreadQuery->latest()->take(5)->get();
                @endphp

                <button class="toolbar-icon-btn" type="button" aria-label="{{ __('admin.toolbar.notifications') }}">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                  </svg>
                  @if($pendingCount > 0)
                    <span class="notif-badge">{{ $pendingCount }}</span>
                  @endif
                </button>

                <div class="dropdown-menu" style="right:auto; min-width:300px; max-width:340px; padding:4px 0;">
                  <div class="dropdown-header" style="display:flex; justify-content:space-between; align-items:center; padding:8px 14px;">
                    <strong>الإشعارات</strong>
                    @if($pendingCount > 0)
                      <span style="font-size:11px; background:#fee2e2; color:#b91c1c; padding:1px 6px; border-radius:999px; font-weight:600;">{{ $pendingCount }} جديد</span>
                    @endif
                  </div>

                  @forelse($recentPending as $app)
                    <div class="dropdown-item" style="display:flex; align-items:center; justify-content:space-between; padding:8px 14px; gap:8px;">
                      <a href="{{ route('admin.membership-applications.show', $app->id) }}" style="flex:1; text-decoration:none; color:inherit;">
                        <div style="font-weight:600; font-size:13.5px; color:#111;">{{ $app->full_name }}</div>
                        <div style="font-size:11.5px; color:#64748b; margin-top:1px;">
                          {{ str_replace('_', ' ', $app->membership_type) }} • {{ $app->created_at->diffForHumans() }}
                        </div>
                      </a>
                      <form method="POST" action="{{ route('admin.membership-applications.mark-read', $app->id) }}" style="margin:0;">
                        @csrf
                        <button type="submit" title="وضع كمقروء" style="background:none; border:none; color:#64748b; cursor:pointer; font-size:13px; padding:2px 6px;">✓</button>
                      </form>
                    </div>
                  @empty
                    <div class="dropdown-item" style="color:#64748b; padding:10px 14px; font-size:13px;">
                      لا توجد طلبات عضوية جديدة
                    </div>
                  @endforelse

                  @if($pendingCount > 0)
                    <div style="height:1px; background:#eee; margin:4px 0;"></div>

                    <form method="POST" action="{{ route('admin.membership-applications.mark-all-read') }}" style="margin:0;">
                      @csrf
                      <button type="submit" class="dropdown-item" style="font-weight:600; color:#b91c1c; width:100%; text-align:left; border:none; background:none; cursor:pointer; padding:8px 14px;">
                        وضع الكل كمقروء
                      </button>
                    </form>

                    <a href="{{ route('admin.membership-applications') }}" class="dropdown-item" style="font-weight:600; color:var(--accent); padding:8px 14px;">
                      عرض كل طلبات العضوية →
                    </a>
                  @endif
                </div>
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
                 <strong>{{ Auth::user()->name }}</strong>
                 <small>{{ Auth::user()->email }}</small>
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
               <a href="{{ route('admin.profile') }}" class="dropdown-item">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                   <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                   <circle cx="12" cy="7" r="4" />
                 </svg>
                 {{ __('admin.profile.title') }}
               </a>
              <div class="dropdown-divider"></div>
              <button style="background-color: #fff; border: 1px #fff;" type="button" class="dropdown-item text-red" onclick="document.getElementById('dropdown-logout-form').submit();">
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

    document.addEventListener('DOMContentLoaded', function() {
      initDropdowns();

      // Sidebar elements
      const sidebarToggle = document.getElementById('sidebar-toggle');
      const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
      const sidebar = document.getElementById('sidebar');

      function toggleSidebar() {
        if (!sidebar) return;

        if (window.innerWidth < 768) {
          // Mobile: toggle drawer
          sidebar.classList.toggle('mobile-open');
        } else {
          // Desktop: toggle collapse
          sidebar.classList.toggle('collapsed');
        }
      }

      // Desktop sidebar toggle button (inside sidebar)
      if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', toggleSidebar);
      }

      // Mobile hamburger button in toolbar
      if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function(e) {
          e.stopImmediatePropagation();
          toggleSidebar();
        });
      }

      // Close drawer when clicking outside (mobile only)
      document.addEventListener('click', function(e) {
        if (window.innerWidth < 768 && 
            sidebar && 
            sidebar.classList.contains('mobile-open') && 
            !sidebar.contains(e.target) && 
            mobileSidebarToggle && 
            !mobileSidebarToggle.contains(e.target)) {
          sidebar.classList.remove('mobile-open');
        }
      });
    });
  </script>
</body>
</html>
