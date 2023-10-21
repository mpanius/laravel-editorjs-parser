<div class="bg-white border-2 rounded-2xl p-6 grid gap-2 grid-cols-auto grid-cols-3  my-6">
    <div class="col-span-3 md:col-span-2 prose prose-a:text-gray-400">
        <h4>{{ data_get($data,'meta.title') }}</h4>
        <p class="prose hidden md:block">
            {{ data_get($data,'meta.description') }}
        </p>
        <span>
                <a target="_blank" class="no-underline text-sm" href="{{$data['link']}}">{{parse_url($data['link'],PHP_URL_HOST)}}</a>
        </span>

    </div>
    @isset($data['meta']['image']['url'])
        <div class="col-span-3 md:col-span-1 md:mt-0">

            <img class="md:h-full md:object-cover my-1" style="margin-top:0;" src="{{ data_get($data['meta.image.url'] }}">

        </div>
    @endisset
</div>
