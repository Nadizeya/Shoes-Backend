@extends('layouts.app')

@section('css')


@section('content')
<!--  Body Wrapper -->

<!-- Sidebar Start -->
<!--  Sidebar End -->
<!--  Header Start -->
@include('components.header')
<!--  Header End -->
@include('components.right_sidebar')
@include('components.left_sidebar')

{{-- @dd($user); --}}
@section('content')
<div class="main-container">
    <div class="pd-ltr-20">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>All Cancel Orders</h4>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('order.all')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Cancel Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">All Canceled Orders</h3>
                        <div class="d-flex justify-content-end">
                            <div class="mb-3 mr-3  text-right">
                                <a href="{{route('order.all')}}" class="btn btn-outline-primary btn-rounded">All Orders </a>
                            </div>
                            <div class="mb-3 text-right">
                                <a href="{{route('order.completed')}}" class="btn btn-success btn-rounded">Delivered Orders </a>
                            </div>
                            <div class="mb-3 ml-3 text-right">
                                <a href="{{route('order.confirm')}}" class="btn btn-primary btn-rounded">Shipped Orders </a>
                            </div>
                            <div class="mb-3 ml-3 text-right">
                                <a href="{{route('order.pending')}}" class="btn btn-warning btn-rounded">Placed Orders </a>
                            </div>
                        </div>


                        <table id="datatable1" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">


                            <thead>
                            <tr>
                                <th class="text-center">Sl</th>
                                <th>Order Code</th>
                                <th class="text-center"> Customer Name </th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Product Count</th>

                                {{--                                    <th>Order Products</th>--}}
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($orders as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $item->order_code }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->total_price }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    {{--                                    <td>--}}
                                    {{--                                        <button class="btn btn-primary btn-sm view-items" data-items='@json($item->items)'>--}}
                                    {{--                                            View Products--}}
                                    {{--                                        </button>--}}
                                    {{--                                    </td>--}}
                                    <td>{{$item->total_product}}</td>

                                    @if ($item->status == "placed")
                                        <td>
                                            <button class="btn btn-warning btn-sm view-items" data-items='@json($item->items)'>
                                                {{$item->status}}
                                            </button>
                                        </td>

                                    @elseif (($item->status == "shipped"))
                                        <td>
                                            <button class="btn btn-primary btn-sm view-items" data-items='@json($item->items)'>
                                                {{$item->status}}
                                            </button>
                                        </td>

                                    @elseif (($item->status == "delivered"))
                                        <td>
                                            <button class="btn btn-success btn-sm view-items" data-items='@json($item->items)'>
                                                {{$item->status}}
                                            </button>
                                        </td>
                                    @elseif (($item->status == "cancel"))
                                        <td>
                                            <button class="btn btn-danger btn-sm view-items" data-items='@json($item->items)'>
                                                {{$item->status}}
                                            </button>
                                        </td>
                                    @endif
                                    <td class="text-center">

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeStatus"     data-item='{"id": "{{ $item->id }}", "status": "{{ $item->status }}"}'>
                                                    <i class="fas fa-receipt " style="color: #FFD43B;"> </i> Voucher</button>
                                                <button class="dropdown-item btn btn-primary  view-items" type="button"
                                                        data-items='@json($item->items)'
                                                        data-order-code="{{ $item->order_code }}">

                                                    <span class="micon dw dw-gift"></span> <span class="mtext">View Products</span>
                                                </button>
                                                <a class="dropdown-item" href="{{ route('order.show', $item->id) }}" title="Show Data"><i class="fas fa-eye"></i> View</a>
                                                <button class="dropdown-item" type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeStatus"     data-item='{"id": "{{ $item->id }}", "status": "{{ $item->status }}"}'>
                                                    <i class="fas fa-edit"></i> Change Status</button>
                                                @if ($item->status == 'cancel')
                                                    <form action="{{ route('order.destroy', $item->id) }}" method="POST" style="display:inline-block;" id="deleteForm_{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $item->id }})">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                                {{--                                                <form action="{{ route('order.destroy', $item->id) }}" method="POST" style="display:inline-block;" id="deleteForm">--}}
                                                {{--                                                    @csrf--}}
                                                {{--                                                    @method('DELETE')--}}
                                                {{--                                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event)"><i class="fas fa-trash-alt"></i> Delete</button>--}}
                                                {{--                                                </form>--}}
                                            </div>
                                        </div>
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
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>

    <!-- Modal for displaying order items -->
    <div class="modal fade" id="orderItemsModal" tabindex="-1" role="dialog" aria-labelledby="orderItemsModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderItemsModalLabel">Order Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Images</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Product Price</th>
                            <th>Total Price</th>
                        </tr>
                        </thead>
                        <tbody id="orderItemsBody">
                        <!-- Items will be injected here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatus" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Change Status</h5>
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

    @endsection

    @section('js')
        <!-- Responsive examples -->
        <script src="{{ asset('assets/datatable/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

        <script src="{{ asset('assets/datatable/lib/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>



        <script src="{{ asset('assets/datatable/js/datatables.init.js') }}"></script>




        <!-- buttons for Export datatable -->
        <script src="{{asset('src/plugins/datatables/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('src/plugins/datatables/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('src/plugins/datatables/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('src/plugins/datatables/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('src/plugins/datatables/js/buttons.flash.min.js')}}"></script>
        <script src="{{asset('src/plugins/datatables/js/pdfmake.min.js')}}"></script>
        <script src="{{asset('src/plugins/datatables/js/vfs_fonts.js')}}"></script>
        <script src="{{ asset('src/plugins/datatables/js/jszip.min.js') }}"></script>
        <!-- Datatable Setting js -->
        <script src="{{asset('vendors/scripts/datatable-setting.js')}}"></script>
        <script>
            $(document).ready(function () {
                $(document).on('click', '.view-items', function () {
                    const items = $(this).data('items'); // Get items from button
                    console.log("Items:", items); // Debugging
                    const orderCode = $(this).data('order-code'); // Get Order Code

                    const $orderItemsBody = $('#orderItemsBody');
                    const $orderItemsHeader = $("#orderItemsModalLabel");

                    $orderItemsBody.empty(); // Clear previous data

                    let i = 1;
                    let subtotal = 0; // Initialize subtotal

                    if (!items || items.length === 0) {
                        $orderItemsBody.append(`
                <tr>
                    <td colspan="6" class="text-center">No items found</td>
                </tr>
            `);
                    } else {
                        items.forEach(item => {
                            let productName = item.variation && item.variation.product
                                ? item.variation.product.name
                                : 'Unknown Product';

                            let size = item.variation ? item.variation.size : 'N/A';
                            let price1 = item.price ? (item.price * item.quantity).toFixed(2) : 'N/A';

                            let price = item.price ? parseFloat(item.price) : 0;

                            let totalPrice = price * item.quantity; // Calculate total price per product
                            subtotal += totalPrice; // Add to subtotal

                            let images = item.variation && item.variation.images.length
                                ? item.variation.images.map(img => `<img src="${img.full_image_path}" width="50">`).join(' ')
                                : 'No Image';

                            $orderItemsBody.append(`
                    <tr>
                        <td>${i++}</td>
                        <td>${productName}</td>
                        <td>${images}</td>
                        <td>${size}</td>
                        <td>${item.quantity}</td>
                        <td>${price} MMK</td>
                        <td>${totalPrice.toFixed(2)} MMK</td>
                    </tr>
                `);
                        });

                        // Add Subtotal row at the end
                        $orderItemsBody.append(`
                <tr>
                    <td colspan="6" class="text-right"><strong>Subtotal:</strong></td>
                    <td><strong>${subtotal.toFixed(2)} MMK</strong></td>
                </tr>
            `);
                    }
                    $orderItemsHeader.text(`Order Products For  ${orderCode}`);


                    // Show the modal
                    $('#orderItemsModal').modal('show');
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

        <script type="text/javascript">
            $('#datatable1').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Order Exported data', // Title for Excel
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the last column (Action)
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the last column (Action)
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Order Exported data',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the last column (Action)
                        }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, -1], // Page lengths (use -1 for "All")
                    [10, 25, 50, "All"] // Labels for dropdown
                ],
                pageLength: 10, // Default page length
                responsive: true,
                processing: true,
                paging: true,
            });
            // function confirmDelete() {
            //     $('#confirmDeleteModal').modal('show');
            // }

            $('#changeStatus').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var item = button.data('item'); // Retrieve data from button
                var itemId = item.id;
                var itemStatus = item.status;

                console.log("Item Data:", item); // Debugging
                console.log("Item Status:", itemStatus); // Debugging

                var modal = $(this);

                // Update form action
                modal.find('#statusForm').attr('action', '/admin/orders/change-status/' + itemId);

                // Update dropdown selection
                modal.find('#status').val(itemStatus);
            });
            // function submitDelete() {
            //     document.getElementById('deleteForm').submit();
            // }
            // function submitChange() {
            //     document.getElementById('deleteForm').submit();
            // }



        </script>

@endsection
