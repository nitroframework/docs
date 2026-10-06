<fusion:card>
    <p>{{ $student['name'] }} has {{ $student['credits'] }} credits.</p>

    <fusion:slot name="footer">
        <button fusion:click="enrol($student['id'])">Enrol</button>
    </fusion:slot>
</fusion:card>
