<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
  <div class="col-span-full">
    <x-admin.alert type="info" class="mb-2">
      Первое изображение будет использоваться как изображение карточки товара!
    </x-admin.alert>
    
    <x-admin.form.upload
      id="image"
      name="image[]"
      label="Изображение"
      readonly="{{ Auth::user()->cannot('update_product', App\Models\Admin\User::class) }}"
      :multiple="true"
      :uploaded="isset($product) ? $product->image_uploaded : null"
    />
  </div>
</div>