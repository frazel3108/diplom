<script>
import { Pagination } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';

export default {
  name: "OfferCarousel",
  props: {
    items: {
      type: Array,
      required: true
    },
  },
  data() {
    return {
       modules: [Pagination],
    }
  },
  components: {
      Swiper,
      SwiperSlide
  },
}
</script>

<template>
  <swiper
      class="swiper mb-5"
      :modules="modules"
      :pagination="{ clickable: true, dynamicBullets: true }"
    >
      <swiper-slide
        v-for="item in items"
        :key="item.id"
        class="slide"
      >
        <div class="relative text-center">
          <img
            :src="item.banner"
            :alt="item.name"
            class="max-h-[500px] h-full w-full object-cover"
          />
          <div class="absolute backdrop-blur-[1px] top-1/2 left-1/2 w-full h-full -translate-x-1/2 -translate-y-1/2">
            <div class="absolute top-3/4 left-3/4 max-sm:top-1/3 max-sm:left-0 max-sm:right-0 max-sm:items-center flex flex-col text-white text-right">
              <span class="text-4xl">{{ item.name }}</span>
              <a
                :href="'/catalog/?offer%5B%5D=' + item.id"
                class="md:text-xl sm:text-sm"
              >
                Перейти к акции
              </a>
            </div>
          </div>
        </div>
      </swiper-slide>
    </swiper>
</template>
