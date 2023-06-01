<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <form method="POST" id="form" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        @isset ($characteristic)
          @method('PUT')
        @endisset

        <x-admin.status class="mb-4" :status="session('status')"/>
        <x-admin.errors class="mb-4" :errors="$errors"/>

        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
          <x-admin.form.input
            id="name"
            name="name"
            label="Название характеристики"
            :value="old('name', isset($characteristic) ? $characteristic->name : '')"
            required
          />
          <x-admin.form.input
            id="order"
            name="order"
            type="number"
            label="Приоритет"
            :value="old('order', isset($characteristic) ? $characteristic->order : 0)"
          />
        </div>

        <x-admin.btn type="submit" form="form" class="flex items-center">
          <x-admin.svg.check class="w-3 h-2.5 mr-2" />
          <span>Сохранить</span>
        </x-admin.btn>
      </form>
    </div>

  </div>


  </form>
</x-admin-app-layout>