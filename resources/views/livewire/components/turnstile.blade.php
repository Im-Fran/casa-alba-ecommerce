@props([
    'first-error-only' => true,
])

<div class="flex-1 flex flex-col w-full" wire:ignore>
    <div
        id="cf-turnstile"
        class="cf-turnstile bg-white"
    ></div>

    @if($errors->count() > 0)
        @dd($this->all())
        @if($errors->has($errorFieldName))
            @foreach($errors->get($errorFieldName) as $message)
                @foreach(Arr::wrap($message) as $line)
                    <div class="{{ $errorClass }}" x-classes="text-red-500 label-text-alt p-1">{{ $line }}</div>
                    @break($firstErrorOnly)
                @endforeach
                @break($firstErrorOnly)
            @endforeach
        @endif
    @endif

    @script
        <script>
            const captchaCallback = (token) => $wire.$set('response', token)
            const captchaExpiredCallback = () => $wire.$set('response', null)
            $wire.watch("response", (value, old) => {
                // If there was a value, and now there isn't, reset the Turnstile.
                if (!! old && ! value) {
                    window.turnstile.reset();
                }
            })

            turnstile.render('#cf-turnstile', {
                sitekey: '{{ config('services.turnstile.key') }}',
                callback: captchaCallback,
                'expired-callback': captchaExpiredCallback,
                'timeout-callback': captchaExpiredCallback,
                theme: 'light',
                language: 'es',
                size: 'flexible',
            })
        </script>
    @endscript
</div>
