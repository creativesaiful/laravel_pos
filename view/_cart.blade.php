@php
use App\CPU\helpers;
$helper = new helpers();
@endphp

<div class="d-flex flex-row table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="">
            <tr>
                <th class="fw-normal" style="font-size: 12px; min-width:150px">{{$helper->translate('item')}}</th>
                <th class="fw-normal text-center" style="font-size: 12px">{{$helper->translate('qty')}}</th>
                <th class="fw-normal" style="font-size: 12px">{{$helper->translate('price')}}</th>
                <th class="fw-normal" style="font-size:12px ;width: 75px">{{$helper->translate('delete')}}</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $subtotal = 0;
            $addon_price = 0;
            $tax = 0;
            $discount = 0;
            $discount_type = 'amount';
            $discount_on_product = 0;
            $total_tax = 0;
            $ext_discount = 0;
            $ext_discount_type = 'amount';
            $coupon_discount =0;
        ?>
        @if(session()->has($cart_id) && count( session()->get($cart_id)) > 0)
            <?php
                $cart = session()->get($cart_id);
                if(isset($cart['tax']))
                {
                    $tax = $cart['tax'];
                }
                if(isset($cart['discount']))
                {
                    $discount = $cart['discount'];
                    $discount_type = $cart['discount_type'];
                }
                if (isset($cart['ext_discount'])) {
                    $ext_discount = $cart['ext_discount'];
                    $ext_discount_type = $cart['ext_discount_type'];
                }
                if(isset($cart['coupon_discount']))
                {
                    $coupon_discount = $cart['coupon_discount'];
                }
            ?>
            @foreach(session()->get($cart_id) as $key => $cartItem)
            @if(is_array($cartItem))
                <?php
                
                $product_subtotal = ($cartItem['price'])*$cartItem['quantity'];
                $discount_on_product += ($cartItem['discount']*$cartItem['quantity']);
                $subtotal += $product_subtotal;

                //tax calculation
                $product = \App\Models\Product::find($cartItem['id']);
                $total_tax += \App\CPU\Helpers::tax_calculation($cartItem['price'], $product['tax'], $product['tax_type'])*$cartItem['quantity'];
                
                ?>
                
            <tr>
                <td class="media align-items-center">
                   
                    
                            <img class="avatar avatar-sm float-start" src="{{asset('storage/upload/products/thumbnail')}}/{{$cartItem['image']}}"
                            onerror="this.src='{{asset('admin/img/placeholder/img1.jpg')}}'" alt="{{$cartItem['name']}} image" width="35px" style="margin-right: 10px" >
                    

                       
                            <div class="media-body">
                                <span class="text-hover-primary mb-0" style="font-size: 12px">{{Str::limit($cartItem['name'], 10)}}</span> <br>
                                <small style="font-size: 10px">{{Str::limit($cartItem['variant'], 12)}}</small>
                                
                            </div>
                   
                 
                   
                   
                </td>
                <td class="align-items-center text-center">
                    <input type="number"  data-key="{{$key}}" style="width:50px;text-align: center;" value="{{$cartItem['quantity']}}" min="1" onchange="updateQuantity('{{$cartItem['id']}}',this.value,event)">
                </td>
                <td class="text-center px-0 py-1">
                    <div class="" style="font-size: 12px; margin-top:10px">
                        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product_subtotal))}}
                    </div> <!-- price-wrap .// -->
                </td>
                <td class="align-items-center text-center">
                    <a href="javascript:removeFromCart({{$key}})" class="btn btn-sm btn-outline-danger">
                        <i class="fa-solid fa-trash"></i>
                    
                    </a>
                </td>
            </tr>
            @endif
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<?php
    $total = $subtotal;
    $discount_amount = $discount_on_product;
    $total -= $discount_amount;

    $extra_discount = $ext_discount;
    $extra_discount_type = $ext_discount_type;
    if($extra_discount_type == 'percent' && $extra_discount > 0){
        $extra_discount =  (($subtotal)*$extra_discount) / 100;
    }
    if($extra_discount) {
        $total -= $extra_discount;
    }

    $total_tax_amount= $total_tax;
?>
<div class="box p-3">
    <dl class="row text-sm-right">

        <div class="col-12 d-flex justify-content-between">
            <dt  class="col-sm-6 fw-normal text-end">{{$helper->translate('sub_total')}} : </dt>
            <dd class="col-sm-6 text-end">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</dd>

        </div>

        <div class="col-12 d-flex justify-content-between">
            <dt  class="col-sm-6 fw-normal text-end">{{$helper->translate('product')}} {{$helper->translate('discount')}} :</dt>
            <dd class="col-sm-6 text-right text-end">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($discount_amount,2))) }}</dd>
        </div>

        <div class="col-12 d-flex justify-content-between">
            <dt  class="col-sm-6 fw-normal text-end">{{$helper->translate('extra')}} {{$helper->translate('discount')}} :</dt>
            <dd class="col-sm-6 text-right text-end">
                <button id="extra_discount" class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#add-discount">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($extra_discount))}}
            </dd>
        </div>

        <div class="col-12 d-flex justify-content-between">
            <dt  class="col-sm-6 fw-normal text-end">{{$helper->translate('coupon')}} {{$helper->translate('discount')}} :</dt>
            <dd class="col-sm-6 text-right text-end">
                <button id="coupon_discount" class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#add-coupon-discount">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($coupon_discount))}}
            </dd>
        </div>

        <div class="col-12 d-flex justify-content-between">
            <dt  class="col-sm-6 fw-normal text-end">{{$helper->translate('tax')}} : </dt>
            <dd class="col-sm-6 text-right text-end">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total_tax_amount,2)))}}</dd>
        </div>

        <div class="col-12 d-flex justify-content-between">
            <dt  class="col-sm-6 text-end">{{$helper->translate('total')}} : </dt>
            <dd class="col-sm-6 text-right  text-end">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(round($total+$total_tax_amount-$coupon_discount, 2)))}}</dd>
        </div>
    </dl>
    <div class="row">
        <div class="col-md-6 mb-2 text-center">
            <a href="#" class="btn btn-danger btn-block" onclick="emptyCart()"><i
                    class="fa fa-times-circle "></i> {{$helper->translate('Cancel')}} </a>
        </div>
        <div class="col-md-6 text-center">
            <button id="submit_order" type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#paymentModal"><i class="fa fa-shopping-bag"></i>
                {{$helper->translate('Order')}} </button>
        </div>
    </div>
