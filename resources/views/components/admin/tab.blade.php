@props(['tab', 'title'])

<div
  class="button button_small cursor-pointer rounded font-light p-2 tabs-item hover:bg-orange-500"
  :class="activeTab === '{{ $tab }}' ? 'bg-red-500' : 'button_transparent'"
  @click="activeTab = '{{ $tab }}'"
>
  {{ $title }}
</div>
