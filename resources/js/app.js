// The docs' small behaviours: theme, tabs, copy, "On this page", search, the mobile drawer.
// Pages change with nitro:navigate (the docs keep their layout, other pages swap the body; this script stays): init() sets up each
// page, on load and after every visit; the window's listeners are added once.
import './autosize.js';

const $ = (selector, root = document) => root.querySelector(selector);
const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];

// ------------------------------------------------------------------ theme

function applyTheme(theme) {
    const dark = theme === 'dark' || (theme === 'system' && matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.classList.toggle('dark', dark);
    document.documentElement.dataset.theme = theme;
    for (const button of $$('[data-theme-set]')) button.setAttribute('aria-checked', String(button.dataset.themeSet === theme));
}

matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => applyTheme(document.documentElement.dataset.theme ?? 'system'));

// ------------------------------------------------------------------ "On this page"

let headings = [];

/**
 * The section being read: the last heading above a line a third down the screen. At the bottom
 * of the page, where a short last section never reaches that line: the section the address names
 * (a link to it was followed) if it is on screen, else the last one on screen.
 */
function trackSection() {
    const line = innerHeight / 3;
    let current = headings[0]?.id;
    for (const heading of headings) {
        if (heading.getBoundingClientRect().top <= line) current = heading.id;
    }
    if (innerHeight + scrollY >= document.documentElement.scrollHeight - 2) {
        const onScreen = headings.filter((heading) => heading.getBoundingClientRect().top < innerHeight);
        const named = onScreen.find((heading) => `#${heading.id}` === decodeURIComponent(location.hash));
        current = (named ?? onScreen.at(-1))?.id ?? current;
    }
    for (const link of $$('[data-toc-link]')) link.classList.toggle('is-active', link.dataset.tocLink === current);
}

addEventListener('scroll', trackSection, { passive: true });
/** A link to a section followed: the address names it once the browser has scrolled. */
addEventListener('hashchange', trackSection);

function buildToc() {
    const content = $('[data-content]');
    headings = content ? $$('h2[id], h3[id]', content) : [];

    for (const heading of headings) {
        if ($('.anchor', heading)) continue;
        const anchor = document.createElement('a');
        anchor.href = `#${heading.id}`;
        anchor.className = 'anchor';
        anchor.textContent = '#';
        anchor.setAttribute('aria-label', `Link to ${heading.textContent}`);
        heading.append(anchor);
    }

    for (const toc of $$('[data-toc]')) {
        toc.replaceChildren();
        /** A page without sections has no "On this page". */
        const holder = toc.closest('details') ?? toc.closest('aside');
        holder?.toggleAttribute('hidden', headings.length === 0);
        if (headings.length === 0) continue;

        const list = document.createElement('ul');
        list.className = 'space-y-2';
        for (const heading of headings) {
            const item = document.createElement('li');
            const link = document.createElement('a');
            link.href = `#${heading.id}`;
            link.textContent = heading.firstChild.textContent.trim();
            link.dataset.tocLink = heading.id;
            link.className = `toc-link ${heading.tagName === 'H3' ? 'pl-3' : ''}`;
            item.append(link);
            list.append(item);
        }
        toc.append(list);
    }

    trackSection();
}

// ------------------------------------------------------------------ search (⌘K / Ctrl K)

const isMac = /Mac|iPhone|iPad/.test(navigator.platform);

/** Every page and section (App\Docs\SearchIndex), fetched the first time search opens. */
let searchIndex = null;

function loadSearchIndex() {
    searchIndex ??= fetch('/docs/search.json', { headers: { Accept: 'application/json' } })
        .then((response) => (response.ok ? response.json() : Promise.reject(response.status)))
        .then((entries) => entries.map((entry) => ({
            ...entry,
            find: { title: entry.title.toLowerCase(), heading: (entry.heading ?? '').toLowerCase(), text: entry.text.toLowerCase(), code: entry.code.toLowerCase() },
        })))
        .catch(() => (searchIndex = null, []));
    return searchIndex;
}

