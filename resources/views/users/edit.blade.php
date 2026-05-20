@extends('layouts.facility')

@section('title', 'تعديل مستخدم - {{ $facility->name }}')

@section('page-title', 'تعديل مستخدم')

@section('content')
<div class="page-inner">
    @if(session('success'))
        <div class="alert alert-success mb-4" style="animation: slideIn 0.3s ease;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error mb-4" style="animation: slideIn 0.3s ease;">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error mb-4" style="animation: slideIn 0.3s ease;">
            <strong>يرجى تصحيح الأخطاء التالية:</strong>
            <ul style="margin:0.5rem 0 0 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-hdr mb-4">
        <div>
            <h1>تعديل المستخدم</h1>
            <p>تحديث بيانات المستخدم: {{ $user->name }}</p>
        </div>
        <a href="{{ route('facility.users.index') }}" class="btn btn-back" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.25rem; border-radius:16px; background:var(--surface); border:1px solid var(--border-gray); color:var(--muted); font-size:0.875rem; font-weight:700; text-decoration:none; white-space:nowrap;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            عودة
        </a>
    </div>

    <div class="form-layout">
        <!-- Side Preview Card -->
        <div class="form-preview">
            <div class="form-preview-icon" style="background:{{ $user->is_active ? 'var(--green-light)' : 'var(--red-light)' }}; color:{{ $user->is_active ? 'var(--green)' : 'var(--red)' }};">
                @if($user->is_active)
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
                @else
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
                @endif
            </div>
            <h3>{{ $user->name }}</h3>
            <p>{{ $user->email ?? 'لا يوجد بريد' }}</p>

            <div class="preview-stats">
                <div class="preview-stat orange">
                    <p>هوية المستخدم</p>
                    <p>#{{ $user->id }}</p>
                </div>
                <div class="preview-stat orange">
                    <p>تاريخ الانضمام</p>
                    <p>{{ $user->created_at?->format('m/Y') ?? '—' }}</p>
                </div>
            </div>

            <div style="margin-top:1.25rem; padding:1rem; background:var(--bg); border-radius:16px; text-align:left;">
                <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-gray' }}">
                    {{ $user->is_active ? '● نشط' : '○ غير نشط' }}
                </span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-section">
            <form method="POST" action="{{ route('facility.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="form-section-hdr">
                    <div class="form-section-hdr-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h3>تعديل البيانات</h3>
                </div>

                <div class="field-grid">
                    <div class="field-group">
                        <label for="name">الاسم الكامل <span style="color:var(--red)">*</span></label>
                        <input type="text" name="name" id="name" class="field-input @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" placeholder="الاسم الكامل للمستخدم" required>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="role">الدور <span style="color:var(--red)">*</span></label>
                        <select name="role" id="role" class="field-input @error('role') is-invalid @enderror" required>
                            <option value="user"   {{ old('role', $user->role) == 'user'   ? 'selected' : '' }}>مستخدم</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>مشرف</option>
                            <option value="admin"  {{ old('role', $user->role) == 'admin'  ? 'selected' : '' }}>مدير</option>
                        </select>
                        @error('role')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email"
                               class="field-input @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" placeholder="example@sharyan.com">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone"
                               class="field-input @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}" placeholder="05xxxxxxxx">
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="national_id">الرقم الوطني</label>
                        <input type="text" name="national_id" id="national_id"
                               class="field-input @error('national_id') is-invalid @enderror"
                               value="{{ old('national_id', $user->national_id) }}" placeholder="الرقم الوطني">
                        @error('national_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="position">المنصب الوظيفي</label>
                        <input type="text" name="position" id="position"
                               class="field-input @error('position') is-invalid @enderror"
                               value="{{ old('position', $user->position) }}" placeholder="e.g. طبيب، ممرض">
                        @error('position')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="department">القسم</label>
                        <input type="text" name="department" id="department"
                               class="field-input @error('department') is-invalid @enderror"
                               value="{{ old('department', $user->department) }}" placeholder="e.g. الطوارئ، الباطنية">
                        @error('department')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="password">كلمة المرور الجديدة</label>
                        <small style="display:block; color:var(--muted); margin-bottom:0.4rem; font-size:0.75rem;">اتركها فارغة لعدم التغيير</small>
                        <input type="password" name="password" id="password"
                               class="field-input @error('password') is-invalid @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="field-input" placeholder="••••••••">
                    </div>
                </div>

                <div style="display:flex; gap:1rem; align-items:center; margin-top:2rem; flex-wrap:wrap;">
                    <button type="submit" class="btn btn-save" style="display:inline-flex; align-items:center; gap:0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                        حفظ التغييرات
                    </button>
                    <a href="{{ route('facility.users.index') }}" class="btn btn-cancel">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
