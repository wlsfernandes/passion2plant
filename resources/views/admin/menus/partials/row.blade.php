<tr class="{{ $depth === 0 ? 'table-primary' : '' }}">
    <td>{{ $item->id }}</td>

    <td>
        @if ($depth > 0)
            <span class="text-muted">{{ str_repeat('— ', $depth) }}</span>
        @endif

        @if ($depth === 0)
            <strong>{{ $item->title_en }}</strong>
        @else
            {{ $item->title_en }}
        @endif
    </td>

    <td>{{ $item->title_es }}</td>

    <td>{{ $item->link }}</td>

    <td>{{ $item->order }}</td>

    <td class="text-center">

        <a href="{{ route('menus.edit', $item) }}" class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('menus.destroy', $item) }}" method="POST" style="display:inline-block"
            onsubmit="return confirm('Delete this menu?')">

            @csrf
            @method('DELETE')

            <button class="btn btn-sm btn-danger">
                Delete
            </button>

        </form>

    </td>
</tr>

@foreach ($item->childrenRecursive as $child)
    @include('admin.menus.partials.row', ['item' => $child, 'depth' => $depth + 1])
@endforeach
