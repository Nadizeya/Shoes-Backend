@extends('layouts.app')
{{-- @section('title','POS') --}}
@section('css')
<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 10px;
    }

    .delete-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        background: red;
        color: white;
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        /* Adjust font size to fit within the circle */
    }

    .avatar-lg {
        width: 100px;
        height: 100px;
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
                                <li class="breadcrumb-item active" aria-current="page">Add Brand</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Add Brand</h5>
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

                        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Brand Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Brand" name="name" value="{{ old('name') }}">
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
                                            <input name="image" class="form-control" type="file" id="image" multiple="">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12" id="imagePreviewContainer">
                                        {{-- <!-- Display default image if no image is selected -->
                                        <div class="image-container">
                                            <img src="{{ asset('/upload/no_image.jpg')}}" class="rounded avatar-lg" alt="Default Image">
                                        </div> --}}
                                   </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12 mb-30"></div>
                                <div class="col-md-4 col-sm-12 mb-30">
                                    <button type="submit" class="btn btn-primary m0">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-wrap pd-20 mb-20 card-box">
    Developed By Nay Oo Lwin
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var filesArray = [];
        var defaultImagePath = "{{ asset('/upload/no_image.jpg')}}";



        $('#image').change(function(e) {
            $('#imagePreviewContainer').empty(); // Clear previous images
            filesArray = Array.from(e.target.files);

            if (filesArray.length === 0) {
                showDefaultImage();
            } else {
                filesArray.forEach((file, index) => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imgContainer = $('<div>').attr('class', 'image-container');
                        var img = $('<img>').attr('src', e.target.result).attr('class', 'rounded avatar-lg');
                        var deleteIcon = $('<span>').attr('class', 'delete-icon').html('&times;');

                        deleteIcon.click(function() {
                            imgContainer.remove();
                            filesArray = filesArray.filter(f => f !== file);
                            updateInputField();
                            if (filesArray.length === 0) {
                                showDefaultImage();
                            }
                        });

                        imgContainer.append(img).append(deleteIcon);
                        $('#imagePreviewContainer').append(imgContainer);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });

        function showDefaultImage() {
            var imgContainer = $('<div>').attr('class', 'image-container');
            var img = $('<img>').attr('src', defaultImagePath).attr('class', 'rounded avatar-lg');
            imgContainer.append(img);
            $('#imagePreviewContainer').append(imgContainer);
        }

        function updateInputField() {
            var dataTransfer = new DataTransfer();
            filesArray.forEach(file => dataTransfer.items.add(file));
            $('#image')[0].files = dataTransfer.files;
        }

        // Show default image on page load
        showDefaultImage();
    });

</script>
@endsection
