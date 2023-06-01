@props(['errors'])

@if ($errors->any())
  <div {{ $attributes }}>
    @foreach ($errors->all() as $error)
      <x-admin.alert>{{ $error }}</x-admin.alert>
    @endforeach
  </div>
@endif
