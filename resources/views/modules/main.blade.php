<x-app-layout>
  @if ($offers->count() > 0)
    <offer-carousel :items="{{ Js::from($offers) }}" ></offer-carousel>
  @endif
  @if ($recommendations->count() > 0)
    <div class="space-y-4">
      <div class="flex flex-col sm:flex-row justify-between">
        <h2 class="font-medium">Мы рекомендуем</h2>
        <a href="/catalog/" class="text-gray-500">Посмотреть ещё</a>
      </div>

      <card-carousel
        :items="{{ Js::from($recommendations) }}"
        :options=@json(['loop' => true])
      ></card-carousel>
    </div>
  @endif
  
  <hr class="h-px my-8 bg-gray-200 border-0">
  @if ($topCategories->count() > 0)
    <h2 class="font-medium text-center text-2xl mt-4">Наши популярные категории товаров!</h2>
    <section class="mt-11 flex md:flex-row max-sm:flex-col w-full justify-between">
      @foreach($topCategories as $category)
        <x-card-category :category="$category" />
      @endforeach
    </section>
  @endif
  
  @php $countVisibleCategory = 0; @endphp
  @foreach($categories as $category)
    @if($countVisibleCategory > 4)
      @continue
    @else
       @php $countVisibleCategory++; @endphp
    @endif
    
    <hr class="h-px my-8 bg-gray-200 border-0">
    <div class="space-y-4">
      <div class="flex flex-col sm:flex-row justify-between">
        <h2 class="font-medium">{{ $category->name }}</h2>
        <a href="/catalog/{{ $category->url }}/" class="text-gray-500">Посмотреть ещё</a>
      </div>

      <card-carousel
        :items="{{ Js::from($category->products->take(15)->map(fn($product) => $product->exportForVue())) }}"
        :options=@json(['loop' => true])
      ></card-carousel>

      @if ($countVisibleCategory == 2)
        <hr class="h-px my-8 bg-gray-200 border-0">
        <h2 class="font-bold lg:text-title">Почему именно мы?</h2>
        
        <div class="grid max-sm:grid-rows-4 sm:grid-cols-4 sm:gap-y-3 items-center text-center items-stretch">
          <div class="flex flex-col flex-wrap justify-center">
            <i class="bi bi-cash text-2xl"></i>
            <span class="lg:text-2xl md:text-xl sm:text-lg">Лучшие цены!</span>
          </div>
          <div class="flex flex-col flex-wrap justify-center">
            <i class="bi bi-truck text-2xl"></i>
            <span class="lg:text-2xl md:text-xl sm:text-lg">Моментальная доставка</span>
          </div>
          <div class="flex flex-col flex-wrap justify-center">
            <i class="bi bi-gift text-2xl"></i>
            <span class="lg:text-2xl md:text-xl sm:text-lg">Регулярные акции и скидки!</span>
          </div>
          <div class="flex flex-col flex-wrap justify-center">
            <i class="bi bi-person-hearts text-2xl"></i>
            <span class="lg:text-2xl md:text-xl sm:text-lg">Техподдержка покупателю</span>
          </div>
        </div>
      
      @elseif($countVisibleCategory == 4)
        <hr class="h-px my-8 bg-gray-200 border-0">
        <x-subscribe></x-subscribe>
      @endif
    </div>
  @endforeach
  
  <hr class="h-px my-8 bg-gray-200 border-0">
</x-app-layout>