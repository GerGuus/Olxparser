<x-app-layout>
    <div>
        <form method="POST" action="{{ route('2fa-check.store') }}">
            @csrf
            <x-text-input id="url_submit" class="block mt-1 w-full"
                          type="text"
                          name="2faCode"/>
            <x-input-error :messages="$errors->get('2faCode')" class="mt-2" />
            <x-primary-button class="ml-4">
                {{ __('Submit') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
