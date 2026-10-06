{{-- An array: square brackets --}}
<p>{{ $task['title'] }}</p>
<p>{{ $task['owner']['name'] ?? 'Nobody' }}</p>

{{-- A model: an arrow, and its loaded relations the same way --}}
<p>{{ $post->title }}</p>
<p>{{ $post->author->name }}</p>
<p>{{ $post->editor?->name ?? 'Not edited' }}</p>
