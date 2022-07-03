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
                <li class="breadcrumb-item" aria-current="page">{{ $helper->translate('orders') }}</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <span style="font-size: 25px">{{ $helper->translate('pos_orders') }} <span
                        class="badge badge-soft-dark mx-2">{{ $orders->count() }}</span></span>
            </div>

            <div class="card-body">
                <div>

                    <form action="{{route('admin.pos.order-search')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="from-group">
                                    <label for="min">Minimum date:</label>
                                    <input type="date" name="from" id="from"  value="{{$from}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="max">Maximum date:</label>
                                    <input type="date" name="to" id="to" class="form-control" value="{{$to}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" value="Filter" class="btn btn-info" style="margin-top: 25px">

                                </div>
                            </div>
                        </div>



                    </form>


                </div>

                <div class="table-responsive">
                    <table class="table" id="orderTable">
                        <thead class="thead-light">
                            <tr>
                                <th scope>
                                    {{ $helper->translate('SL') }}#
                                </th>
                                <th scope>{{ $helper->translate('Order') }}</th>
                                <th scope>{{ $helper->translate('Date') }}</th>
                                <th scope>{{ $helper->translate('customer_name') }}</th>
                                <th scope>{{ $helper->translate('Status') }}</th>
                                <th scope>{{ $helper->translate('Total') }}</th>
                                <th scope>{{ $helper->translate('Order') }} {{ $helper->translate('Status') }} </th>
                                <th scope>{{ $helper->translate('Action') }}</th>
                            </tr>
                        </thead>



                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr class="status-{{ $order['order_status'] }} class-all">
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                       {{ $order['id'] }}
                                        
                                    </td>
                                    <td>{{ date('d M Y', strtotime($order['created_at'])) }}</td>
                                    <td>
                                        @if ($order->customer)
                                         {{ $order->customer['f_name'] . ' ' . $order->customer['l_name'] }}
                                        @else
                                            <label
                                                class="badge badge-danger">{{ $helper->translate('invalid_customer_data') }}</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <span class="badge badge-soft-success">
                                                <span
                                                    class="legend-indicator bg-success"></span>{{ $helper->translate('paid') }}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger">
                                                <span
                                                    class="legend-indicator bg-danger"></span>{{ $helper->translate('unpaid') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td> {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order->order_amount)) }}
                                    </td>
                                    <td class="text-capitalize">
                                        @if ($order['order_status'] == 'pending')
                                            <span class="badge badge-soft-info ">
                                                <span
                                                    class="legend-indicator bg-info"></span>{{ $order['order_status'] }}
                                            </span>
                                        @elseif($order['order_status'] == 'processing' || $order['order_status'] == 'out_for_delivery')
                                            <span class="badge badge-soft-warning ">
                                                <span
                                                    class="legend-indicator bg-warning"></span>{{ $order['order_status'] }}
                                            </span>
                                        @elseif($order['order_status'] == 'confirmed')
                                            <span class="badge badge-soft-success">
                                                <span
                                                    class="legend-indicator bg-success"></span>{{ $order['order_status'] }}
                                            </span>
                                        @elseif($order['order_status'] == 'failed')
                                            <span class="badge badge-danger">
                                                <span
                                                    class="legend-indicator bg-warning"></span>{{ $order['order_status'] }}
                                            </span>
                                        @elseif($order['order_status'] == 'delivered')
                                            <span class="badge badge-soft-success">
                                                <span
                                                    class="legend-indicator bg-success"></span>{{ $order['order_status'] }}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger">
                                                <span
                                                    class="legend-indicator bg-danger"></span>{{ $order['order_status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>

                                        <a class="btn btn-primary btn-sm mr-1" title="{{ $helper->translate('view') }}"
                                            href="{{ route('admin.pos.order-details', ['id' => $order['id']]) }}"><i
                                                class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a class="btn btn-info btn-sm mr-1" target="_blank"
                                            title="{{ $helper->translate('invoice') }}" href=""><i
                                                class="fa fa-download" aria-hidden="true"></i> </a>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')


    <script>
        $(document).ready(function() {
            $('#orderTable').DataTable();
        });
    </script>
@endsection
