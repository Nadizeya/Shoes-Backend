@extends('layouts.app')
@section('title','POS')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('src/plugins/cropperjs/dist/cropper.css')}}">
<style type="text/css">
    .image-preview {
        /* width: ; */
        /* Set the desired width */
        height: 200px !important;
        /* Set the desired height */
        /* object-fit: cover; */
        /* To maintain aspect ratio and cover the given dimensions */
        border-radius: 20%;
        /* Optional: To make the image circular */
        /* margin-top: 10px;
        margin-left: 10px; */
        margin: 0 auto;
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
         <div class="pd-ltr-20 xs-pd-20-10">
             <div class="min-height-200px">
                 <div class="page-header">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="title">
                                 <h4>User Details </h4>
                             </div>
                             <nav aria-label="breadcrumb" role="navigation">
                                 <ol class="breadcrumb">
                                     <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                     <li class="breadcrumb-item"><a href="{{route('admin.user')}}">User</a></li>
                                     <li class="breadcrumb-item active" aria-current="page">User Details {{$user->name}}</li>
                                 </ol>
                             </nav>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                         <div class="pd-20 card-box height-100-p">
                             <div class="profile-photo">
                                 <img src="{{ $user->profile ? asset($user->profile) : asset('vendors/images/profile/default.avif') }}" alt="{{ $user->name }}" class="avatar-photo">
                             </div>
                             <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
                             @if($user->terminate == 1)
                                 <p class="text-center text-danger font-18">Terminate</p>
                             @else
                                 <p class="text-center text-success font-18">Active</p>
                             @endif
                             <p class="text-center text-muted font-14">{{ $user->role }}</p>
                             <div class="profile-info card-box">
                                 <div class="row">
                                     <div class="col-md-4 col-sm-12 mb-30">

                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <h5 class="mb-20 h4 text-blue text-center">Contact Information</h5>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30 d-flex justify-content-center">

                                         <h2 class="card-title text-primary text-right text-decoration mr-10">
                                             <a href="javascript:void(0);"
                                                class="btn btn-warning btn-sm change-status-btn"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-status="{{ $user->terminate }}"
                                                data-toggle="modal"
                                                data-target="#changeStatusModal">
                                                 <i class="fas fa-exchange-alt"></i> Change Status
                                             </a>
                                         </h2>

                                         <h2 class="card-title text-primary text-right text-decoration">
                                             <a href="{{route('admin.user.delete',$user->id)}}" class="badge badge-danger"> Delete <i class="fas fa-trash"></i></a>
                                         </h2>
                                     </div>
                                 </div>
                                 <div class="row ">

                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">

                                             <div class="card-header text-dark text-center">Email Address </div>
                                             <div class="card-body">
                                                 <h5 class="card-title text-dark text-center"> {{isset($user->email) ? $user->email : 'Null'}}</h5>

                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">

                                             <div class="card-header text-dark  text-center">Phone Number </div>

                                             <div class="card-body">
                                                 <h5 class="card-title text-dark  text-center">{{isset($user->phone) ? $user->phone : 'No Phone Number'}}</h5>


                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">

                                             <div class="card-header text-dark  text-center">Birthday </div>

                                             <div class="card-body">
                                                 <h5 class="card-title text-dark text-center">{{isset($user->dob) ? $user->dob : 'Null'}}</h5>


                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row ">
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">
                                             <div class="card-header text-dark  text-center">Address </div>
                                             <div class="card-body">
                                                 <h5 class="card-title text-dark text-center "> {{isset($user->address) ? $user->address : 'No Adress'}}</h5>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">
                                             <div class="card-header text-dark text-center">Register Date </div>
                                             <div class="card-body">
                                                 <h5 class="card-title text-dark text-center">{{isset($user->created_at) ? $user->created_at: 'No Register Date'}}</h5>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-dark bg-light card-box">
                                             <div class="card-header text-center">Last Update </div>
                                             <div class="card-body">
                                                 <p class="card-title  text-center">{{isset($user->updated_at) ? $user->updated_at	: 'No Postal Code'}}</p>



                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="col-md-12 col-sm-12 mb-30">
                                     <h5 class="mb-20 h4 text-blue text-center">User-Orders</h5>

                                 </div>
                                 <div class="row ">
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">
                                             <div class="card-header text-dark  text-center">Last Order Date </div>
                                             <div class="card-body">
                                                 <h5 class="card-title text-primary text-center">
                                                     {{ $latestOrderDate ? $latestOrderDate->format('d M Y') : 'No Orders Yet' }}
                                                 </h5>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">
                                             <div class="card-header text-dark  text-center">Total Order Count </div>

                                             <div class="card-body">
                                                 <h5 class="card-title text-primary text-center">
                                                     {{$user->orders_count ?? 0}}
                                                 </h5>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">
                                             <div class="card-header text-dark  text-center">Total Order Product Count  </div>

                                             <div class="card-body">
                                                 <h5 class="card-title text-primary text-center">
                                                     {{$user->orders_sum_total_product ?? 0}}
                                                 </h5>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-12 col-sm-12 mb-30">
                                         <div class="card text-white bg-light card-box">
                                             <div class="card-header text-dark  text-center">Total Order Amount ( MMK )</div>
                                             <div class="card-body">
                                                 <h5 class="card-title text-primary text-center">
                                                     {{ number_format($user->orders_sum_total_price) }} MMK
                                                 </h5>
                                             </div>
                                         </div>

                                     </div>
                                 </div>
                                 <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                     <thead>
                                     <tr>
                                         <th class="text-center">Sl</th>
                                         <th>Order Code</th>
                                         <th class="text-center"> Customer Name </th>
                                         <th>Total Amount</th>
                                         <th>Order Date</th>
{{--                                         <th>Order Products</th>--}}
                                         <th>Product Count</th>
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
                                             <td>{{ $item->total_price }} MMK</td>
                                             <td>{{ $item->created_at->format('Y-m-d:h-m') }}</td>
                                             <td>{{$item->total_product}}</td>
{{--                                             <td>--}}
{{--                                                 <button class="btn btn-primary btn-sm view-items" data-items='@json($item->items)'>--}}
{{--                                                     View Products--}}
{{--                                                 </button>--}}
{{--                                             </td>--}}
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
                                                         <button class="dropdown-item btn btn-primary generate-voucher" type="button"  data-id="{{ $item->id }}" >
                                                             <i class="fas fa-receipt " style="color: #FFD43B;"> </i> Voucher
                                                         </button>
                                                         <button class="dropdown-item btn btn-primary  view-items" type="button"
                                                                 data-items='@json($item->items)'
                                                                 data-order-code="{{ $item->order_code }}">

                                                             <span class="micon dw dw-gift"></span> <span class="mtext">View Products</span>
                                                         </button>
                                                         <a class="dropdown-item" href="{{ route('order.show', $item->id) }}" title="Show Data"><i class="fas fa-eye"></i> View</a>
                                                         <button class="dropdown-item" type="button"
                                                                 class="btn btn-primary"
                                                                 data-toggle="modal" data-target="#changeStatus"
                                                                 data-item='{"id": "{{ $item->id }}","order_code": "{{ $item->order_code }}", "status": "{{ $item->status }}"}'>
                                                             <i class="fas fa-edit"></i> Change Status</button>
{{--                                                         <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline-block;" id="deleteForm">--}}
{{--                                                             @csrf--}}
{{--                                                             @method('DELETE')--}}
{{--                                                             <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event)"><i class="fas fa-trash-alt"></i> Delete</button>--}}
{{--                                                         </form>--}}
                                                     </div>
                                                 </div>
                                                 <!-- Bootstrap Modal -->
{{--                                                 <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">--}}
{{--                                                     <div class="modal-dialog modal-dialog-centered" role="document">--}}

{{--                                                         <div class="modal-content">--}}
{{--                                                             <div class="modal-header">--}}
{{--                                                                 <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>--}}
{{--                                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                                     <span aria-hidden="true">&times;</span>--}}
{{--                                                                 </button>--}}
{{--                                                             </div>--}}
{{--                                                             <div class="modal-body">--}}
{{--                                                                 Are you sure you want to delete this product--}}
{{--                                                             </div>--}}
{{--                                                             <div class="modal-footer">--}}
{{--                                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>--}}
{{--                                                                 <button type="button" class="btn btn-danger" onclick="submitDelete()">Delete</button>--}}
{{--                                                             </div>--}}
{{--                                                         </div>--}}
{{--                                                     </div>--}}
{{--                                                 </div>--}}
{{--                                             </td>--}}
                                         </tr>
                                     @endforeach
                                     </tbody>
                                 </table>
                             </div>
                             <!-- Change Status Modal -->
                             <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="changeStatusLabel">Change User Status</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                             </button>
                                         </div>
                                         <form id="changeStatusForm" method="POST" action="{{ route('admin.user.status.update') }}">
                                             @csrf
                                             <div class="modal-body">
                                                 <input type="hidden" name="id" id="userId">
                                                 <p>Are you sure you want to change the status of <strong id="userName"></strong>?</p>
                                                 <select name="terminate" id="userStatus" class="form-control">
                                                     <option value="0">Active</option>
                                                     <option value="1">Terminate</option>
                                                 </select>
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                 <button type="submit" class="btn btn-primary">Update Status</button>
                                             </div>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 @include('components.footer')

             </div>
         </div>
     </div>
      <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatus" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Change Status For </h5>
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

{{--     <div class="footer-wrap pd-20 mb-20 card-box text-center">--}}
{{--                    Developed By Voom--}}
{{--     </div>--}}
@endsection

@section('js')
<script src="{{asset('src/plugins/cropperjs/dist/cropper.js')}}"></script>
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
    window.addEventListener('DOMContentLoaded', function() {
        var image = document.getElementById('image');
        var cropBoxData;
        var canvasData;
        var cropper;

        $('#modal').on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                autoCropArea: 0.5
                , dragMode: 'move'
                , aspectRatio: 3 / 3
                , restore: false
                , guides: false
                , center: false
                , highlight: false
                , cropBoxMovable: false
                , cropBoxResizable: false
                , toggleDragModeOnDblclick: false
                , ready: function() {
                    cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                }
            });
        }).on('hidden.bs.modal', function() {
            cropBoxData = cropper.getCropBoxData();
            canvasData = cropper.getCanvasData();
            cropper.destroy();
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var initialImageSrc = "{{ $user->profile ? asset($user->profile) : asset('vendors/images/profile/default.avif') }}";

        var imagePreview = document.getElementById('imagePreview');
        var fileInput = document.querySelector('input[name="profile_picture"]');
        var cancelButton = document.getElementById('cancelButton');

        if (fileInput && imagePreview) {
            fileInput.addEventListener('change', function(event) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            });
        }

        if (cancelButton) {
            cancelButton.addEventListener('click', function() {
                imagePreview.src = initialImageSrc;
                fileInput.value = '';
            });
        }
    });

</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.change-status-btn', function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            var userStatus = $(this).data('status');

            console.log("User ID:", userId); // Debugging - Check if userId is retrieved
            console.log("User Status:", userStatus);

            $('#userId').val(userId);
            $('#userName').text(userName);
            $('#userStatus').val(userStatus);
        });
        $('#changeStatus').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var item = button.data('item'); // Retrieve data from button
            var itemId = item.id;
            var itemStatus = item.status;
            var orderCode=item.order_code;

            console.log("Item Data:", item); // Debugging
            console.log("Item Status:", itemStatus); // Debugging
            console.log("Code",orderCode);

            var modal = $(this);

            // Update form action
            modal.find('#statusForm').attr('action', '/admin/orders/change-status-user/' + itemId);

            // Update dropdown selection
            modal.find('#status').val(itemStatus);
            modal.find('#title').text("Change Status For " + orderCode);

        });





        $('#changeStatusForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: "{{ route('admin.user.status.update') }}",
                type: "POST",
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    if(response.success) {

                        $('#changeStatusModal').modal('hide'); // Hide modal
                        location.reload(); // Reload page to reflect changes
                    } else {
                        alert('Failed to update status.');
                    }
                }
            });
        });
    });
</script>


    // For generate Voucher
<script>
        $(document).ready(function() {
            $(document).on('click', '.generate-voucher', function() {
                var userId = $(this).data('id');
                console.log(userId);

                // Send AJAX request to generate the voucher
                $.ajax({
                    url: "{{ route('order.voucher') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: userId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Open the voucher in a new tab
                            var printWindow = window.open(response.voucher_url, '_blank');

                            // Wait for the new window to load before triggering print
                            printWindow.onload = function() {
                                printWindow.print();
                            };
                        } else {
                            alert("Failed to generate voucher.");
                        }
                    },
                    error: function() {
                        alert("An error occurred while generating the voucher.");
                    }
                });
            });
        });
</script>
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


@endsection
