@extends('layouts.app')
@section('title','POS')
@section('css')
<style>
     .image-container {
        position: relative;
        display: inline-block;
        margin: 10px;
    }
    .avatar-lg {
        width: 100px;
        height: 100px;
    }
    .myfoot{
        position: fixed;
  left: 0;
  bottom: 0;
    }
</style>

@endsection

@section('content')
<!--  Body Wrapper -->

<!-- Sidebar Start -->
<!--  Sidebar End -->
<!--  Header Start -->
@include('components.header')
<!--  Header End -->
@include('components.right_sidebar')
@include('components.left_sidebar')

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10 ">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>Order Details</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('order.all')}}">Orders</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show Order Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row mb-30">
                <div class="col-12 ">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">

                                </div>


                                <div class="col-md-4 col-sm-12 ">
                                    <h5 class=" h3 text-dark text-center">Order Details</h5>

                                </div>
                                <div class="col-md-5 col-sm-12 mb-30 d-flex justify-content-center">
                                    <h2 class="card-title text-primary text-right text-decoration mr-10">
                                        <a href="javascript:void(0);"
                                           class="btn btn-warning btn-sm change-status-btn"
                                           data-toggle="modal" data-target="#changeStatus"  data-item='@json(["id" => $order->id, "status" => $order->status])'>
                                            <i class="fas fa-exchange-alt"></i> Change Order Status
                                        </a>

                                        @if ($order->status == 'cancel')
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-order-btn"
                                               onclick="confirmDelete({{ $order->id }})">
                                                <i class="fas fa-trash-alt"></i> Delete Order
                                            </a>
                                        @endif
                                    </h2>

                                    @if ($order->status == 'cancel')
                                        <form action="{{ route('order.delete', $order->id) }}" method="POST" style="display:none;" id="deleteForm_{{ $order->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                    <!-- Bootstrap Modal -->
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this Order
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger" onclick="submitDelete()">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatus" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Change Order Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="POST" style="display:inline-block;" id="statusForm">
                                                        @csrf
                                                        @method('PUT')

                                                        <select class="form-control" id="status" name="status">
                                                            <option value="placed">Placed</option>
                                                            <option value="shipped">Shipped</option>
                                                            <option value="delivered">Delivered</option>
                                                            <option value="cancel">Cancel</option>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" form="statusForm" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>




                            </div>

                        </div>

                        <br>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="container mb-30">
                                <div class="row">
                                    {{-- <div class="col-md-3 col-sm-12 mb-1">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Order Number </div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{isset($order->id) ? $order->id: 'Null'}}</h5>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3 col-sm-12 mb-1">
                                        <div class="card  text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Order Code</div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{$order->order_code ?? "No Order Code"}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 mb-30">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Order Status </div>
                                            <div class="card-body">
                                                @if ($order->status == "placed")
                                                    <td>
                                                    <h5 class="card-title text-center text-warning"> {{$order->status}}</h5>
                                                    </td>

                                                    @elseif (($order->status == "shipped"))
                                                    <td>
                                                    <h5 class="card-title text-center text-primary"> {{$order->status}}</h5>
                                                    </td>

                                                    @elseif (($order->status == "delivered"))
                                                    <td>
                                                    <h5 class="card-title text-center text-success"> {{$order->status}}</h5>
                                                    </td>
                                                    @elseif (($order->status == "cancel"))
                                                    <td>
                                                    <h5 class="card-title text-center text-danger"> {{$order->status}}</h5>
                                                    </td>
                                                @endif

                                            </div>
                                        </div>
                                    </div>





                                    <div class="col-md-3 col-sm-12 mb-1">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Total Product Count</div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{$total_qty}}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-12 mb-1">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Order Date</div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{$order->created_at->format('Y-m-d H:i:s')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 mb-1">
                                        <div class="card  text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Order Total Price</div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{$order->total_price ?? "No Order Code"}} Ks</h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 col-sm-12 mb-30">
                                <h3 class="mb-20 h4 text-blue text-center">Order-Product-Details</h3>

                            </div>
                             <div class="container">
                                <div class="row">
{{--                                    <div class="col-md-12 col-sm-12 ">--}}
{{--                                        <h5 class=" h3 text-dark ">Product Details Information</h5>--}}
{{--                                    </div>--}}

                                    <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>
                                            <tr>
                                                <th class="text-center">Sl</th>
                                                <th>Order Code</th>
                                                <th class="text-center"> Product  </th>
                                                <th class="text-center"> Image  </th>
                                                <th class="text-center"> Size </th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Total Price</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($subtotal = 0) {{-- Initialize subtotal variable --}}
                                            @php($i = 1)
                                            @foreach($order->items as $key => $item)
                                            @php($totalPrice = $item->price * $item->quantity) {{-- Calculate total price for each item --}}
                                            @php($subtotal += $totalPrice) {{-- Add to subtotal --}}
{{--                                            <tr>--}}
{{--                                                <td class="text-center">{{ $i++ }}</td>--}}
{{--                                                <td>{{ $order->order_code }}</td>--}}
{{--                                                <td>{{ $item->variation->product->name }}</td>--}}

