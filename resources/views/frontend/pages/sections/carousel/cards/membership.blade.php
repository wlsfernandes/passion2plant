<div class="blog__items h-100 d-flex flex-column">

    {{-- Image --}}
    <div class="thumb">
        <a href="{{ route('memberships.information', $membership) }}">
            <img src="{{ route('admin.images.preview', ['model' => 'memberships', 'id' => $membership->id]) }}"
                alt="{{ strip_tags($membership->title) }}" loading="lazy" style="object-position: top;">
        </a>
    </div>

    {{-- Content --}}
    <div class="content d-flex flex-column flex-grow-1">

        <div class="cms_content">
            <a href="{{ route('memberships.information', $membership) }}">
                {!! $membership->title !!}
            </a>
        </div>

        @if ($membership->amount)
            <span class="badge bg-soft-success text-success mb-2">
                ${{ number_format($membership->amount, 0) }}
            </span>
        @endif

        <div class="cms_content">
            {!! $membership->description !!}
        </div>

        <div class="mt-auto">
            <a href="{{ route('memberships.information', $membership) }}" class="btn btn-sm btn-outline-success mt-2">
                Become a Member Now
            </a>
        </div>

    </div>
</div>
