<x-app-layout>
  <h1 class="text-2xl mt-5 font-bold">Корзина</h1>
  @if (isset(auth()->user()->basket->products) && auth()->user()->basket->products->count() != 0)
    <div class="flex flex-row mt-5 space-x-10">
      <div class="flex flex-col w-[60%]">
        <hr class="w-full">
        @foreach (auth()->user()->basket->products as $product)
          <div class="flex flex-row w-full p-5 space-x-5 items-center">
            <div class="w-[30%] items-center">
              <img
                src="{{ $product->data->image_uploaded[0]['url'] ?? 'https://via.placeholder.com/500x500.png' }}"
                class="rounded-2"
                alt="{{ $product->data->name }}"
              >
            </div>
            <div class="flex flex-col w-full h-full justify-between">
              <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                  <span class="font-semibold">
                    <a href="{{ $product->data->route }}">{{ $product->data->name }}</a>
                  </span>
                  <span class="font-light text-gray-400">{{ $product->data->category->name }}</span>
                </div>
                <form action="{{ route('lk.basket.delete', [$product->data]) }}" method="post">
                  @csrf
                  @method('delete')
                  <button type="submit"><i class="bi bi-x text-gray-400"></i></button>
                </form>
              </div>
              <div class="flex flex-row justify-between mt-3">
                <div class="flex flex-col w-fit">
                  <span class="text-sm mb-1">Количество:</span>
                  <div class="flex flex-row border-solid border-[1px] divide-x-[1px] px-2 items-center">
                    <div class="pr-2">
                      <form action="{{ route('lk.basket.add', [$product->data]) }}" method="post">
                        @csrf
                        <button type="submit">+</button>
                      </form>
                    </div>
                    <div class="px-2">
                      {{ $product->quantity }}
                    </div>
                    <div class="pl-2">
                      <form action="{{ route('lk.basket.remove', [$product->data]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">-</button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col text-right self-end">
                  @if ($product->data->prices()['discount'])
                    <span class="uppercase whitespace-nowrap text-gray-500 text-xxs line-through">
                      {{ $product->data->prices()['old_price'] * $product->quantity }}&nbsp;₽
                    </span>
                  @endif
                  <span class="font-roboto whitespace-nowrap <?= $product->data->prices()['discount'] ? 'text-green-600' : '' ?> font-medium text-base">
                    {{ $product->data->prices()['price'] * $product->quantity }}&nbsp;₽
                  </span>
                </div>
              </div>
            </div>
          </div>
          <hr class="w-full">
        @endforeach
      </div>
      <div class="flex flex-col bg-gray-200 w-[40%] h-fit p-5 rounded-2 shadow-lg">
        <div class="w-full">
          <h2 class="text-center font-bold">Сумма заказа:</h2>
        </div>
        <hr class="w-full border-blue-200 border-[1px] rounded-full mt-5 mb-2">
        <div class="flex flex-row justify-between">
          <span>Товаров на сумму:</span>
          <span>{{ auth()->user()->basket->summary()['subTotal'] }}&nbsp;₽</span>
        </div>
        <hr class="w-full border-blue-200 border-[1px] rounded-full my-2">
        <div class="flex flex-row justify-between">
          <span>Общая скидка:</span>
          <span>{{ auth()->user()->basket->summary()['discountTotal'] }}&nbsp;₽</span>
        </div>
        <hr class="w-full border-blue-200 border-[1px] rounded-full my-2">
        <div class="flex flex-row justify-between">
          <span class="font-semibold">Итог:</span>
          <span class="font-semibold">{{ auth()->user()->basket->summary()['total'] }}&nbsp;₽</span>
        </div>
        <form method="post">
          @csrf
          <button type="submit" class="mt-4 font-medium w-full py-2.5 px-4 rounded-1 bg-brand h-10 tracking-wide">
            Оформить
          </button>
        </form>
      </div>
    </div>
  @else
    <div class="text-center my-2 w-full h-full">
      <p class="h-full">
        К нашему сожелению, ваша корзина пуста. Вы можете добавить в корзину понравившиеся вам товары на странице <a href="{{ route('catalog.list') }}" class="underline">товаров</a>
      </p>
    </div>
  @endif
</x-app-layout>