function openSearch() {
    const search = $('[data-search]');
    search.hidden = false;
    const input = $('[data-search-input]', search);
    input.focus();
    input.select();
    showResults(input.value);
}

function closeSearch() {
    $('[data-search]').hidden = true;
}

/**
 * Every word must appear somewhere in the entry; a word in the page's title counts most, then in
 * the section's heading, then in its text, then in its code. The whole query in a title or heading
 * counts extra.
 */
function score(entry, query, words) {
    let total = 0;
    for (const word of words) {
        /** Titles name things in words: #[Server] is "Server methods". */
        const bare = word.replace(/[^\p{L}\p{N}:-]/gu, '') || word;
        const inTitle = entry.find.title.includes(bare);
        const inHeading = entry.find.heading.includes(bare);
        const inText = entry.find.text.includes(word);
        const inCode = entry.find.code.includes(word);
        if (!inTitle && !inHeading && !inText && !inCode) return 0;
        total += (inTitle ? 16 : 0) + (entry.find.title.startsWith(bare) ? 8 : 0) + (inHeading ? 10 : 0) + (inText ? 2 : 0) + (inCode ? 1 : 0);
    }
    if (entry.find.title.includes(query) || entry.find.heading.includes(query)) total += 12;
    if (!entry.heading) total += 2;
    return total;
}

/** The text around the first word found (its start when the words are only in its code), with the words marked. */
function excerpt(text, words) {
    const lower = text.toLowerCase();
    const found = words.map((word) => lower.indexOf(word)).filter((i) => i >= 0);
    const at = found.length ? Math.min(...found) : 0;
    const start = Math.max(0, at - 50);
    const piece = (start > 0 ? '…' : '') + text.slice(start, start + 140).trim() + (start + 140 < text.length ? '…' : '');
    const fragment = document.createDocumentFragment();
    const pattern = new RegExp(`(${words.map((word) => word.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')).join('|')})`, 'gi');
    piece.split(pattern).forEach((part, i) => {
        if (i % 2 === 1) {
            const mark = document.createElement('mark');
            mark.textContent = part;
            fragment.append(mark);
        } else if (part) {
            fragment.append(part);
        }
    });
    return fragment;
}

async function showResults(value) {
    const list = $('[data-search-results]');
    const entries = await loadSearchIndex();
    if ($('[data-search-input]').value !== value) return;

    const query = value.trim().toLowerCase();
    const words = query.split(/\s+/).filter(Boolean);
    let results = entries.filter((entry) => !entry.heading);
    if (words.length) {
        const best = entries.map((entry) => ({ entry, score: score(entry, query, words) })).filter((r) => r.score > 0).sort((a, b) => b.score - a.score).slice(0, 20).map((r) => r.entry);
        /** Each page's sections together, the pages in the order of their best result. */
        const pages = [...new Set(best.map((entry) => entry.page))];
        results = best.sort((a, b) => pages.indexOf(a.page) - pages.indexOf(b.page));
    }

    list.replaceChildren();
    if (!entries.length) return list.append(searchNote('Search is not available right now.'));
    if (!results.length) return list.append(searchNote(`Nothing found for “${value.trim()}”.`));

    /** Grouped by where they are: the sidebar's sections when browsing, the pages when searching. */
    let group = null;
    for (const entry of results) {
        const name = words.length ? entry.title : entry.section;
        if (name !== group) {
            group = name;
            const label = document.createElement('p');
            label.className = 'search-group';
            label.textContent = name;
            list.append(label);
        }
        list.append(searchResult(entry, words));
    }
    selectResult(0);
}

function searchNote(text) {
    const note = document.createElement('p');
    note.className = 'px-3 py-6 text-center text-sm text-slate-500';
    note.textContent = text;
    return note;
}

