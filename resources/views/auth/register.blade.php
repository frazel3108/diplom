<x-app-layout>
  <section class="h-[85vh]">
    <div class="px-6 h-full text-gray-800">
      <div class="flex lg:justify-between justify-center items-center flex-wrap h-full g-6">
        <div class="grow-0 shrink-1 md:shrink-0 basis-auto lg:w-6/12 md:w-9/12 mb-12 md:mb-0">
          <img
            src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="w-full"
            alt="Sample image"
          />
        </div>
        <div class="lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
          <x-admin.status class="mb-4" :status="session('status')"/>
          <x-admin.errors class="mb-4" :errors="$errors"/>
          <div class="flex items-center my-4 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5">
            <p class="text-center font-semibold mx-4 mb-0">Зарегистрироваться</p>
          </div>
          <form action="{{ route('lk.register') }}" method="post" class="space-y-4">
            @csrf
            <x-admin.form.input
              label="Имя"
              id="name"
              name="name"
              placeholder="Иванов Иван"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              autocomplete="on"
              :value="old('name')"
              autofocus
              required
            />

            <x-admin.form.input
              label="Email"
              id="email"
              name="email"
              placeholder="example@mail.ru"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              autocomplete="email"
              :value="old('email')"
              required
            />
            <div class="form-group">
              <x-admin.form.input
                label="Номер телефона"
                id="phone"
                type="tel"
                name="phone"
                placeholder="+7 (999) 999-99-99"
                class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
                autocomplete="phone"
                :value="old('phone')"
                required
              />
            </div>

            <x-admin.form.input
              label="Пароль"
              id="password"
              name="password"
              type="password"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              autocomplete="new-password"
              required
            />

            <x-admin.form.input
              label="Подтверждние введённого пароля"
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              autocomplete="new-password"
              required
            />

            <div class="text-center lg:text-left">
              <button
                type="submit"
                class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
              >
                Зарегестрироваться
              </button>
              <p class="text-sm font-semibold mt-2 pt-1 mb-0">
                Вспомнили данные от аккаунта?
                <a
                  href="{{ route('lk.login') }}"
                  class="text-red-600 hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out"
                >
                  Войти
                </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</x-app-layout>