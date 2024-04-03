
@if ($errors instanceof Illuminate\Support\MessageBag && $errors->any())
    <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
@endif
