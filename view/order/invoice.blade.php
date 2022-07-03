
@php
use App\CPU\helpers;
$helper = new helpers();
@endphp

<div style="width:410px;">
    <div class="text-center pt-4 mb-3">
        <h2 style="line-height: 1">{{\App\Models\BusinessSetting::where(['type'=>'company_name'])->first()->value}}</h2>
        {{-- <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
            {{\App\Model\BusinessSetting::where(['type'=>'address'])->first()->value}}
        </h5> --}}
        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
            {{$helper->translate('Phone')}}
            : {{\App\Models\BusinessSetting::where(['type'=>'company_phone'])->first()->value}}
        </h5>
    </div>

    <span>--------------------------------------------------------------------------------------</span>
    <div class="row mt-3">
        <div class="col-6">
            <h5>{{$helper->translate('Order ID')}} : {{$order['id']}}</h5>
        </div>
        <div class="col-6">
            <h5 style="font-weight: lighter">
                {{date('d/M/Y h:i a',strtotime($order['created_at']))}}
            </h5>
        </div>
        @if($order->customer)
            <div class="col-12">
                <h5>{{$helper->translate('Customer Name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}</h5>
                @if ($order->customer->id !=0)
                    <h5>{{$helper->translate('Phone')}} : {{$order->customer['phone']}}</h5>
                @endif
                
            </div>
        @endif
    </div>
    <h5 class="text-uppercase"></h5>
    <span>--------------------------------------------------------------------------------------</span>
    <table class="table table-bordered mt-3" style="width: 98%">
        <thead>
        <tr>
            <th style="width: 10%">{{$helper->translate('QTY')}}</th>
            <th class="">{{$helper->translate('DESC')}}</th>
            <th class="">{{$helper->translate('Price')}}</th>
        </tr>
        </thead>

        <tbody>
        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_dis_on_pro=0)
        @php($product_price=0)
        @php($total_product_price=0)
        @php($ext_discount=0)
        @php($coupon_discount=0)
        @foreach($order->details as $detail)
            @if($detail->product)
                
                <tr>
                    <td class="">
                        {{$detail['qty']}}
                    </td>
                    <td class="">
                        <span style="word-break: break-all;"> {{ Str::limit($detail->product['name'], 200) }}</span><br>
                        @if(count(json_decode($detail['variation'],true))>0)
                            <strong><u>{{$helper->translate('Variation')}} : </u></strong>
                            @foreach(json_decode($detail['variation'],true) as $key1 =>$variation)
                                <div class="font-size-sm text-body" style="color: black!important;">
                                    <span>{{$key1}} :  </span>
                                    <span
                                        class="font-weight-bold">{{$variation}} </span>
                                </div>
                            @endforeach
                        @endif

                    

                        {{$helper->translate('Discount')}} : {{\App\CPU\Helpers::currency_converter(round($detail['discount'],2))}}
                    </td>
                    <td style="width: 28%">
                        @php($amount=($detail['price']*$detail['qty'])-$detail['discount'])
                        @php($product_price = $detail['price']*$detail['qty'])
                        {{\App\CPU\Helpers::currency_converter(round($amount,2))}}
                    </td>
                </tr>
                @php($sub_total+=$amount)
                @php($total_product_price+=$product_price)
                @php($total_tax+=$detail['tax'])
                
            @endif
        @endforeach
        </tbody>
    </table>
    <span>---------------------------------------------------------------------------------------</span>
    <?php
    
        
        if ($order['extra_discount_type'] == 'percent') {
            $ext_discount = ($total_product_price / 100) * $order['extra_discount'];
        } else {
            $ext_discount = $order['extra_discount'];
        }
        if(isset($order['discount_amount'])){
            $coupon_discount =$order['discount_amount'];
        }
    ?>
    <div class="row justify-content-md-end">
        <div class="col-md-8 col-lg-8">
            <dl class="row text-right" style="color: black!important;">
                <dt class="col-7">{{$helper->translate('Items Price')}}:</dt>
                <dd class="col-5">{{\App\CPU\Helpers::currency_converter(round($sub_total,2))}}</dd>
                <dt class="col-7">{{$helper->translate('Tax')}} / {{$helper->translate('VAT')}}:</dt>
                <dd class="col-5">{{\App\CPU\Helpers::currency_converter(round($total_tax,2))}}</dd>
                
                <dt class="col-7">{{$helper->translate('Subtotal')}}:</dt>
                <dd class="col-5">{{\App\CPU\Helpers::currency_converter(round($sub_total+$total_tax,2))}}</dd>
                
                <dt class="col-7">{{$helper->translate('extra_discount')}}:</dt>
                <dd class="col-5">{{\App\CPU\Helpers::currency_converter(round($ext_discount,2))}}</dd>

                <dt class="col-7" >{{$helper->translate('coupon_discount')}}:</dt>
                <dd class="col-5">{{\App\CPU\Helpers::currency_converter(round($coupon_discount,2))}}</dd>
                
                <dt class="col-7" style="font-size: 20px">{{$helper->translate('Total')}}:</dt>
                <dd class="col-5" style="font-size: 20px">{{\App\CPU\Helpers::currency_converter(round($order->order_amount,2))}}</dd>
            </dl>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-between border-top">
        <span>{{$helper->translate('Paid_by')}}: {{$helper->translate($order->payment_method)}}</span>
    </div>
    <span>---------------------------------------------------------------------------------------</span>
    <h5 class="text-center pt-3">
        """{{$helper->translate('THANK YOU')}}"""
    </h5>
    <span>---------------------------------------------------------------------------------------</span>
</div>
