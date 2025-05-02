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
                        <h4>All Users</h4>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Users</li>
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

                        <h4 class="card-title">All users with user role </h4>

                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">

                            <table id="datatable" class="table table-bordered dt-responsive  nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%; height: auto">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Register Date</th>
                                    <th>Order</th>
                                    <th>Amount</th>
                                    <th>Action</th>

                                </thead>


                                <tbody>
                                @php($i = 1)
                                @foreach($users as $key => $item)
                                    <tr>
                                        <td> {{ $i++}} </td>
                                        <td> <img src="{{ $item->image ? asset($item->image) : asset('vendors/images/profile/default.avif') }}" alt="{{ $item->name }}" width="80px" height="50px" />



                                        </td>
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->email }} </td>
                                        <td> {{ $item->phone }} </td>
                                        <td>{{$item->address}}</td>
                                        {{--                                    @if($item->terminate == 1)--}}
                                        {{--                                        <td><a href="#" class="btn btn-danger btn-sm" title="Edit Data" id="status">Terminate</a></td>--}}
                                        {{--                                    @else--}}
                                        {{--                                        <td><a href="#" class="btn btn-success btn-sm" title="Edit Data" id="status">Active</a></td>--}}

                                        {{--                                    @endif--}}
                                        <td>
                                            <!-- Change Status Button -->
                                            <a href="javascript:void(0)"
                                               class="btn btn-sm {{ $item->terminate == 1 ? 'btn-danger' : 'btn-success' }}"
                                               data-id="{{ $item->id }}"
                                               data-status="{{ $item->terminate }}">
                                                {{ $item->terminate == 1 ? 'Terminate' : 'Active' }}
                                            </a>

                                        </td>
                                        {{--                                       <td class="btn btn-secondary ">Active</td>--}}

                                        {{--                                    <td>{{$item->is}}</td>--}}
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->orders_count}}</td>
                                        @if(number_format($item->orders_sum_total_price) == 0)
                                            <td>{{ number_format($item->orders_sum_total_price) }}</td>
                                        @else
                                            <td>{{number_format($item->orders_sum_total_price)}} MMK</td>

                                        @endif

                                        <td>
                                            <a href=" {{route('admin.user.show',$item->id)}}" class="btn btn-info btn-sm" title="Edit Data"> <i class="fas fa-eye"></i> </a>


                                            <a href="{{route('admin.user.delete',$item->id)}}" class="btn btn-danger btn-sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                            <a href="javascript:void(0);"
                                               class="btn btn-warning btn-sm change-status-btn"
                                               data-id="{{ $item->id }}"
                                               data-name="{{ $item->name }}"
                                               data-status="{{ $item->terminate }}"
                                               data-toggle="modal"
                                               data-target="#changeStatusModal">
                                                <i class="fas fa-exchange-alt"></i> Change Status
                                            </a>


                                        </td>

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

@endsection
