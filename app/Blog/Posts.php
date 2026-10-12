<?php

namespace App\Blog;

use App\Events\PostPublished;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * The examples' blog: each reader's own posts, kept in their session. Your app would keep them
 * in the database (a Post model); here every reader starts with the same few posts, and what
 * they write is theirs alone and gone when the session ends.
 */
final class Posts
{
    /** Posts a reader can have: the session stays small. */
    public const LIMIT = 20;

    /**
     * Newest first.
     *
     * @return list<array{id: string, title: string, body: string, date: string}>
     */
    public static function all(): array
    {
        if (! session()->has('blog.posts')) {
            session(['blog.posts' => self::samples()]);
        }

        return session('blog.posts');
    }

    /**
     * Writes a new post (no id) or one of the reader's own (its id), and tells the reader's other
     * tabs through Reverb.
     *
     * @return array{id: string, title: string, body: string, date: string}
     */
    public static function save(?string $id, string $title, string $body): array
    {
        $posts = self::all();
        $index = $id === null ? null : array_search($id, array_column($posts, 'id'), true);

        if ($id !== null && $index === false) {
            throw ValidationException::withMessages(['title' => 'This post was deleted.']);
        }

        if ($id === null && count($posts) >= self::LIMIT) {
            throw ValidationException::withMessages(['title' => 'This blog keeps '.self::LIMIT.' posts. Delete one to write another.']);
        }

        $post = [
            'id' => $id ?? (string) Str::ulid(),
            'title' => $title,
            'body' => $body,
            'date' => $id === null ? now()->format('M j, Y') : $posts[$index]['date'],
        ];

        if ($id === null) {
            array_unshift($posts, $post);
        } else {
            $posts[$index] = $post;
        }

        session(['blog.posts' => $posts]);

        /** A broadcast that can't be sent (Reverb not running) doesn't stop the post being saved. */
        rescue(function () use ($post, $id) {
            event(new PostPublished(self::channel(), $post, created: $id === null));
        }, report: false);

        return $post;
    }

    public static function delete(string $id): void
    {
        session(['blog.posts' => array_values(array_filter(self::all(), fn (array $post) => $post['id'] !== $id))]);
    }

    /** The reader's broadcast channel: a name only their session knows, so no one else hears their posts. */
    public static function channel(): string
    {
        if (! session()->has('blog.channel')) {
            session(['blog.channel' => Str::random(40)]);
        }

        return session('blog.channel');
    }

    /** @return list<array{id: string, title: string, body: string, date: string}> */
    private static function samples(): array
    {
        $posts = [
            ['Shipping the new search', "Search used to wait for the server on every keystroke. Now the list filters as you type, in the browser, and the server only hears about it when you save.\n\nThe code didn't change much: the same PHP class, compiled to run where the user is."],
            ['Notes from the Laravel meetup', "Three talks, one theme: send less to the server. Queues, caching and components that do their work in the browser.\n\nThe best question of the night: what still needs a request? Saving, and anything secret."],
            ['Why we write PHP for the browser', "Our team knows PHP and Blade. Learning a second language for every interactive widget slowed us down.\n\nWriting the component once, and letting it run in the browser, gave us both: one language and an app that feels instant."],
        ];

        return array_map(fn (array $post, int $daysAgo) => [
            'id' => (string) Str::ulid(),
            'title' => $post[0],
            'body' => $post[1],
            'date' => now()->subDays($daysAgo)->format('M j, Y'),
        ], $posts, [2, 9, 21]);
    }
}