{{--                                                <td class="text-center">--}}
{{--                                                    @if (!empty($item->variation->images) && count($item->variation->images) > 0)--}}
{{--                                                        <img src="{{ $item->variation->images[0]->full_image_path }}" alt="Product Image" width="50">--}}
{{--                                                    @else--}}
{{--                                                        <img src="{{ asset('upload/no_image.jpg') }}" alt="No Image" width="50">--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                                <td class="text-center">{{ $item->variation->size }}</td>--}}
{{--                                                <td class="text-center">{{ $item->price }} Ks</td>--}}
{{--                                                <td class="text-center">{{ $item->quantity }}</td>--}}
{{--                                                <td class="text-center">{{ $item->price * $item->quantity }} Ks</td>--}}
{{--                                            @endforeach--}}

                                            <tr>
                                                <td class="text-center">{{ $i++ }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $item->variation->product->name }}</td>

                                                {{-- Display the first image, or fallback to a placeholder --}}
                                                <td class="text-center">
                                                    @if (!empty($item->variation->images) && count($item->variation->images) > 0)
                                                        <img src="{{ $item->variation->images[0]->full_image_path }}" alt="Product Image" width="100">
                                                    @else
                                                        <img src="{{ asset('default-image.png') }}" alt="No Image" width="50">
                                                    @endif
                                                </td>

                                                <td class="text-center">{{ $item->variation->size }}</td>
                                                <td class="text-center">{{ number_format($item->price, 2) }} Ks</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">{{ number_format($totalPrice, 2) }} Ks</td>
                                            </tr>
                                            @endforeach

                                            {{-- Subtotal Row --}}
                                            <tr>
                                                <td colspan="7" class="text-right"><strong>Subtotal:</strong></td>
                                                <td class="text-center"><strong>{{ number_format($subtotal, 2) }} Ks</strong></td>
                                            </tr>


                                        </tbody>
                                    </table>



                                </div>


                            </div>
                            <hr>
                            <div class="col-md-12 col-sm-12 mb-30">
                                <h3 class="mb-20 h4 text-blue text-center">Customer Information</h3>

                            </div>
                            <div class="container">
                                <div class="row">
{{--                                    <div class="col-md-12 col-sm-12 ">--}}
{{--                                        <h5 class=" h3 text-dark ">Customer Information</h5>--}}

