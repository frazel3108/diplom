@props(['init-tab'])
<div class="w-full px-4 -mt-10">
  <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
    <div class="space-y-4" x-data="{ activeTab: '{{ $initTab }}' }">
      <div class="flex items-center p-4 space-x-4">
        {{ $tabs }}
      </div>
      <div>
        {{ $slot }}
      </div>
    </div>
  </div>
</div>