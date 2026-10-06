// Models: read again from the database on every #[Server] call.
$this->posts = Post::with('author')->latest()->get();

// Arrays: only the fields the view needs, and the browser may change them.
$this->posts = Post::latest()->get(['id', 'title'])->toArray();
