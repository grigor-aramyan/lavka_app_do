@extends('admin.layouts.app')

@section('content')
    <div class="container">

        <h2>Orders</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ordered for Date</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Phone</th>
                    <th scope="col">User Id</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td id="order_ordered_for_date_{{$order->id}}">{{ $order->ordered_for_date }}</td>
                        <td id="order_total_price_{{$order->id}}">${{ $order->total_price }}</td>
                        <td id="order_status_{{$order->id}}">{{ $order->status }}</td>
                        @if (isset($order->delivery_phone))
                            <td id="order_delivery_phone_{{$order->id}}">{{ $order->delivery_phone }}</td>
                        @else
                            <td id="order_delivery_phone_{{$order->id}}">{{ $order->user->phone }}</td>
                        @endif
                        <td>{{ $order->user->id }}</td>
                        <td>
                            <a class="mr-2" href="javascript:void(0)"><img id="edit_order" data-id="{{ $order->id }}" title="Edit" src="{{ asset('images/icons/edit.png') }}" /></a>
                            <a class="mr-2" href="{{ route('admin-order-delete', $order->id) }}"><img title="Delete" src="{{ asset('images/icons/cancel.png') }}" /></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($last_page > 1)
            <div style="text-align: center;">
                <ul style="list-style-type: none; display: inline-block;">
                    @foreach(range(1, $last_page) as $idx)
                        @if ($idx == $active_page)
                            <li style="float: left;" class="ml-2"><a href="javascript:void(0)" style="color: grey; pointer-events: none;">{{ $idx }}</a></li>
                        @else
                            <li style="float: left;" class="ml-2"><a href="{{ route('admin-orders-list', $idx) }}">{{ $idx }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div id="orders_edit_dialog" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" type="text" id="order_id" />
                    <div class="form-group">
                        <label for="order_ordered_for_date" class="col-form-label">Ordered for Date:</label>
                        <input type="date" class="form-control" id="order_ordered_for_date">
                    </div>
                    <div class="form-group">
                        <label for="order_price" class="col-form-label">Total price $:</label>
                        <input type="text" class="form-control" id="order_price">
                    </div>
                    <div class="form-group">
                        <label for="order_phone" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control" id="order_phone">
                    </div>
                    <div class="form-group">
                        <label for="order_status" class="col-form-label">Status:</label>
                        <select id="order_status" class="form-select" aria-label="Default select example">
                            <option value="pending">Pending</option>
                            <option value="in_warehouse">In Warehouse</option>
                            <option value="on_the_way">On the Way</option>
                            <option value="delivered">Delivered</option>
                            <option value="completed">Completed</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save_edited_order" type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection