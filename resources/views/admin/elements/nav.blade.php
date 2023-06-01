<nav class="absolute top-0 left-0 w-full z-10 bg-white lg:flex-row lg:flex-nowrap lg:justify-start flex items-center py-1 px-4 lg:bg-transparent">
  <div class="w-full mx-aut0 items-center flex justify-between lg:flex-nowrap flex-wrap lg:px-6 px-4">
    <div class="text-blueGray-800 lg:text-white text-sm uppercase inline-block font-semibold my-3">
      {{ App\Facades\Breadcrumbs::getCurrent() ?? '' }}
    </div>
    <button
      class="ml-auto cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-blueGray-400 rounded bg-transparent block outline-none focus:outline-none text-blueGray-300 lg:hidden"
      type="button"
    >
      <i class="bi bi-person"></i>
    </button>
    <div
      class="items-center w-full lg:flex lg:w-auto flex-grow duration-300 transition-all ease-in-out lg:h-auto-important hidden"
    >
      <x-admin.list.search />
      <div x-data="{ isOpen: false }" class="relative inline-block">
        <!-- Dropdown toggle button -->
        <button @click="isOpen = !isOpen" class="w-12 h-12 text-sm text-white bg-blueGray-300 inline-flex items-center justify-center rounded-full relative z-10 text-blueGray-500 block p-2 text-gray-700 bg-white border border-transparent rounded-md focus:border-blue-500 focus:ring-opacity-40 focus:ring-blue-300 focus:ring focus:outline-none"></button>
    
        <!-- Dropdown menu -->
        <div x-show="isOpen"
          @click.away="isOpen = false"
          x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="opacity-0 scale-90"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-100"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-90"
          class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl"
        >
          <form action="{{ route('admin.logout') }}" method="post">
            @csrf
            <button type="submit" class="w-full block text-left px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
              Выйти
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>