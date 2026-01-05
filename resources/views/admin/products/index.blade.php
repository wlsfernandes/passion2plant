@extends('admin.layouts.master')

@section('title', 'Products')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-box"></i> Products
            </h5>
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Product
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Store</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Image</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                        </td>

                                        <td>
                                            {{ $product->store->name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ number_format($product->price, 2) }}
                                            <small class="text-muted">{{ $product->currency }}</small>
                                        </td>

                                        <td>
                                            {{ $product->type ?? '-' }}
                                        </td>

                                        {{-- Image --}}
                                        <td class="text-center">
                                            <a href="{{ route('admin.images.edit', ['model' => 'products', 'id' => $product->id]) }}"
                                                title="Upload / Edit image" class="me-2">
                                                <i
                                                    class="uil-image font-size-22 {{ $product->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                            </a>

                                            @if($product->image_url)
                                                <a href="{{ route('admin.images.preview', ['model' => 'products', 'id' => $product->id]) }}"
                                                    title="View image" target="_blank">
                                                    <i class="fas fa-eye font-size-6 text-primary"></i>
                                                </a>
                                            @else
                                                <i class="fas fa-eye font-size-6 text-muted"></i>
                                            @endif
                                        </td>

                                        {{-- Publish toggle --}}
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('admin.publish.toggle', [
                            'model' => Str::snake(class_basename($product)),
                            'id' => $product->id
                        ]) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="badge border-0 {{ $product->is_published ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $product->is_published ? __('Yes') : __('No') }}
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Actions --}}
                                        <td>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                                <i class="uil-pen"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this product?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
                                                    <i class="uil-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection