<div class="w-full h-5">
  <div class="relative h-5 items-center overflow-hidden">
    <div class="flex items-center max-sm:mb-3 pb-5 whitespace-nowrap overflow-hidden overflow-x-auto">
      @if (Breadcrumbs::isActive())
        @foreach(Breadcrumbs::getLinks() as $link)
          <span class="mr-2.5">
            <a href="{{ $link[1] }}" class="font-light text-black-opacity text-sm pb-7">{{ $link[0] }}</a>
          </span>
          <div class="mr-2.5">
            <x-svg.arrow-down class="w-3 h-3 text-gray-600 -rotate-90" />
          </div>
        @endforeach
        <span class="text-sm">{{ Breadcrumbs::getCurrent() }}</span>
      @endif
    </div>
  </div>
</div>