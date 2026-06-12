@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.users.add_new'))
@section('page-title', __('admin.users.add_new'))

@section('content')
<div class="page-hdr mb-4" style="display:flex; justify-content:space-between; align-items:center;">
  <div>
    <h1 style="margin:0;">{{ __('admin.users.add_new') }}</h1>
  </div>
  <a href="{{ route('admin.users') }}" class="btn btn-back" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.25rem; border-radius:16px; background:var(--surface); border:1px solid var(--border-gray); color:var(--muted); font-size:0.875rem; font-weight:700; text-decoration:none;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    {{ __('admin.users.back') }}
  </a>
</div>

<div class="form-layout">
  <!-- Side Preview -->
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
    </div>
    <h3>{{ __('admin.users.new_user') }}</h3>
    <p>{{ __('admin.users.add_description') }}</p>

    <div class="preview-stats">
      <div class="preview-stat orange">
        <p>{{ __('admin.users.role') }}</p>
        <p>{{ __('admin.users.role_set_on_create') }}</p>
      </div>
    </div>
  </div>

  <!-- Form Section -->
  <div class="form-section">
    <form method="POST" action="{{ route('admin.users.store') }}" id="createUserForm">
      @csrf

      <div class="form-section-hdr">
        <div class="form-section-hdr-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <h3>{{ __('admin.users.user_data') }}</h3>
      </div>

      <div class="field-grid">
        <div class="field-group">
          <label>{{ __('admin.users.full_name') }} <span style="color:var(--red)">*</span></label>
          <input type="text" name="name" class="field-input" value="{{ old('name') }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.email') }} <span style="color:var(--red)">*</span></label>
          <input type="email" name="email" class="field-input" value="{{ old('email') }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.users.password') }} <span style="color:var(--red)">*</span></label>
          <input type="password" name="password" class="field-input" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.users.role') }}</label>
          <select name="role" class="field-input" id="roleSelect">
            <option value="admin">{{ __('admin.users.role_admin') }}</option>
            <option value="staff">{{ __('admin.users.role_staff') }}</option>
          </select>
        </div>
      </div>

      <div id="permissionsSection" style="display:none; margin-top: 1.5rem;">
        <div class="form-section-hdr">
          <div class="form-section-hdr-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2z"/><path d="M12 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
          </div>
          <h3>{{ __('admin.permissions.admin_sections') }}</h3>
        </div>
        <p style="color: var(--muted); margin-bottom: 1rem;">{{ __('admin.permissions.staff_hint') }}</p>

        <div class="permissions-grid">
          @foreach($sections as $sectionKey => $actions)
            @php
              $labelKey = 'admin.nav.' . $sectionKey;
              $label = __($labelKey);
              if ($label === $labelKey) {
                $label = ucwords(str_replace('-', ' ', $sectionKey));
              }
              $fullActions = implode(', ', $actions);
            @endphp
            <div class="perm-item">
              <div class="perm-item-hdr">
                <input type="checkbox" class="full-access-check" data-section="{{ $sectionKey }}">
                <label for="" style="font-weight:600; font-size:0.9rem; color:#111827;">
                  {{ $label }}
                </label>
              </div>
              <div class="perm-actions">
                @foreach($actions as $action)
                  @php
                    $actionLabelKey = 'admin.permissions.actions.' . $action;
                    $actionLabel = __($actionLabelKey);
                    if ($actionLabel === $actionLabelKey) {
                      $actionLabels = [
                        'view' => 'عرض',
                        'create' => 'إضافة',
                        'edit' => 'تعديل',
                        'delete' => 'حذف',
                        'update' => 'تحديث',
                        'export' => 'تصدير',
                      ];
                      $actionLabel = $actionLabels[$action] ?? $action;
                    }
                  @endphp
                  <label style="display:inline-flex; align-items:center; gap:0.25rem; font-size:0.8rem; color:#6b7280; margin-right:0.75rem;">
                    <input type="checkbox" name="permissions[{{ $sectionKey }}][]" value="{{ $action }}" class="action-check" {{ in_array('view', $actions) ? '' : '' }}>
                    {{ $actionLabel }}
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; border:none; cursor:pointer; margin-top: 1.5rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        {{ __('admin.users.add_button') }}
      </button>
    </form>
  </div>
</div>

<style>
.permissions-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
}
.perm-item {
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 1rem;
}
.perm-item-hdr {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}
.perm-actions {
  padding-right: 1.5rem;
}
.full-access-check {
  width: 18px;
  height: 18px;
  accent-color: var(--accent, #6366f1);
  cursor: pointer;
}
.action-check {
  width: 14px;
  height: 14px;
  accent-color: var(--accent, #6366f1);
  cursor: pointer;
}
</style>

<script>
document.getElementById('roleSelect').addEventListener('change', function() {
  var section = document.getElementById('permissionsSection');
  if (this.value === 'staff') {
    section.style.display = 'block';
  } else {
    section.style.display = 'none';
  }
});

document.querySelectorAll('.full-access-check').forEach(function(check) {
  check.addEventListener('change', function() {
    var section = this.dataset.section;
    var actionChecks = document.querySelectorAll('.action-check');
    actionChecks.forEach(function(c) {
      var name = c.getAttribute('name');
      if (name && name.includes('[' + section + ']')) {
        c.checked = check.checked;
      }
    });
  });
});
</script>
@endsection
