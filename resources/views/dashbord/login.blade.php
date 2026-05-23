<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="{{ __('admin.login_description') }}" />
  <title>{{ __('admin.login_title') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('dashbord/style.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .lang-switcher-login {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 100;
      display: flex;
      background: rgba(255,255,255,0.9);
      border: 1px solid #e5e7eb;
      border-radius: 9999px;
      padding: 3px;
      font-size: 13px;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .lang-switcher-login a {
      padding: 5px 14px;
      border-radius: 9999px;
      color: #64748b;
      text-decoration: none;
      transition: all 0.2s;
    }
    .lang-switcher-login a.active {
      background: #0f172a;
      color: #fff;
    }
    .lang-switcher-login a:hover:not(.active) {
      color: #334155;
      background: #f8fafc;
    }
    /* RTL support */
    [dir="rtl"] .lang-switcher-login {
      right: auto;
      left: 20px;
    }
  </style>
 </head>
<body>
 
  <!-- Language Switcher -->
  <div class="lang-switcher-login">
    <a href="{{ route('admin.lang', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
    <a href="{{ route('admin.lang', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
  </div>

  <div class="login-page">
    <div class="login-blob1" aria-hidden="true"></div>
    <div class="login-blob2" aria-hidden="true"></div>
    <div class="login-blob3" aria-hidden="true"></div>

    <div style="position:relative; z-index:10; width:100%; max-width:420px; padding:0 1rem;">
      <div class="login-card">
        <div class="login-shine" aria-hidden="true"></div>

        <div class="login-logo-wrap">
          <div aria-hidden="true">
            <img src="{{ asset('logo.png') }}" alt="{{ __('admin.app_name') }}">
          </div>

          <p>{{ __('admin.login_subtitle') }}</p>
        </div>

        <form id="login-form" novalidate>
          @csrf
          <div class="login-fields">
            <div class="login-field">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
              </svg>
              <input class="login-input" type="email" name="email" placeholder="{{ __('admin.email') }}" required />
              <span class="error-text" id="email-error"></span>
            </div>

            <div class="login-field">
              <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
              <input class="login-input" type="password" name="password" placeholder="{{ __('admin.password') }}" required />
              <span class="error-text" id="password-error"></span>
            </div>
          </div>

          <button type="submit" class="login-submit" id="login-btn">
            <span>{{ __('admin.login_button') }}</span>
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M19 12H5m-7 0 7-7-7 7"/>
            </svg>
          </button>
        </form>
      <p class="login-version">{{ __('admin.app_name') }} — ليبيا</p>
    </div>
  </div>

  <script>
    const i18n = {
      loggingIn: @json(__('admin.logging_in')),
      loginButton: @json(__('admin.login_button')),
      errorTitle: @json(__('admin.connection_error')),
    };

    document.getElementById('login-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = document.getElementById('login-btn');
      btn.innerHTML = '<span>' + i18n.loggingIn + '</span>';
      btn.disabled = true;

      try {
        const formData = new FormData(this);
        const res = await fetch('{{ route("admin.login.post") }}', {
          method: 'POST', body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (data.success) {
          Swal.fire({icon:'success', title: '{{ __('admin.login_success') }}', text: data.message, timer:1200, showConfirmButton:false})
            .then(() => window.location.href = data.redirect);
        } else {
          // Clear previous errors
          document.getElementById('email-error').innerText = '';
          document.getElementById('password-error').innerText = '';

          // Show error under fields
          if (data.message.includes('البريد') || data.message.toLowerCase().includes('email')) {
            document.getElementById('email-error').innerText = data.message;
          } else {
            document.getElementById('password-error').innerText = data.message;
          }

          btn.innerHTML = '<span>{{ __('admin.login_button') }}</span>';
          btn.disabled = false;
        }
      } catch (err) {
        Swal.fire({icon:'error', title: i18n.errorTitle, text: i18n.errorTitle});
        btn.innerHTML = '<span>{{ __('admin.login_button') }}</span>';
        btn.disabled = false;
      }
    });
  </script>
</body>
</html>
