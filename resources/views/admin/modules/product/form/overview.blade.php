<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
  <x-admin.form.select
    label="Категория товара"
    id="category_id"
    name="category_id"
    :options="$categories"
    :value="old('category_id', isset($product) ? $product->category_id : '')"
    wrapper-class="col-start-1"
    required
  />
  <x-admin.form.input
    id="name"
    name="name"
    label="Название Товара"
    :value="old('name', isset($product) ? $product->name : '')"
    required
  />
  <x-admin.form.input
    name="url"
    label="Url"
    id="url"
    :value="old('url', isset($product) ? $product->url : '')"
  />
  <x-admin.form.input
    name="order"
    type="number"
    label="Приоритет"
    :value="old('order', isset($product) ? $product->order : 0)"
    id="order"
  />
  <div class="col-span-full">
    <x-admin.form.wysiwyg
      name="description"
      label="Описание"
      rows="6"
    >{!! old('description', isset($product) ? $product->description : '') !!}</x-admin.form.wysiwyg>
  </div>
  <x-admin.form.input
    name="price"
    type="number"
    label="Цена без скидки"
    :value="old('price', isset($product) ? $product->price : 0)"
    id="price"
    required
  />
  <x-admin.form.input
    name="sale_price"
    type="number"
    label="Цена с учётом скидки"
    :value="old('sale_price', isset($product) ? $product->sale_price : 0)"
    id="sale_price"
  />
  <x-admin.form.checkbox
    id="popular"
    name="popular"
    :checked="old('popular', isset($product) ? $product->popular : 0)"
  >
    Популярный товар
  </x-admin.form.checkbox>
</div>