<a href="{{ route('students.index') }}" fusion:navigate>Students</a>

<a href="{{ route('students.index') }}" fusion:navigate.keypress>Starts on mouse down</a>
<a href="?tab=notes" fusion:navigate.preserve-scroll>Keeps the scroll position</a>
<a href="{{ route('students.index') }}" fusion:navigate fusion:current="font-bold">Bold while current</a>
