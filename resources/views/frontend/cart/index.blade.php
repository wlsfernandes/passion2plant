@extends('frontend.layouts.app')

@section('title', 'Stores' . ' | Passion2Plant')

@section('content')
    <!--Breadcumd Section Here-->
    <section class="breadcumd__banner overhid">
        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.our_store')
                </h2>
                <ul class="right__content">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa-solid fa-house"></i>
                            @lang('pages.home')
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        @lang('pages.store')
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!--Breadcumd Section End-->

    <section class="cart__section pt-80 pb-80 overhid">
        <div class="container">
            <div class="main__cart__wrap">
                <div class="row">
                    <div class="col-12">
                        <div class="cart__wrapper">
                            <div class="cart-items-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php $subtotal = 0; @endphp

                                        @forelse(session('cart', []) as $item)
                                            @php
                                                $lineTotal = $item['price'] * $item['quantity'];
                                                $subtotal += $lineTotal;
                                            @endphp

                                            <tr class="cart-item">
                                                {{-- PRODUCT --}}
                                                <td class="cart-item-info">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                        style="width:80px;height:auto;">
                                                    <div class="ms-2">
                                                        <strong>{{ $item['name'] }}</strong>
                                                    </div>
                                                </td>

                                                {{-- PRICE --}}
                                                <td class="cart-item-price">
                                                    $ {{ number_format($item['price'], 2) }}
                                                </td>
                                                {{-- QUANTITY --}}
                                                <td>
                                                    <div class="cart-item-quantity">
                                                        <span class="fw-semibold">
                                                            {{ (int) $item['quantity'] }}
                                                        </span>
                                                    </div>
                                                </td>

                                                {{-- SUBTOTAL --}}
                                                <td class="cart-item-price">
                                                    $ {{ number_format($lineTotal, 2) }}
                                                </td>

                                                {{-- REMOVE --}}
                                                <td class="cart-item-remove">
                                                    <form method="POST"
                                                        action="{{ route('cart.remove', $item['product_id']) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    Your cart is empty.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOTALS --}}
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-xl-6">
                        <div class="cart__pragh__box">
                            <div class="cart__graph">
                                <h4>Cart Total</h4>
                                <ul>
                                    <li>
                                        <span>Subtotal</span>
                                        <span>$ {{ number_format($subtotal, 2) }}</span>
                                    </li>
                                    <li>
                                        <span>Shipping</span>
                                        <span>$ 0.00</span>
                                    </li>
                                    <li>
                                        <strong>Total</strong>
                                        <strong>$ {{ number_format($subtotal, 2) }}</strong>
                                    </li>
                                </ul>

                                <div class="chck">
                                    <a href="{{ route('checkout.index') }}" class="cmn--btn">
                                        <span>Checkout</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection
