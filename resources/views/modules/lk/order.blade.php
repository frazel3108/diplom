<x-app-layout>
  <h1 class="text-lg mt-10 font-bold">История заказов</h1>

  <div class="flex flex-col h-full">
    @foreach (auth()->user()->order_history as $order)
      <x-lk.order :order="$order" />
    @endforeach
  </div>

</x-app-layout>