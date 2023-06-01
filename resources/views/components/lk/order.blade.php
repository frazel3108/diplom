@props(['order' => []])

<div class="bg-white m-5 rounded-lg border-solid border-2 shadow-xl">
  <div class="flex flex-col p-5">
    <div class="flex md:flex-row max-md:flex-col justify-between">
      <div class="flex flex-row max-md:flex-wrap max-md:justify-center items-center space-x-5">
        <div>
          <span>Номер заказа</span>
          <p class="text-gray-500">#{{ $order->id }}</p>
        </div>
        <div>
          <span>Дата заказа</span>
          <p class="text-gray-500">{{ date('j.n.Y', strtotime($order->updated_at)) }}</p>
        </div>
        <div class="max-md:my-2">
          <span>Сумма заказа</span>
          <p class="font-bold">{!! number_format($order->summary()['total'], 2, ',', '&nbsp;') !!}&nbsp;&#8381;</p>
        </div>
      </div>
    </div>
  </div>
  @foreach($order->products as $product)
    <hr class="w-full">
    <div class="flex flex-col p-5">
      <div class="flex md:flex-row max-md:flex-col md:space-x-5">
        <div class="md:max-w-[10rem] max-md:w-full">
          <img
            src="{{ $product->data->image_uploaded[0]['url'] ?? 'https://via.placeholder.com/500x500.png' }}"
            class="w-full h-full rounded-2"
            alt="{{ $product->data->name }}"
          >
        </div>
        <div class="flex flex-col w-full max-md:mt-2">
          <div class="flex flex-row justify-between items-center">
            <span class="font-semibold">{{ $product->data->name }}</span>
            <span>
              {!! number_format($product->price * $product->quantity, 2, ',', '&nbsp;') !!}&nbsp;&#8381;
            </span>
          </div>
          @foreach ($product->contents as $content)
            @if ($content->type == 'text')
              <div class="md:mt-5 max-md:mt-2 h-full">
                <span>Данные:</span>
                <span class="font-light text-gray-500">{!! $content->content !!}</span>
              </div>
            @else
              <a
                class="my-2 underline font-light text-gray-500 hover:font-bold hover:text-black"
                href="{{ $content->file_link }}"
                download
              >
                Скачать
              </a>
            @endif
          @endforeach
        </div>
      </div>
      <div class="justify-end space-x-5 max-md:mt-2 flex flex-row">
        <a href="{{ $product->data->route }}" class="text-blue-500">Посмотреть товар</a>
        <form action="{{ route('lk.basket.add', ['product'=> $product->data]) }}" method="post">
          @csrf
          <button type="submit" class="text-blue-500">Купить снова</button>
        </form>
      </div>
    </div>
  @endforeach
</div>