<x-app-layout>
  <h1 class="text-2xl mt-5 font-bold">Настройки</h1>
  <hr class="w-full my-2">

  <x-admin.status class="mb-4" :status="session('status')"/>
  <x-admin.errors class="mb-4" :errors="$errors" />

  @if (is_null($user->email_verified_at))
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
      <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
      <form method="post" action="{{ route('lk.verification.resend') }}">
        @csrf
        <button type="submit"
          class="btn btn-link p-0 m-0 align-baseline">Пожалуйста подтвердите свою почту!</button>
      </form>
    </div>
  @endif

  <form action="{{ route('lk.setting.update', ['user' => $user]) }}" method="post">
    @csrf
    @method('PUT')
    <div class="flex flex-col w-full">
      <div class="flex flex-col md:flex-row justify-between p-5 bg-gray-100 rounded-2 my-2 items-center">
        <label class="uppercase text-xs font-medium text-gray-500">Имя</label>
        @if (!$change)
          <span class="uppercase text-xs font-medium text-black">{{ $user->name }}</span>
        @else
          <x-admin.form.input
            name="name"
            placeholder="Имя"
            :value="old('name', isset($user) ? $user->name : '')"
            class="max-md:mt-2 max-md:text-center"
          />
        @endif
      </div>
      <div class="flex flex-col md:flex-row justify-between p-5 bg-gray-100 rounded-2 my-2 items-center">
        <label class="uppercase text-xs font-medium text-gray-500">Email</label>
        @if (!$change)
          <span class="uppercase text-xs font-medium text-black">{{ $user->email }}</span>
        @else
          <x-admin.form.input
            name="email"
            type="email"
            placeholder="Email"
            class="max-md:mt-2 max-md:text-center"
            :value="old('email', isset($user) ? $user->email : '')"
          />
        @endif
      </div>
      <div class="flex flex-col md:flex-row justify-between p-5 bg-gray-100 rounded-2 my-2 items-center">
        <label class="uppercase text-xs font-medium text-gray-500">Номер телефона</label>
        @if (!$change)
          <span class="uppercase text-xs font-medium text-black">{{ $user->phone }}</span>
        @else
          <x-admin.form.input
            name="phone"
            type="phone"
            placeholder="Номер телефона"
            class="max-md:mt-2 max-md:text-center"
            :value="old('phone', isset($user) ? $user->phone : '')"
          />
        @endif
      </div>
      @if ($change)
        <hr class="w-full my-2">
        <h2 class="text-lg font-semibold">Изменение пароля</h2>
        <div class="flex flex-col md:flex-row justify-between p-5 bg-gray-100 rounded-2 my-2 items-center">
          <label class="uppercase text-xs font-medium text-gray-500">Старый пароль</label>
            <x-admin.form.input
              type="password"
              name="old_password"
              class="max-md:mt-2 max-md:text-center"
              placeholder="Старый пароль"
            />
        </div>
        <div class="flex flex-col md:flex-row justify-between p-5 bg-gray-100 rounded-2 my-2 items-center">
          <label class="uppercase text-xs font-medium text-gray-500">Новый пароль</label>
            <x-admin.form.input
              type="password"
              name="new_password"
              class="max-md:mt-2 max-md:text-center"
              placeholder="Новый пароль"
            />
        </div>
        <div class="flex flex-col md:flex-row justify-between p-5 bg-gray-100 rounded-2 my-2 items-center">
          <label class="uppercase text-xs font-medium text-gray-500">Подтверждение нового пароля</label>
            <x-admin.form.input
              type="password"
              name="new_password_confirmation"
              class="max-md:mt-2 max-md:text-center"
              placeholder="Повтор нового пароля"
            />
        </div>
      @endif
    </div>
    <div class="flex items-center w-full justify-around">
      @if(request()->get('change', '') == '')
        <a
          class="mt-4 font-medium py-2.5 px-4 rounded-1 bg-brand h-10 tracking-wide text-white hover:bg-brand-hover"
          href="{{ '?' . http_build_query(['change' => 'true']) }}"
        >
          Изменить
        </a>
        <form action="{{ route('lk.setting.delete', ['user' => $user]) }}" method="post">
          @csrf
          @method('delete')
          <button type="submit" class="mt-4 font-medium py-2.5 px-4 rounded-1 bg-red-300 h-10 tracking-wide text-white hover:bg-red-500">
            Удалить аккаунт
          </a>
        </form>
      @else
        <button type="submit" class="mt-4 font-medium py-2.5 px-4 rounded-1 bg-brand h-10 tracking-wide text-white hover:bg-brand-hover">Сохранить</button>
      @endif
    </div>
  </form>
</x-app-layout>