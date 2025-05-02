@extends('layouts.app')
@section('title','POS')
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


<div class="main-container">
    <div class="pd-ltr-20">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>All Brands</h4>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Brands</li>
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
                        <h3 class="card-title text-center">All Brands</h3>

                        <!-- Button placed above the DataTable -->
                        <div class="mb-3 text-right">
                            <a href="{{route('products.create')}}" class="btn btn-primary btn-rounded">Add Product <i class="fas fa-add"></i></a>
                        </div>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <table id="datatable" class="data-table table  nowrap"> --}}

                            <thead>
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th>Product Image</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center"> Brand Name</th>
                                    <th class="text-center"> Category Name</th>
                                    <th class="text-center"> SubCategory Name</th>
                                    <th class="text-center">Video</th>


                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($products as $key => $item)

                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center">
                                        @foreach($item->images as $image)
                                        {{-- {{ $item->image ? asset($item->image) : asset('vendors/images/profile/default.avif') }} --}}

                                        <img src="{{ asset($image->path) }}" width="50" height="50" alt="image">
                                        @endforeach

                                    </td>

                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->brand->name }}</td>
                                    <td class="text-center">{{ $item->category->name }}</td>
                                    <td class="text-center">{{ $item->subcategory->name }}</td>
                                    <td> @foreach($item->videos as $video)
                                        <video src="{{ asset( $video->path) }}" width="50" height="50" controls></video>
                                        @endforeach</td>







                                    {{-- <td class="text-center">
                                        <a href="{{ route('brands.show', $item->id) }}" class="btn btn-info sm" title="View Data"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('products.edit', $item->id) }}" class="btn btn-info sm" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline-block;" id="deleteForm">

                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete()"><i class="fas fa-trash-alt"></i></button>
                                    </form>

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
                                                    Are you sure you want to delete this item
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger" onclick="submitDelete()">Delete</button>
                                                </div>
                                            </div>



                                            </td> --}}
                                            <td class="text-center">
                                                <a href="{{ route('brands.show', $item->id) }}" class="btn btn-info sm" title="View Data"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('brands.edit', $item->id) }}" class="btn btn-info sm" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                                <form action="{{ route('brands.destroy', $item->id) }}" method="POST" style="display:inline-block;" id="deleteForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" id="myBtn"><i class="fas fa-trash-alt"></i></button>
                                                </form>

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
                                                                Are you sure you want to delete this item?
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
        </div> <!-- end row -->

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
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}


<script type="text/javascript">
    //  function confirmDelete() {
    //  console.log('Showing delete confirmation modal');
    // $('#confirmDeleteModal').modal('show');

    //  }

    //  function submitDelete() {
    //  console.log('Submitting delete form');
    //  document.getElementById('deleteForm').submit();
    //  }
    $(document).ready(function() {
        console.log('hit');
        $('#confirmDeleteModal').modal('show');

        $("#myBtn").click(function() {
            console.log('hit');
            $("#confirmDeleteModal").modal();

        });
    });

</script>



@endsection

