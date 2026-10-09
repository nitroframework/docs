use App\Nitro\Pages\Students\Show;

Route::nitro('/students/{student}', Show::class)->name('students.show');
Route::nitro('/students', 'pages::students.index')->name('students.index');

Route::middleware('auth')->group(function () {
    Route::nitro('/settings', Settings::class)->name('settings');
});
