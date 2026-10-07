<?php

// app/Fusion/Components/Vue/PaymentDesk.php: #[View(vue: 'payment-desk')]

/** Picked: said at once, in the browser. */
public function pick(int $id): void
{
    $this->student = $id;
    $this->dispatch('student-picked', id: $id);
}

/** Recorded on the server; the others hear of it with the answer. */
#[Server]
public function record(): void
{
    $this->validate();
    $payment = Payment::record($this->student, $this->amount * 100, $this->method);

    $this->dispatch('payment-recorded', payment: $payment->only('student_id', 'cents', 'method'));
}
