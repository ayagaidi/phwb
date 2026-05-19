<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="دوشة — تسجيل الدخول للوحة التحكم (المتجر)" />
  <title>دوشة | تسجيل الدخول</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('dashbord/style.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <div class="login-page">
    <div class="login-blob1" aria-hidden="true"></div>
    <div class="login-blob2" aria-hidden="true"></div>
    <div class="login-blob3" aria-hidden="true"></div>

    <div style="position:relative; z-index:10; width:100%; max-width:420px; padding:0 1rem;">
      <div class="login-card">
        <div class="login-shine" aria-hidden="true"></div>

        <div class="login-logo-wrap">
          <div class="login-logo" aria-hidden="true">
            <span>د</span>
          </div>
          <h1>منظومة دوشة</h1>
          <p>سجل الدخول للمتابعة إلى لوحة التحكم</p>
        </div>

        <form id="login-form" novalidate>
          @csrf
          <div class="login-fields">
            <div class="login-field">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
              </svg>
              <input class="login-input" type="email" id="login-email" name="email" placeholder="البريد الإلكتروني" required />
            </div>

            <div class="login-field">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
              <input class="login-input" type="password" id="login-password" name="password" placeholder="كلمة المرور" required />
            </div>
          </div>

          <button type="submit" class="login-submit" id="login-btn">
            <span>دخول</span>
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M19 12H5m-7 0 7-7-7 7"/>
            </svg>
          </button>
        </form>

        <div class="login-extras">
          <button type="button" class="login-biometric">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"/>
              <path d="M14 13.12c0 2.38 0 6.38-1 8.88"/>
              <path d="M17.29 21.02c.12-.6.43-2.3.5-3.02"/>
              <path d="M2 12a10 10 0 0 1 18-6"/>
              <path d="M2 17.5c0-.35.03-.7.08-1.03"/>
              <path d="M5 19.5C5.5 18 6 15 6 12a6 6 0 0 1 .34-2"/>
              <path d="M17.5 12.87a6 6 0 0 0-11.23-1.87"/>
              <path d="M20 12c0 1.72-.19 3.4-.56 5"/>
            </svg>
            <span>استخدام بصمة الوجه</span>
          </button>
          <div class="login-divider" aria-hidden="true"></div>
          <button type="button" class="login-help">هل تواجه مشكلة؟</button>
        </div>
      </div>

      <p class="login-version">Dawsha Platform &nbsp;•&nbsp; v2.4.0</p>
    </div>

    <div class="login-home-bar" aria-hidden="true"></div>
  </div>

  <script>
    document.getElementById('login-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const btn = document.getElementById('login-btn');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<span>جاري الدخول...</span>';
      btn.disabled = true;

      try {
        const formData = new FormData(this);
        
        const response = await fetch('{{ route("owner.login.post") }}', {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        const data = await response.json();

        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'نجاح',
            text: data.message,
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            window.location.href = data.redirect;
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: data.message
          });
          btn.innerHTML = originalText;
          btn.disabled = false;
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'خطأ',
          text: 'حدث خطأ في الاتصال بالخادم'
        });
        btn.innerHTML = originalText;
        btn.disabled = false;
      }
    });
  </script>
</body>
</html>
