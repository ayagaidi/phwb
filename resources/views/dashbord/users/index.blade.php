@extends('layouts.app')

@section('title', 'صيادلة بلا حدود | إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="stats-cards-row mb-4">
  <div class="stat-card-users">
    <div class="top">
      <div class="ic orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      </div>
    </div>
    <p class="lbl">إجمالي المستخدمين</p>
    <p class="val">{{ $users->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic green">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <span class="badge-pill">{{ $users->count() > 0 ? round(($users->where('is_active', true)->count() / $users->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">النشطين</p>
    <p class="val">{{ $users->where('is_active', true)->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic red">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      </div>
      <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">{{ $users->count() > 0 ? round(($users->where('is_active', false)->count() / $users->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">غير النشطين</p>
    <p class="val">{{ $users->where('is_active', false)->count() }}</p>
  </div>
</div>

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">قائمة المستخدمين</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      إضافة مستخدم
    </a>
  </div>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>المستخدم</th>
          <th class="tc">البريد</th>
          <th class="tc">الدور</th>
          <th class="tc">الحالة</th>
          <th class="tl">الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $index => $user)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="cell-name">
                <div class="cell-icon" style="background:var(--accent-light); color:var(--accent);">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div>
                  <strong>{{ $user->name }}</strong>
                  @if($user->email)
                    <small>{{ $user->email }}</small>
                  @endif
                </div>
              </div>
            </td>
            <td class="tc">{{ $user->email }}</td>
            <td class="tc">
              <span class="badge badge-orange">{{ $user->role ?? 'مستخدم' }}</span>
            </td>
            <td class="tc">
              @if($user->is_active)
                <span class="badge badge-green">نشط</span>
              @else
                <span class="badge badge-gray">معطل</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="icon-btn icon-btn-edit" title="تعديل">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="icon-btn {{ $user->is_active ? 'icon-btn-accept' : 'icon-btn-reject' }}" title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                    @if($user->is_active)
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
                    @else
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    @endif
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center; padding:3rem; color:var(--muted);">
              لا يوجد مستخدمين حتى الآن
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
