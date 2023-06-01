<x-app-layout>
  <h1 class="text-2xl mt-5">Добро пожаловать, <span class="font-bold">{{ auth()->user()->name }}</span>!</h1>
  <div class="lg:grid lg:grid-cols-2 lg:gap-6">
    <a href="{{ route('lk.basket') }}" class="bg-white m-5 rounded-lg shadow-md hover:shadow-xl flex flex-row justify-between p-5">
      <span class="text-lg font-semibold mt-2">Корзина</span>
      <img class="w-32 h-32" src="/storage/cart-icon.png" alt="Корзина">
    </a>
    <a href="{{ route('lk.order_history') }}" class="bg-white m-5 rounded-lg shadow-md hover:shadow-xl flex flex-row justify-between p-5">
      <span class="text-lg font-semibold mt-2">История заказов</span>
      <img class="w-48 h-32" src="/storage/order_history.png" alt="История заказов">
    </a>
    <a href="{{ route('lk.setting') }}" class="bg-white m-5 rounded-lg shadow-md hover:shadow-xl flex flex-row justify-between p-5">
      <span class="text-lg font-semibold mt-2">Настройки</span>
      <img class="w-32 h-32" src="/storage/setting.png" alt="Настройки">
    </a>
    <div class="bg-white m-5 rounded-lg shadow-md hover:shadow-xl flex flex-row justify-between p-5">
      <div class="flex flex-col">
        <span class="text-lg font-semibold mt-2">Статистика</span>
        <span class="text-lg font-base mt-2">
          Кол-во купленных товаров: {{ auth()->user()->count_buy_products }}
        </span>
      </div>
      <img class="w-32 h-32" src="/storage/stats.png" alt="Статистика">
    </div>
  </div>
</x-app-layout>