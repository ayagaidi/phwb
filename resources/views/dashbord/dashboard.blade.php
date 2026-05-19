<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>دوشة | لوحة تحكم المالك</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('dashbord/style.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="dashboard-body">

  <div class="app-layout">
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-logo">D</div>
        <span class="sidebar-brand">Dawsha</span>
      </div>
      <nav class="sidebar-nav">
        <a href="#" class="nav-item active"><span class="nav-label">الرئيسية</span></a>
        <a href="#" class="nav-item"><span class="nav-label">إدارة المستخدمين</span></a>
        <a href="#" class="nav-item"><span class="nav-label">لوحات التحكم</span></a>
      </nav>
      <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-item text-danger">
            <span class="nav-label">تسجيل الخروج</span>
          </button>
        </form>
      </div>
    </aside>

    <main class="main-area">
      <header class="toolbar">
        <h2 class="toolbar-title">لوحة تحكم المالك - إدارة المستخدمين ولوحات التحكم</h2>
      </header>
      <div class="content-scroll">
        <div class="content">
          <div class="welcome-header">
            <h1>مرحباً بك في لوحة المالك</h1>
            <p>تحكم كامل في النظام والمستخدمين</p>
          </div>
          <div class="glass-box p-6">
            <h3>إدارة النظام</h3>
            <button onclick="showUsers()" class="login-submit" style="max-width:220px; margin-top:1rem;">
              إدارة المستخدمين
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    function showUsers() {
      Swal.fire({icon:'info', title:'إدارة المستخدمين', text:'هنا يمكنك إدارة جميع المستخدمين'});
    }
  </script>
</body>
</html>
