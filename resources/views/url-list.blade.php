<style>
    .url-list{
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-bottom: 5px;
    }
    .url-item{
        width: 100%;
        display: flex;
        justify-content: space-between;
        background-color: lightgray;
        border: 2px solid black;
        border-radius: 20px;
        margin-bottom: 5px;
        padding-right: 10px;
        padding-left: 10px;
    }

</style>
<x-app-layout>
    <a href="{{ route('url.create')}}"> Create New</a>
    <div class="url-list">
        @foreach($list as $url)
            <div class="url-item">
                {{ $url->url }}
                <div>
                    <a href="{{ route('url.edit', $url) }}">Edit</a>
                    <form method="POST" action="{{ route('url.destroy', $url->id) }}">
                        @method('DELETE')
                        @csrf
                        <x-primary-button class="ml-4">
                            {{ __('Delete') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
