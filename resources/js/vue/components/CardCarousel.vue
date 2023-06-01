<script>

import { Navigation } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';

export default {
  name: "CardCarousel",
  props: {
    items: {
      type: Array,
      default: () => [],
      required: true,
    },
    options: {
      type: Object,
      default: () => ({
        loop: false,
        centered: false,
      }),
      required: false,
    },
  },
  components: {
    Swiper,
    SwiperSlide,
  },
  data() {
    return {
      data_items: this.items,
      data_options: this.options,
      modules: [Navigation],
      breakpoints: {
        768: {
            slidesPerView: 2.38,
            spaceBetween: 16,
          },
          1024: {
            slidesPerView: 3.16,
            spaceBetween: 20,
          },
          1420: {
            slidesPerView: 3.2,
            spaceBetween: 20,
          },
      }
    }
  },
}
</script>

<template>
  <swiper
    class="swiper relative mt-5 md:mt-6 lg:mt-7 flex items-stretch"
    :modules="modules"
    :slides-per-view="1.25"
    :centered-slides="data_options.centered"
    :space-between="10"
    :grab-cursor="true"
    :loop="data_options.loop"
    :pagination="{ clickable: true }"
    :breakpoints="breakpoints"
  >
    <swiper-slide
      class="slide lg:max-w-[390px] transition duration-200 ease-in-out mb-3"
      v-for="item in data_items"
      :key="item.id"
    >
      <a :href="item.url" class="flex flex-col h-full w-full rounded-xl bg-white p-4 hover:shadow-lg">
        <div class="h-52 lg:h-60 w-full rounded-2 overflow-hidden">
          <img
            :src="item.images ? item.images[0].url : 'https://via.placeholder.com/500x500.png'"
            :alt="item.name" class="w-full h-full object-cover object-center rounded-2"
          />
        </div>
        <div class="mt-2.5 md:mt-4 lg:mt-5 lg:px-3.5 pb-4">
          <div class="flex flex-col-reverse md:flex-row justify-between items-start md:items-center">
            <div class="font-fira text-gray-800 font-medium text-base lg:text-xl mt-2.5 md:mt-0">
              {{ item.name }}
            </div>
            <div v-if="item.new" class="font-roboto text-gray-500 text-xxs md:text-xs font-medium py-1 px-1 md:px-2.5 border border-gray-500 rounded">
              New
            </div>
          </div>
        </div>

        <div class="pb-4 lg:px-3.5 mt-auto">
          <div class="grid grid-cols-2 items-end mt-3 2xl:mt-5">
            <div v-if="item.dataPrice.discount > 0">
              <div class="uppercase whitespace-nowrap text-gray-500 text-xxs lg:text-xs line-through">
                {{ Intl.NumberFormat().format(item.dataPrice.old_price) }} &#8381;
              </div>
              <div class="font-roboto whitespace-nowrap text-green-600 font-medium text-base md:text-xl 2xl:text-2xl">
                {{ Intl.NumberFormat().format(item.dataPrice.price) }}
                <small class="font-roboto text-green-600 font-medium text-xs md:text-sm lg:text-base">
                  &#8381;
                </small>
              </div>
            </div>
            <div v-if="item.dataPrice.discount == 0 || !item.dataPrice.discount">
              <div class="font-roboto whitespace-nowrap text-green-600 font-medium text-base md:text-xl 2xl:text-2xl">
                {{ Intl.NumberFormat().format(item.dataPrice.price) }}
                <small class="font-roboto text-green-600 font-medium text-xs md:text-sm lg:text-base">
                  &#8381;
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-brand rounded-md flex items-center justify-center text-white text-semibold text-sm lg:text-base h-10 lg:h-12 hover:bg-brand-hover hover:text-gray-300 cursor-pointer transition ease-in-out duration-200">
          Подробнее
        </div>
      </a>
    </swiper-slide>
  </swiper>
</template>

<style type="scss">
  .swiper-slide {
    @apply h-auto;
  }
</style>
