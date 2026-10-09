# Nitro docs: design plan

The look and the building blocks of the documentation site, before its content. Tailwind CSS
(v4) throughout.

## What the best docs sites do (research, October 2026)

| Site | What to take |
|---|---|
| **Tailwind Plus "Syntax"** (docs template) | A landing hero with a code card beside the headline; quick-link cards under the intro; three columns (nav, content, "On this page"); two callout styles; prev/next at the bottom; soft gradient glows behind the hero. |
| **Tailwind Plus "Protocol"** (API template) | Two-column reference pages: the explanation left, the code right, scrolling together. Good for the attributes and config reference. |
| **Laravel docs** | Dense, well-grouped sidebar; a version switcher; "On this page" with two levels; code tabs per platform (macOS / Windows / Linux); "Next steps" lists that end each page. Nitro's readers know this site. |
| **Livewire docs** | Version switcher in the header; info and warning callouts with a title ("Don't worry about styling"); a troubleshooting section; "Next steps". Nitro's closest neighbour: readers will compare. |
| **Inertia docs** | Backend and frontend code side by side (`UserController.php` beside `Users.vue`), with framework tabs. Nitro's version of this is a component's class beside its view. |
| **Stripe docs** | Three columns with code alongside the prose; the polish of small details (copy buttons, hover states, anchors). |
| **Starlight / VitePress** | The component kit docs need: asides, tabs, cards, link cards, steps, file trees, badges; `⌘K` search over the whole site; "Edit this page"; last updated. |

## Principles

1. **Reading first.** A comfortable line length (~72 characters), generous spacing, quiet chrome.
   The code and the prose are the design.
2. **Show where code runs.** Nitro's one idea is that methods run in the browser and `#[Server]`
   methods on the server. The design makes that visible everywhere (see "Signature elements").
3. **Fast.** Instant page changes, no layout shift, search that answers while typing.
4. **Dark mode as a first-class theme**, not an inverted afterthought. Both are designed.
5. **Accessible:** keyboard navigation everywhere, visible focus, contrast AA or better, reduced
   motion respected.

## Brand

- **Idea:** two things fusing: the server (warm) and the browser (cool). A gradient from one to
  the other is Nitro's mark; used sparingly (logo, hero glow, the active nav item, the Server
  and Browser badges).
- **Colours** (a starting point, to tune on a mockup):
  - Server: amber/orange (`amber-500` → `orange-500`)
  - Browser: violet/indigo (`violet-500` → `indigo-500`)
  - The nitro gradient: orange → pink → violet
  - Neutrals: zinc (slate is cooler; zinc pairs better with the warm side)
- **Fonts:** Inter (or Geist) for text; JetBrains Mono (or Geist Mono) for code. Both self-hosted.
- **Logo:** a wordmark "Nitro" with the gradient on a small mark; light and dark versions.

## Layout

```
┌──────────────────────────────────────────────────────────────────────────────┐
│ ◆ Nitro  v0.x ▾         [ Search docs…  ⌘K ]          Docs  GitHub  ☀/☾       │  header (sticky)
├──────────────┬──────────────────────────────────────────────┬────────────────┤
│ GETTING      │  Components › Properties                     │ On this page   │
│  Introduction│                                              │  Properties    │
│  Installation│  # Properties                                │   Types        │
│  Quickstart  │                                              │   #[Locked]    │
│ ESSENTIALS   │  Prose at ~72ch …                            │   #[Url]       │
│  Components ●│                                              │                │
│  Properties  │  ┌ Counter.php ─┬ counter.blade.php ┐        │                │
│  Methods     │  │ code …                          │ ⧉       │                │
│  Views       │  └─────────────────────────────────┘        │                │
│ ...          │                                              │                │
│              │  ‹ Components            Methods ›           │                │
└──────────────┴──────────────────────────────────────────────┴────────────────┘
```

- **Header:** logo, version switcher, search (`⌘K` / `Ctrl K`), Docs / GitHub links, theme
  switcher (light / dark / system).
- **Left sidebar:** grouped sections, collapsible groups, the current page highlighted with the
  nitro gradient; scrolls on its own; remembers its scroll between pages.
- **Content:** breadcrumb, title, an optional one-line lead, prose; prev/next cards; "Edit this
  page on GitHub" and "Last updated".
- **Right column:** "On this page", two levels, highlighting the section in view.
- **Mobile:** the sidebar becomes a drawer; "On this page" a collapsible block under the title.

## Signature elements (what makes it Nitro's)

1. **Runs-where badges.** A small pill on code and on API entries: **Browser** (cool), **Server**
   (warm), **Both** (the gradient). A `#[Server]` method in a code block gets a margin marker on
   its line.
2. **Class beside view.** A component's PHP class and its Blade view shown together: side by side
   on wide screens, as tabs on narrow ones (Inertia's idea, for Nitro's shape).
3. **"Compiled" toggle.** Under a component, a toggle shows the JavaScript the browser runs,
   generated by the real compiler at docs build time. It answers "what does Nitro do with my
   code?" better than prose, and no other framework's docs can show it.
4. **Live examples.** Small working Nitro components inside the pages (a counter, a filtered
   list, a form with validation), so the docs demonstrate what they describe.

## Components (the kit the content is written with)

| Component | Use |
|---|---|
| Callout: note, tip, warning, danger | With an optional title; icon per kind |
| Code block | File name title, language, copy button, highlighted lines, diff lines (`+`/`-`), line markers (`#[Server]`) |
| Code tabs | Laravel / Nitro, macOS / Windows / Linux, class / view |
| Class + view pair | Signature element 2 |
| Compiled toggle | Signature element 3 |
| Steps | Numbered installation and quickstart steps |
| File tree | Where files go (`app/Nitro/Pages`, `resources/views/nitro/...`) |
| Cards and link cards | Landing quick links, "Next steps" |
| Badges | Browser / Server / Both, "Since 0.x", "Experimental" |
| API table | Attributes, config keys, directives, events: name, type, default, description, runs-where |
| Keyboard keys | `⌘K`, `Esc` |
| Live example frame | Signature element 4, with "View source" |

## Pages beyond the docs

- **Landing page:** headline and one sentence; a code card with a component's class and view; three
  points (write PHP and Blade, runs in the browser, `#[Server]` when you need the server); a short
  live demo; "Get started" and "GitHub".
- **Search:** results grouped by page, with the matching section heading; keyboard only.
- **404:** search box and the main sections.

## Tech (to decide)

- **Option A: built with Nitro itself** (a Laravel or Nitro app with Nitro pages, Markdown
  content, client-side navigation). The docs become Nitro's biggest real app and the live
  examples are native. Code highlighting in PHP (Phiki, a PHP port of Shiki).
- **Option B: a static site** (Vite + Tailwind + Markdown, plain HTML out). Simpler to host
  anywhere; live examples would need the Nitro runtime embedded.
- Either way: Tailwind v4, Markdown files for the content, search index built at build time.

## Next

1. Decide the tech (A or B) and the brand colours.
2. Build a one-page visual mockup: header, sidebar, a content page using every component, light
   and dark.
3. Review it, adjust, then plan the content (sections and pages).