function searchResult(entry, words) {
    const link = document.createElement('a');
    const path = `/docs/${entry.page}`;
    link.href = entry.anchor ? `${path}#${entry.anchor}` : path;
    /** Another page is a Nitro visit; a section of this one, the browser's own jump. */
    if (location.pathname !== path) link.setAttribute('nitro:navigate', '');
    link.className = 'search-result';
    link.role = 'option';
    link.dataset.searchResult = '';

    const title = document.createElement('span');
    title.className = 'search-result-title';
    title.textContent = entry.heading ?? entry.title;
    const text = document.createElement('span');
    text.className = 'search-result-text';
    text.append(words.length ? excerpt(entry.text, words) : entry.text.slice(0, 120));
    link.append(title, text);

    link.addEventListener('pointermove', () => selectResult($$('[data-search-result]').indexOf(link), false));
    link.addEventListener('click', (event) => openResult(link, event));
    return link;
}

/**
 * Opening a result closes the dialog: at once, or (data-search-close-on="after", config/docs.php)
 * once the visit to another page has shown it, the result marked as loading until then.
 */
function openResult(link, event) {
    const search = $('[data-search]');
    const visit = link.hasAttribute('nitro:navigate') && !(event.metaKey || event.ctrlKey || event.shiftKey || event.altKey);
    if (!visit || search.dataset.searchCloseOn !== 'after') return closeSearch();

    link.setAttribute('aria-busy', 'true');
    addEventListener('nitro:navigated', () => {
        link.removeAttribute('aria-busy');
        closeSearch();
    }, { once: true });
}

function selectResult(index, scroll = true) {
    const results = $$('[data-search-result]');
    if (!results.length) return;
    const at = (index + results.length) % results.length;
    results.forEach((result, i) => result.setAttribute('aria-selected', String(i === at)));
    if (scroll) results[at].scrollIntoView({ block: 'nearest' });
}

document.addEventListener('input', (event) => {
    if (event.target.matches?.('[data-search-input]')) showResults(event.target.value);
});

addEventListener('keydown', (event) => {
    const search = $('[data-search]');
    if (!search) return;
    if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault();
        search.hidden ? openSearch() : closeSearch();
    } else if (search.hidden) {
        return;
    } else if (event.key === 'Escape') {
        closeSearch();
    } else if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
        event.preventDefault();
        const results = $$('[data-search-result]');
        const at = results.findIndex((result) => result.getAttribute('aria-selected') === 'true');
        selectResult(at + (event.key === 'ArrowDown' ? 1 : -1));
    } else if (event.key === 'Enter' && !event.isComposing) {
        event.preventDefault();
        $('[data-search-result][aria-selected="true"]')?.click();
    }
});

// ------------------------------------------------------------------ the sidebar keeps its scroll across pages

let sidebarScroll = 0;

addEventListener('click', (event) => {
    if (event.target.closest('[data-drawer] a')) sidebarScroll = $('[data-drawer]').scrollTop;
}, true);

// ------------------------------------------------------------------ the Rendering page's demo

/** Flashes each element an update changes, and says how many changed. */
function flashUpdates(root) {
    const count = $('[data-flash-count]', root);

    new MutationObserver((mutations) => {
        const changed = new Set();
        for (const mutation of mutations) {
            const node = mutation.target.nodeType === Node.ELEMENT_NODE ? mutation.target : mutation.target.parentElement;
            if (!node || count?.contains(node)) continue;
            if (mutation.type === 'childList' && mutation.addedNodes.length) {
                for (const added of mutation.addedNodes) {
                    if (added.nodeType === Node.ELEMENT_NODE) changed.add(added);
                    else if (added.textContent.trim() !== '') changed.add(node);
                }
            } else {
                changed.add(node);
            }
        }
        if (!changed.size) return;

        for (const node of changed) {
            node.classList.remove('flash-update');
            void node.offsetWidth;
            node.classList.add('flash-update');
        }
        if (count) count.textContent = `${changed.size} ${changed.size === 1 ? 'element' : 'elements'} changed; the other ${root.querySelectorAll('*').length - (count ? 1 : 0) - changed.size} were left alone.`;
    }).observe(root, { subtree: true, childList: true, characterData: true, attributes: true, attributeFilter: ['disabled', 'hidden'] });
}

