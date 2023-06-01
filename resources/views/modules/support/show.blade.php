<x-app-layout>
  <x-admin.status class="my-4" :status="session('status')"/>
  <x-admin.errors class="my-4" :errors="$errors"/>
  <h1 class="text-hero">Помощь</h1>

  <div class="grid max-md:flex max-md:flex-col md:grid-cols-2">
    <div class="md:col-span-2 mt-2">
      <h2 class="text-title text-center">Как купить товар?</h2>
      <span>
        <p class="max-md:mt-2">В качестве оплаты за товары мы принимает электронные деньги, что позволяет моментально доставить товар покупателю.</p>
        <p class="max-md:mt-2">Если это программа или книга, то сразу после оплаты вам будет предоставлена ссылка для скачивания, если это предоплаченная карта или карта экспресс-оплаты, то вам будут предоставлены её реквизиты (серийный номер, PIN-код и т.д.) или их отсканированное изображение.</p>
      </span>
      <h2 class="text-lg text-center mt-5">Процесс покупки товара в нашем магазине максимально прост и интуитивно понятен. Разделим данный процесс на 3 <b>важных</b> шага!</h2>
    </div>
    <div class="mt-2 max-md:mt-4">
      <h3 class="text-xl font-medium">Шаг 1. Выбор товара</h3>
      <img
        src="https://img.freepik.com/free-photo/woman-using-laptop-and-credit-card-for-online-shopping_23-2148101684.jpg?w=1380&t=st=1675108520~exp=1675109120~hmac=35ceef3ffd9b56a73e2294c2cedd7978045da589e6bce447cff76bb6bcc38049"
        class="shadow-lg mt-3 w-full"
        alt="Шаг 1"
      >
    </div>
    <div class="md:mt-2 max-md:mt-4 md:mx-4 self-center">
      <span>Выберите интересующий вас товар. Ознакомьтесь со всей информацией: наличие, характеристики, особенности и другой предоставленной информации на странице товара. Нажмите кнопку "Добавить в корзину"!</span>
    </div>
    <div class="mt-4 md:mr-4 flex flex-col justify-evenly">
      <h3 class="text-xl mt-2 font-medium">Шаг 2. Выбор способа оплаты</h3>
      <div>
        <p class="max-md:mt-2">Теперь выберите доступный и удобный вам способ оплаты.</p>
        <p class="max-md:mt-2">Введите свой электронный адрес (если требуется).</p>
        <p class="max-md:mt-2">Поставьте галочку, подтверждающую ваше согласие с описанием товара, его региональными ограничениями и с тем, что вы прочитали <i>пользовательское соглашение</i>, <i>политику конфиденциальности</i> и дали <i>согласие на обработку своих персональных данных</i>.</p>
        <p class="max-md:mt-2">Нажмите на кнопку "Перейти к оплате"!</p>
        <p class="max-md:mt-2">Теперь оплатите заказ выбранным способом оплаты на странице, на которую вас перебросит.</p>
      </div>
    </div>
    <div class="md:mt-4 max-md:mt-2">
      <img
        src="https://img.freepik.com/free-photo/credit-cards_144627-16725.jpg?w=1380&t=st=1675109017~exp=1675109617~hmac=a6de6aabbb3b1c5cc7948583417123365d5d43d9825561e2d7e11c55a4436133"
        class="shadow-lg mt-3 w-full"
        alt="Шаг 2"
      >
    </div>
    <div class="mt-2 max-md:mt-4">
      <h3 class="text-xl font-medium">Шаг 3. Получение товара</h3>
      <img
        src="https://img.freepik.com/free-photo/inbox-communication-notification-e-mail-mail-concept_53876-120057.jpg?w=1380&t=st=1675109970~exp=1675110570~hmac=bc386e7794dd9babf0e8cb1e2ac103b2624cd79d2510abf478fd472322394239"
        class="shadow-lg mt-3 w-full"
        alt="Шаг 3"
      >
    </div>
    <div class="md:mt-2 max-md:mt-4 md:mx-4 self-center">
      <span>
        <p class="max-md:mt-2">После успешной оплаты вас автоматически перебросит на страницу с вашим заказом, а именно с товаром и возможным бонусом к нему.</p>
        <p class="max-md:mt-2">После этого на свою почту вы получите уведомление с информацией по вашему заказу, также эту информацию вы можете просмотреть у себя в личном кабинете.</p>
      </span>
    </div>
    <div class="mt-5 flex flex-col items-center md:col-span-2">
      <h2 class="text-xl font-medium">Форма обратной связи</h2>
      <form action="" method="post" class="w-full max-w-lg space-y-2">
        @csrf
        @auth()
          <x-admin.form.input name="email" class="hidden" value="{{ auth()->user()->email }}"/>
          <x-admin.form.input name="name" class="hidden" value="{{ auth()->user()->name }}"/>
        @endauth
        @guest
          <x-admin.form.input label="E-mail" type="email" name="email" :value="old('email')" required/>
          <x-admin.form.input label="Ваше имя" name="name" :value="old('name')" required/>
        @endguest
        <x-admin.form.textarea label="Ваш вопрос" name="message" cols="30" rows="10" :value="old('message')" required></x-admin.form.textarea>
        <div class="mt-3 flex justify-center">
          <x-admin.btn type="submit">
            Отправить форму
          </x-admin.btn>
        </div>
      </form>
    </div>
  </div>


</x-app-layout>