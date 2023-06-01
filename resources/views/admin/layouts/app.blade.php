<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin-Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ file_cache('/admin/css/main.css') }}">
</head>
<body class="h-full bg-blueGray-100">

<div class="w-full relative md:flex flex-col md:flex-row md:min-h-screen ct-docs-disable-sidebar-content overflow-x-hidden">
  
  <x-admin.sidebar />
  
  <div class="relative bg-blueGray-100 w-full h-full">
   
    @include('admin.elements.nav')
  
    @isset($headerRight)
      {{ $headerRight }}
    @endisset
    
    {{ $slot }}
  
    @isset($footer)
      {{ $footer }}
    @endisset
    
    @include('admin.elements.footer')
    
  </div>
  
</div>

<script src="{{ file_cache('/admin/js/app.js') }}"></script>
</body>
</html>