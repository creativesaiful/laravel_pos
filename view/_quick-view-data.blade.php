@php
use App\CPU\helpers;
$helper = new helpers();
@endphp


<style>
    .color-border {
        border-color: #ffffff;
    }

    .border-add {
        border-color: #ff0303 !important;
        border: 2px;
        border-style: solid;
    }

    .btn-color {
        width: 30px;
        height: 20px;
        border-radius: 5px;
    }

    .btn-check:checked+.check-label {
        background-color: #EF7822;
        color: #FFFFFF;
        border: none;
    }

    .btn-choice {
        width: 70px;
        height: 30px;
        text-align: center;
        background-color: #bdbdbd;
        color: #fff;
        border: 1px solid #565656;
    }
</style>


<div class="modal-header p-2">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" style="border: none; color:black" type="button" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <!-- Product gallery-->
        <div class="col-md-3 active p3">
            <img class="img-responsive" style="width:auto;overflow:hidden;border-radius: 5%;"
                src="{{ asset('storage/upload/products/thumbnail') }}/{{ $product->thumbnail }}"
                onerror="this.src='{{ asset('admin/img/placeholder/img1.jpg') }}'"
                data-zoom="{{ asset('storage/upload/products/gallery') }}/{{ $product['image'] }}"
                alt="Product image" width="">
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="col-md-9">

            <div class="mb-2">
                <span class="product-title text-dark"
                    style="font-size: 18px">{{ Str::limit($product->name, 26) }}</span>
            </div>


            <div class="mb-3 text-dark">
                <span class="h4 font-weight-normal text-accent mr-1">
                    {{ \App\CPU\Helpers::get_price_range($product) }}
                </span>
                @if ($product->discount > 0)
                    <strike style="font-size: 12px!important;">
                        {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['unit_price'])) }}
                    </strike>
                @endif
            </div>

            @if ($product->discount > 0)
                <div class="text-dark">
                    <strong>Discount : </strong>
                    <strong
                        id="set-discount-amount">{{ \App\CPU\BackEndHelper::usd_to_currency(\App\CPU\Helpers::get_product_discount($product, $product['unit_price'])) }}</strong>
                </div>
            @endif


        </div>
    </div>

    <div class="row pt-2">
        <div class="col-12">
            <?php
            $cart = false;
            if (session()->has('cart')) {
                foreach (session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $product['id']) {
                        $cart = $cartItem;
                    }
                }
            }
            
            ?>
            <h6>{{ $helper->translate('description') }}</h6>
            <span class="d-block text-dark">
                {!! $product->description !!}
            </span>
            <form id="add-to-cart-form" class="mb-2">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="position-relative">
                    @if (count(json_decode($product->colors)) > 0)
                        <div class="flex-start">
                            <div class="product-description-label mt-2 text-dark">{{ $helper->translate('color') }}:
                            </div>
                            <div class="d-flex justify-content-left flex-wrap" id="option1" style="height: 16px;">
                                @foreach (json_decode($product->colors) as $key => $color)
                                    <input class="btn-check" type="radio" onclick="color_change(this);"
                                        id="{{ $product->id }}-color-{{ $key }}" name="color"
                                        value="{{ $color }}" @if ($key == 0) checked @endif
                                        autocomplete="off">
                                    <label id="label-{{ $product->id }}-color-{{ $key }}"
                                        class="btn-color m-2 color-border {{ $key == 0 ? 'border-add' : '' }}"
                                        style="background: {{ $color }};"
                                        for="{{ $product->id }}-color-{{ $key }}"
                                        data-toggle="tooltip"></label>
                                @endforeach

                            </div>
                        </div>
                    @endif
                    @php
                        $qty = 0;
                        if (!empty($product->variation)) {
                            foreach (json_decode($product->variation) as $key => $variation) {
                                $qty += $variation->qty;
                            }
                        }
                    @endphp
                </div>
                @foreach (json_decode($product->choice_options) as $key => $choice)
                    <div class="h3 p-0 pt-2 text-dark"><span style="font-size: 14px">{{ $choice->title }}</span>
                    </div>

                    <div class="d-flex justify-content-left flex-wrap" style="height: 25px;">
                        @foreach ($choice->options as $key => $option)
                            <input class="btn-check" type="radio" id="{{ $choice->name }}-{{ $option }}"
                                name="{{ $choice->name }}" value="{{ $option }}"
                                @if ($key == 0) checked @endif autocomplete="off">
                            <label class="btn-choice btn-sm check-label mx-1 choice-input"
                                for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                        @endforeach
                    </div>
                @endforeach

                <!-- Quantity + Add to cart -->
                <div class="row my-3">
                    <div class="col-md-6">
                        <div class="my-2 text-dark"> <span
                                style="font-size: 14px">{{ $helper->translate('Quantity') }}:</span>
                        </div>



                        <div class="">
                            <div class="input-group input-group--style-2 pr-3" style="width: 160px;">
                                <span class="input-group-btn">
                                    <button class="btn-number text-dark" type="button" data-type="minus"
                                        data-field="quantity" disabled="disabled" style="padding: 10px; border: none">
                                        <i class="fa-solid fa-minus"></i>

                                    </button>
                                </span>
                                <input type="text" name="quantity"
                                    class="form-control input-number text-center cart-qty-field" placeholder="1"
                                    value="1" min="1" max="100">
                                <span class="input-group-btn">
                                    <button class="btn-number text-dark" type="button" data-type="plus"
                                        data-field="quantity" style="padding: 10px; border:none">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="no-gutters mt-2 text-dark" id="chosen_price_div">

                            <div class="product-description-label">{{ $helper->translate('Total_price') }}:</div>


                            <div class="product-price">
                                <strong id="chosen_price"></strong>
                            </div>

                        </div>
                    </div>


                </div>



                <div class="d-flex justify-content-center mt-2">
                    <button class="btn btn-primary btn-sm" onclick="addToCart()" type="button"
                        style="width:37%; height: 45px">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                        {{ $helper->translate('add') }}
                    </button>
                </div>
            </form>
        </div>
    </div>




</div>


<script>
    function color_change(val) {
        console.log(val.id);
        $('.color-border').removeClass("border-add");
        $('#label-' + val.id).addClass("border-add");
    };


    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function() {
        getVariantPrice();
    });
</script>
