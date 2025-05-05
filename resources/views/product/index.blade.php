@extends('layouts.app')

@section('title','SneakersBuy')

@section('css')
     Place any custom CSS or links here
@endsection

@section('content')
    @include('components.header')
    @include('components.right_sidebar')
    @include('components.left_sidebar')

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>All Product</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    All Product
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Export Datatable start -->
            <div class="row mb-30">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">All Products</h3>

                            <div class="mb-3 text-right">
                                <a href="{{route('products.create')}}" class="btn btn-primary btn-rounded">
                                    Add Product <i class="fas fa-add"></i>
                                </a>
                            </div>

                            <table id="datatable" class="table table-bordered dt-responsive" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Category</th>
{{--                                    <th class="text-center">Price</th>--}}
{{--                                    <th class="text-center">Discount Price</th>--}}
                                    <th class="text-center">Sell</th>
                                    <th class="text-center">Stock</th>
{{--                                    <th class="text-center">View SubProduct</th>--}}
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Updated Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($products as $key => $item)

                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('products.show', $item->id) }}">
                                                        <i class="fas fa-eye"></i> Show
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('products.edit', $item->id) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline-block;" id="deleteForm_{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"  class="dropdown-item text-danger" onclick="confirmDelete({{ $item->id }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                            Delete
                                                        </button>
                                                    </form>
{{--                                                    <form action="{{ route('products.destroy', $item->id) }}"--}}
{{--                                                          method="POST"--}}
{{--                                                          style="display:inline-block;"--}}
{{--                                                          id="deleteForm">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('DELETE')--}}
{{--                                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event)">--}}
{{--                                                            <i class="fas fa-trash-alt"></i> Delete--}}
{{--                                                        </button>--}}
{{--                                                    </form>--}}
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Delete</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this product?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-danger" onclick="submitDelete()">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Variation Image -->
                                        <td class="text-center">


                                            @if($item->variations->first()->images->first())
                                                <img src="{{ asset($item->variations->first()->images->first()->image_path) }}"
                                                     alt="Variation Image"
                                                     width="100"
                                                     height="100">
                                            @else
                                                <img src="/path/to/placeholder.png"
                                                     alt="No Variation Image"
                                                     width="100"
                                                     height="100">
                                            @endif
                                        </td>

                                        <td class="text-center">{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->total_variation_qty }}</td>
                                        <td class="text-center">{{ $item->brand->name }}</td>
                                        <td class="text-center">{{ $item->category->name }}</td>
{{--                                        <td class="text-center">{{ $item->original_price }} Ks</td>--}}
{{--                                        <td class="text-center">{{ $item->discount_price }} Ks</td>--}}
                                        <td class="text-center">{{ $item->total_sell_qty }}</td>
                                        <td class="text-center">{{ $item->total_stock_qty }}</td>
{{--                                        <td class="text-center">{{ $item->pending_qty }}</td>--}}
{{--                                        <td class="text-center"> <a href="{{route('products.create')}}" class="btn btn-sm btn-primary btn-rounded">--}}
{{--                                                View SubProducts--}}
{{--                                            </a></td>--}}
                                        <td class="text-center">{{ $item->created_at }}</td>
                                        <td class="text-center">{{ $item->updated_at }}</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Export Datatable End -->

            @include('components.footer')
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
    <!-- Datatable Setting js -->
    <script src="{{asset('vendors/scripts/datatable-setting.js')}}"></script>
    <script type="text/javascript">
        let deleteId = null; // Store the selected category id


        function confirmDelete(id) {
            deleteId = id; // Store the correct id
            console.log(deleteId);
            $('#confirmDeleteModal').modal('show'); // Show the modal
        }

        function submitDelete() {
            if (deleteId) {
                document.getElementById('deleteForm_' + deleteId).submit(); // Submit the correct form
            }
        }

    </script>


@endsection

