@props(['status'])

@if ($status)
  <x-admin.alert {{ $attributes->merge(['type' => 'success']) }}>{{ $status }}</x-admin.alert>
@endif