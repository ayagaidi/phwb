@extends('layouts.facility')

@section('title', 'إدارة المستخدمين - لوحة تحكم المنشأة')

@section('page-title', 'إدارة المستخدمين')

@section('content')
<div class="page-inner">
    @if(session('success'))
        <div class="alert alert-success mb-4" style="animation: slideIn 0.3s ease;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error mb-4" style="animation: slideIn 0.3s ease;">{{ session('error') }}</div>
    @endif

    <!-- Page Header -->
    <div class="page-hdr mb-4">
        <div>
            <h1>إدارة المستخدمين</h1>
            <p>إدارة موظفي ومسؤولي {{ $facility->name }}</p>
        </div>
        <a href="{{ route('facility.users.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none; white-space:nowrap; box-shadow:0 4px 14px rgba(0,0,0,0.12);">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            إضافة مستخدم
        </a>
    </div>

    <!-- Stats Row -->
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

    <!-- Users Table Card -->
    <div class="table-card">
        <div class="table-card-hdr">
            <h3 class="table-card-title">قائمة المستخدمين</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المستخدم</th>
                        <th class="tc">الهاتف</th>
                        <th class="tc">المنصب</th>
                        <th class="tc">الدور</th>
                        <th class="tc">الحالة</th>
                        <th class="tc">تاريخ الانضمام</th>
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
                            <td class="tc">{{ $user->phone ?? '—' }}</td>
                            <td class="tc">{{ $user->position ?? '—' }}</td>
                            <td class="tc">
                                @php
                                    $role_labels = ['admin' => 'مدير', 'manager' => 'مشرف', 'user' => 'مستخدم'];
                                @endphp
                                <span class="badge badge-orange">{{ $role_labels[$user->role] ?? $user->role }}</span>
                            </td>
                            <td class="tc">
                                @if($user->is_active)
                                    <span class="badge badge-green">نشط</span>
                                @else
                                    <span class="badge badge-gray">غير نشط</span>
                                @endif
                            </td>
                            <td class="tc">{{ $user->created_at?->format('Y-m-d') ?? '—' }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('facility.users.edit', $user) }}" class="icon-btn icon-btn-edit" title="تعديل">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('facility.users.toggle', $user) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="icon-btn {{ $user->is_active ? 'icon-btn-accept' : 'icon-btn-reject' }}"
                                                title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                                            @if($user->is_active)
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
                                            @else
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('facility.users.destroy', $user) }}" style="display:inline;"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="icon-btn icon-btn-del" title="حذف">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:3rem; color:var(--muted);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin:0 auto 1rem;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                                <br>لا يوجد مستخدمين حتى الآن
                                <br><a href="{{ route('facility.users.create') }}" style="color:var(--accent); font-weight:700;">إضافة أول مستخدم ←</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
