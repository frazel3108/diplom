@props(['label', 'checked' => false, 'readonly' => false, 'required' => false])

@php
  $attrs = [
    'type' => 'checkbox',
    'class' => 'h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer',
  ];
  
  if ($readonly) {
    $attrs['readonly'] = '';
  }
  if ($required) {
    $attrs['required'] = '';
  }
  if ($checked) {
    $attrs['checked'] = '';
  }
@endphp

<label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer mb-2 last:mb-0">
  <input {!! $attributes->merge($attrs) !!}>
  <span class="ml-2">{{ $slot }}</span>
</label>