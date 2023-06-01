<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-6 mb-4">
  <x-admin.form.select
    label="Акции, в которых участвует товар"
    id="others"
    name="offers"
    wrapper-class="md:col-span-2"
    :options="$offers"
    :value="old('offer', isset($product->offers) ? $product->offers->pluck('id')->toArray() : [])"
    multiple
    required
  />
</div>
