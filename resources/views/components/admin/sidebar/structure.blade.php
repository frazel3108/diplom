@props (['structure' => [], 'isParentGroup' => false])

@foreach ($structure as $item)
  @if ($item['type'] == 'link')
    <x-admin.sidebar.link :link="$item" :is-parent-group="$isParentGroup" />
  @endif

  @if ($item['type'] == 'section')
    <div class="pt-2 space-y-3">
      <div class="flex items-center space-x-1">
        <div class="flex-shrink-0 text-xs uppercase text-stone-400">{{ $item['name'] }}</div>
        <div class="w-full h-px bg-stone-500"></div>
      </div>
      <x-admin.sidebar.structure :structure="$item['items']" :is-parent-group="$isParentGroup" />
    </div>
  @endif
  
  @if ($item['type'] == 'group')
    <x-admin.sidebar.group :group="$item" />
  @endif
@endforeach