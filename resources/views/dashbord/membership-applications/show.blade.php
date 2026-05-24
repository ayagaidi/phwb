@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.membership_applications.details_title'))
@section('page-title', __('admin.membership_applications.details_title'))

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

<div class="form-layout">
  <!-- Preview Sidebar -->
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
      </svg>
    </div>
    <h3>{{ $application->full_name }}</h3>
    <p>{{ $application->email }}</p>
    <p class="mt-2">
      @if($application->membership_type == 'full_member')
        <span class="badge badge-green">عضو عامل</span>
      @elseif($application->membership_type == 'student_member')
        <span class="badge badge-blue">عضو طالب</span>
      @else
        <span class="badge badge-orange">عضو داعم</span>
      @endif
    </p>
  </div>

  <!-- Main Content -->
  <div class="form-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
       <h3>{{ __('admin.membership_applications.details_title') }}</h3>
       <a href="{{ route('admin.membership-applications') }}" class="btn btn-secondary btn-sm">
         <i class="fas fa-arrow-left ml-2"></i> {{ __('admin.membership_applications.back') }}
       </a>
    </div>

    <!-- Personal & Professional Data -->
    <div class="row">
      <div class="col-md-6">
        <h5 class="mb-3">{{ __('admin.membership_applications.personal_data') }}</h5>
        <div class="field-group">
          <label>الاسم الكامل</label>
          <div class="field-input bg-light">{{ $application->full_name }}</div>
        </div>
        <div class="field-group">
          <label>تاريخ الميلاد</label>
          <div class="field-input bg-light">{{ $application->date_of_birth ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>الجنس</label>
          <div class="field-input bg-light">{{ $application->gender ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>الهاتف</label>
          <div class="field-input bg-light">{{ $application->phone }}</div>
        </div>
        <div class="field-group">
          <label>واتساب</label>
          <div class="field-input bg-light">{{ $application->whatsapp ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>المدينة</label>
          <div class="field-input bg-light">{{ $application->city }}</div>
        </div>
      </div>

      <div class="col-md-6">
        <h5 class="mb-3">{{ __('admin.membership_applications.professional_data') }}</h5>
        <div class="field-group">
          <label>المؤهل العلمي</label>
          <div class="field-input bg-light">{{ $application->qualification ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>الجامعة</label>
          <div class="field-input bg-light">{{ $application->university ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>سنة التخرج</label>
          <div class="field-input bg-light">{{ $application->graduation_year ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>رقم الترخيص</label>
          <div class="field-input bg-light">{{ $application->license_number ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>مكان العمل</label>
          <div class="field-input bg-light">{{ $application->current_workplace ?? '-' }}</div>
        </div>
        <div class="field-group">
          <label>سنوات الخبرة</label>
          <div class="field-input bg-light">{{ $application->years_experience ?? '-' }}</div>
        </div>
      </div>
    </div>

    <hr class="my-4">

    <h5 class="mb-3">{{ __('admin.membership_applications.membership_info') }}</h5>
    <div class="field-group">
      <label>سبب الانضمام</label>
      <div class="field-input bg-light" style="min-height: 80px; white-space: pre-wrap;">{{ $application->reason }}</div>
    </div>

    @if($application->contribution_areas)
    <div class="field-group">
      <label>مجالات المساهمة</label>
      <div class="field-input bg-light" style="min-height: 60px; white-space: pre-wrap;">{{ $application->contribution_areas }}</div>
    </div>
    @endif

    <div class="field-group">
      <label>متاح للعمل الميداني</label>
      <div class="field-input bg-light">{{ $application->available_for_fieldwork ? __('admin.membership_applications.yes') : __('admin.membership_applications.no') }}</div>
    </div>

    <hr class="my-4">

    <!-- Admin Actions -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-light">
        <h5 class="mb-0">{{ __('admin.membership_applications.admin_actions') }}</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.membership-applications.update', $application->id) }}">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-5">
              <div class="field-group">
                <label>حالة الطلب</label>
                <select name="status" class="field-input form-select">
                  <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>{{ __('admin.membership_applications.pending') }}</option>
                  <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>{{ __('admin.membership_applications.approved') }}</option>
                  <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>{{ __('admin.membership_applications.rejected') }}</option>
                </select>
              </div>
            </div>

            <div class="col-md-7">
              <div class="field-group">
                <label>ملاحظات الإدارة</label>
                 <textarea name="admin_notes" class="field-input" rows="4" placeholder="{{ __('admin.membership_applications.admin_notes_placeholder') }}">{{ $application->admin_notes }}</textarea>
              </div>
            </div>
          </div>

          <div class="mt-4">
             <button type="submit" class="btn btn-primary px-4">
               <i class="fas fa-save me-2"></i> {{ __('admin.membership_applications.save_changes') }}
             </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
