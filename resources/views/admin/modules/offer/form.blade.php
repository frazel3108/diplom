<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <form method="POST" id="form" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        @isset ($offer)
          @method('PUT')
        @endisset
    
        <x-admin.status class="mb-4" :status="session('status')"/>
        <x-admin.errors class="mb-4" :errors="$errors"/>
    
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
          <x-admin.form.input
            id="name"
            name="name"
            label="Название акции"
            :value="old('name', isset($offer) ? $offer->name : '')"
            required
          />
          <x-admin.form.input
            id="href"
            name="href"
            label="Страница акции"
            :value="old('href', isset($offer) ? $offer->href : '')"
            required
          />
          <x-admin.form.input
            id="percent"
            name="percent"
            type="number"
            max="99"
            min="5"
            step="5"
            label="Процент скидки товара"
            :value="old('percent', isset($offer) ? $offer->percent : 5)"
            required
          />
          <x-admin.form.input
            id="start_at"
            type="date"
            name="start_at"
            label="Дата начала акции"
            :value="old('start_at', isset($offer) ? $offer->start_at : '')"
            required
          />
          <x-admin.form.input
            id="end_at"
            type="date"
            name="end_at"
            label="Дата окончания акции"
            :value="old('end_at', isset($offer) ? $offer->end_at : '')"
            required
          />
          <x-admin.form.upload
            id="banner"
            name="banner"
            label="Баннер"
            readonly="{{ Auth::user()->cannot('update_offer', App\Models\Admin\User::class) }}"
            required
            :uploaded="isset($offer->banner)
              ? [
                'src' => $offer->banner,
                'url' => $offer->banner_link,
              ]
              : null
            "
          />
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
