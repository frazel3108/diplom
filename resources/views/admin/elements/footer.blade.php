<footer class="block py-4">
  @if (config('app.debug'))
    <div class="container mx-auto px-4">
      <hr class="mb-4 border-b-1 border-blueGray-200">
      <div class="flex flex-wrap items-center md:justify-between justify-center">
        <div class="w-full md:w-4/12 px-4">
          <div class="text-center mb-2 md:text-left md:mb-0">
            Page generation: {{ (microtime(true) - LARAVEL_START) }}
          </div>
        </div>
      </div>
    </div>
  @endif
</footer>