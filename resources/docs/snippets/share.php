use Nitro\Facades\Nitro;

Nitro::share('user', fn () => $request->user()?->only('id', 'name'));
Nitro::share('locale', app()->getLocale());

Nitro::shareOnce('countries', fn () => Country::pluck('name', 'code'));
Nitro::share('permissions', Nitro::once(fn () => $user->permissions())->until(3600));