{{--                                    </div>--}}

                                    <div class="col-md-4 col-sm-12 mb-20">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Customer Name </div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{isset($order->user->name) ? $order->user->name: 'Null'}}</h5>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-4 col-sm-12 mb-20">
                                        <div class="card  text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Email Address</div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{$order->user->email}}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-20">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Phone Number </div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{isset($order->user->phone) ? $order->user->phone : 'No Phone Number'}} </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-1">
                                        <div class="card text-white bg-light card-box">
                                            <div class="card-header text-dark text-center">Address</div>
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-dark"> {{$order->user->address}}</h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <hr>
                        <div class="col-md-12 col-sm-12 mb-30">
                            <h2 class="mb-20 h3 text-blue text-center">Customer Delivery Information</h2>

                        </div>
                        <div class="container">
                            <div class="row">
                                {{--                                    <div class="col-md-12 col-sm-12 ">--}}
                                {{--                                        <h5 class=" h3 text-dark ">Customer Information</h5>--}}

                                {{--                                    </div>--}}

                                <div class="col-md-6 col-sm-12 mb-20">
                                    <div class="card text-white bg-light card-box">
                                        <div class="card-header text-dark text-center">Customer Delivery Name </div>
                                        <div class="card-body">
                                            <h5 class="card-title text-center text-dark"> {{isset($order->userAddress->username) ? $order->userAddress->username: 'Null'}}</h5>
                                        </div>
                                    </div>
                                </div>





                                <div class="col-md-6 col-sm-12 mb-20">
                                    <div class="card text-white bg-light card-box">
                                        <div class="card-header text-dark text-center">Customer Delivery Phone Number </div>
                                        <div class="card-body">
                                            <h5 class="card-title text-center text-dark"> {{isset($order->userAddress->phone) ? $order->userAddress->phone : 'No Phone Number'}} </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 mb-1">
                                    <div class="card text-white bg-light card-box">
                                        <div class="card-header text-dark text-center">Customer Delivery Address</div>
                                        <div class="card-body">
                                            <h5 class="card-title text-center text-dark"> {{$order->userAddress->address ?? "No Address"}}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="col-md-12 col-sm-12 mb-30">
                            <h3 class="mb-20 h4 text-blue text-center">Payment Transactions</h3>
                            <p class="mb-20  text-danger text-center">* Payment Screenshot Can Be View By Clicking It. *</p>


                        </div>
                        <div class="container">
                            <div class="row">


                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                    <tr>
                                        <th class="text-center">Sl</th>
                                        <th class="text-center">Sender</th>
                                        <th class="text-center"> Receiver</th>
                                        <th class="text-center"> Screenshot  </th>
                                        <th class="text-center">Bank Or Pay </th>
                                        <th class="text-center">Account Number </th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Date</th>




                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="text-center">{{ 1 }}</td>
                                            <td class="text-center">{{ $order->user->name }}</td>
                                            <td class="text-center"> {{$order->transaction->account->holder_name}}</td>

                                            {{-- Display the first image, or fallback to a placeholder --}}
                                            <td class="text-center">
                                                @if (!empty($order->transaction->payment_screenshot))
{{--                                                    <img src="{{url($order->transaction->payment_screenshot)}}" alt="Transaction Image" width="50">--}}
                                                    <img src="{{ url($order->transaction->payment_screenshot) }}" alt="Transaction Image" width="100"
                                                         data-toggle="modal" data-target="#imageModal" data-image="{{ url($order->transaction->payment_screenshot) }}" style="cursor: pointer;">

                                                @else
                                                    <img src="{{ asset('default-image.png') }}" alt="No Image" width="50">
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->transaction->account->bank->bank_name }}</td>

                                            <td class="text-center">{{ $order->transaction->account->account_number ?? $order->tranaction->account->paynumber }}</td>
                                            <td class="text-center">{{ number_format($order->transaction->total_price, 2) }} Ks</td>
                                            <td class="text-center">{{$order->transaction->created_at->format('Y-m-d H:i:s')}}</td>
                                        </tr>





                                    </tbody>
                                </table>
                                <!-- Bootstrap Modal for Large Image -->
                                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center">Payment Transaction Image Screenshot</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img id="modalImage" src="" alt="Large Image" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                    </div>
                </div>
            </div>

{{--                 @include('components.footer')--}}

        </div>
    </div>
</div>

{{--<div class="footer-wrap pd-20 card-box myfoot">--}}
{{--    Developed By Voom--}}
{{--</div>--}}

@endsection

@section('js')
<script type="text/javascript">


</script>
 <script>
            $(document).ready(function () {
                $('#imageModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var imageUrl = button.data('image'); // Extract image URL
                    $('#modalImage').attr('src', imageUrl); // Update modal image
                });
            });
 </script>
<script>
    let deleteOrderId = null;

    function confirmDelete(orderId) {
        deleteOrderId = orderId; // Store order ID
        $('#confirmDeleteModal').modal('show'); // Show modal
    }

    function submitDelete() {
        if (deleteOrderId) {
            document.getElementById('deleteForm_' + deleteOrderId).submit(); // Submit form
        }
    }

    // Handle Delete Confirmation Button Click
    document.getElementById("confirmDeleteBtn").addEventListener("click", function () {
        submitDelete();
    });

</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.change-status-btn', function () {
            var item = $(this).data('item'); // Retrieve data from button
            console.log("Item Data:", item); // Debugging

            var itemId = item.id;
            var itemStatus = item.status;

            var modal = $('#changeStatus');

            // Update form action
            modal.find('#statusForm').attr('action', '/admin/orders/change-status/' + itemId);

            // Update dropdown selection
            modal.find('#status').val(itemStatus);
        });
    });
</script>
@endsection