</div>

<div class="modal fade" id="add-discount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$helper->translate('update_discount')}}</h5>
                <button class="close call-when-done" style="border: none; color:black" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">{{$helper->translate('discount')}}</label>
                        <input type="number" id="dis_amount" min="0" class="form-control" name="discount">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">{{$helper->translate('type')}}</label>
                        <select name="type" id="type_ext_dis" class="form-control">
                            <option value="amount" {{$discount_type=='amount'?'selected':''}}>{{$helper->translate('amount')}}()</option>
                            <option value="percent" {{$discount_type=='percent'?'selected':''}}>{{$helper->translate('percent')}}(%)</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 my-2">
                        <button class="btn btn-primary" onclick="extra_discount();" type="submit">{{$helper->translate('submit')}}</button>
                    </div>
                </div>
                    
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-coupon-discount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$helper->translate('coupon_discount')}}</h5>
                <button class="close call-when-done" style="border: none; color:black" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group col-md-12">
                        <label for="">{{$helper->translate('coupon_code')}}</label>
                        <input type="text" id="coupon_code" class="form-control" name="coupon_code">
                        {{-- <input type="hidden" id="user_id" name="user_id" > --}}
                    </div>

                    <div class="form-group col-md-12 my-2">
                        <button class="btn btn-primary" type="submit" onclick="coupon_discount();">{{$helper->translate('submit')}}</button>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-tax" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$helper->translate('update_tax')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.tax')}}" method="POST" class="row">
                    @csrf
                    <div class="form-group col-12">
                        <label for="">{{$helper->translate('tax')}} (%)</label>
                        <input type="number" class="form-control" name="tax" min="0">
                    </div>

                    <div class="form-group col-sm-12">
                        <button class="btn btn-primary" type="submit">{{$helper->translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$helper->translate('payment')}}</h5>
                <button class="close call-when-done" style="border: none; color:black" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.place-order')}}" id='order_place' method="post" class="row">
                    @csrf
                    <div class="form-group col-12 my-2">
                        <label class="input-label" for="">{{$helper->translate('amount')}}({{\App\CPU\currency_symbol()}})</label>
                        <input type="number" class="form-control" name="amount" min="0" step="0.01" 
                                value="{{\App\CPU\BackEndHelper::usd_to_currency($total+$total_tax_amount-$coupon_discount)}}"
                                readonly>
                    </div>
                   
                    <div class="form-group col-12 my-2">
                        <label class="input-label" for="">{{$helper->translate('type')}}</label>
                        <select name="type" class="form-control">
                            <option value="cash">{{$helper->translate('cash')}}</option>
                            <option value="card">{{$helper->translate('card')}}</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-12 my-2">
                        <button class="btn btn-primary" id="order_complete" type="submit">{{$helper->translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="short-cut-keys" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$helper->translate('short_cut_keys')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>{{$helper->translate('to_click_order')}} : alt + O</span><br>
                <span>{{$helper->translate('to_click_payment_submit')}} : alt + S</span><br>
                <span>{{$helper->translate('to_close_payment_submit')}} : alt + Z</span><br>
                <span>{{$helper->translate('to_click_cancel_cart_item_all')}} : alt + C</span><br>
                <span>{{$helper->translate('to_click_add_new_customer')}} : alt + A</span> <br>
                <span>{{$helper->translate('to_submit_add_new_customer_form')}} : alt + N</span><br>
                <span>{{$helper->translate('to_click_short_cut_keys')}} : alt + K</span><br>
                <span>{{$helper->translate('to_print_invoice')}} : alt + P</span> <br>
                <span>{{$helper->translate('to_cancel_invoice')}} : alt + B</span> <br>
                <span>{{$helper->translate('to_focus_search_input')}} : alt + Q</span> <br>
                <span>{{$helper->translate('to_click_extra_discount')}} : alt + E</span> <br>
                <span>{{$helper->translate('to_click_coupon_discount')}} : alt + D</span> <br>
                <span>{{$helper->translate('to_click_clear_cart')}} : alt + X</span> <br>
                <span>{{$helper->translate('to_click_new_order')}} : alt + R</span> <br>

            </div>
        </div>
    </div>
</div>

