<ul class="menu-container">
    @foreach($items as $menu_item)
        <li class="menu-item"><a href="{{ $menu_item->link() }}">{{ $menu_item->title }}</a></li>
    @endforeach
</ul>
