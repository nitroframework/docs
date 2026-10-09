<nitro:card>
    <p>{{ $student['name'] }} has {{ $student['credits'] }} credits.</p>

    <nitro:slot name="footer">
        <button nitro:click="enrol($student['id'])">Enrol</button>
    </nitro:slot>
</nitro:card>
