<?php

// app/Nitro/Components/React/PostPreview.php: #[View(react: 'post-preview')]

#[On('post-picked')]
public function show(int $id): void
{
    $this->current = $id;
}

#[On('post-published')]
public function published(array $post): void
{
    $this->published[$post['category']] = ($this->published[$post['category']] ?? 0) + 1;
}
