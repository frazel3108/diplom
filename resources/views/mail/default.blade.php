@if (isset($data['name']))
Имя: <b>{{ $data['name'] }}</b><br>
@endif
@if (isset($data['email']))
E-mail: <b><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></b><br>
@endif
@if (isset($data['message']))
Сообщение: <b>{{ $data['message'] }}</b><br>
@endif
----------<br>
IP: <b>{{ $_SERVER['REMOTE_ADDR'] }}</b><br>
Страница формы: <b>{{ $_SERVER['HTTP_REFERER'] ?? '' }}</b><br>
Время заявки: <b>{{ Carbon\Carbon::now() }}</b><br>