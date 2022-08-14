@php
if (auth()->user() != null) {
    $user_id = Auth::user()->id;
    $cart = \App\Models\Cart::where('user_id', $user_id)->get();
} else {
    $temp_user_id = Session()->get('temp_user_id');
    if ($temp_user_id) {
        $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
    }
}
@endphp

<div class="header-action-icon-2">
    {{-- route('cart') --}}
    <a class="mini-cart-icon" href="#">
        <img alt="{{ env('APP_NAME') }}" src="{{ asset('assets/frontend/imgs/theme/icons/icon-cart.svg') }}" />
        <span class="pro-count blue">{{ isset($cart) ? $cart->count() : 0 }}</span>
    </a>
    <a href="shop-cart.html"><span class="lable">{{ translate('Cart') }}</span></a>
    @if (isset($cart) && count($cart) > 0)
        <div class="cart-dropdown-wrap cart-dropdown-hm2">
            <ul>
                @php
                    $total = 0;
                @endphp
                @foreach ($cart as $key => $cartItem)
                    @php
                        $product = \App\Models\Product::find($cartItem['product_id']);
                        // $total = $total + ($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity'];
                        $total = $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
                    @endphp
                    @if ($product != null)
                        <li>
                            <div class="shopping-cart-img">
                                <a href="{{ route('product', $product->slug) }}">
                                    <img alt="{{ $product->getTranslation('name') }}"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}""
                                        class="lazyload"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                    />
                                </a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4>
                                    <a href="{{ route('product', $product->slug) }}">
                                        {{ $product->getTranslation('name') }}
                                    </a>
                                </h4>
                                <h4><span>{{ $cartItem['quantity'] }} × </span>{{ cart_product_price($cartItem, $product) }}</h4>
                            </div>
                            <div class="shopping-cart-delete">
                                <a href="#" onclick="removeFromCart({{ $cartItem['id'] }})"><i class="fi-rs-cross-small"></i></a>
                            </div>
                        </li>
                    @endif

                @endforeach

            </ul>
            <div class="shopping-cart-footer">
                <div class="shopping-cart-total">
                    <h4>Total <span>$4000.00</span></h4>
                </div>
                <div class="shopping-cart-button">
                    <a href="{{ route('cart') }}" class="outline">{{ translate('View cart') }}</a>
                    @auth
                        <a href="{{ route('checkout.shipping_info') }}">{{ translate('Checkout') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    @else
        <div class="cart-dropdown-wrap cart-dropdown-hm2">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h6 fw-700">{{ translate('Your Cart is empty') }}</h3>
        </div>
    @endif

</div>
