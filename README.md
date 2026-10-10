# Nitro documentation

**Read the docs: [nitro-docs.laravel.cloud](https://nitro-docs.laravel.cloud/)**

The documentation site for [Nitro](https://github.com/nitroframework/nitro): PHP components for
Laravel that run in the browser. Write a component's logic in PHP and its view in Blade, Vue,
React, Solid or Svelte; Nitro compiles the PHP to JavaScript that runs in the browser, and calls
the server only when you ask it to.

The site is a Laravel application built with Nitro itself: its search, navigation and live
examples are Nitro components and pages.

## Running it locally

Requires PHP 8.3+, Composer and Node.js.

```bash
git clone https://github.com/nitroframework/docs.git nitro-docs
cd nitro-docs
composer setup            # dependencies, .env, the app key, the database, and the front-end build
php artisan nitro:build   # compiles the Nitro components and pages
php artisan serve
```

Then open http://localhost:8000.

## Where things are

| What | Where |
| --- | --- |
| The pages | `resources/views/docs/content/*.blade.php`, one file per page |
| The sidebar: groups and order of pages | `config/docs.php` (`nav`) |
| Code examples shown on the pages | `resources/docs/snippets/` |
| The live examples (components) | `app/Nitro/Components/` and `resources/views/nitro/components/` |
| The home page | `resources/views/home.blade.php` |
| Code highlighting, the sidebar, search | `app/Docs/` |

A page shows a snippet with `<x-docs.code src="file.php" lang="php" />`, so examples stay plain
files that can be read and checked on their own.

## Contributing

Corrections and clearer explanations are welcome. Open a pull request against `main`; for a
larger change, open an issue first. Keep examples close to real use: what runs on the server
goes in a `#[Server]` method, and every API a page describes should match Nitro's source.

## License

The documentation is open-source under the [MIT license](https://github.com/nitroframework/nitro/blob/main/LICENSE.md).
Nitro was created by [Zeeshan Ali](https://github.com/ZeeshanX4).
