@php
use App\CPU\helpers;
$helper = new helpers();
@endphp
@extends('layouts.back-end.master')

@section('title', 'POS Order List')


@section('content')
    <div class="layout-content-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.dashboard') }}">{{ $helper->translate('dashboard') }}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pos.index') }}">{{ $helper->translate('pos') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ $helper->translate('order_details') }}</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <div class="d-sm-flex align-items-sm-center">
                    <span style="font-size: 25px; margin-right:25px">{{ $helper->translate('Order') }}
                        #{{ $order['id'] }}</span>

                    @if ($order['payment_status'] == 'paid')
                        <span class="badge badge-primary ml-sm-3">
                            <span class="bg-success"></span>{{ $helper->translate('Paid') }}
                        </span>
                    @else
                        <span class="badge badge-primary ml-sm-3">
                            <span class="bg-danger"></span>{{ $helper->translate('Unpaid') }}
                        </span>
                    @endif

                    @if ($order['order_status'] == 'pending')
                        <span class="badge badge-info ml-2 ml-sm-3 text-capitalize">
                            <span
                                class="bg-info text"></span>{{ $helper->translate(str_replace('_', ' ', $order['order_status'])) }}
                        </span>
                    @elseif($order['order_status'] == 'failed')
                        <span class="badge badge-danger ml-2 ml-sm-3 text-capitalize">
                            <span
                                class=" bg-info"></span>{{ $helper->translate(str_replace('_', ' ', $order['order_status'])) }}
                        </span>
                    @elseif($order['order_status'] == 'processing' || $order['order_status'] == 'out_for_delivery')
                        <span class="badge badge-warning ml-2 ml-sm-3 text-capitalize">
                            <span
                                class="bg-warning"></span>{{ $helper->translate(str_replace('_', ' ', $order['order_status'])) }}
                        </span>
                    @elseif($order['order_status'] == 'delivered' || $order['order_status'] == 'confirmed')
                        <span class="badge badge-success ml-2 ml-sm-3 text-capitalize">
                            <span
                                class="bg-success"></span>{{ $helper->translate(str_replace('_', ' ', $order['order_status'])) }}
                        </span>
                    @else
                        <span class="badge badge-danger ml-2 ml-sm-3 text-capitalize">
                            <span
                                class="bg-danger"></span>{{ $helper->translate(str_replace('_', ' ', $order['order_status'])) }}
                        </span>
                    @endif
                    <span class="ml-2 ml-sm-3">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        {{ date('d M Y H:i:s', strtotime($order['created_at'])) }}
                    </span>

                    @if (\App\CPU\Helpers::get_business_settings('order_verification'))
                        <span class="ml-2 ml-sm-3">
                            <b>
                                {{ $helper->translate('order_verification_code') }} :
                                {{ $order['verification_code'] }}
                            </b>
                        </span>
                    @endif


                </div>
                <hr>

                <div class="">
                    <a class="text-body mr-3" target="_blank" href=''>
                        <i class="tio-print mr-1"></i> {{ $helper->translate('Print') }}
                        {{ $helper->translate('invoice') }}
                    </a>
                </div>



            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="pull-right">
                                <h6 class="" style="color: #8a8a8a;">
                                    {{ $helper->translate('Payment') }} {{ $helper->translate('Method') }}
                                    : {{ str_replace('_', ' ', $order['payment_method']) }}
                                </h6>
                                <h6 class="" style="color: #8a8a8a;">
                                    {{ $helper->translate('Payment') }} {{ $helper->translate('reference') }}
                                    : {{ str_replace('_', ' ', $order['transaction_ref']) }}
                                </h6>
                            </div>
                        </div>

                        <hr>



                        <br>

                        <div class="row">
                            <div class="col-md-2">
                                <p>{{ $helper->translate('image') }}</p>
                            </div>
                            <div class="col-md-3">
                                <p> {{ $helper->translate('Name') }}</p>
                            </div>

                            <div class="col-md-1">
                                <p> {{ $helper->translate('price') }}</p>
                            </div>

                            <div class="col-md-1">
                                <p>Q</p>
                            </div>
                            <div class="col-md-1 text-right">
                                <p> {{ $helper->translate('TAX') }}</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <p> {{ $helper->translate('Discount') }}</p>
                            </div>

                            <div class="col-md-2 text-right">
                                <p> {{ $helper->translate('Subtotal') }}</p>
                            </div>
                        </div>



                        @php($subtotal = 0)
                        @php($total = 0)
                        @php($shipping = 0)
                        @php($discount = 0)
                        @php($tax = 0)
                        @php($extra_discount = 0)
                        @php($product_price = 0)
                        @php($total_product_price = 0)
                        @php($coupon_discount = 0)
                        @foreach ($order->details as $key => $detail)
                            @if ($detail->product)
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img class="img-fluid"
                                                onerror="this.src='{{ asset('admin/img/placeholder/img1.jpg') }}'"
                                                src="{{ \App\CPU\ProductManager::product_image_path('thumbnail') }}/{{ $detail->product['thumbnail'] }}"
                                                alt="Image Description" width="100px">
                                        </div>
                                        <div class="col-md-3">
                                            <p>
                                                {{ substr($detail->product['name'], 0, 30) }}{{ strlen($detail->product['name']) > 10 ? '...' : '' }}
                                            </p>
                                            <strong><u>{{ $helper->translate('Variation') }} : </u></strong>

                                            <div class="font-size-sm text-body">

                                                <span class="font-weight-bold">{{ $detail['variant'] }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <h6>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($detail['price'])) }}
                                            </h6>
                                        </div>

                                        <div class="col-md-1">

                                            <h5>{{ $detail->qty }}</h5>
                                        </div>
                                        <div class="col-md-1 text-right">

                                            <h5>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($detail['tax'])) }}
                                            </h5>
                                        </div>
                                        <div class="col-md-2 text-right">

                                            <h5>
                                                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($detail['discount'])) }}
                                            </h5>
                                        </div>

                                        <div class="col-md-2 text-right">
                                            @php($subtotal = $detail['price'] * $detail->qty + $detail['tax'] - $detail['discount'])
                                            @php($product_price = $detail['price'] * $detail['qty'])
                                            <h5 style="font-size: 12px">
                                                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal)) }}
                                            </h5>
                                        </div>
                                        @php($total_product_price += $product_price)
                                    </div>
                                </div>

                                {{-- seller info old --}}

                                @php($discount += $detail['discount'])
                                @php($tax += $detail['tax'])
                                @php($total += $subtotal)
                                <!-- End Media -->
                               
                            @endif


                            @php($sellerId = $detail->seller_id)
                        @endforeach
                        @php($shipping = $order['shipping_cost'])

                        <?php
                        if ($order['extra_discount_type'] == 'percent') {
                            $extra_discount = ($total_product_price / 100) * $order['extra_discount'];
                        } else {
                            $extra_discount = $order['extra_discount'];
                        }
                        if (isset($order['discount_amount'])) {
                            $coupon_discount = $order['discount_amount'];
                        }
                        ?>

