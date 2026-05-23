@props(['unit'])

<li>
  <div class="org-node">
    <div class="org-node-content">
      @if($unit->photo)
        <img src="{{ asset('storage/' . $unit->photo) }}" class="org-photo" alt="{{ $unit->display_name }}">
      @else
        <div class="org-photo placeholder">
          {{ strtoupper(mb_substr($unit->display_name, 0, 1)) }}
        </div>
      @endif

      <div class="org-text">
        <div class="org-name">{{ $unit->display_name }}</div>
        @if($unit->display_title)
          <div class="org-title">{{ $unit->display_title }}</div>
        @endif
      </div>
    </div>

    <div class="org-actions">
      <a href="{{ route('admin.org-structure.edit', $unit->id) }}" class="btn-small edit" title="تعديل">تعديل</a>

      <form method="POST" action="{{ route('admin.org-structure.destroy', $unit->id) }}" id="delete-form-{{ $unit->id }}" style="display:inline;">
        @csrf @method('DELETE')
        <button type="button" class="btn-small delete" onclick="confirmDelete({{ $unit->id }})" title="حذف">حذف</button>
      </form>
    </div>
  </div>

  @if($unit->children->count() > 0)
    <ul>
      @foreach($unit->children as $child)
        <x-org-unit :unit="$child" />
      @endforeach
    </ul>
  @endif
</li>
