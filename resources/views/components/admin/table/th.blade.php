@props(['sortBy' => null])
<th {!! $attributes->except('link-class')->merge(['class' => 'px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-bold text-left bg-blueGray-100 text-blueGray-500 border-blueGray-200']) !!}>
  @if ($sortBy)
    @php
      $query = request()->toArray();
      unset($query['page']);
  
      if ($sortBy == request()->get('sort-by')) {
        if (request()->get('sort-dir') == 'desc') {
          unset($query['sort-by']);
          unset($query['sort-dir']);
        } else {
          $query['sort-dir'] = 'desc';
        }
      } else {
        $query['sort-by'] = $sortBy;
        $query['sort-dir'] = 'asc';
      }
  
      $query = '?' . http_build_query($query);
    @endphp
    
    <a {{ $attributes->only([])
      ->merge(['class' => $attributes->get('link-class', '')])
      ->merge([
        'href' => $query,
        'class' => 'w-full flex items-center cursor-pointer hover:text-red-burgundian-dark group',
      ]
    ) }}>
      <span class="border-b border-gray-400 group-hover:border-red-burgundian-dark mr-2">{{ $slot }}</span>
      @if (request()->get('sort-by') == $sortBy)
        @if (request()->get('sort-dir') == 'desc')
          <x-admin.svg.arrow class="w-1.5 min-w-[6px] h-3 rotate-180 fill-current transition duration-200 ease-in-out" />
        @else
          <x-admin.svg.arrow class="w-1.5 min-w-[6px] h-3 fill-current transition duration-200 ease-in-out" />
        @endif
      @else
        <x-admin.svg.arrow class="w-1.5 min-w-[6px] h-3 fill-current transition duration-200 ease-in-out" />
        <x-admin.svg.arrow class="w-1.5 min-w-[6px] h-3 rotate-180 fill-current transition duration-200 ease-in-out" />
      @endif
    </a>
  @else
    {{ $slot }}
  @endif
</th>