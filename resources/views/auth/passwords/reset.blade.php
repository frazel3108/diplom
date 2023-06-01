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
          <div class="flex items-center my-4 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5">
            <p class="text-center font-semibold mx-4 mb-0">Восстановление пароля</p>
          </div>
          <form action="{{ route('lk.password.update') }}" method="post">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <x-admin.form.input
              label="Email адресс"
              id="email"
              name="email"
              type="email"
              placeholder="example@mail.ru"
              :value="$email ?? old('email')"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              autocomplete="email"
              autofocus
              required
            />

            <x-admin.form.input
              label="Пароль"
              id="password"
              name="password"
              type="password"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              required
              autocomplete="new-password"
            />

            <x-admin.form.input
              label="Подтверждение пароля"
              id="password-confirm"
              name="password_confirmation"
              type="password"
              class="border border-solid border-gray-300 shadow-sm focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none px-4 py-2"
              required
              autocomplete="new-password"
            />

            <div class="text-center lg:text-left my-3">
              <button
                type="submit"
                class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
              >
                Восстановить пароль
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</x-app-layout>