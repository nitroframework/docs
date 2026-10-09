{{-- This link's visit, inside a View Transition. --}}
<a href="{{ route('students.show', $student) }}" nitro:navigate.transition>{{ $student->name }}</a>

{{-- With nitro:prefetch: asked for in view, shown with a transition. --}}
<a href="{{ route('students.show', $student) }}" nitro:navigate.transition nitro:prefetch.visible>{{ $student->name }}</a>
