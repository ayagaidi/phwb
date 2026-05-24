@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.membership_applications.title'))
@section('page-title', __('admin.membership_applications.title'))

@section('content')
@if(session('success'))
  <div class="alert mb-4" style="
      background: #ecfdf5; 
      border: 1px solid #10b981; 
      border-left: 5px solid #10b981;
      border-radius: 12px;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      color: #065f46;
      box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
  ">
    <div style="font-size: 22px; color: #10b981;">
      <i class="fas fa-check-circle"></i>
    </div>
    <div>
      <strong style="color: #065f46; font-size: 15px;">{{ __('admin.membership_applications.success') }}</strong>
      <span style="color: #047857; font-size: 14.5px;">{{ session('success') }}</span>
    </div>
  </div>
@endif

<div class="stats-cards-row mb-4">
  <div class="stat-card-users">
    <div class="top">
      <div class="ic orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      </div>
    </div>
    <p class="lbl">{{ __('admin.membership_applications.total') }}</p>
    <p class="val">{{ $allApplications->count() }}</p>
  </div>
 
  <div class="stat-card-users">
    <div class="top">
      <div class="ic green">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <span class="badge-pill">{{ $allApplications->count() > 0 ? round(($allApplications->where('membership_type', 'full_member')->count() / $allApplications->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.membership_applications.full_member_percent') }}</p>
    <p class="val">{{ $allApplications->where('membership_type', 'full_member')->count() }}</p>
  </div>
 
  <div class="stat-card-users">
    <div class="top">
      <div class="ic red">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      </div>
      <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">{{ $allApplications->count() > 0 ? round(($allApplications->whereIn('membership_type', ['student_member', 'supporter'])->count() / $allApplications->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.membership_applications.student_supporter_percent') }}</p>
    <p class="val">{{ $allApplications->whereIn('membership_type', ['student_member', 'supporter'])->count() }}</p>
  </div>
</div>

<!-- Status Filter + Export -->
<div class="mb-4" style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
        <span style="font-weight: 600; color: #374151; margin-right: 8px;">فلترة حسب الحالة:</span>
        
        <a href="{{ route('admin.membership-applications') }}" 
           class="badge {{ !$status ? 'badge-green' : 'badge-gray' }}" 
           style="text-decoration: none; padding: 6px 14px; border-radius: 9999px; font-size: 13px;">
            الكل
        </a>
        
        <a href="{{ route('admin.membership-applications', ['status' => 'pending']) }}" 
           class="badge {{ $status === 'pending' ? 'badge-orange' : 'badge-gray' }}" 
           style="text-decoration: none; padding: 6px 14px; border-radius: 9999px; font-size: 13px;">
            قيد المراجعة
        </a>
        
        <a href="{{ route('admin.membership-applications', ['status' => 'approved']) }}" 
           class="badge {{ $status === 'approved' ? 'badge-green' : 'badge-gray' }}" 
           style="text-decoration: none; padding: 6px 14px; border-radius: 9999px; font-size: 13px;">
            معتمد
        </a>
        
        <a href="{{ route('admin.membership-applications', ['status' => 'rejected']) }}" 
           class="badge {{ $status === 'rejected' ? 'badge-red' : 'badge-gray' }}" 
           style="text-decoration: none; padding: 6px 14px; border-radius: 9999px; font-size: 13px;">
            مرفوض
        </a>
    </div>

    <a href="{{ route('admin.membership-applications.export', request()->only('status')) }}" 
       class="btn btn-primary"
       style="background: #10b981; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        تصدير إلى Excel
    </a>
</div>

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">
      @if($status === 'pending')
        طلبات قيد المراجعة
      @elseif($status === 'approved')
        الطلبات المعتمدة
      @elseif($status === 'rejected')
        الطلبات المرفوضة
      @else
        {{ __('admin.membership_applications.new_applications') }}
      @endif
    </h3>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('admin.membership_applications.applicant') }}</th>
          <th class="tc">{{ __('admin.membership_applications.email') }}</th>
          <th class="tc">{{ __('admin.membership_applications.phone') }}</th>
        <th class="tc">{{ __('admin.membership_applications.type') }}</th>
        <th class="tc">الحالة</th>
        <th class="tc">{{ __('admin.membership_applications.date') }}</th>
        <th class="tl">{{ __('admin.membership_applications.actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($applications as $index => $app)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="cell-name">
                <div class="cell-icon" style="background:var(--accent-light); color:var(--accent);">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div>
                  <strong>{{ $app->full_name }}</strong>
                  <small>{{ $app->city }}</small>
                </div>
              </div>
            </td>
            <td class="tc">{{ $app->email }}</td>
            <td class="tc">{{ $app->phone }}</td>
            <td class="tc">
              @if($app->membership_type == 'full_member')
                <span class="badge badge-green">{{ __('admin.membership_applications.full_member') }}</span>
              @elseif($app->membership_type == 'student_member')
                <span class="badge badge-blue">{{ __('admin.membership_applications.student_member') }}</span>
              @else
                <span class="badge badge-orange">{{ __('admin.membership_applications.supporter') }}</span>
              @endif
            </td>
            <td class="tc">
              @if($app->status === 'approved')
                <span class="badge badge-green">معتمد</span>
              @elseif($app->status === 'rejected')
                <span class="badge badge-red">مرفوض</span>
              @else
                <span class="badge badge-orange">قيد المراجعة</span>
              @endif
            </td>
            <td class="tc">{{ $app->created_at->format('Y-m-d') }}</td>
            <td>
              <div class="action-btns">
                <a href="{{ route('admin.membership-applications.show', $app->id) }}" 
                   class="icon-btn icon-btn-edit" 
                    title="{{ __('admin.membership_applications.details_title') }}">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </a>
              </div>
            </td>
          </tr>

       
        @empty
          <tr>
            <td colspan="8" style="text-align:center; padding:3rem; color:var(--muted);">
              {{ __('admin.membership_applications.no_applications') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
