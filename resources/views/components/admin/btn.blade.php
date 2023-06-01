@props([
  'tag' => 'button', // any
  'theme' => 'main', // light
  'size' => 'base', // sm, xs
])

@php
  $class = 'rounded-lg border cursor-pointer transition';
  
  // bg-red-burgundian-dark -> bg-orange-500
  // border-red-burgundian-dark -> border-orange-500
  // bg-red-burgundian -> bg-red-500
  
  switch ($theme) {
    case 'light':
      $class .= ' hover:bg-brand-hover hover:border-brand hover:text-white';
      break;
    default:
      $class .= ' bg-brand hover:bg-brand-hover border-brand hover:border-brand-hover text-white';
  }
  
  switch ($size) {
    case 'xs':
      $class .= ' text-xs px-2 py-1';
      break;
    case 'sm':
      $class .= ' text-xs px-3 py-2';
      break;
    default:
      $class .= ' text-sm px-4 py-2.5';
  }
@endphp

<{{ $tag }} {!! $attributes->merge(['class' => $class]) !!}>
{{ $slot }}
</{{ $tag }}>