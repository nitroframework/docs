public string $problem = '';

#[Server]
public function sync(): void
{
    $this->problem = '';
    $this->contacts = Crm::contacts()->since($this->lastSync)->get()->toArray();
}

/** A #[Server] method threw: tell the visitor, report it, and keep the page working. */
public function exception(Throwable $exception): void
{
    if (! $exception instanceof CrmUnavailable) {
        throw $exception;
    }

    report($exception);
    $this->problem = 'The CRM is not answering. Try again in a minute.';
}
