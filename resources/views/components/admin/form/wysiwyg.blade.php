@props(['label' => null, 'uploadUrl' => null])

<div
  class="space-y-1"
  x-data="wysiwyg({
    ref: '{{ $attributes->get('name', 'wysiwyg') }}',
    uploadUrl: {{ Js::from($uploadUrl ?? (route('admin.upload') . '/')) }},
  })"
>
  @isset ($label)
    <label for="{{ $attributes->get('id') }}" class="block text-sm font-medium text-gray-700">
      {!! $label !!}
    </label>
  @endisset
  
  <textarea
    {!! $attributes !!}
    x-ref="{{ $attributes->get('name', 'wysiwyg') }}"
  >{!! $slot !!}</textarea>
</div>

<script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>