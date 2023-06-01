@if ($paginator->hasPages())
  <nav
    role="navigation"
    class="flex flex-wrap items-center justify-center space-x-2 lg:space-x-3 leading-none text-sm md:text-base lg:text-lg"
  >
    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="relative inline-flex items-center px-4 py-2 rounded-xl cursor-default">
          {{ $element }}
        </span>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span
              class="flex-shrink-0 relative inline-flex items-center px-4 py-2 bg-brand text-white rounded-xl cursor-default transition duration-200 ease-in-out"
            >
              {{ $page }}
            </span>
          @else
            <a
              href="{{ $url }}"
              class="flex-shrink-0 relative inline-flex items-center px-4 py-2 hover:text-white hover:bg-brand rounded-xl cursor-pointer transition duration-200 ease-in-out"
            >
              {{ $page }}
            </a>
          @endif
        @endforeach
      @endif
    @endforeach
  </nav>
@endif