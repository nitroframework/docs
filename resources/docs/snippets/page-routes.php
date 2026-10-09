use App\Nitro\Pages\Posts\Show;

Route::nitro('/posts/{post}', Show::class)->name('posts.show');
Route::nitro('/posts', 'pages::posts.index')->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::nitro('/settings', Settings::class)->name('settings');
});
