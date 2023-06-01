@props(['items' => [], 'label' => null])

<div
  class="space-y-1"
  x-data="inputItems({
    items: {{ Js::from($items) }},
  })"
  x-ref="items"
>
  @isset ($label)
    <x-admin.form.label :id="$attributes->get('id')">
      {{ $label }}
    </x-admin.form.label>
  @endisset
  <div class="flex flex-col">
    <template x-for="(item, idx) in items">
      <div
        class="w-full"
        x-bind:class="draggingIdx === null || draggingIdx != idx ? 'mb-2' : ''"
      >
        <div
          class="w-full border-2 border-gray-200 border-dashed mb-2"
          x-bind:class="draggingIdx != idx && ghostIdx !== null && ghostIdx == idx ? '' : 'hidden'"
          x-bind:style="`height: ${draggingElemHeight}px`"
        ></div>
        <div
          class="flex items-stretch w-full"
          x-bind:class="`item_${idx}`"
        >
          <div
            class="flex-shrink-0 w-6 border border-r-0 border-gray-200 bg-gray-100 cursor-move hover:bg-gray-200 flex items-center justify-center"
            @mousedown="e => onMousedown(idx, e)"
          >
            <x-admin.svg.drag class="w-6 fill-current text-gray-400" />
          </div>
          <x-admin.form.input
            x-bind:class="`input_${idx}`"
            name="{{ $attributes->get('name') }}[]"
            wrapper-class="flex-grow"
            class="rounded-l-none"
            x-bind:value="item"
            @keyup="e => onKeyup(idx, e)"
            @blur="onBlur(idx)"
          />
        </div>
      </div>
    </template>
    <div
      class="w-full border-2 border-gray-200 border-dashed mb-2"
      x-bind:class="[
        ghostIdx !== null && ghostIdx == items.length ? '' : 'hidden',
      ]"
      x-bind:style="`height: ${draggingElemHeight}px`"
    ></div>
    <x-admin.form.input
      wrapper-class="flex-grow"
      @keyup="e => onNewItemKeyup(e)"
    />
  </div>
</div>
