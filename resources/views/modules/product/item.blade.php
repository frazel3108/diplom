<x-app-layout>
  <h1 class="font-bold text-3xl inline align-middle text-[#202020]">
    {{ $product->name }} @if ($product->isNew())<span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 rounded">
        New
      </span>
    @endif
  </h1>

  <div class="md:grid md:grid-cols-3 max-md:flex max-md:flex-col space-x-2 md:gap-12 mt-2">

    <div class="w-full h-max">
      <product-carousel :images="{{ Js::from($product->image_uploaded) }}" ></product-carousel>
    </div>

    <div class="w-full mb-5 max-md:mt-5">
      @if ($product->offers->count() > 0)
        <h3 class="pb-2 text-[#222] tracking-[.25px] text-sm font-medium">Товар также участвует в акции:</h3>
        <div class="flex flex-row flex-wrap">
          @foreach($product->offers as $offer)
            <a href="/catalog/?offer%5B%5D={{ $offer->id }}">
              <img class="w-auto max-h-15 mr-3 mb-3" src="{{ $offer->banner_link }}" alt="{{ $offer->name }}">
            </a>
          @endforeach
        </div>
      @endif


      <h3 class="pb-2 text-[#222] tracking-[.25px] text-sm font-medium">Описание</h3>
      <a href="#description" class="line-clamp-6 leading-5 text-sm">
        {!! $product->description !!}
      </a>

      @if ($product->characteristics->count() > 0)
        <h3 class="py-2 text-[#222] tracking-[.25px] text-sm font-medium">Характеристики</h3>
        @foreach ($product->characteristics as $characteristic)
          <div class="flex flex-row space-x-2 items-center">
            <div>{{ $characteristic->name }}: </div>
            <div class="leading-5 text-sm">{{ $characteristic->pivot->value }}</div>
          </div>
        @endforeach
      @endif
    </div>

    <section>
      <div class="flex flex-col rounded-2 p-4 shadow-lg">
        @if ($product->prices()['discount'] > 0)
          <div class="flex flex-row items-end flex-wrap">
            <span class="line-through text-sm text-gray-400">
              {{ number_format($product->prices()['old_price'], 2, '.', ' ') }}&nbsp;₽
            </span>
            <span class="ml-1.5 bg-red-400 py-0.5 px-1 h-auto text-white text-sm rounded-tl-lg rounded-bl-lg">
              -{{ $product->prices()['discount'] }}%
            </span>
          </div>
        @endif
        <span class="text-3xl leading-10 font-bold">
          {{ number_format($product->prices()['price'], 2, '.', ' ') }} ₽
        </span>
        <span class="text-sm mt-1.5 mb-1 text-[#222]">Онлайн оплата</span>
        @if ($product->prices()['discount'] > 0)
          <span class="text-base text-[#222]">
            Экономия: <span class="text-base font-medium leading-5">
              {{ $product->prices()['old_price'] - $product->prices()['price'] }}&nbsp;₽
            </span>
          </span>
        @endif

        <span class="text-base text-[#222]">
          Наличие: <span class="text-base font-medium leading-5">
            @if ($product->count_content > 10)
              {{ $product->count_content }}
            @elseif ($product->count_content == 0)
              Нет в наличие
            @else
              Мало
            @endif
          </span>
        </span>
        <div class="flex mt-4 flex-row w-full justify-around space-x-2">
          <a
            href="{{ route('warranty') }}"
            class="rounded-1 py-2.5 px-4 bg-gray-100 shadow-sm hover:bg-brand-hover hover:text-white w-full text-center"
          >
            Гарантия
          </a>
          <a
            href="{{ route('support') }}"
            class="rounded-1 py-2.5 px-4 bg-gray-100 shadow-sm hover:bg-brand-hover hover:text-white w-full text-center"
          >
            Как купить
          </a>
        </div>
        @if(auth()->user() && auth()->user()->countBasketProduct($product))
          <div class="flex flex-row text-center text-white">
            <form method="post" class="w-[20%]">
              @csrf
              <button type="submit" class="mt-4 font-medium py-2.5 px-2 rounded-l-1 bg-brand-hover h-10 w-full tracking-wide">+</button>
            </form>
            <p class="mt-4 font-medium w-full py-2.5 bg-brand h-10 tracking-wide">
              В корзине {{ auth()->user()->countBasketProduct($product) }} шт.
            </p>
            <form method="post" class="w-[20%]">
              @method('delete')
              @csrf
              <button type="submit" class="mt-4 font-medium py-2.5 px-2 rounded-r-1 bg-brand-hover h-10 w-full tracking-wide">-</button>
            </form>
          </div>
        @else
          <form method="post">
            @csrf
            <button
              type="submit"
              class="mt-4 font-medium w-full py-2.5 px-4 text-white rounded-1 bg-brand h-10 tracking-wide"
              @if ($product->count_content == 0)
                disabled
              @endif
            >
              Добавить в корзину
            </button>
          </form>
        @endif
        @guest()
          <div class="mt-1 text-justify">
            <span class="text-xs leading-tight text-gray-900">
                * Вы не прошли авторизацию, поэтому при попытке <b>добавить товар в корзину</b>, вас перенаправит на страницу авторизации!
            </span>
          </div>
        @endguest
      </div>
    </section>

    <div class="col-span-2 max-md:mt-4">
      @if ($others->count() > 0)
        <h2 class="inline-flex flex-row flex-wrap whitespace-pre-wrap text-left mr-1 items-center min-w-full text-3xl leading-9 font-semibold ">
          Еще может подойти
        </h2>
        <card-carousel :items="{{ Js::from($others) }}" class="mt-6"></card-carousel>
      @endif
      <div class="mt-5 mb-3">
        <h2 id="description" class="font-medium text-2xl">Описание</h2>
        <div class="relative text-base">
          {!! $product->description !!}
        </div>
      </div>
    </div>
  </div>

  <!-- Дисклеймер -->

  <!-- Слайдер похожих категорий категорий -->

  <div class="mt-5">
    <x-subscribe></x-subscribe>
  </div>

</x-app-layout>