<div class="col-span-full">
  <x-admin.form.wysiwyg
    name="content"
    label="Описание"
    rows="6"
  >{!! old('content', isset($content) ? $content->content : '') !!}</x-admin.form.wysiwyg>
</div>