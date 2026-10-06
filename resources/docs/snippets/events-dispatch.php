$this->dispatch('notify', 'Saved');                        // Every listener.
$this->dispatch('notify', 'Saved')->to(Toaster::class);    // Only Toaster components.
$this->dispatch('refresh')->self();                        // Only this component.

#[On('notify')]
public function notify(string $message, string $tone = 'info'): void { ... }
