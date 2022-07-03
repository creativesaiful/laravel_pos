<div class="col-md-2 my-3">
    <div class="product-card card" onclick="quickView('{{ $product->id }}')" style="cursor: pointer;">
        <div class="card-header inline_product clickable p-0" style="height:100px;width:100%;overflow:hidden;">
            <div class="d-flex align-items-center justify-content-center d-block">
                <img src="{{ asset('storage/upload/products/thumbnail') }}/{{ $product->thumbnail }}"
                    onerror="this.src='{{ asset('admin/img/placeholder.img1.jpg') }}'"
                    style="width: 100%; border-radius: 5%;">
            </div>
        </div>

        <div class="card-body inline_product text-center p-1 clickable" style="height:3.5rem; max-height: 3.5rem">
            <div style="position: relative;" class="product-title1 text-dark font-weight-bold">
               <span style="font-size: 12px"> {{ Str::limit($product['name'], 13) }}</span>
            </div>
            <div class="justify-content-between text-center">
                <div class="product-price text-center">
                   <span style="font-size: 12px"> {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['unit_price'] - \App\CPU\Helpers::get_product_discount($product, $product['unit_price']))) }}</span>
                    @if ($product->discount > 0)
                        <strike style="font-size: 12px!important;color: grey!important;">
                            {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['unit_price'])) }}
                        </strike><br>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
