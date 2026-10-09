class NewsletterPanel extends Component
{
    public int $issueId;              // Sent to the browser.
    #[Locked] public string $status;  // Sent, but can't be changed.

    #[Server]
    public function send(): void
    {
        // Load the subscribers where you need them, not in the state.
        $issue = Issue::findOrFail($this->issueId);

        Mail::to($issue->subscribers)->send(new IssueMail($issue));
    }
}
