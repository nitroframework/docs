// routes/web.php
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('/posts/{post}/comments', [CommentController::class, 'store']);

// app/Http/Controllers/PostController.php
class PostController extends Controller
{
    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => $post->only('id', 'title', 'body'),
        ]);
    }
}

// app/Http/Controllers/CommentController.php
class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['comment' => 'required|max:1000']);
        $post->comments()->create(['body' => $request->comment, 'user_id' => auth()->id()]);

        return back();
    }
}
