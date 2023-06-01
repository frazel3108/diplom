<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <div class="px-6 py-4 border-0">
        <div class="flex flex-wrap max-sm:flex-col items-center">
          <div class="flex flex-col relative w-full max-sm:mb-3 max-w-full flex-1 float-left max-sm:justify-between max-sm:flex-row-reverse">
            <div class="mt-2">
              <x-admin.btn tag="a" href="{{ route('admin.user.create') }}">
                + Создать
              </x-admin.btn>
            </div>
            <div class="mt-4">
              <h3 class="font-bold text-lg text-blueGray-700">Page visits</h3>
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
            <x-admin.table.th sort-by="name">
              Имя
            </x-admin.table.th>
            <x-admin.table.th sort-by="email">
              Почта
            </x-admin.table.th>
            <x-admin.table.th sort-by="phone">
              Номер Телефона
            </x-admin.table.th>
            <x-admin.table.th class="w-12"></x-admin.table.th>
          </tr>
          </thead>
          <tbody>
          @foreach($users as $user)
            <tr>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  <span class="ml-3 font-bold NaN"># {{ $user->id }}</span>
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $user->name }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $user->email }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  {{ $user->phone }}
                </div>
              </td>
              <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <div class="flex items-center">
                  <a
                    class="cursor-pointer transition duration-200"
                    href="{{ route('admin.user.show', ['user' => $user]) }}"
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
      {{ $users->links() }}
    </div>
  </x-slot>
  
{{--  <div class="table-wrapper">--}}
{{--    <table class="table">--}}
{{--      <thead>--}}
{{--      <tr>--}}
{{--        <x-admin.table.th class="w-16" link-class="justify-center" sort-by="id">--}}
{{--          #--}}
{{--        </x-admin.table.th>--}}
{{--        <x-admin.table.th sort-by="name">--}}
{{--          Название--}}
{{--        </x-admin.table.th>--}}
{{--        <x-admin.table.th class="w-12"></x-admin.table.th>--}}
{{--      </tr>--}}
{{--      </thead>--}}
{{--      <tbody>--}}
{{--      @foreach ($users as $user)--}}
{{--        <tr>--}}
{{--          <td class="text-center"># {{ $user->id }}</td>--}}
{{--          --}}{{--          <td>{{ $user->city->name }}</td>--}}
{{--          <td>{{ $user->name }}</td>--}}
{{--          --}}{{--          <td>{{ $user->phone }}</td>--}}
{{--          <td>--}}
{{--            <a--}}
{{--              --}}{{--              href="{{ route('admin.dealer.show', ['dealer' => $dealer]) }}"--}}
{{--              class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-300 hover:bg-gray-200 cursor-pointer transition duration-200 ease-in-out"--}}
{{--            >--}}
{{--              --}}{{--              <x-admin.svg.eye class="w-4 h-4" />--}}
{{--            </a>--}}
{{--          </td>--}}
{{--        </tr>--}}
{{--      @endforeach--}}
{{--      </tbody>--}}
{{--    </table>--}}
{{--  </div>--}}
</x-admin-app-layout>