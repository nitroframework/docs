use App\Fusion\Pages\Students\Show;

Route::fusion('/students/{student}', Show::class)->name('students.show');
Route::fusion('/students', 'pages::students.index')->name('students.index');

Route::middleware('auth')->group(function () {
    Route::fusion('/settings', Settings::class)->name('settings');
});
