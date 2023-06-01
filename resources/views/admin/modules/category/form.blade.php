<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <form method="POST" id="form" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        @isset ($category)
          @method('PUT')
        @endisset
    
        <x-admin.status class="mb-4" :status="session('status')"/>
        <x-admin.errors class="mb-4" :errors="$errors"/>
    
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
          <x-admin.form.select
            label="Родительская категория"
            id="parent_id"
            name="parent_id"
            :options="$categories"
            :value="old('parent_id', isset($category) ? $category->parent_id : '')"
            wrapper-class="col-start-1"
            required
          />
          <x-admin.form.input
            id="name"
            name="name"
            label="Название категории"
            :value="old('name', isset($category) ? $category->name : '')"
            required
          />
          <x-admin.form.input
            name="url"
            label="Url"
            id="url"
            :value="old('url', isset($category) ? $category->url : '')"
          />
          <x-admin.form.input
            name="order"
            type="number"
            label="Приоритет"
            :value="old('order', isset($category) ? $category->order : '')"
            id="order"
          />
          <x-admin.form.upload
            id="image"
            name="image"
            label="Изображение"
            readonly="{{ Auth::user()->cannot('update_category', App\Models\Admin\User::class) }}"
            :uploaded="isset($category->image)
              ? [
                'src' => $category->image,
                'url' => $category->image_link,
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