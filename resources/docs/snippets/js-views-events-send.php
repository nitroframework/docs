<?php

// app/Nitro/Components/Vue/PostList.php: #[View(vue: 'post-list')]

/** Picked: said at once, in the browser. */
public function pick(int $id): void
{
    $this->post = $id;
    $this->dispatch('post-picked', id: $id);
}

/** Published on the server; the others hear of it with the answer. */
#[Server]
public function publish(): void
{
    $this->validate();
    $post = Post::findOrFail($this->post)->publish();

    $this->dispatch('post-published', post: $post->only('id', 'title', 'category'));
}
