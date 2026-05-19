<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>دوشة | تسجيل الدخول</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../style.css" />
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
          <div class="login-logo" aria-hidden="true"><span>د</span></div>
          <h1>منظومة دوشة</h1>
          <p>سجل الدخول للمتابعة إلى لوحة التحكم</p>
        </div>

        <form id="login-form" novalidate>
          @csrf
          <div class="login-fields">
            <div class="login-field">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
              <input class="login-input" type="email" name="email" placeholder="البريد الإلكتروني" required />
            </div>
            <div class="login-field">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input class="login-input" type="password" name="password" placeholder="كلمة المرور" required />
            </div>
          </div>

          <button type="submit" class="login-submit" id="login-btn">
            <span>دخول</span>
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5m-7 0 7-7-7 7"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('login-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = document.getElementById('login-btn');
      btn.innerHTML = '<span>جاري الدخول...</span>';
      btn.disabled = true;

      try {
        const formData = new FormData(this);
        const res = await fetch('{{ route("admin.login.post") }}', {
          method: 'POST', body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (data.success) {
          Swal.fire({icon:'success', title:'نجاح', text:data.message, timer:1200, showConfirmButton:false})
            .then(() => window.location.href = data.redirect);
        } else {
          Swal.fire({icon:'error', title:'خطأ', text:data.message});
          btn.innerHTML = '<span>دخول</span>';
          btn.disabled = false;
        }
      } catch (err) {
        Swal.fire({icon:'error', title:'خطأ', text:'مشكلة في الاتصال'});
        btn.innerHTML = '<span>دخول</span>';
        btn.disabled = false;
      }
    });
  </script>
</body>
</html>
