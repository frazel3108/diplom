@props([
  'title',
  'name' => '',
  'dataSelect' => [],
  'dataSelected' => []
])
<div class="p-5 border-b last:border-b-0 border-black">
  <div class="font-medium uppercase mb-3">{{ $title }}</div>
  @foreach ($dataSelect as $item)
    <x-admin.form.checkbox
      name="{{ $name ?: $title }}"
      value="{{ $item['id'] }}"
    >
      {{ $item['name'] ?: '' }}
    </x-admin.form.checkbox>
  @endforeach
</div>