use Nitro\Fusion\Facades\Fusion;

Fusion::share('user', fn () => $request->user()?->only('id', 'name'));
Fusion::share('locale', app()->getLocale());

Fusion::shareOnce('countries', fn () => Country::pluck('name', 'code'));
Fusion::share('permissions', Fusion::once(fn () => $user->permissions())->until(3600));
