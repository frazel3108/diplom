<x-admin-app-layout>
  <div class="relative pb-32 bg-sky-500"></div>
  <x-admin.form.with-tabs init-tab="overview">
      <x-slot:tabs>
        <x-admin.tab tab="overview" title="Основное" />
        <x-admin.tab tab="media" title="Медиа" />
        <x-admin.tab tab="characteristics" title="Характеристики" />
        <x-admin.tab tab="other" title="Дополнительно" />
      </x-slot:tabs>
      
      <form method="POST" id="form" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        @isset ($product)
          @method('PUT')
        @endisset
    
        <x-admin.status class="mb-4" :status="session('status')"/>
        <x-admin.errors class="mb-4" :errors="$errors" />
  
        <div x-show="activeTab === 'overview'">
          @include('admin.modules.product.form.overview')
        </div>
        <div x-show="activeTab === 'media'" style="display: none;">
          @include('admin.modules.product.form.media')
        </div>
        <div x-show="activeTab === 'characteristics'" style="display: none;">
          @include('admin.modules.product.form.characteristics')
        </div>
        <div x-show="activeTab === 'other'" style="display: none;">
          @include('admin.modules.product.form.other')
        </div>
        
        <div class="flex space-x-2">
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
          <x-admin.btn type="submit" form="form" class="flex items-center">
            <x-admin.svg.check class="w-3 h-2.5 mr-2" />
            <span>Сохранить</span>
          </x-admin.btn>
        </div>
      </form>
  </x-admin.form.with-tabs>
</x-admin-app-layout>