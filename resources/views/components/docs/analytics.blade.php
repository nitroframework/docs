{{-- Cloudflare Web Analytics: in production, with the site's token (config/services.php), so a local copy or a fork reports nothing. spa: nitro:navigate visits count as page views. --}}
@if (app()->isProduction() && config('services.cloudflare_analytics.token'))
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js" data-cf-beacon='{{ json_encode(['token' => config('services.cloudflare_analytics.token'), 'spa' => true]) }}'></script>
@endif
