@props([
  'label' => null,
  'options' => [],
  'value' => null,
  'name' => null,
  'wrapperClass' => '',
  'multiple' => false,
])

<div
  x-data="select({
    options: {{ Js::from($options) }},
    value: {{ Js::from($value) }},
    multiple: {{ Js::from($multiple) }},
  })"
  class="space-y-1 {{ $wrapperClass }}">
  @isset ($label)
    <label for="{{ $attributes->get('id') }}" class="form-label block text-sm font-medium text-gray-700 mb-2">
      {!! $label !!}
    </label>
  @endisset
  
  <div
    tabindex="0"
    class="relative cursor-pointer"
    x-on:focus="onContainerFocus"
    x-on:blur="onContainerBlur"
    x-ref="container"
  >
    <div x-show="!inFocus" class="shadow-sm flex items-center justify-between space-x-4 w-full px-3 py-2.5 border border-gray-200 rounded-lg text-gray-900 text-sm focus:outline-none">
      <div
        class="truncate"
        x-text="label"
      ></div>
      <x-admin.svg.chevron class="w-3 flex-shrink-0 fill-current text-gray-700" />
    </div>
    @if ($multiple)
      <template x-for="id in selected">
        <input type="hidden" name="{{ $name }}[]" x-bind:value="id">
      </template>
    @else
      <input type="hidden" name="{{ $name }}" x-bind:value="selected?.id">
    @endif
    <x-admin.form.input
      x-show="inFocus"
      style="display: none;"
      x-model="search"
      x-ref="search"
      x-on:blur="onSearchBlur"
      x-on:keydown="onSearchKeydown"
    />
    <div
      x-show="inFocus"
      style="display: none;"
      class="absolute top-full left-0 mt-1 w-full h-full h-60 drop-shadow bg-white border border-gray-200 rounded overflow-y-scroll z-10"
      x-ref="dropdown"
    >
      <div class="w-full h-full flex flex-col">
        <template x-for="(option, idx) in filteredOptions">
          <div
            class="px-4 py-2 border-gray-200 cursor-pointer option"
            x-bind:class="{
              'border-t': idx > 0,
              'bg-brand text-white': isOptionSelected(option) && !isOptionNavigated(idx),
              'bg-gray-200': isOptionNavigated(idx) && !isOptionSelected(option),
              'bg-gray-300 text-brand': isOptionNavigated(idx) && isOptionSelected(option),
              'hover:bg-gray-100': !isOptionSelected(option),
            }"
            x-text="option.name"
            @click.stop="onOptionClick(option)"
          ></div>
        </template>
      </div>
    </div>
  </div>
</div>