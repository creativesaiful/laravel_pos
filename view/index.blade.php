@php
use App\CPU\helpers;
$helper = new helpers();
@endphp
<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> @yield('title') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front-end/assets/img/favicon_2.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/bootstrap.min_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/animate.min_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/fontawesome-all.min_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/mCustomScrollbar.min_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/flaticon_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/slick_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/jquery-ui_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/default_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/style_2.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/toastr.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/responsive_2.css') }}">
</head>

<body class="footer-offset">






    <!-- Preloader -->
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>
    <!-- Preloader end -->

    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- Header start -->




    <!-- main-area -->
    <main>

        <div class="header-search-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-3">
                        <div class="logo">
                            <a href="{{ route('admin.dashboard') }}"><img
                                    src="{{ asset('front-end/assets/img/logo/logo.png') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-9">
                        <div class="d-block d-sm-flex align-items-center justify-content-end">

                            <div class="header-action">
                                <ul>
                                    <li><a href="index.html#"> <i class="far fa-star"></i> Browser</a></li>
                                    <li><a href="index.html#"><i class="fas fa-envelope"></i>Message</a></li>
                                    <li class="header-shop"><a href="index.html#"><i
                                                class="flaticon-shopping-bag"></i>Cart
                                            <span class="cart-count">0</span>
                                        </a></li>
                                    <li class="header-sine-in">
                                        <a href="contact.html">
                                            <i class="flaticon-user"></i>
                                            <p>{{ auth('admin')->user()->name }} <span>My Account</span></p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">

                                <div class="row">
                                    <div class="col-md-6">
                                        <form>
                                            <div class="form-group">
                                                <input type="search" id="search" name="search"
                                                    class="form-control search-bar-input" placeholder="Search">


                                                <diV class="card search-card "
                                                    style="position: absolute;z-index: 1;width: 50%;">
                                                    <div id="search-box" class="card-body search-result-box d-none"
                                                        style="">
                                                    </div>
                                                </diV>


                                            </div>



                                        </form>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="category" id="category" class="form-control select_dropdown"
                                                title="select category" onchange="set_category_filter(this.value)">
                                                <option value="">{{ $helper->translate('All Categories') }}
                                                </option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $category == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    @foreach ($products as $product)
                                        @include('admin.pos._single_product', ['product' => $product])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card">

                            <div class="card-header">
                                <div class="form-group col-md-12">
                                    <select onchange="customer_change(this.value);" id='customer' name="customer_id"
                                        data-placeholder="Walk In Customer"
                                        class=" form-control select_dropdown js-data-example-ajax">
                                        <option value="0">{{ $helper->translate('walking_customer') }}
                                        </option>
                                    </select>

                                </div>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="w-100 d-inline-block btn btn-success rounded"
                                            id="add_new_customer" type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-customer" title="Add Customer">
                                            <i class="fa-solid fa-plus"></i>
                                            {{ $helper->translate('new_customer') }}
                                        </button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <a class="w-100 d-inline-block btn btn-warning rounded" onclick="new_order()">
                                            {{ $helper->translate('new_order') }}
                                        </a>
                                    </div>
                                </div>


                                <div class="row mt-2">
                                    <div class="form-group col-12 mb-0">
                                        <label
                                            class="input-label text-capitalize border p-1">{{ $helper->translate('current_customer') }}
                                            : <span class="style-i4 mb-0 p-1" id="current_customer"></span></label>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="form-group mt-1 col-12 col-lg-6 mt-2 mb-0">
                                        <select id='cart_id' name="cart_id" class=" form-control select_dropdown"
                                            onchange="cart_change(this.value);">
                                        </select>
                                    </div>

                                    <div class="form-group mt-1 col-12 col-lg-6 mt-2 mb-0">
                                        <a class="w-100 d-inline-block btn btn-danger rounded" onclick="clear_cart()">
                                            {{ $helper->translate('clear_cart') }}
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <div class='w-100' id="cart">
                                    @include('admin.pos._cart', ['cart_id' => $cart_id])
                                </div>
                            </div>





                        </div>


                    </div>


                </div>
            </div>
        </div>







        {{-- Modal Start --}}

        <!-- End Content -->
        <div class="modal fade" id="quick-view" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" id="quick-view-modal">

                </div>
            </div>
        </div>


        @php($order = \App\Models\Order::find(session('last_order')))



        @if ($order)
            @php(session(['last_order' => false]))
            <div class="modal fade" id="print-invoice" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $helper->translate('Print Invoice') }}</h5>
                            <button class="close call-when-done" style="border: none; color:black" type="button"
                                data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                            </button>
                        </div>
                        <div class="modal-body row" style="font-family: emoji;">
                            <div class="col-md-12">
                                <center>
                                    <input id="print_invoice" type="button" class="btn btn-primary non-printable"
                                        onclick="printDiv('printableArea')"
                                        value="Proceed, If thermal printer is ready." />
                                    <a href="{{ url()->previous() }}"
                                        class="btn btn-danger non-printable">{{ $helper->translate('Back') }}</a>
                                </center>
                                <hr class="non-printable">
                            </div>
                            <div class="row" id="printableArea" style="margin: auto;">
                                @include('admin.pos.order.invoice')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif




        <div class="modal fade" id="add-customer" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $helper->translate('add_new_customer') }}</h5>
                        <button class="close call-when-done" style="border: none; color:black" type="button"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.pos.customer-store') }}" method="post" id="product_form">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('first_name') }} <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="f_name" class="form-control"
                                            value="{{ old('f_name') }}"
                                            placeholder="{{ $helper->translate('first_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('last_name') }} <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="l_name" class="form-control"
                                            value="{{ old('l_name') }}"
                                            placeholder="{{ $helper->translate('last_name') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('email') }}<span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email') }}"
                                            placeholder="{{ $helper->translate('Ex_:_ex@example.com') }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('phone') }}<span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone') }}"
                                            placeholder="{{ $helper->translate('phone') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('country') }} <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="country" class="form-control"
                                            value="{{ old('country') }}"
                                            placeholder="{{ $helper->translate('country') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('city') }} <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control"
                                            value="{{ old('city') }}"
                                            placeholder="{{ $helper->translate('city') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('zip_code') }} <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="zip_code" class="form-control"
                                            value="{{ old('zip_code') }}"
                                            placeholder="{{ $helper->translate('zip_code') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="input-label">{{ $helper->translate('address') }} <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ old('address') }}"
                                            placeholder="{{ $helper->translate('address') }}" required>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" id="submit_new_customer"
                                class="btn btn-primary">{{ $helper->translate('submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>







    </main>
    <!-- main-area-end -->



    <!-- JS here -->
    <script src="{{ asset('front-end/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/sweet_alert.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/toastr.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('front-end/assets/js/main.js') }}"></script>


    <script>
        @if (Session::has('message'))

            var type = ("{{ Session::get('type') }}");

            var message = ("{{ Session::get('message') }}");
            switch (type) {
                case 'success':
                    toastr.success(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                case 'info':
                    toastr.info(message);
                    break;
            }
        @endif
    </script>

    <script>
        $(document).ready(function () {
             @if ($order)
               $('#print-invoice').modal('show');

          
             @endif
        });
      

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
    <script>
        document.addEventListener("keydown", function(event) {

            if (event.altKey && event.code === "KeyO") {
                $('#submit_order').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyZ") {
                $('#payment_close').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyS") {
                $('#order_complete').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyC") {
                emptyCart();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyA") {
                $('#add_new_customer').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyN") {
                $('#submit_new_customer').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyK") {
                $('#short-cut').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyP") {
                $('#print_invoice').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyQ") {
                $('#search').focus();
                $("#search-box").css("display", "none");
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyE") {
                $("#search-box").css("display", "none");
                $('#extra_discount').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyD") {
                $("#search-box").css("display", "none");
                $('#coupon_discount').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyB") {
                $('#invoice_close').click();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyX") {
                clear_cart();
                event.preventDefault();
            }
            if (event.altKey && event.code === "KeyR") {
                new_order();
                event.preventDefault();
            }

        });


        // Filter by category 
        function set_category_filter(id) {
            var nurl = new URL('{!! url()->full() !!}');
            nurl.searchParams.set('category_id', id);
            location.href = nurl;
        }



        //Search script

        jQuery(".search-bar-input").on('keyup', function() {
            //$('#search-box').removeClass('d-none');
            $(".search-card").removeClass('d-none').show();
            let name = $(".search-bar-input").val();
            //console.log(name);
            if (name.length > 0) {
                $('#search-box').removeClass('d-none').show();
                $.get({
                    url: '{{ route('admin.pos.search-products') }}',
                    dataType: 'json',
                    data: {
                        name: name
                    },

                    success: function(data) {
                        //console.log(data.count);

                        $('.search-result-box').empty().html(data.result);
                        if (data.count == 1) {
                            $('.search-result-box').empty().hide();
                            $('#search').val('');
                            quickView(data.id);
                        }

                    },

                });
            } else {
                $('.search-result-box').empty();
                $(".search-card").hide();
            }
        });





        function quickView(product_id) {
            $.ajax({
                url: '{{ route('admin.pos.quick-view') }}',
                type: 'GET',
                data: {
                    product_id: product_id
                },
                dataType: 'json', // added data type
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    console.log("success...");
                    console.log(data);

                    // $("#quick-view").removeClass('fade');
                    // $("#quick-view").addClass('show');

                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                },
                complete: function() {
                    $('#loading').hide();
                },
            });


        }




        function checkAddToCartValidity() {
            var names = {};
            $('#add-to-cart-form input:radio').each(function() { // find unique names
                names[$(this).attr('name')] = true;
            });
            var count = 0;
            $.each(names, function() { // then count them
                count++;
            });
            if ($('input:radio:checked').length == count) {
                return true;
            }
            return false;
        }


        function getVariantPrice() {
            if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {

                $.ajax({
                    _token: '{{ csrf_token() }}',
                    type: "POST",
                    url: '{{ route('admin.pos.variant_price') }}',
                    data: $('#add-to-cart-form').serializeArray(),
                    success: function(data) {

                        $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                        $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                        $('#set-discount-amount').html(data.discount);
                    }
                });
            }
        }


        function cartQuantityInitialize() {
            $('.btn-number').click(function(e) {
                e.preventDefault();

                var fieldName = $(this).attr('data-field');
                var type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            $('.input-number').focusin(function() {
                $(this).data('oldValue', $(this).val());
            });

            $('.input-number').change(function() {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                var name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cart',
                        text: 'Sorry, the minimum value was reached'
                    });
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cart',
                        text: 'Sorry, stock limit exceeded.'
                    });
                    $(this).val($(this).data('oldValue'));
                }
            });
            $(".input-number").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }



        function addToCart(form_id = 'add-to-cart-form') {
            if (checkAddToCartValidity()) {

                $.post({
                    _token: '{{ csrf_token() }}',
                    url: '{{ route('admin.pos.add-to-cart') }}',
                    data: $('#' + form_id).serializeArray(),
                    beforeSend: function() {
                        //$('#preloader').show();
                    },
                    success: function(data) {

                        if (data.data == 1) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Cart',
                                text: 'Product already added in cart'
                            });

                            return false;
                        } else if (data.data == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Cart',
                                text: 'Sorry, product is out of stock.'
                            });
                            return false;

                        }
                        $('.call-when-done').click();

                        toastr.success('Item has been added in your cart!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#cart').empty().html(data.view);
                        //updateCart();
                        $('.search-result-box').empty().hide();
                        $('#search').val('');
                    },
                    complete: function() {
                        $('#preloader').hide();
                    }
                });
            } else {
                Swal.fire({
                    type: 'info',
                    title: 'Cart',
                    text: 'Please choose all the options"'
                });
            }
        }


        function customer_change(val) {
            //let  cart_id = $('#cart_id').val();
            $.post({
                url: '{{ route('admin.pos.remove-discount') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    //cart_id:cart_id,
                    user_id: val
                },
                beforeSend: function() {
                    $('#preloader').removeClass('d-none');
                },
                success: function(data) {
                    // console.log(data);

                    var output = '';
                    for (var i = 0; i < data.cart_nam.length; i++) {
                        output +=
                            `<option value="${data.cart_nam[i]}" ${data.current_user==data.cart_nam[i]?'selected':''}>${data.cart_nam[i]}</option>`;
                    }
                    $('#cart_id').html(output);
                    $('#current_customer').text(data.current_customer);
                    $('#cart').empty().html(data.view);
                },
                complete: function() {
                    $('#preloader').addClass('d-none');
                }
            });
        }



        $('.js-select2-custom').each(function() {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });


        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ route('admin.pos.customers') }}',
                data: function(params) {

                    console.log(params);
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });



        function removeFromCart(key) {
            //console.log(key);
            $.post('{{ route('admin.pos.remove-from-cart') }}', {
                _token: '{{ csrf_token() }}',
                key: key
            }, function(data) {

                $('#cart').empty().html(data.view);
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    //updateCart();

                    toastr.info('Item has been removed from cart', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }


            });
        }










        function updateCart() {
            $.post('<?php echo e(route('admin.pos.cart_items')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>'
            }, function(data) {
                $('#cart').empty().html(data);
            });
        }

        $(function() {
            $(document).on('click', 'input[type=number]', function() {
                this.select();
            });
        });




        //Update qty

        function updateQuantity(key, qty, e) {


            if (qty !== "") {
                var element = $(e.target);
                var minValue = parseInt(element.attr('min'));
                // maxValue = parseInt(element.attr('max'));
                var valueCurrent = parseInt(element.val());

                //var key = element.data('key');

                $.post('{{ route('admin.pos.updateQuantity') }}', {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: qty
                }, function(data) {

                    if (data.qty < 0) {
                        toastr.warning('product quantity is not enough!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    if (data.upQty === 'zeroNegative') {
                        toastr.warning('Product quantity can not be zero or less than zero in cart!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    if (data.qty_update == 1) {
                        toastr.success('Product quantity updated!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    $('#cart').empty().html(data.view);
                });
            } else {
                var element = $(e.target);
                var minValue = parseInt(element.attr('min'));
                var valueCurrent = parseInt(element.val());

                $.post('{{ route('admin.pos.updateQuantity') }}', {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: minValue
                }, function(data) {

                    if (data.qty < 0) {
                        toastr.warning('product_quantity_is_not_enough!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    if (data.upQty === 'zeroNegative') {
                        toastr.warning('Product quantity can not be zero or less than zero in cart!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    if (data.qty_update == 1) {
                        toastr.success('Product quantity updated!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    $('#cart').empty().html(data.view);
                });
            }

            // Allow: backspace, delete, tab, escape, enter and .
            if (e.type == 'keydown') {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            }

        };


        //extra discount






        //ORder place 

        $('#order_place').submit(function(eventObj) {
            if ($('#customer').val()) {
                $(this).append('<input type="hidden" name="user_id" value="' + $('#customer').val() + '" /> ');
            }
            return true;
        });



        //Coupon code discount
        function coupon_discount() {

            let coupon_code = $('#coupon_code').val();


            $.post({
                _token: '{{ csrf_token() }}',
                url: '{{ route('admin.pos.coupon-discount') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code: coupon_code,
                },
                beforeSend: function() {
                    $('#loading').removeClass('d-none');
                },
                success: function(data) {
                    //console.log(data);
                    if (data.coupon === 'success') {
                        $("#add-coupon-discount").modal("hide");
                        toastr.success('coupon_added_successfully', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else if (data.coupon === 'amount_low') {
                        $("#add-coupon-discount").modal("hide");
                        toastr.warning('this_discount_is_not_applied_for_this_amount', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else if (data.coupon === 'cart_empty') {
                        $("#add-coupon-discount").modal("hide");
                        toastr.warning('your_cart_is_empty', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        $("#add-coupon-discount").modal("hide");
                        toastr.warning('coupon_is_invalid', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function() {
                    $('.modal-backdrop').addClass('d-none');
                    //$(".footer-offset").removeClass("modal-open");
                    $('#preloader').addClass('d-none');
                }
            });

        }
    </script>

    <script>
        'use strict';

        function extra_discount() {
            //let  user_id = $('#customer').val();
            let discount = $('#dis_amount').val();
            let type = $('#type_ext_dis').val();
            //let  cart_id = $('#cart_id').val();
            if (discount > 0) {

                $.post({

                    url: '{{ route('admin.pos.discount') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        discount: discount,
                        type: type,
                        //cart_id:cart_id
                    },
                    beforeSend: function() {
                        $('#preloader').removeClass('d-none');
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.extra_discount === 'success') {
                            $("#add-discount").modal("hide");
                            toastr.success(
                                '{{ $helper->translate('extra_discount_added_successfully') }}', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                        } else if (data.extra_discount === 'empty') {
                            $("#add-discount").modal("hide");
                            toastr.warning('{{ $helper->translate('your_cart_is_empty') }}', {
                                CloseButton: true,
                                ProgressBar: true
                            });

                        } else {
                            $("#add-discount").modal("hide");
                            toastr.warning(
                                '{{ $helper->translate('this_discount_is_not_applied_for_this_amount') }}', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                        }

                        //$('.modal-backdrop').addClass('d-none');
                        $('#cart').empty().html(data.view);


                        // $('#search').focus();
                    },
                    complete: function() {
                        //$('.modal-backdrop').addClass('d-none');

                        //$(".footer-offset").removeClass("modal-open");
                        $('#preloader').addClass('d-none');



                    }
                });
            } else {
                toastr.warning('{{ $helper->translate('amount_can_not_be_negative_or_zero!') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        }
    </script>


    <script>
        "use strict";

        function clear_cart() {
            let url = "{{ route('admin.pos.clear-cart-ids') }}";
            document.location.href = url;
        }


        function emptyCart() {
            Swal.fire({
                title: '{{ $helper->translate('Are_you_sure?') }}',
                text: '{{ $helper->translate('You_want_to_remove_all_items_from_cart!!') }}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#161853',
                cancelButtonText: '{{ $helper->translate('No') }}',
                confirmButtonText: '{{ $helper->translate('Yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post('{{ route('admin.pos.emptyCart') }}', {
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('#cart').empty().html(data.view);
                        toastr.info('{{ $helper->translate('Item has been removed from cart') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    });
                }
            })
        }
    </script>




</body>

</html>
