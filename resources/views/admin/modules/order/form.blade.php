<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 px-6 py-4 shadow-lg rounded-lg bg-white text-blueGray-700">
      <h2 class="font-bold text-lg text-blueGray-700">Заказ #{{ $order->id }}</h2>
      <div class="mt-1">
        <label for="user">Пользователь</label>
        <a
          id="user"
          href="{{ route('admin.user.show', ['user' => $order->user]) }}"
          class="w-fit [word-wrap: break-word] my-[5px] mr-4 flex h-[52px] cursor-pointer items-center rounded-[26px] bg-[#eceff1] py-0 px-[12px] text-sm font-normal normal-case leading-loose text-[#4f4f4f] shadow-none transition-[opacity] duration-300 ease-linear hover:!shadow-none active:bg-[#cacfd1]"
        >
          <img
            class="my-0 mr-[8px] -ml-[12px] h-[inherit] w-[inherit] rounded-[100%]"
            src="https://tecdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp"
            alt="{{ $order->user->name }}"
          >
          <span class="mx-2">{{ $order->user->name }}</span>
        </a>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 px-6 py-4 shadow-lg rounded-lg bg-white text-blueGray-700">
       <div class="px-6 py-4 border-0">
        <div class="flex flex-wrap max-sm:flex-col items-center">
          <div class="flex flex-col relative w-full max-sm:mb-3 max-w-full flex-1 float-left max-sm:justify-between max-sm:flex-row-reverse">
            <div class="mt-4">
              <h3 class="font-bold text-lg text-blueGray-700">Товары в корзине</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="block w-full overflow-x-auto">
        <table class="w-full bg-transparent border-collapse">
          <thead>
            <tr>
              <x-admin.table.th class="w-5">
                Название
              </x-admin.table.th>
              <x-admin.table.th class="w-32">
                Цена покупки
              </x-admin.table.th>
              <x-admin.table.th class="w-32">
                Текущая цена товара
              </x-admin.table.th>
              <x-admin.table.th class="w-12"></x-admin.table.th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->products as $product)
              <tr>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                  <div class="flex">
                    <span class="ml-3 font-bold NaN">{{ $product->data->name }}</span>
                  </div>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs p-4">
                  <div class="flex">
                    {!! number_format($product->price, 2, ',', '&nbsp;') !!}&nbsp;&#8381;
                  </div>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs p-4">
                  <div class="flex">
                    {!! number_format($product->data->prices()['price'], 2, ',', '&nbsp;') !!}&nbsp;&#8381;
                  </div>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                  <div class="flex">
                    <a
                      class="cursor-pointer transition duration-200"
                      href="{{ route('admin.product.show', ['product' => $product->data]) }}"
                    >
                      Просмотреть Товар
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-admin-app-layout>