<hr>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <dl class="row text-sm-right">

                                    <dt class="col-sm-6">{{ $helper->translate('extra_discount') }}</dt>
                                    <dd class="col-sm-6 text-right">
                                        <strong>-
                                            {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($extra_discount)) }}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{ $helper->translate('coupon_discount') }}</dt>
                                    <dd class="col-sm-6 text-right">
                                        <strong>-
                                            {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($coupon_discount)) }}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{ $helper->translate('Total') }}</dt>
                                    <dd class="col-sm-6 text-right">
                                        <strong>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total + $shipping - $extra_discount - $coupon_discount)) }}</strong>
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>


                    </div>


                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-header-title">{{$helper->translate('Customer')}}</h4>
                            </div>

                            @if($order->customer)
                        <div class="card-body">
                            <div class="media align-items-center" href="javascript:">
                                <div class="">
                                    <img
                                        class="avatar-img" style="width: 56px;height: 42px"
                                        onerror="this.src='{{asset('admin/img/placeholder/img1.jpg')}}'"
                                        src="{{asset('storage/upload/customer'.$order->customer->image)}}"
                                        alt="Image">
                                </div>
                                <div class="media-body">
                                <span
                                    class="text-body text-hover-primary">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{--<i class="tio-chevron-right text-body"></i>--}}
                                </div>
                            </div>

                            <hr>

                            <div class="media align-items-center" href="javascript:">
                          
                                    <i class="fa fa-shopping-bag text-primary" aria-hidden="true" style="font-size: 25px"></i>
                               
                                <div class="media-body">
                                    <span
                                        class="text-body text-hover-primary"> {{\App\Models\Order::where('order_type','POS')->where('customer_id',$order['customer_id'])->count()}} {{$helper->translate('orders')}}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{--<i class="tio-chevron-right text-body"></i>--}}
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{$helper->translate('Contact')}} {{$helper->translate('info')}} </h5>
                            </div>

                            <ul class="list-unstyled list-unstyled-py-2">
                                <li>
                                    <i class="tio-online mr-2"></i>
                                    {{$order->customer['email']}}
                                </li>
                                <li>
                                    <i class="tio-android-phone-vs mr-2"></i>
                                    {{$order->customer['phone']}}
                                </li>
                            </ul>

                            <hr>
                            
                        </div>
                    @else
                        <div class="card-body">
                            <div class="media align-items-center">
                                <span>{{$helper->translate('no_customer_found')}}</span>
                            </div>
                        </div>
                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
