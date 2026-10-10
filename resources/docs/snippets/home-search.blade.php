<div>
    <input nitro:model="search" placeholder="Search posts...">

    <ul>
        @foreach ($this->found as $post)
            <li>{{ $post['title'] }}</li>
        @endforeach
    </ul>
</div>
