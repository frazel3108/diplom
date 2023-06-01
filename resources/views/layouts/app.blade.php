<!doctype html>
<html lang="ru">
<head>
  @include('elements.head')
</head>
<body>
  <section id="app">
    <div class="w-full relative flex min-h-screen h-screen flex-col overflow-x-hidden">
      @include('elements.header')
  
      @if (Breadcrumbs::isActive())
        <div class="container -mt-2">
          @include('elements.breadcrumbs')
        </div>
      @endif
      
      <div class="container w-full mb-auto">
        {{ $slot }}
      </div>

      @include('elements.footer')
    </div>
  </section>
  <script src="{{ file_cache('/js/app.js') }}"></script>
</body>
</html>