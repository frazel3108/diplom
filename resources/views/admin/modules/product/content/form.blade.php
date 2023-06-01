<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <div class="w-full px-4 -mt-10">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white text-blueGray-700">
      <form method="POST" id="form" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        @isset ($content)
          @method('PUT')
        @endisset
  
        <x-admin.status class="mb-4" :status="session('status')"/>
        <x-admin.errors class="mb-4" :errors="$errors"/>
        
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
          <div class="col-span-full">
            <x-admin.form.select
              label="Товар"
              id="product_id"
              name="product_id"
              :options="$products"
              :value="old('product_id', isset($content) ? $content->product_id : '')"
              wrapper-class="col-start-1"
              required
            />
          </div>
        </div>
        
        <x-admin.alert type="info" class="mb-2">
          Можно выбрать только 1 тип предоставляемой позиции
        </x-admin.alert>
        <x-admin.alert type="info" class="mb-2">
          Пожалуйста не переключайтесь, при сохранении, на другой таб, если вы загружаете <b>другой</b> тип позиции
        </x-admin.alert>
        <div
          class="space-y-2"
          x-data="{ activeTab: '<?= isset($content) ? $content->type : 'text' ?>' }"
        >
          <div class="flex space-x-4">
            <x-admin.tab tab="text" title="Текст" />
            <x-admin.tab tab="file" title="Файл" />
            <x-admin.form.input
              name="type"
              type="hidden"
              x-model="activeTab"
            />
          </div>
          <div>
            <div>
              <div x-show="activeTab === 'text'" style="display: none;">
                @include('admin.modules.product.content.form.text')
              </div>
            </div>
            <div x-show="activeTab === 'file'" style="display: none;">
              @include('admin.modules.product.content.form.file')
            </div>
          </div>
        </div>
        
        <div class="flex items-baseline space-x-2 space-y-4">
          <div class="">
            <x-admin.btn
              type="submit"
              name="action"
              onclick="history.back()"
              form="form"
              value="Cancel"
              class="flex items-center"
            >
              <span>Назад</span>
            </x-admin.btn>
          </div>
          <x-admin.btn type="submit" form="form" class="flex items-center">
            <x-admin.svg.check class="w-3 h-2.5 mr-2" />
            <span>Сохранить</span>
          </x-admin.btn>
        </div>
      </form>
    </div>
  </div>
</x-admin-app-layout>