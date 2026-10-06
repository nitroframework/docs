// Send an event to every #[On('cart-updated')] method, and to the window.
Fusion.dispatch('cart-updated', [3]);

// Go to a page the way a fusion:navigate link does.
Fusion.visit('/orders');

// The components on the page.
for (const component of Fusion.components()) {
    console.log(component.name, component.el, component.unsaved());
}
