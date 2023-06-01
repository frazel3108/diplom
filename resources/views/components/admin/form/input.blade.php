@props(['label', 'type' => 'text', 'readonly' => false, 'required' => false])

@php
  $attrs = [
    'type' => $type,
    'class' => 'form-control w-full px-3 py-2.5 border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-600 focus:outline-none shadow-sm',
  ];
  
  if ($readonly) {
    $attrs['readonly'] = '';
  }
  if ($required) {
    $attrs['required'] = '';
  }
@endphp

<div {{ $attributes->only([])->merge(['class' => 'space-y-1'])->merge(['class' => $attributes->get('wrapper-class')]) }}>
  @isset ($label)
    <x-admin.form.label :id="$attributes->get('id')">
      {{ $label }}
    </x-admin.form.label>
  @endisset
  <input  {!! $attributes->except(['label', 'wrapper-class'])->merge($attrs) !!}>
</div>