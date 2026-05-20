@extends('layouts.app')

@section('title', 'صيادلة بلا حدود | طرق التبرع')
@section('page-title', 'طرق التبرع')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">طرق التبرع</h3>
    <a href="{{ route('admin.donation-methods.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      إضافة طريقة
    </a>
  </div>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>الطريقة</th>
          <th>الوصف</th>
          <th>إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($methods as $index => $method)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="cell-name">
                <div class="cell-icon" style="background:var(--accent-light); color:var(--accent);">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20m10-10H2"/></svg>
                </div>
                <strong>{{ $method->name }}</strong>
              </div>
            </td>
            <td>{{ Str::limit($method->description, 60) }}</td>
            <td>
              <div class="action-btns">
                <a href="#" class="icon-btn icon-btn-edit" title="تعديل">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.donation-methods.destroy', $method->id) }}" id="delete-form-{{ $method->id }}" style="display:inline;">
                  @csrf @method('DELETE')
                  <button type="button" class="icon-btn icon-btn-reject" onclick="confirmDelete({{ $method->id }})" title="حذف">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2 2 2 0 0 1 2 2v2"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="text-align:center; padding:2rem;">لا توجد طرق تبرع بعد</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'هل أنت متأكد؟',
    text: "هل أنت متأكد من حذف طريقة التبرع؟",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'نعم، احذف',
    cancelButtonText: 'إلغاء'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('delete-form-' + id).submit();
    }
  });
}
</script>
@endsection
