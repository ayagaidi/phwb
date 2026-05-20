<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'صيادلة بلا حدود | لوحة التحكم')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('dashbord/style.css') }}" />
  @stack('styles')
</head>
<body class="dashboard-body">

  <div class="app-layout">
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-logo">D</div>
        <span class="sidebar-brand">صيادلة بلا حدود</span>
      </div>

      <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <span class="nav-label">الرئيسية</span>
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <span class="nav-label">المستخدمين</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-item text-danger">
            <span class="nav-label">تسجيل الخروج</span>
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
        <h2 class="toolbar-title">@yield('page-title', 'لوحة التحكم')</h2>
        <div class="toolbar-actions">
          <div class="search-box">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" placeholder="بحث..." />
          </div>
          <button class="icon-btn">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
            <span class="badge"></span>
          </button>
          <div class="user-avatar">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
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
</body>
</html>
