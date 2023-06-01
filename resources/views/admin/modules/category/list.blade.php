<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <div class="px-6 py-4 border-0">
        <div class="flex flex-wrap max-sm:flex-col items-center">
          <div class="flex flex-col relative w-full max-sm:mb-3 max-w-full flex-1 float-left max-sm:justify-between max-sm:flex-row-reverse">
            @can('create_category', App\Models\Admin\User::class)
              <div class="mt-2">
                <x-admin.btn tag="a" href="{{ route('admin.category.create') }}">
                  + Создать
                </x-admin.btn>
              </div>
            @endcan
            <div class="mt-4">
              <h3 class="font-bold text-lg text-blueGray-700">Категории</h3>
            </div>
          </div>
          <x-admin.list.tabs :tabs="$tabs ?? []"/>
        </div>
      </div>
      <div class="block w-full overflow-x-auto">
        <table class="items-center w-full bg-transparent border-collapse">
          <thead>
          <tr>
            <x-admin.table.th class="w-16" sort-by="id">
              #
            </x-admin.table.th>
            <x-admin.table.th class="w-32" sort-by="name">
              Название
            </x-admin.table.th>
            <x-admin.table.th class="w-32" sort-by="parent_id">
              Название родительской категории
            </x-admin.table.th>
            <x-admin.table.th sort-by="url">
              Путь
            </x-admin.table.th>
            <x-admin.table.th class="w-12" sort-by="group">
              Приоритет
            </x-admin.table.th>
            <x-admin.table.th class="w-12"></x-admin.table.th>
          </tr>
          </thead>
          <tbody>
          @foreach($categories as $category)
            <tr>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  <span class="ml-3 font-bold NaN"># {{ $category->id }}</span>
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $category->name }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $category->parentCategory()
                      ? $category->parentCategory()->name
                      : 'Без родительской категории' }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  <a target="_blank" href="{{ $category->app_url }}">{{ $category->app_url }}</a>
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $category->order }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  @can('view_category', App\Models\Admin\User::class)
                    <a
                      class="cursor-pointer transition duration-200"
                      href="{{ route('admin.category.show', ['category' => $category]) }}"
                    >
                      Просмотреть
                    </a>
                  @endcan
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <x-slot:footer>
    <div class="ml-auto px-4">
      {{ $categories->links() }}
    </div>
  </x-slot>
</x-admin-app-layout>
