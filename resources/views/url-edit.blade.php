<x-app-layout>
    <div>
        <form method="POST" action="{{ route('url.update', $url) }}">
            @csrf
            @method("PUT")
            <x-text-input id="url_submit" class="block mt-1 w-full"
                          type="text"
                          name="url"/>
            <x-primary-button class="ml-4">
                {{ __('Submit') }}
            </x-primary-button>
        </form>
        <a class="ml-4" href="{{ route('url.index')}}">Return</a>
    </div>
</x-app-layout>
