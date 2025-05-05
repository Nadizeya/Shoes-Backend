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
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>Brand</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('brands.index')}}">Brand</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show Brand</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">

                                </div>


                                <div class="col-md-4 col-sm-12 ">
                                    <h5 class=" h3 text-dark text-center">Brand Details</h5>

                                </div>
                                <div class="col-md-4 col-sm-12 ">

                                    <h2 class="card-title text-primary text-right text-decoration">
                                        <a href="{{ route('brands.edit', $brand->id) }}" class="badge badge-primary"> Edit <i class="fas fa-edit"></i></a>

                                    </h2>


                                </div>



                            </div>

                            {{-- <h5 class="mb-20 h4 text-blue text-center">Show Brand Details</h5> --}}
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


                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Brand Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Brand" name="name" value="{{ $brand->name }} " readonly>
                                            <div class="input-group-append custom">
                                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Brand Image</span>
                                            </div>
                                            @if($brand->image)
                                        <div class="image-container">
                                            <img src="{{ asset($brand->image)}}" class="rounded avatar-lg" alt="Brand Image">
                                        </div>
                                        @else
                                        <div class="image-container">
                                            <img src="{{ asset('/upload/no_image.jpg')}}" class="rounded avatar-lg" alt="Default Image">
                                        </div>
                                        @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12" id="imagePreviewContainer">
                                    {{-- </div> --}}

                                </div>
                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-wrap pd-20 card-box myfoot">
    Developed By Voom
</div>

@endsection

@section('js')
<script type="text/javascript">
    // $(document).ready(function() {
    //     var filesArray = [];
    //     var defaultImagePath = "{{ asset('/upload/no_image.jpg')}}";



    //     $('#image').change(function(e) {
    //         $('#imagePreviewContainer').empty(); // Clear previous images
    //         filesArray = Array.from(e.target.files);

    //         if (filesArray.length === 0) {
    //             showDefaultImage();
    //         } else {
    //             filesArray.forEach((file, index) => {
    //                 var reader = new FileReader();
    //                 reader.onload = function(e) {
    //                     var imgContainer = $('<div>').attr('class', 'image-container');
    //                     var img = $('<img>').attr('src', e.target.result).attr('class', 'rounded avatar-lg');
    //                     var deleteIcon = $('<span>').attr('class', 'delete-icon').html('&times;');

    //                     deleteIcon.click(function() {
    //                         imgContainer.remove();
    //                         filesArray = filesArray.filter(f => f !== file);
    //                         updateInputField();
    //                         if (filesArray.length === 0) {
    //                             showDefaultImage();
    //                         }
    //                     });

    //                     imgContainer.append(img).append(deleteIcon);
    //                     $('#imagePreviewContainer').append(imgContainer);
    //                 }
    //                 reader.readAsDataURL(file);
    //             });
    //         }
    //     });

    //     function showDefaultImage() {
    //         var imgContainer = $('<div>').attr('class', 'image-container');
    //         var img = $('<img>').attr('src', defaultImagePath).attr('class', 'rounded avatar-lg');
    //         imgContainer.append(img);
    //         $('#imagePreviewContainer').append(imgContainer);
    //     }

    //     function updateInputField() {
    //         var dataTransfer = new DataTransfer();
    //         filesArray.forEach(file => dataTransfer.items.add(file));
    //         $('#image')[0].files = dataTransfer.files;
    //     }

    //     // Show default image on page load
    //     showDefaultImage();
    // });

</script>
@endsection
