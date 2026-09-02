<section class="inner-cta-wrap">
    <div class="container inner-cta">
        <img src="{{ asset('assets/brand/dialo-icon.png') }}" alt="" aria-hidden="true">
        <div>
            <h2>{{ __('messages.home.cta_title') }}</h2>
            <p>{{ __('messages.home.cta_text') }}</p>
        </div>
        <a class="button inner-cta-button" href="{{ route(app()->getLocale().'.home') }}#download">{{ __('messages.download_soon') }}</a>
    </div>
</section>
