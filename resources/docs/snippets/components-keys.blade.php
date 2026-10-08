<ul>
    @foreach ($tasks as $task)
        {{-- Sorted, filtered or added to: each child keeps its own state by its task's id. --}}
        <fusion:task-item :task="$task" :key="$task['id']" />
    @endforeach
</ul>
