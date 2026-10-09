<a href="{{ route('students.index') }}" nitro:navigate>Students</a>

<a href="{{ route('students.index') }}" nitro:navigate.keypress>Starts on mouse down</a>
<a href="?tab=notes" nitro:navigate.preserve-scroll>Keeps the scroll position</a>
<a href="{{ route('students.index') }}" nitro:navigate nitro:current="font-bold">Bold while current</a>
