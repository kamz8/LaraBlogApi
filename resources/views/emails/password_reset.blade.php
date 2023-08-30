@component('mail::message')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Greeting --}}
    # Witaj!

    Ktoś poprosił o zresetowanie hasła do Twojego konta. Kliknij przycisk poniżej, aby to zrobić:

    {{-- Action Button --}}
    @component('mail::button', ['url' => url('password/reset', $token)])
        Zresetuj hasło
    @endcomponent

    {{-- Subcopy --}}
    Jeśli nie prosiłeś o resetowanie hasła, możesz zignorować tę wiadomość.

    {{-- Footer --}}
    @slot('footer')
    @component('mail::footer')
    &copy; {{ date('Y') }} {{ config('app.name') }}. Wszelkie prawa zastrzeżone.
@endcomponent
@endslot
@endcomponent
