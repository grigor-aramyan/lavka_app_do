@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Latest Users</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td id="user_name_{{$user->id}}">{{ $user->name }}</td>
                        <td id="user_email_{{$user->id}}">{{ $user->email }}</td>
                        <td id="user_phone_{{$user->id}}">{{ $user->phone }}</td>
                        <td id="user_role_{{$user->id}}">{{ $user->role }}</td>
                        <td>
                            <a class="mr-2" href="javascript:void(0)"><img id="edit_user" data-id="{{ $user->id }}" title="Edit" src="{{ asset('images/icons/edit.png') }}" /></a>
                            <a class="mr-2" href="{{ route('admin-user-delete', $user->id) }}"><img title="Delete" src="{{ asset('images/icons/cancel.png') }}" /></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr />

        <h2>Latest Products</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Count</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        @if (isset($product->image_uri))
                            <td style="width: 20%;">
                                <img style="width: 100%; height: auto;" title="Product image" src="{{ asset($product->image_uri) }}" />
                                <div class="mt-1" style="border-radius: 10px; padding: 3px; opacity: 50%; z-index: 100; background-color: black; text-align: center;">
                                    <button id="upload_product_image" data-id="{{ $product->id }}" style="" class="btn btn-warning">Edit</button>
                                </div>
                            </td>
                        @else
                            <td style="width: 20%;">
                                <img style="width: 100%; height: auto;" title="Product image" src="{{ asset('images/no_image.jpg') }}" />
                                <div class="mt-1" style="border-radius: 10px; padding: 3px; opacity: 50%; z-index: 100; background-color: black; text-align: center;">
                                    <button id="upload_product_image" data-id="{{ $product->id }}" style="" class="btn btn-warning">Upload</button>
                                </div>
                            </td>
                        @endif
                        <td>{{ $product->id }}</td>
                        <td id="product_name_{{$product->id}}">{{ $product->name }}</td>
                        @if (isset($product->category))
                            <td>{{ $product->category->name }}</td>
                        @else
                            <td>Misc</td>
                        @endif
                        <input type="hidden" id="product_category_{{$product->id}}" value="{{ $product->category ? $product->category->id : null }}" />
                        <td id="product_price_{{$product->id}}">${{ $product->price }}</td>
                        <td id="product_count_{{$product->id}}">{{ $product->count }}</td>
                        <td>{{ count($product->orders) }}</td>
                        <td>
                            <a class="mr-2" href="javascript:void(0)"><img id="edit_product" data-id="{{ $product->id }}" title="Edit" src="{{ asset('images/icons/edit.png') }}" /></a>
                            <a class="mr-2" href="{{ route('admin-product-delete', $product->id) }}"><img title="Delete" src="{{ asset('images/icons/cancel.png') }}" /></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr />

        <h2>Latest Orders</h2>
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
    </div>

    <form method="post" style=""></form>

    <div id="users_edit_dialog" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" type="text" id="user_id" />
                    <div class="form-group">
                        <label for="user_email" class="col-form-label">Email:</label>
                        <input type="text" disabled class="form-control" id="user_email">
                    </div>
                    <div class="form-group">
                        <label for="user_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="user_name">
                    </div>
                    <div class="form-group">
                        <label for="user_phone" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control" id="user_phone">
                    </div>
                    <div class="form-group">
                        <label for="user_role" class="col-form-label">Role:</label>
                        <select id="user_role" class="form-select" aria-label="Default select example">
                            <option value="regular">Regular</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save_edited_user" type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

    <div id="products_edit_dialog" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" type="text" id="product_id" />
                    <div class="form-group">
                        <label for="product_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="product_name">
                    </div>
                    <div class="form-group">
                        <label for="product_price" class="col-form-label">Price $:</label>
                        <input type="text" class="form-control" id="product_price">
                    </div>
                    <div class="form-group">
                        <label for="product_count" class="col-form-label">Count:</label>
                        <input type="number" min="0" class="form-control" id="product_count">
                    </div>
                    <div class="form-group">
                        <label for="product_category" class="col-form-label">Category:</label>
                        <select id="product_category" class="form-select" aria-label="Default select example">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="-1">Misc</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save_edited_product" type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="product_image_edit_dialog" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form style="" id="product_image_upload_form" enctype="multipart/form-data" method="post" action="{{ route('admin-products-image') }}">
                        @csrf
                        <input type="hidden" type="text" name="product_id" id="editing_product_image_product_id" />
                        <div class="form-group">
                            <label for="product_image" class="col-form-label">Product image:</label>
                            <br />
                            <input type="file" name="product_image" id="product_image" accept="image/*" />
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button onclick="(function() { $('#product_image_upload_form').submit(); })();" type="button" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection