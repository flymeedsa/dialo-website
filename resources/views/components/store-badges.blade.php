@props(['compact' => false])
<div {{ $attributes->class(['store-badges', 'compact' => $compact]) }} aria-label="{{ __('messages.download_soon') }}">
    <span class="store-badge" aria-disabled="true"><span class="store-mark">▶</span><span><small>{{ app()->getLocale()==='ar'?'قريبًا على':'Coming soon on' }}</small><strong>Google Play</strong></span></span>
    <span class="store-badge" aria-disabled="true"><span class="store-mark apple">●</span><span><small>{{ app()->getLocale()==='ar'?'قريبًا على':'Coming soon on' }}</small><strong>App Store</strong></span></span>
</div>
