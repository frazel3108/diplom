<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <form method="POST" id="form" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        @isset ($role)
          @method('PUT')
        @endisset

        <x-admin.status class="mb-4" :status="session('status')"/>
        <x-admin.errors class="mb-4" :errors="$errors"/>

        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
          <x-admin.form.input
            label="Название роли для доступа"
            id="name"
            name="name"
            :value="old('name', isset($role) ? $role->name : '')"
            required
          />
          <x-admin.form.input
            label="Название ключа роли"
            id="key"
            name="key"
            :value="old('key', isset($role) ? $role->key : '')"
          />

          <hr class="col-span-full h-px my-2 bg-gray-200 border-0">

          @foreach ($acceses as $access)
            <x-admin.form.label id="{{ $access->name }}">{{ $access->name }}</x-admin.form.label>
            <div
              class="space-y-2"
              x-data="{ activeTab: '<?= isset($role) ? $role->roleAccess($access)->level->name : $levels[0]->name ?>' }"
            >
              <div class="flex space-x-4">
                @foreach ($levels as $level)
                  <x-admin.tab tab="{{ $level->name }}" title="{{ $level->name }}" />
                @endforeach
                <x-admin.form.input
                  name="Access[{{ $access->name }}][level]"
                  type="hidden"
                  x-model="activeTab"
                />
              </div>
              <div>
                <div x-show="activeTab === 'PARTIAL_ACCESS'" style="display: none;">
                  <x-admin.form.label>
                    Модели классов, к которым разрешён доступ
                  </x-admin.form.label>
                  <select
                    name="Access[{{ $access->name }}][info][]"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    multiple
                  >
                    @foreach ($allModels as $model)
                      <option @if (in_array($model, $roleInfo[$access->name])) selected @endif >{{ $model }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          @endforeach

        </div>

        <x-admin.btn type="submit" form="form" class="flex items-center">
          {{--    <x-admin.svg.check class="w-3 h-2.5 mr-2" />--}}
          <span>Сохранить</span>
        </x-admin.btn>
      </form>
    </div>

  </div>


  </form>
</x-admin-app-layout>
