@extends('layouts.app')

@section('title', __('admin.org_structure.management'))
@section('page-title', __('admin.org_structure.title'))

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">الهيكل التنظيمي</h3>
    <a href="{{ route('admin.org-structure.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      {{ __('admin.org_structure.add_unit') }}
    </a>
  </div>

  <div class="org-chart-wrapper">
    <div class="org-chart">
      @forelse($units as $unit)
        <x-org-chart-node :unit="$unit" />
      @empty
        <div style="text-align:center; padding:3rem; color:var(--muted);">
          {{ __('admin.org_structure.no_units') }} <a href="{{ route('admin.org-structure.create') }}">{{ __('admin.org_structure.add_first') }}</a>
        </div>
      @endforelse
    </div>
  </div>
</div>

<style>
  .org-chart-wrapper {
    background: #f8fafc;
    padding: 2.5rem 1.5rem;
    border-radius: 16px;
    overflow-x: auto;
  }

  .org-chart {
    display: flex;
    justify-content: center;
  }

  .org-node-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
  }

  .org-node {
    background: white;
    border: 2px solid #cbd5e1;
    border-radius: 12px;
    padding: 12px 16px;
    min-width: 200px;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    z-index: 2;
  }

  .org-node-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
  }

  .org-photo {
    width: 70px;
    height: 70px;
    border-radius: 9999px;
    object-fit: cover;
    border: 3px solid #f1f5f9;
  }

  .org-photo.placeholder {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 700;
    font-size: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .org-info {
    text-align: center;
  }

  .org-name {
    font-weight: 700;
    font-size: 14.5px;
    color: #1e293b;
  }

  .org-title {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
  }

  .org-actions {
    margin-top: 8px;
    display: flex;
    justify-content: center;
    gap: 6px;
  }

  .btn-small {
    font-size: 10.5px;
    padding: 3px 8px;
    border-radius: 5px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    cursor: pointer;
    text-decoration: none;
    color: #475569;
  }

  .btn-small.edit:hover { background: #dbeafe; }
  .btn-small.delete:hover { background: #fee2e2; color: #b91c1c; }

  /* Children row - horizontal */
  .org-children-row {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 30px;
    position: relative;
    padding-top: 25px;
  }

  /* Vertical line from parent node down to the horizontal connector */
  .org-node-wrapper > .org-children-row::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 25px;
    background: #94a3b8;
  }

  /* Horizontal connector line above the children */
  .org-children-row::after {
    content: '';
    position: absolute;
    top: 25px;
    left: 20px;
    right: 20px;
    height: 2px;
    background: #94a3b8;
    z-index: 1;
  }

  /* Vertical lines from the horizontal line down to each child */
  .org-children-row > .org-node-wrapper::before {
    content: '';
    position: absolute;
    top: -25px;
    left: 50%;
    width: 2px;
    height: 25px;
    background: #94a3b8;
    z-index: 1;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
  Swal.fire({
    title: '{{ __("admin.confirm.delete_title") }}',
    text: '{{ __("admin.org_structure.deleted") }}?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: '{{ __("admin.confirm.delete_button") }}',
    cancelButtonText: '{{ __("admin.confirm.cancel") }}'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('delete-form-' + id).submit();
    }
  });
}
</script>
@endsection
