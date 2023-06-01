@props([
  'title' => '',
  'value' => 0,
  'difference' => 0.0,
  'last' => '',
  'icon_class' => '',
  'icon_bg' => 'bg-red-500'
])
<div class="w-full lg:w-6/12 xl:w-3/12 px-4">
  <div class="relative flex flex-col min-w-0 break-words bg-white rounded-lg mb-6 xl:mb-0 shadow-lg">
    <div class="flex-auto p-4">
      <div class="flex flex-wrap">
        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
          <h5 class="text-blueGray-400 uppercase font-bold text-xs">{{ $title }}</h5>
          <span class="font-bold text-xl">{{ $value }}</span>
        </div>
        @if ($icon_class)
          <div class="relative w-auto pl-4 flex-initial">
            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full {{ $icon_bg }}">
              <i class="{{ $icon_class }}"></i>
            </div>
          </div>
        @endif
      </div>
      <p class="text-sm text-blueGray-500 mt-4">
        <span class="{{ $difference > 0 ? 'text-emerald-500' : 'text-red-500' }} mr-2">
          <i class="bi {{ $difference > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> {{ $difference }}%
        </span>
        <span class="whitespace-nowrap">{{ $last }}</span>
      </p>
    </div>
  </div>
</div>