<div class="col-span-full">
  <x-admin.alert type="info" class="mb-2">
    Можно загрузить только 1 файл, типы поддерживаемых файлов:
    <li>Текстовые файлы (.txt)</li>
    <li>Microsoft Word (.doc, .docx)</li>
  </x-admin.alert>
  <x-admin.form.upload
    label="Файл"
    id="file"
    name="file"
    readonly="{{ Auth::user()->cannot('update_product_content', App\Models\Admin\User::class) }}"
    :uploaded="isset($content->file)
      ? [
        'src' => $content->file,
        'url' => $content->file_link,
      ]
      : null
    "
  />
</div>