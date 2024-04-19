<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                {{-- <x-ApplicationLogo class="w-20 h-20 text-gray-500 fill-current" /> --}}
            </a>
        </x-slot>
        <div class="mb-4 text-sm text-gray-600">
            {{ new Illuminate\Support\HtmlString(__("Received an email with a login code? If not, click <a class=\"hover:underline\" href=\":url\">here</a>.", ['url' => route('verify.resend')])) }} 
        </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('verify.store') }}">
            @csrf
            <div>
                <x-input-label for="two_factor_code" :value="__('Code')" />
                <x-text-input id="two_factor_code" class="block w-full mt-1" type="text" name="two_factor_code" required
                    autofocus />
                <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
            </div>
            <div class="flex justify-end mt-4">
                <x-primary-button>
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

