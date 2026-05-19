<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>دوشة | لوحة تحكم المتجر</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('dashbord/style.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="dashboard-body">

  <div class="app-layout">
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-logo">D</div>
        <span class="sidebar-brand">Dawsha</span>
      </div>

      <nav class="sidebar-nav">
        <a href="{{ route('owner.dashboard') }}" class="nav-item active" data-page="index">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <span class="nav-label">الرئيسية</span>
        </a>
        <a href="#" class="nav-item" data-page="orders">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
          <span class="nav-label">الطلبات</span>
        </a>
        <a href="#" class="nav-item" data-page="products">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="m7.5 4.27 9 5.15"></path><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.27 6.96 8.73 5.04 8.73-5.04"></path><path d="M12 22.08V12"></path></svg>
          <span class="nav-label">المنتجات</span>
        </a>
        <a href="#" class="nav-item" data-page="users">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <span class="nav-label">إدارة المستخدمين</span>
        </a>
        <a href="#" class="nav-item" data-page="settings">
          <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          <span class="nav-label">الإعدادات</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <form action="{{ route('owner.logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-item text-danger" id="logout-btn">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
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
        <h2 class="toolbar-title" id="toolbar-title">الرئيسية - لوحة تحكم المالك</h2>
        <div class="toolbar-actions">
          <div class="search-box">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" placeholder="بحث..." />
          </div>
          <div class="user-avatar">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
        </div>
      </header>

      <div class="content-scroll">
        <div class="content">
          
          <div class="view active" id="overview">
            <div class="welcome-header">
              <h1>مرحباً بك في لوحة تحكم المالك</h1>
              <p>إدارة كاملة للوحات التحكم والمستخدمين</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
              <div class="stat-card">
                <div class="stat-icon bg-blue-50 text-blue-600">
                  <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div class="stat-info">
                  <span class="stat-label">إجمالي المستخدمين</span>
                  <div class="stat-row">
                    <span class="stat-value">248</span>
                    <span class="stat-trend trend-up">+23</span>
                  </div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon bg-green-50 text-green-600">
                  <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div class="stat-info">
                  <span class="stat-label">لوحات التحكم النشطة</span>
                  <div class="stat-row">
                    <span class="stat-value">15</span>
                    <span class="stat-trend trend-up">+2</span>
                  </div>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon bg-purple-50 text-purple-600">
                  <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div class="stat-info">
                  <span class="stat-label">المستخدمين الجدد</span>
                  <div class="stat-row">
                    <span class="stat-value">34</span>
                    <span class="stat-trend trend-up">+12%</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="glass-box p-6">
              <h3 class="box-title">إدارة المستخدمين ولوحات التحكم</h3>
              <p class="text-gray-600 mt-2">هذه اللوحة مخصصة للمالك لإدارة جميع المستخدمين ولوحات التحكم الفرعية.</p>
              <div class="mt-4">
                <button onclick="manageUsers()" class="login-submit" style="max-width: 200px;">
                  إدارة المستخدمين
                </button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    function manageUsers() {
      Swal.fire({
        icon: 'info',
        title: 'إدارة المستخدمين',
        text: 'سيتم فتح صفحة إدارة المستخدمين قريباً',
        confirmButtonText: 'حسناً'
      });
    }

    // Logout with SweetAlert confirmation
    document.getElementById('logout-btn')?.addEventListener('click', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'تسجيل الخروج؟',
        text: 'هل أنت متأكد من تسجيل الخروج؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم، اخرج',
        cancelButtonText: 'إلغاء'
      }).then((result) => {
        if (result.isConfirmed) {
          this.closest('form').submit();
        }
      });
    });
  </script>
</body>
</html>
