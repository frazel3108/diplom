<script>
import { ref } from 'vue';
import SwiperClass, { Navigation, Thumbs } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

export default {
  name: "ProductCarousel",
  props: {
    images: {
      type: [Array, null],
      default: () => [],
      required: true,
    },
  },
  components: {
    Swiper,
    SwiperSlide,
  },
  data() {
    const thumbsSwiper = ref();
    const setThumbsSwiper = (SwiperClass) => {
        thumbsSwiper.value = SwiperClass;
    };

    return {
        data_images: this.images ? this.images : [{url: 'https://via.placeholder.com/500x500.png'}],
        modules: [Navigation, Thumbs],
        setThumbsSwiper,
        thumbsSwiper
    }
  },
}
</script>

<template>
  <div class="thumb-example">
  <swiper
    class="top-swiper"
    :style="{
      '--swiper-navigation-color': '#fff',
      '--swiper-pagination-color': '#fff'
    }"
    :modules="modules"
    :space-between="10"
    :navigation="true"
    :thumbs="{ swiper: thumbsSwiper }"
  >
    <swiper-slide class="slide self-center" v-for="(slide, index) in data_images" :key="index">
      <img :src="slide.url" class="h-full w-auto"/>
    </swiper-slide>
  </swiper>
  <swiper
    v-if="data_images.length > 1"
    class="thumbs-swiper mt-2 h-20"
    :modules="modules"
    :space-between="10"
    :slides-per-view="data_images.length >= 4 ? 4 : data_images.length"
    :watch-slides-progress="true"
    :prevent-clicks="false"
    :prevent-clicks-propagation="false"
    @swiper="setThumbsSwiper"
  >
    <swiper-slide
      class="slide thumbs-swiper-slide-item max-w-fit"
      v-for="(slide, index) in data_images"
      :key="index"
    >
      <img :src="slide.url" class="h-full object-cover" />
    </swiper-slide>
  </swiper>
</div>
</template>