// ------------------------------------------------------------------ each page

function init() {
    applyTheme(document.documentElement.dataset.theme ?? 'system');

    for (const button of $$('[data-theme-set]')) {
        button.addEventListener('click', () => {
            try { localStorage.setItem('theme', button.dataset.themeSet); } catch {}
            applyTheme(button.dataset.themeSet);
        });
    }

    for (const tabs of $$('[data-tabs]')) {
        const list = $('[data-tabs-list]', tabs);
        const panels = $$('[data-tab]', tabs);
        const select = (index) => panels.forEach((panel, i) => {
            panel.hidden = i !== index;
            list.children[i].classList.toggle('is-active', i === index);
            list.children[i].setAttribute('aria-selected', String(i === index));
        });
        list.replaceChildren();
        panels.forEach((panel, i) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.role = 'tab';
            button.className = 'tab-button';
            button.textContent = panel.dataset.tab;
            button.addEventListener('click', () => select(i));
            list.append(button);
        });
        select(0);
    }

    for (const pair of $$('[data-pair]')) {
        for (const tab of $$('[data-pair-tab]', pair)) {
            tab.addEventListener('click', () => {
                for (const other of $$('[data-pair-tab]', pair)) other.classList.toggle('is-active', other === tab);
                for (const panel of $$('[data-pair-panel]', pair)) panel.classList.toggle('hidden', panel.dataset.pairPanel !== tab.dataset.pairTab);
            });
        }
    }

    for (const toggle of $$('[data-compiled-toggle]')) {
        toggle.addEventListener('click', () => {
            const panel = toggle.nextElementSibling;
            panel.hidden = !panel.hidden;
            toggle.setAttribute('aria-expanded', String(!panel.hidden));
            if (!panel.hidden && !panel.dataset.loaded) {
                panel.dataset.loaded = 'true';
                fetch(`/docs/compiled/${panel.dataset.compiled}`)
                    .then((response) => (response.ok ? response.text() : Promise.reject(response)))
                    .then((html) => { panel.innerHTML = html; })
                    .catch(() => {
                        delete panel.dataset.loaded;
                        panel.querySelector('p').textContent = 'Could not load the compiled code.';
                    });
            }
        });
    }

    for (const button of $$('[data-copy]')) {
        button.addEventListener('click', async () => {
            const code = button.closest('[data-code]')?.dataset.code ?? '';
            try { await navigator.clipboard.writeText(code); } catch { return; }
            const label = $('[data-copy-label]', button);
            label.textContent = 'Copied';
            setTimeout(() => (label.textContent = 'Copy'), 1500);
        });
    }

    for (const root of $$('[data-flash-updates]')) flashUpdates(root);

    buildToc();

    for (const key of $$('[data-mod-key]')) key.textContent = isMac ? '⌘' : 'Ctrl';
    $$('[data-search-open]').forEach((button) => button.addEventListener('click', openSearch));
    $$('[data-search-close]').forEach((element) => element.addEventListener('click', closeSearch));

    const drawer = $('[data-drawer]');
    const backdrop = $('[data-drawer-backdrop]');
    if (drawer) {
        drawer.scrollTop = sidebarScroll;
        const setDrawer = (open) => {
            drawer.classList.toggle('-translate-x-full', !open);
            backdrop.classList.toggle('hidden', !open);
        };
        $('[data-drawer-open]')?.addEventListener('click', () => setDrawer(true));
        $('[data-drawer-close]')?.addEventListener('click', () => setDrawer(false));
        backdrop?.addEventListener('click', () => setDrawer(false));
    }

    startVeins();
}

// ------------------------------------------------------------------ the homepage's veins

/** The lines behind the hero run while they are in view (app.css, .veins). */
function startVeins() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => entry.target.classList.toggle('is-live', entry.isIntersecting));
    }, { threshold: 0.2 });
    $$('.veins').forEach((veins) => observer.observe(veins));
}

init();
addEventListener('nitro:navigated', init);
