<h1>Dashboard</h1>

@deferred('stats')
    <x-stats :stats="$stats" />
@placeholder
    <div class="skeleton"></div>
@enddeferred
