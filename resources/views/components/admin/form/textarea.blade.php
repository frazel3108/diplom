@props(['label', 'readonly' => false, 'required' => false])

@php
  $attrs = [
    'class' => 'w-full px-3 py-2.5 border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-600 focus:outline-none',
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
    <label for="{{ $attributes->get('id') }}" class="block text-sm font-medium text-gray-700">
      {!! $label !!}
    </label>
  @endisset
  
  <div class="flex shadow-sm">
    <textarea
      {!!
        $attributes->except(['label', 'wrapper-class'])
          ->merge($attrs)
      !!}
    >{!! $slot !!}</textarea>
  </div>
</div>
