@props(['type' => 'error'])

@php
  $classes = 'py-2 px-4 leading-normal border-l-4 ';
  
  switch ($type) {
    case('info'):
      $classes .= 'bg-blue-200 border-blue-500 text-blue-800';
      break;
    case('success'):
      $classes .= 'bg-green-200 border-green-500 text-green-700';
      break;
    case('warning'):
      $classes .= 'bg-orange-200 border-orange-500 text-orange-700';
      break;
    case('light'):
      $classes .= 'bg-gray-200 border-gray-500 text-gray-700';
      break;
    default:
      $classes .= 'bg-red-200 border-red-500 text-red-500';
  }
@endphp

<div {!! $attributes->merge(['class' => $classes]) !!}>{{ $slot }}</div>
