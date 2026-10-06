public function add(): void
{
    $this->items[] = $this->draft;
    $this->draft = '';

    // After the next render: focus the input again.
    $this->js('$refs.draft.focus()');
}
