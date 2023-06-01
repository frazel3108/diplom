<header class="flex flex-col md:flex-row items-center justify-center justify-between p-4">
  <a href="/" class=" flex text-center mb-2 mb-md-0">
    <img class="max-h-[3.5rem]" src="/storage/logo.png" alt="{{env('APP_NAME')}}">
  </a>
  
  <ul class="flex flex-wrap justify-center uppercase">
    <li class="max-sm:my-2">
      <a
        href="{{ Route::is('index') ? '' : route('index') }}"
        class="px-2 uppercase font-medium text-black {{ Route::is('index') ? ' pointer-events-none' : ' hover:text-brand' }}"
        {{ Route::is('index') ? 'disabled' : '' }}
      >
        Главная
      </a>
    </li>
    <li class="max-sm:my-2">
      <a
        href="{{ Route::is('catalog.list') ? '' : route('catalog.list') }}"
        class="px-2 uppercase font-medium {{ Route::is('catalog.list') ? 'text-brand-hover pointer-events-none underline' : 'text-black hover:text-brand' }}"
        {{ Route::is('catalog.list') ? 'disabled' : '' }}
      >
        Все товары
      </a>
    </li>
    <li class="max-sm:my-2">
      <a
        href="{{ Route::is('warranty') ? '' : route('warranty') }}"
        class="px-2 uppercase font-medium {{ Route::is('warranty') ? 'text-brand-hover pointer-events-none underline' : 'text-black hover:text-brand' }}"
        {{ Route::is('warranty') ? 'disabled' : '' }}
      >
        Гарантии
      </a>
    </li>
    <li class="max-sm:my-2">
      <a
        href="{{ Route::is('about') ? '' : route('about') }}"
        class="px-2 uppercase font-medium {{ Route::is('about') ? 'text-brand-hover pointer-events-none underline' : 'text-black hover:text-brand' }}"
        {{ Route::is('about') ? 'disabled' : '' }}
      >
        О нас
      </a>
    </li>
    <li class="max-sm:my-2">
      <a
        href="{{ Route::is('support') ? '' : route('support') }}"
        class="px-2 uppercase font-medium {{ Route::is('support') ? 'text-brand-hover pointer-events-none underline' : 'text-black hover:text-brand' }}"
        {{ Route::is('support') ? 'disabled' : '' }}
      >
        Помощь
      </a>
    </li>
  </ul>

  <div x-data="{ isOpen: false }" class="relative inline-block">
    <button
      x-on:click="isOpen = !isOpen"
      class="w-12 h-12 inline-flex items-center justify-center relative z-10 p-2"
    >
      <i class="text-lg bi bi-person-fill"></i>
    </button>

    <div x-show="isOpen"
      @click.away="isOpen = false"
      x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="opacity-0 scale-90"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-100"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-90"
      class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-2xl border border-solid border-[1px]"
    >
      @guest
        <a href="{{ route('lk.login') }}" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
          Войти
        </a>
      @endguest
      @auth
        <a
          href="{{ route('lk.home') }}"
          class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline w-full text-left"
        >
          Личный кабинет
        </a>
        <a
          href="{{ route('lk.basket') }}"
          class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline w-full text-left"
        >
          Корзина
        </a>
        <form action="{{ route('lk.logout') }}" method="post">
          @csrf
          <button
            type="submit"
            class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline w-full text-left"
          >
            Выйти
          </button>
        </form>
      @endauth
    </div>
  </div>

</header>

@if (
  request()->routeIs('lk.home')
  || request()->routeIs('lk.basket')
  || request()->routeIs('lk.order_history')
  || request()->routeIs('lk.setting')
)
  <div class="flex w-full bg-brand text-white p-5 justify-center">
    <ul class="flex flex-wrap justify-center">
      <li class="mx-2 hover:text-black"><a href="{{ route('lk.home') }}">Главная</a></li>
      <li class="mx-2 hover:text-black"><a href="{{ route('lk.basket') }}">Корзина</a></li>
      <li class="mx-2 hover:text-black"><a href="{{ route('lk.order_history') }}">История заказов</a></li>
      <li class="mx-2 hover:text-black"><a href="{{ route('lk.setting') }}">Настройки</a></li>
    </ul>
  </div>
@endif