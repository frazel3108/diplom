@props (['link', 'isParentGroup'])

@php
  if ($link['active']) {
    $style = 'bg-gray-200 focus:text-gray-900 pointer-events-none cursor-default';
  } else {
    $style = 'hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200';
  }
@endphp

<a
  href="{{ $link['url'] }}"
  class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg focus:shadow-outline focus:outline-none focus:bg-gray-200 {{ $style }}"
>
  {{ $link['name'] }}
</a>