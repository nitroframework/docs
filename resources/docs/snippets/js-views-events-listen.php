<?php

// app/Nitro/Components/React/StudentCard.php: #[View(react: 'student-card')]

#[On('student-picked')]
public function show(int $id): void
{
    $this->current = $id;
}

#[On('payment-recorded')]
public function took(array $payment): void
{
    $this->paid[$payment['student_id']] = ($this->paid[$payment['student_id']] ?? 0) + $payment['cents'];
}
