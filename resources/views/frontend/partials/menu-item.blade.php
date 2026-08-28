<li class="{{ $item->childrenRecursive->isNotEmpty() ? 'has-submenu' : '' }}">
    <div class="menu-item-content">
        @if ($item->link)
            <a href="{{ $item->link }}">{{ $item->title }}</a>
        @elseif ($item->childrenRecursive->isEmpty())
            <span class="menu-item-label">{{ $item->title }}</span>
        @endif

        @if ($item->childrenRecursive->isNotEmpty())
            <button type="button"
                class="submenu-toggle {{ $item->link ? 'submenu-toggle--icon' : 'submenu-toggle--label' }}"
                aria-expanded="false" aria-controls="submenu-{{ $item->id }}"
                aria-label="{{ $item->link ? 'Toggle submenu for '.$item->title : $item->title }}">
                @unless ($item->link)
                    <span>{{ $item->title }}</span>
                @endunless
                <i class="fas fa-chevron-{{ ($depth ?? 0) === 0 ? 'down' : 'right' }}" aria-hidden="true"></i>
            </button>
        @endif
    </div>

    @if ($item->childrenRecursive->isNotEmpty())
        <ul class="sub-menu" id="submenu-{{ $item->id }}">
            @foreach ($item->childrenRecursive as $child)
                @include('frontend.partials.menu-item', ['item' => $child, 'depth' => ($depth ?? 0) + 1])
            @endforeach
        </ul>
    @endif
</li>
