// Send an event to every #[On('cart-updated')] method, and to the window.
Nitro.dispatch('cart-updated', [3]);

// Go to a page the way a nitro:navigate link does.
Nitro.visit('/orders');

// The components on the page.
for (const component of Nitro.components()) {
    console.log(component.name, component.el, component.unsaved());
}
