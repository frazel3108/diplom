<x-app-layout>
  <h1 class="font-medium pt-1 pb-2 text-2xl md:text-4xl">Каталог</h1>
  <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
    <div>
      <main-filter
        :data-categories="{{ Js::from($categories); }}"
        :filter="{{ Js::from($filter->getParamsWithData()); }}"
        :filter-data-set="{{ Js::from($filter->getParams()); }}"
      />
    </div>
    <div class="lg:col-span-3">
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-4">
        @foreach ($products as $product)
          <a href="{{ $product->route }}" class="flex flex-col h-full w-full rounded-xl bg-white p-4 hover:shadow-lg">
            <div class="h-52 lg:h-60 w-full rounded-2 overflow-hidden">
              <img
                src="{{ $product->image_uploaded
                  ? $product->image_uploaded[0]['url']
                  : 'https://via.placeholder.com/500x500.png'
                }}"
                alt="{{ $product->name }}" class="w-full h-full object-cover object-center rounded-2"
              />
            </div>
            <div class="mt-2.5 md:mt-4 lg:mt-5 lg:px-3.5 pb-4">
              <div class="flex flex-col-reverse md:flex-row justify-between items-start md:items-center">
                <div class="font-fira text-gray-800 font-medium text-base lg:text-xl mt-2.5 md:mt-0">
                  {{ $product->name }}
                </div>
                @if ($product->isNew())
                  <div class="font-roboto text-gray-500 text-xxs md:text-xs font-medium py-1 px-1 md:px-2.5 border border-gray-500 rounded">
                    New
                  </div>
                @endif
              </div>
            </div>

            <div class="pb-4 lg:px-3.5 mt-auto">
              <div class="grid grid-cols-2 items-end mt-3 2xl:mt-5">
                <div>
                  @if ($product->prices()['discount'] > 0)
                    <div class="uppercase whitespace-nowrap text-gray-500 text-xxs lg:text-xs line-through">
                       {!! number_format($product->prices()['old_price'], 0, '', '&nbsp;') !!}&#8381;
                    </div>
                  @endif
                  <div class="font-roboto whitespace-nowrap text-green-600 font-medium text-base md:text-xl 2xl:text-2xl">
                    {!! number_format($product->prices()['price'], 0, '', '&nbsp;') !!}
                    <small class="font-roboto text-green-600 font-medium text-xs md:text-sm lg:text-base">
                      &#8381;
                    </small>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-brand rounded-md flex items-center justify-center text-white text-semibold text-sm lg:text-base h-10 lg:h-12 hover:bg-brand-hover hover:text-gray-300 cursor-pointer transition ease-in-out duration-200">
              Подробнее
            </div>
          </a>
        @endforeach
      </div>
      <div class="my-3">
        {{ $products->links() }}
      </div>
    </div>
  </div>
</x-app-layout>