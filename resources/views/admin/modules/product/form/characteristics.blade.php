<table class="table w-full" x-data="interactiveTable">
  <thead>
    <tr>
      <x-admin.table.th class="w-12" />
      <x-admin.table.th class="min-w-xs text-center">
        Характеристика
      </x-admin.table.th>
      <x-admin.table.th class="min-w-xs text-center">
        Значение
      </x-admin.table.th>
      <x-admin.table.th class="w-16" />
    </tr>
  </thead>
  <tbody drag-sort-group>
    @foreach ($product->characteristics ?? [] as $characteristic)
      <tr drag-sort-item>
        <td class="cursor-move hover:bg-gray-200" drag-sort-controll>
            <x-admin.svg.drag class="w-6 fill-current text-gray-400" />
        </td>
        <td>
          <x-admin.form.select
            name="characteristic[id][]"
            wrapper-class="md:col-span-2"
            :options="$characteristics"
            :value="old('characteristic[{{ $loop->index }}][id]', $characteristic->id)"
          />
        </td>
        <td>
          <x-admin.form.input
            name="characteristic[value][]"
            :value="old('characteristic[{{ $loop->index }}][value]', $characteristic->pivot->value)"
          />
        </td>
        <td>
          <div
            class="bg-red-500 text-white text-sm cursor-pointer hover:bg-red-700 rounded py-1 px-2 inline-block"
            title="Удалить"
            x-on:click.prevent="onDeleteClick"
            >
            <x-admin.svg.trash class="fill-current text-inherit w-4" />
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
  <tfooter>
    <tr>
      <td colspan="4" class="bg-gray-50 hover:bg-gray-200 text-center cursor-pointer" x-on:click="onAddClick">
        + Добавить
      </td>
    </tr>
    <tr class="hidden" x-ref="templateRow" drag-sort-item>
      <td class="cursor-move hover:bg-gray-200" drag-sort-controll>
        <x-admin.svg.drag class="w-6 fill-current text-gray-400" />
      </td>
      <td>
        <x-admin.form.select
          name="characteristic[id][]"
          :options="$characteristics"
        />
      </td>
      <td>
        <x-admin.form.input name="characteristic[value][]" />
      </td>
      <td>
        <div
          class="bg-red-500 text-white text-sm cursor-pointer hover:bg-red-700 rounded py-1 px-2 inline-block"
          title="Удалить"
          x-on:click.prevent="onDeleteClick"
          >
          <x-admin.svg.trash class="fill-current text-inherit w-4" />
        </div>
      </td>
    </tr>
    <tr class="hidden" x-ref="templateDelete">
      <td colspan="4" class="bg-red-500 text-white text-xs text-center">
        Удаление записи. <span x-on:click="onDeleteConfirmationClick" class="underline cursor-pointer">Нажмите для подтверждения</span><br>
        Отмена действия через <span countdown>5</span>...
      </td>
    </tr>
  </tfooter>
</table>