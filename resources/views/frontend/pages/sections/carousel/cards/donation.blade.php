<div class="blog__items h-100 d-flex flex-column">

    {{-- Image --}}
    <div class="thumb">
        <a href="{{ route('donations.checkout', $donation) }}">
            <img src="{{ route('admin.images.preview', ['model' => 'donations', 'id' => $donation->id]) }}"
                alt="{{ strip_tags($donation->title) }}" loading="lazy" style="object-position: top">
        </a>
    </div>

    {{-- Content --}}
    <div class="content d-flex flex-column flex-grow-1">

        {{-- Title --}}
        <div class="cms_content mb-2">
            <a href="{{ route('donations.checkout', $donation) }}">
                {!! strip_tags($donation->title) !!}
            </a>
        </div>

        {{-- Suggested Amount --}}
        @if ($donation->suggested_amount)
            <span class="badge bg-soft-success text-success mb-2">
                Suggested: ${{ number_format($donation->suggested_amount, 0) }}
            </span>
        @endif

        {{-- Description --}}
        <div class="cms_content mb-3">
            {!! \Illuminate\Support\Str::limit(strip_tags($donation->description), 120) !!}
        </div>

        {{-- Button --}}
        <div class="mt-auto">
            <a href="{{ route('donations.checkout', $donation) }}" class="btn btn-sm btn-outline-success mt-2">
                Give Now
            </a>
        </div>

    </div>
</div>
