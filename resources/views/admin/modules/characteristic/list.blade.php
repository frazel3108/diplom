<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>

  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <div class="px-6 py-4 border-0">
        <div class="flex flex-wrap max-sm:flex-col items-center">
          <div class="flex flex-col relative w-full max-sm:mb-3 max-w-full flex-1 float-left max-sm:justify-between max-sm:flex-row-reverse">
            <div class="mt-2">
              <x-admin.btn tag="a" href="{{ route('admin.characteristic.create') }}">
                + Создать
              </x-admin.btn>
            </div>
            <div class="mt-4">
              <h3 class="font-bold text-lg text-blueGray-700">Характеристики</h3>
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
            <x-admin.table.th class="w-12" sort-by="order">
              Приоритет
            </x-admin.table.th>
            <x-admin.table.th class="w-12"></x-admin.table.th>
          </tr>
          </thead>
          <tbody>
          @foreach($characteristics as $characteristic)
            <tr>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  <span class="ml-3 font-bold NaN"># {{ $characteristic->id }}</span>
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $characteristic->name }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $characteristic->order }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  <a
                    class="cursor-pointer transition duration-200"
                    href="{{ route('admin.characteristic.show', ['characteristic' => $characteristic]) }}"
                  >
                    Просмотреть
                  </a>
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
      {{ $characteristics->links() }}
    </div>
  </x-slot>
</x-admin-app-layout>