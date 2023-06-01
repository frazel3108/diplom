<script>
import { ref } from 'vue';
import {
  Dialog, DialogPanel, Disclosure,
  DisclosureButton, DisclosurePanel, Menu,
  MenuButton, MenuItem, MenuItems,
  TransitionChild, TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import {
  ChevronDownIcon, FunnelIcon, MinusIcon,
  PlusIcon, Squares2X2Icon
} from '@heroicons/vue/20/solid';

export default {
  name: "MainFilter",
  props: {
    dataCategories: {
      type: Object,
      default: () => ({}),
    },
    filter: {
      type: Object,
      default: () => ({}),
    },
    filterDataSet: {
      type: Object,
      default: () => ({}),
    }
  },
  components: {
    Dialog, DialogPanel, Disclosure,
    DisclosureButton, DisclosurePanel, Menu,
    MenuButton, MenuItem, MenuItems,
    TransitionChild, TransitionRoot, XMarkIcon,
    ChevronDownIcon, FunnelIcon, MinusIcon,
    PlusIcon, Squares2X2Icon,
  },
  data() {
    return {
      subCategories: this.dataCategories['withoutChild'],
      categories: this.dataCategories['withChild'],
      offers: this.filter.offers,
      priceMin: this.filter.prices.min,
      priceMax: this.filter.prices.max,
      sortOptions: [
        { name: 'По популярности', href: '#', current: true },
        { name: 'По новизне', href: '#', current: false },
        { name: 'По цене: от низкой до высокой', href: '#', current: false },
        { name: 'По цене: от высокой до низкой', href: '#', current: false },
      ],
      mobileFiltersOpen: ref(false),
    };
  },
}
</script>

<template>
  <div class="bg-white">
    <div>
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog as="div" class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
          <TransitionChild
            as="template"
            enter="transition-opacity ease-linear duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="transition-opacity ease-linear duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild
              as="template"
              enter="transition ease-in-out duration-300 transform"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transition ease-in-out duration-300 transform"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                <div class="flex items-center justify-between px-4">
                  <h2 class="text-lg font-medium text-gray-900">Фильтр</h2>
                  <button
                    type="button"
                    class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                    @click="mobileFiltersOpen = false"
                  >
                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                  </button>
                </div>

                <form class="mt-4 border-t border-gray-200">
                  <h3 class="px-2 pt-3 font-medium text-gray-900">Категории</h3>
                  <ul role="list" class="px-2 py-3 font-base text-gray-900">
                    <li v-for="category in subCategories">
                      <a
                        v-if="category['item'].products_count > 0"
                        :href="'/catalog/' + category['item'].url + '/'"
                      >
                        {{ category['item'].name }}
                      </a>
                    </li>
                  </ul>

                  <Disclosure
                    as="div"
                    v-for="section in categories"
                    class="border-t border-gray-200 px-4 py-6"
                    v-slot="{ open }"
                  >
                    <h3 class="-mx-2 -my-3 flow-root">
                      <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                        <a
                          :href="'/catalog/' + section['item'].url + '/'"
                          class="font-medium text-gray-900"
                        >
                          {{ section['item'].name }}
                        </a>
                        <span class="ml-6 flex items-center">
                          <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                          <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                        </span>
                      </DisclosureButton>
                    </h3>
                    <DisclosurePanel class="pt-6">
                      <div class="space-y-6">
                        <div v-for="option in section['child']" class="flex items-center">
                          <a
                            :href="'/catalog/' + option['item'].url + '/'"
                            class="ml-3 text-sm text-gray-600"
                          >
                            {{ option['item'].name }}
                          </a>
                        </div>
                      </div>
                    </DisclosurePanel>
                  </Disclosure>
                  <Disclosure
                    as="div"
                    v-if="offers.length > 0"
                    class="border-t border-gray-200 px-4 py-6"
                    v-slot="{ open }"
                  >
                    <h3 class="-mx-2 -my-3 flow-root">
                      <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                         <span class="font-medium text-gray-900">Акции</span>
                         <span class="ml-6 flex items-center">
                           <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                           <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                         </span>
                       </DisclosureButton>
                     </h3>
                     <DisclosurePanel class="pt-6">
                       <div class="space-y-6">
                         <div
                           v-for="offer in offers"
                           class="flex items-center"
                        >
                          <input
                            :id="`filter-mobile-offer-${offer.id}`"
                            :name="`offer[]`"
                            :value="offer.id"
                            type="checkbox"
                            :checked="filterDataSet.offer.includes(offer.id)"
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                          />
                            <label
                              :for="`filter-mobile-offer-${offer.id}`"
                              class="ml-3 min-w-0 flex-1 text-gray-500"
                            >
                              {{ offer.name }}
                            </label>
                         </div>
                       </div>
                     </DisclosurePanel>
                  </Disclosure>
                  <div class="border-y border-gray-200 px-4 py-2 flex flex-col">
                    <label class="py-2">Цена</label>
                    <div class="flex flex-col space-y-2 pb-4">
                      <input
                        type="number"
                        name="price_min"
                        :min="priceMin"
                        :max="priceMax"
                        :placeholder="'от ' + priceMin + ' ₽'"
                        :value="filterDataSet.price_min"
                        class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-600 focus:outline-none shadow-sm"
                      >
                      <input
                        type="number"
                        name="price_max"
                        :min="priceMin"
                        :max="priceMax"
                        :value="filterDataSet.price_max"
                        :placeholder="'до ' + priceMax + ' ₽'"
                        class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-600 focus:outline-none shadow-sm"
                      >
                    </div>
                  </div>
                  <div class="pt-6 mx-2 border-t border-gray-200">
                    <button type="submit" class="rounded-lg border cursor-pointer transition w-full bg-red-500 hover:bg-orange-500 border-red-500 hover:border-orange-500 text-white text-sm px-4 py-2.5">
                      Примернить
                    </button>
                  </div>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="mx-auto">
        <div class="flex items-baseline justify-end border-b border-gray-200 pb-6">
          <div class="flex items-center">
            <button
              type="button"
              class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
              @click="mobileFiltersOpen = true"
            >
              <FunnelIcon class="h-5 w-5" aria-hidden="true" />
            </button>
          </div>
        </div>

        <section aria-labelledby="products-heading" class="pt-6 md:pb-24">

          <div>
            <form class="hidden lg:block">
              <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
                <li v-for="category in subCategories">
                  <a
                    v-if="category['item'].products_count > 0"
                    :href="'/catalog/' + category['item'].url + '/'"
                  >
                    {{ category['item'].name }}
                  </a>
                  <div v-else>
                    {{ category['item'].name }}
                  </div>
                </li>
              </ul>

              <Disclosure
                as="div"
                v-for="section in categories"
                class="border-b border-gray-200 py-6"
                v-slot="{ open }"
              >
                <h3 class="-my-3 flow-root">
                  <DisclosureButton class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                    <a
                      v-if="section['item'].products_count > 0"
                      :href="'/catalog/' + section['item'].url + '/'"
                      class="font-medium text-gray-900"
                    >
                      {{ section['item'].name }}
                    </a>
                    <span v-else class="font-medium text-gray-900">
                      {{ section['item'].name }}
                    </span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="option in section['child']" class="flex items-center">
                      <a
                        v-if="option['item'].products_count > 0"
                        :href="'/catalog/' + option['item'].url + '/'"
                        class="ml-3 text-sm text-gray-600"
                      >
                        {{ option['item'].name }}
                      </a>
                      <span v-else class="ml-3 text-sm text-gray-600">
                        {{ option['item'].name }}
                      </span>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>

              <Disclosure
                as="div"
                v-if="offers.length > 0"
                class="border-b border-gray-200 py-6"
                v-slot="{ open }"
              >
                <h3 class="-my-3 flow-root">
                  <DisclosureButton class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">Акции</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="offer in offers" class="flex items-center">
                      <input
                        :id="`filter-offer-${offer.id}`"
                        :name="`offer[]`"
                        :value="offer.id"
                        type="checkbox"
                        :checked="filterDataSet.offer.includes(offer.id)"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                      />
                      <label
                        :for="`filter-offer-${offer.id}`"
                        class="ml-3 min-w-0 flex-1 text-gray-500"
                      >
                        {{ offer.name }}
                      </label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>

              <div class="border-b border-gray-200 py-2 mt-2 flex flex-col">
                <label class="py-2">Цена</label>
                <div class="flex flex-row pb-4 space-x-2">
                  <input
                    type="number"
                    name="price_min"
                    :min="priceMin"
                    :max="priceMax"
                    :placeholder="'от ' + priceMin + ' ₽'"
                    :value="filterDataSet.price_min"
                    class="form-control w-full px-3 py-1 border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-600 focus:outline-none shadow-sm"
                  >
                  <input
                    type="number"
                    name="price_max"
                    :min="priceMin"
                    :max="priceMax"
                    :value="filterDataSet.price_max"
                    :placeholder="'до ' + priceMax + ' ₽'"
                    class="form-control w-full px-3 py-1 border border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-600 focus:outline-none shadow-sm"
                  >
                </div>
              </div>
              <div class="pt-6">
                <button type="submit" class="rounded-lg border-brand cursor-pointer transition w-full bg-brand hover:bg-brand-hover border-red-500 hover:border-brand-hover text-white text-sm px-4 py-2.5">
                  Применить
                </button>
              </div>
            </form>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>
