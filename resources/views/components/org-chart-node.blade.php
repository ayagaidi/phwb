@props(['unit'])

<div class="org-node-wrapper">
  <!-- The person/unit box -->
  <div class="org-node">
    <div class="org-node-inner">
      @if($unit->photo)
        <img src="{{ asset('storage/' . $unit->photo) }}" class="org-photo" alt="{{ $unit->display_name }}">
      @else
        <div class="org-photo placeholder">
          {{ strtoupper(mb_substr($unit->display_name, 0, 1)) }}
        </div>
      @endif

      <div class="org-info">
        <div class="org-name">{{ $unit->display_name }}</div>
        @if($unit->display_title)
          <div class="org-title">{{ $unit->display_title }}</div>
        @endif
      </div>
    </div>

    <div class="org-actions">
      <a href="{{ route('admin.org-structure.edit', $unit->id) }}" class="btn-small edit" title="{{ __('admin.org_structure.edit') ?? 'تعديل' }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
      </a>
      <form method="POST" action="{{ route('admin.org-structure.destroy', $unit->id) }}" id="delete-form-{{ $unit->id }}" style="display:inline;">
        @csrf @method('DELETE')
        <button type="button" class="btn-small delete" onclick="confirmDelete({{ $unit->id }})" title="{{ __('admin.org_structure.delete') ?? 'حذف' }}">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2 2 2 0 0 1 2 2v2"/></svg>
        </button>
      </form>
    </div>
  </div>

  <!-- Children in horizontal row -->
  @if($unit->children->count() > 0)
    <div class="org-children-row">
      @foreach($unit->children as $child)
        <x-org-chart-node :unit="$child" />
      @endforeach
    </div>
  @endif
</div>
