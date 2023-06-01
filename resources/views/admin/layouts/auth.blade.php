<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin-Panel</title>
  <link rel="stylesheet" href="{{ file_cache('/admin/css/main.css') }}">
</head>
<body>
  {{ $slot }}

  <script src="{{ file_cache('/admin/js/app.js') }}"></script>

</body>
</html>