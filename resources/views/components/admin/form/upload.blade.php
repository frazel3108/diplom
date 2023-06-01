@props([
  'label',
  'uploaded' => null,
  'uploadUrl' => null,
  'readonly' => false,
  'required' => false,
  'multiple' => false,
])

@php
  $attrs = [
    'type' => 'file',
    'class' => 'hidden',
  ];
  
  if ($multiple) {
    $attrs['multiple'] = '';
  } else {
    if ($uploaded) {
      $uploaded = [$uploaded];
    }
  }
@endphp

<div
  class="space-y-1"
  x-data="upload({
    uploaded: {{ Js::from($uploaded || []) }},
    multiple: {{ Js::from($multiple) }},
    uploadUrl: {{ Js::from($uploadUrl) }},
  })"
>
  @isset ($label)
    <x-admin.form.label :id="$attributes->get('id')">
      {{ $label }}
    </x-admin.form.label>
  @endisset
  <div>
    @if ($uploaded && count($uploaded) > 0)
      <ul
        role="list"
        @if ($multiple)
          class="grid grid-cols-1 xs:grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4 mb-2"
        @else
          class="mb-2"
        @endif
      >
        @foreach ($uploaded as $upload)
          @php $ext = pathinfo($upload['url'], PATHINFO_EXTENSION); @endphp
          <li class="relative {{ $ext == 'doc' ? 'w-fit' : ($ext == 'docx' ? 'w-fit' : ($ext == 'txt' ? 'w-fit' : '')) }} ">
            <a
              href="{{ $upload['url'] }}"
              data-fancybox="{{ $attributes->get('name') }}"
              class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden"
            >
              @if($ext == 'doc' || $ext == 'docx')
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 64 64" width="128px" height="128px"><linearGradient id="ay15mXZwsMgjHf8cOP0e8a" x1="32" x2="32" y1="3.75" y2="59.299" gradientUnits="userSpaceOnUse" spreadMethod="reflect"><stop offset="0" stop-color="#1a6dff"/><stop offset="1" stop-color="#c822ff"/></linearGradient><path fill="url(#ay15mXZwsMgjHf8cOP0e8a)" d="M50,11H35V8.975c0-0.938-0.432-1.801-1.185-2.367c-0.763-0.575-1.73-0.755-2.651-0.488 l-18.561,5.342C10.482,12.072,9,14.025,9,16.211v31.578c0,2.187,1.482,4.14,3.603,4.75l18.561,5.342 c0.28,0.081,0.564,0.12,0.845,0.12c0.645,0,1.274-0.208,1.806-0.608C34.568,56.827,35,55.963,35,55.026V53h15c2.757,0,5-2.243,5-5 V16C55,13.244,52.757,11,50,11z M33,55.026c0,0.304-0.142,0.584-0.388,0.77c-0.257,0.193-0.583,0.253-0.896,0.164l-18.56-5.342 C11.887,50.252,11,49.089,11,47.789V16.211c0-1.3,0.887-2.463,2.156-2.828l18.56-5.342c0.312-0.09,0.638-0.03,0.896,0.164 C32.858,8.391,33,8.671,33,8.975V11v42V55.026z M53,48c0,1.654-1.346,3-3,3H35v-6h14v-2H35v-4h14v-2H35v-4h14v-2H35v-4h14v-2H35v-4 h14v-2H35v-6h15c1.654,0,3,1.346,3,3V48z"/><linearGradient id="ay15mXZwsMgjHf8cOP0e8b" x1="22" x2="22" y1="23.833" y2="41.5" gradientUnits="userSpaceOnUse" spreadMethod="reflect"><stop offset="0" stop-color="#6dc7ff"/><stop offset="1" stop-color="#e6abff"/></linearGradient><path fill="url(#ay15mXZwsMgjHf8cOP0e8b)" d="M16.869,40l-3.3-14h2.62l1.28,6.265c0.34,1.767,0.66,2.735,0.88,4.735h0.04 c0.22-2,0.6-2.925,0.98-4.756L20.83,26h2.581l1.34,5.883c0.34,1.724,0.62,3.117,0.82,4.117h0.04c0.24-1,0.56-2.458,0.92-4.224 l1.4-5.776h2.5l-3.621,14H24.17l-1.4-6.61C22.43,31.731,22.19,30,22.03,29h-0.04c-0.24,1-0.5,2.731-0.9,4.39L19.529,40H16.869z"/></svg>
              @elseif($ext == 'txt')
                <svg height="128px" width="128px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><path style="fill:#E2E5E7;" d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z"/><path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z"/><polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 "/><path style="fill:#576D7E;" d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16 V416z"/><g><path style="fill:#FFFFFF;" d="M132.784,311.472H110.4c-11.136,0-11.136-16.368,0-16.368h60.512c11.392,0,11.392,16.368,0,16.368 h-21.248v64.592c0,11.12-16.896,11.392-16.896,0v-64.592H132.784z"/><path style="fill:#FFFFFF;" d="M224.416,326.176l22.272-27.888c6.656-8.688,19.568,2.432,12.288,10.752 c-7.68,9.088-15.728,18.944-23.424,29.024l26.112,32.496c7.024,9.6-7.04,18.816-13.952,9.344l-23.536-30.192l-23.152,30.832 c-6.528,9.328-20.992-1.152-13.68-9.856l25.696-32.624c-8.048-10.096-15.856-19.936-23.664-29.024 c-8.064-9.6,6.912-19.44,12.784-10.48L224.416,326.176z"/><path style="fill:#FFFFFF;" d="M298.288,311.472H275.92c-11.136,0-11.136-16.368,0-16.368h60.496c11.392,0,11.392,16.368,0,16.368 h-21.232v64.592c0,11.12-16.896,11.392-16.896,0V311.472z"/></g><path style="fill:#CAD1D8;" d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z"/></svg>
              @else
                <img src="{{ $upload['url'] }}" class="object-cover pointer-events-none group-hover:opacity-75"/>
              @endif
            </a>
            <input
              type="hidden"
              name="{{ admin_wrap_name('_uploaded_', $attributes->get('name'), $loop->index, $multiple) }}"
              value="{{ $upload['src'] }}"
            >
            <span
              class="absolute top-2 right-2 drop-shadow bg-red-500 text-white text-sm cursor-pointer hover:bg-red-700 rounded p-1"
              title="Удалить"
              @click.prevent="$el.parentNode.remove()"
            >
              <x-admin.svg.trash class="w-4"/>
            </span>
          </li>
        @endforeach
      </ul>
    @endif
    
    @if (!$readonly)
      <div class="flex items-center space-x-4">
        <x-admin.btn
          theme="white"
          type="button"
          @click="$refs.upload.click()"
        >
          Загрузить
        </x-admin.btn>
        <span
          x-show="files && files.length > 0"
          x-text="files ? (files.length === 1 ? files[0].name : `Загружено ${files.length}`) : ''"
          class="text-sm text-gray-700"
        ></span>
      </div>
    @endif
    <input
      {!! $attributes->except(['label', 'uploaded'])->merge($attrs) !!}
      x-ref="upload"
      @change="onChange"
    >
  </div>
</div>
