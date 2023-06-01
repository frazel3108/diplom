<form metho="POST" class="flex flex-row flex-wrap items-center ml-auto mr-3 mt-3">
{{--  <x-admin.svg.search class="z-10 absolute top-1/2 left-5 w-3.5 h-3.5 -translate-y-1/2" />--}}
  <div class="mb-3 pt-0">
    <x-admin.form.input
      type="text"
      name="search"
      placeholder="Поиск"
      value="{{ request()->get('search', '') }}"
      class="border-transparent shadow px-3 py-2 text-sm  w-full placeholder-blueGray-200 text-blueGray-700 relative bg-white rounded-md outline-none focus:ring focus:ring-sky-500 focus:ring-1 focus:border-sky-500 border border-solid transition duration-200  placeholder:text-base"
    />
  </div>
  @if (request()->has('tab'))
    <input type="hidden" name="tab" value="{{ request()->get('tab') }}">
  @endif
</form>
