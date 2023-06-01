@props(['tabs' => []])

@if (count($tabs))
  <div class="flex items-center space-x-4">
    @foreach ($tabs as $tab)
      @if ($tab['active'])
        <x-admin.btn>
          {{ $tab['name'] }}
        </x-admin.btn>
      @else
        <x-admin.btn tag="a" theme="light" href="{{ $tab['link'] }}">
          {{ $tab['name'] }}
        </x-admin.btn>
      @endif
    @endforeach
  </div>
@endif