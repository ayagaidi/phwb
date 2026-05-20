@extends('layouts.app')

@section('title', 'صيادلة بلا حدود | الأخبار والمقالات')
@section('page-title', 'الأخبار والمقالات')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}
  </div>
@endif

<div class="stats-cards-row mb-4">
  <div class="stat-card-users">
    <div class="top">
      <div class="ic orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
    </div>
    <p class="lbl">إجمالي المقالات</p>
    <p class="val">{{ $articles->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic green">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <span class="badge-pill">{{ $articles->count() > 0 ? round(($articles->where('is_published', true)->count() / $articles->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">المنشورة</p>
    <p class="val">{{ $articles->where('is_published', true)->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic red">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      </div>
      <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">{{ $articles->count() > 0 ? round(($articles->where('is_published', false)->count() / $articles->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">المسودات</p>
    <p class="val">{{ $articles->where('is_published', false)->count() }}</p>
  </div>
</div>

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">قائمة الأخبار والمقالات</h3>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      إضافة مقالة
    </a>
  </div>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>العنوان</th>
          <th class="tc">الحالة</th>
          <th class="tc">التاريخ</th>
          <th class="tl">الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($articles as $index => $article)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="cell-name">
                <div class="cell-icon" style="background:var(--accent-light); color:var(--accent);">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                  <strong>{{ $article->title }}</strong>
                </div>
              </div>
            </td>
            <td class="tc">
              @if($article->is_published)
                <span class="badge badge-green">منشور</span>
              @else
                <span class="badge badge-gray">مسودة</span>
              @endif
            </td>
            <td class="tc">{{ $article->created_at ? $article->created_at->format('Y-m-d') : '-' }}</td>
            <td>
              <div class="action-btns">
                <a href="{{ route('admin.articles.edit', $article->id) }}" class="icon-btn icon-btn-edit" title="تعديل">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.articles.toggle', $article->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="icon-btn {{ $article->is_published ? 'icon-btn-reject' : 'icon-btn-accept' }}" title="{{ $article->is_published ? 'إلغاء النشر' : 'نشر' }}">
                    @if($article->is_published)
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
                    @else
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    @endif
                  </button>
                </form>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" id="delete-form-{{ $article->id }}" style="display:inline;">
                   @csrf @method('DELETE')
                   <button type="button" class="icon-btn icon-btn-reject" onclick="confirmDelete({{ $article->id }})" title="حذف">
                     <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2 2 2 0 0 1 2 2v2"/></svg>
                   </button>
                 </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="text-align:center; padding:3rem; color:var(--muted);">
              لا توجد مقالات حتى الآن
            </td>
          </tr>
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
    text: "هل أنت متأكد من حذف هذه المقالة؟",
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
