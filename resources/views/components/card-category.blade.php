@props(['category' => []])

<div class="flex flex-col bg-[#F8F9FA] max-sm:self-center max-sm:my-2 justify-evenly w-full items-center max-w-[320px] px-5 pt-5 rounded-2">
  <p class="text-2xl text-center">{{ $category->name }}</p>
  <a href="/catalog/{{ $category->url }}/" class="py-2 px-6 border-black border-[1px] mt-3 rounded-full hover:text-white hover:bg-brand-hover hover:bg-brand-hover">Посмотреть</a>
  @if ($category->image_link)
    <img
      src="{{ $category->image_link }}"
      alt="{{ $category->name }}"
      class="rounded-2 mt-4 max-sm:hidden"
    >
  @endif
</div>