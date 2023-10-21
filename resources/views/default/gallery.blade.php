<!-- default gallery -->
@if($data['config'] !== 'standard')
    @if($data['countItemEachRow'] == 2)

        <div class="container grid lg:grid-cols-2 gap-2 mx-auto my-6">
            @foreach ($data['items'] as $item)
                <figure class="bg-gray-200 rounded-lg">
                    <a class="glightbox" href="{{ $item['url'] }}">
                        <img class="rounded-t-lg" src="{{ thumbor($item['url'],500) }}"
                             alt="{{ $item['caption'] }}"></a>
                    @if (!empty($item['caption']))
                        <figcaption class="text-center py-1">{{ $item['caption'] }}</figcaption>
                    @endif
                </figure>
            @endforeach

            @endif
            @if($data['countItemEachRow'] == 3)

                <div class="container grid lg:grid-cols-3 gap-2 mx-auto my-4">
                    @foreach ($data['items'] as $item)
                        <figure class="bg-gray-200 rounded-lg">
                            <a class="glightbox" href="{{ $item['url'] }}">
                                <img class="rounded-t-lg" src="{{ thumbor($item['url'],500) }}"
                                     alt="{{ $item['caption'] }}"></a>
                            @if (!empty($item['caption']))
                                <figcaption class="text-center py-1">{{ $item['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            @endif

            @if($data['countItemEachRow'] == 4)

                <div class="container grid md:grid-cols-2 lg:grid-cols-4 gap-2 mx-auto my-6">
                    @foreach ($data['items'] as $item)
                        <figure class="bg-gray-200 rounded-lg">
                            <a class="glightbox" href="{{ $item['url'] }}">
                                <img class="rounded-t-lg" src="{{ thumbor($item['url'],500) }}"
                                     alt="{{ $item['caption'] }}"></a>
                            @if (!empty($item['caption']))
                                <figcaption class="text-center py-1">{{ $item['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>

            @endif
            @else
                <div class="bg-gray-200 rounded-xl mb-8">
                <div x-data="carousel()" class="relative pb-16">
                    <img
                        class="w-full object-cover object-center"
                        :src="images[selected]"
                        alt="mountains"
                    />

                    <button
                        @click="if (selected > 0 ) {selected -= 1} else { selected = images.length - 1 }"
                        class="absolute inset-y-0 left-0 pl-2 py-[25%] h-full w-12 group hover:bg-gray-500 hover:bg-opacity-75 cursor-pointer"
                    >
        <span class="group-hover:block text-gray-50">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
</svg>
        </span>
                    </button>
                    <button
                        @click="if (selected < images.length - 1  ) {selected += 1} else { selected = 0 }"
                        class="absolute inset-y-0 right-0 pl-2 pr-0 py-[25%] h-full w-12 group hover:bg-gray-500 hover:bg-opacity-75 cursor-pointer"
                    >
        <span class="group-hover:block text-gray-50">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
</svg>
        </span>
                    </button>

                    <div class="absolute -bottom-3 w-full p-8 flex justify-center space-x-4">
                        <template x-for="(image,index) in images" :key="index">
                            <button
                                @click="selected = index"
                                :class="{'bg-gray-300': selected == index, 'bg-gray-500': selected != index}"
                                class="h-8 w-8 rounded-full hover:bg-gray-300 ring-2 ring-gray-300"
                            ></button>
                        </template>
                    </div>
                </div>
                </div>
                <script>
                    const carousel = () => {
                        return {
                            selected: 0,
                            images: [
                                @foreach ($data['items'] as $item)
                                @if(!($loop->index ===0)), @endif "{{$item['url']}}"
                                @endforeach
                            ]
                        };
                    };
                </script>

    @endif
