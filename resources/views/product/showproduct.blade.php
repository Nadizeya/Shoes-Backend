{{--@extends('layouts.app')--}}
{{--@section('title', 'Edit Product')--}}
{{--@section('css')--}}
{{--<style>--}}
{{--    .image-container,--}}
{{--    .video-container {--}}
{{--        position: relative;--}}
{{--        display: inline-block;--}}
{{--        margin: 10px;--}}
{{--    }--}}

{{--    .delete-icon {--}}
{{--        position: absolute;--}}
{{--        top: 10px;--}}
{{--        right: 10px;--}}
{{--        background: red;--}}
{{--        color: white;--}}
{{--        border-radius: 50%;--}}
{{--        padding: 5px;--}}
{{--        cursor: pointer;--}}
{{--        width: 20px;--}}
{{--        height: 20px;--}}
{{--        display: flex;--}}
{{--        align-items: center;--}}
{{--        justify-content: center;--}}
{{--        font-size: 14px;--}}
{{--    }--}}

{{--    .video-media-preview {--}}
{{--        width: 250px;--}}
{{--        height: 250px;--}}
{{--    }--}}

{{--    .image-media-preview {--}}
{{--        width: 100px;--}}
{{--        height: 100px;--}}
{{--    }--}}

{{--</style>--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--@include('components.header')--}}
{{--@include('components.right_sidebar')--}}
{{--@include('components.left_sidebar')--}}

{{--<div class="main-container">--}}
{{--    <div class="pd-ltr-20 xs-pd-20-10">--}}
{{--        <div class="min-height-200px">--}}
{{--            <div class="page-header">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="title">--}}
{{--                            <h4>Product</h4>--}}
{{--                        </div>--}}
{{--                        <nav aria-label="breadcrumb">--}}
{{--                            <ol class="breadcrumb">--}}
{{--                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Product</a></li>--}}
{{--                                <li class="breadcrumb-item active" aria-current="page">Show Product</li>--}}
{{--                            </ol>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row">--}}
{{--                <div class="col-12 mb-30">--}}
{{--                    <div class="pd-20 card-box height-100-p">--}}
{{--                        <div class="profile-info card-box">--}}
{{--                            --}}{{-- <h5 class="mb-20 h4 text-blue text-center">Show Product</h5> --}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-4 col-sm-12">--}}

{{--                                </div>--}}


{{--                                <div class="col-md-4 col-sm-12 ">--}}
{{--                                    <h5 class=" h3 text-dark text-center">Product Details</h5>--}}

{{--                                </div>--}}
{{--                                <div class="col-md-4 col-sm-12 ">--}}

{{--                                    <h2 class="card-title text-primary text-right text-decoration">--}}
{{--                                        <a href="{{ route('products.edit', $product->id) }}" class="badge badge-primary"> Edit <i class="fas fa-edit"></i></a>--}}

{{--                                    </h2>--}}


{{--                                </div>--}}



{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <br>--}}
{{--                        @if ($errors->any())--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <ul>--}}
{{--                                @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        @endif--}}

{{--                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            @method('PUT')--}}
{{--                            <div class="container">--}}
{{--                                <div class="row">--}}
{{--                                    --}}{{-- Name --}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Product Name</span>--}}
{{--                                            </div>--}}
{{--                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->name }}" readonly >--}}
{{--                                            <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    --}}{{-- Brand --}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Brand</span>--}}
{{--                                            </div>--}}
{{--<input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product['brand']['name'] }}" readonly >--}}

{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    --}}{{-- Category --}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Category</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product['category']['name'] }}" readonly >--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Quantity</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->quantity}}" readonly >--}}
{{--                                             <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy  dw dw-shopping-cart1"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Stock</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->instock}}" readonly >--}}
{{--                                             <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy  dw dw-shopping-cart1"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Sell</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->sell_qty}}" readonly >--}}
{{--                                             <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy  dw dw-shopping-cart1"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Pending Stock</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->pending_qty}}" readonly >--}}
{{--                                            <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy  dw dw-shopping-cart1"></i></span>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Orignal Price</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->original_price}} Ks" readonly >--}}
{{--                                           <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy dw dw-money"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                      <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">isDiscount</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->is_discount}} " readonly >--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Discount Price</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->discount_price}} Ks" readonly >--}}
{{--                                           <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy dw dw-money"></i></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Discount Percentage</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->discount_percent}} %" readonly >--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Is Recommend </span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->is_recommend}} " readonly >--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


{{--                                    --}}{{-- Sub Category --}}
{{--                                    --}}{{-- <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Sub-Category</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product['subcategory']['name'] }}" readonly >--}}
{{--                                        </div>--}}
{{--                                    </div> --}}

{{--                                    --}}{{-- Short Description --}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group html-editor custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Short Description</span>--}}
{{--                                            </div>--}}
{{--                                           <input type="text" class="form-control form-control-lg" placeholder="Null" name="name" value="{{ $product->short_description }}" readonly >--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    --}}{{-- Product Description --}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Description</span>--}}
{{--                                            </div>--}}
{{--                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Product Name" name="name" value="{{ $product->description}}" readonly >--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    --}}{{-- Product Image --}}
{{--                                    <div class="col-md-12 col-12 card card-box mb-2">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Product Image</span>--}}
{{--                                            </div>--}}
{{--                                            --}}{{-- <input type="file" class="form-control" id="images" name="images[]" multiple> --}}
{{--                                             <div class="col-md-9 row">--}}
{{--                                        <div id="imagePreviewContainer" class="col-md-12">--}}
{{--                                            @foreach($product->images as $image)--}}
{{--                                            <div class="image-container">--}}
{{--                                                <img src="{{ asset($image->path) }}" class="image-media-preview" />--}}
{{--                                                --}}{{-- <span class="delete-icon" data-id="{{ $image->id }}">&times;</span> --}}
{{--                                            </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


{{--                                    --}}{{-- Product Video --}}
{{--                                    <div class="col-md-12 col-12 card card-box">--}}
{{--                                        <div class="input-group custom">--}}
{{--                                            <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Product Video</span>--}}
{{--                                            </div>--}}
{{--                                             <div class="col-md-9 row">--}}
{{--                                        <div id="videoPreviewContainer">--}}
{{--                                            @foreach($product->videos as $video)--}}
{{--                                            <div class="video-container">--}}
{{--                                                <video src="{{ asset($video->path) }}" class="video-media-preview" controls></video>--}}
{{--                                                --}}{{-- <span class="delete-icon" data-id="{{ $video->id }}">&times;</span> --}}
{{--                                            </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                            --}}{{-- <input type="file" class="form-control" id="videos" name="videos[]" multiple> --}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            --}}{{-- <div class="row">--}}
{{--                                <div class="col-md-4 col-sm-12 mb-30"></div>--}}
{{--                                <div class="col-md-4 col-sm-12 mb-30">--}}
{{--                                    <button type="submit" class="btn btn-primary m0">Update</button>--}}
{{--                                </div>--}}
{{--                            </div> --}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="footer-wrap pd-20 mb-20 card-box">--}}
{{--    Developed By Voom--}}
{{--</div>--}}

{{--@endsection--}}

{{--@section('js')--}}
{{--<script src="{{ asset('/assets/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>--}}

{{--<script type="text/javascript">--}}


{{--    $(document).ready(function() {--}}
{{--    var imageFilesArray = [];--}}
{{--    var videoFilesArray = [];--}}

{{--    $('#images').change(function(e) {--}}
{{--    $('#imagePreviewContainer').empty();--}}
{{--    imageFilesArray = Array.from(e.target.files);--}}
{{--    previewFiles(imageFilesArray, '#imagePreviewContainer', 'image');--}}
{{--    });--}}

{{--    $('#videos').change(function(e) {--}}
{{--    $('#videoPreviewContainer').empty();--}}
{{--    videoFilesArray = Array.from(e.target.files);--}}
{{--    previewFiles(videoFilesArray, '#videoPreviewContainer', 'video');--}}
{{--    });--}}



{{--    function previewFiles(files, container, type) {--}}
{{--    files.forEach((file, index) => {--}}
{{--    var reader = new FileReader();--}}
{{--    reader.onload = function(e) {--}}
{{--    var mediaContainer = $('<div>').attr('class', type + '-container image-container');--}}
{{--        var media;--}}
{{--        if (type === 'image') {--}}
{{--        media = $('<img>').attr('src', e.target.result).attr('class', 'image-media-preview');--}}
{{--        } else {--}}
{{--        media = $('<video>').attr('src', e.target.result).attr('class', 'video-media-preview').attr('controls', true);--}}
{{--            }--}}
{{--            var deleteIcon = $('<span>').attr('class', 'delete-icon').html('&times;');--}}

{{--                deleteIcon.click(function() {--}}
{{--                mediaContainer.remove();--}}
{{--                if (type === 'image') {--}}
{{--                imageFilesArray = imageFilesArray.filter(f => f !== file);--}}
{{--                updateInputField('#images', imageFilesArray);--}}
{{--                } else {--}}
{{--                videoFilesArray = videoFilesArray.filter(f => f !== file);--}}
{{--                updateInputField('#videos', videoFilesArray);--}}
{{--                }--}}
{{--                });--}}

{{--                mediaContainer.append(media).append(deleteIcon);--}}
{{--                $(container).append(mediaContainer);--}}
{{--                }--}}
{{--                reader.readAsDataURL(file);--}}
{{--                });--}}
{{--                }--}}

{{--                function updateInputField(selector, files) {--}}
{{--                var dataTransfer = new DataTransfer();--}}
{{--                files.forEach(file => dataTransfer.items.add(file));--}}
{{--                $(selector)[0].files = dataTransfer.files;--}}
{{--                }--}}
{{--                });--}}
{{--</script>--}}
{{--@endsection--}}


@extends('layouts.app')
@section('title', 'Show Product')

@section('css')
    <style>
        .image-media-preview, .video-media-preview {
            margin: 5px;
        }
        .image-media-preview {
            width: 100px; height: 100px; object-fit: cover;
        }
        .video-media-preview {
            width: 120px; height: 100px;
        }
    </style>
@endsection

@section('content')
    @include('components.header')
    @include('components.right_sidebar')
    @include('components.left_sidebar')

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h4>Show Product</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('products.index') }}">Product</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Show Product
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="row">
                    <div class="col-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="profile-info card-box">
                                <h5 class="mb-20 h4 text-blue text-center">Product Details</h5>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <!-- Product Name -->
                                    <div class="col-md-6 col-6">
                                        <div class="form-group custom">
                                            <label>Product Name:</label>
                                            <p class="form-control-static">{{ $product->name }}</p>
                                        </div>
                                    </div>

                                    <!-- Brand -->
                                    <div class="col-md-6 col-6">
                                        <div class="form-group custom">
                                            <label>Brand Name :</label>
                                            <p class="form-control-static">
                                                {{ optional($product->brand)->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr />

                                    <!-- Category -->
                                    <div class="col-md-6 col-6">
                                        <div class="form-group custom">
                                            <label>Category Name:</label>
                                            <p class="form-control-static">
                                                {{ optional($product->category)->name }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Recommended? -->
                                    <div class="col-md-6 col-12">
                                        <label>Recommend:</label>
                                        <p class="form-control-static">
                                            {{ $product->is_recommend ? 'Yes' : 'No' }}
                                        </p>
                                    </div>

                                    <!-- Short Description -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group custom">
                                            <label>Short Description:</label>
                                            <p class="form-control-static">{{ $product->short_description }}</p>
                                        </div>
                                    </div>

                                    <!-- Full Description -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group custom">
                                            <label>Details:</label>
                                            <p class="form-control-static">{{ $product->description }}</p>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <h4>Product Variations</h4>

                                @forelse($product->variations as $index => $variation)
                                    <div class="card mb-3 p-3">
                                        <div class="row">
                                            <!-- Variation Size -->
                                            <div class="col-md-4">
                                                <label>Size:</label>
                                                <p class="form-control-static">
                                                    {{ $variation->size }}
                                                </p>
                                            </div>
                                            <!-- Variation Quantity -->
                                            <div class="col-md-4">
                                                <label>Quantity:</label>
                                                <p class="form-control-static">
                                                    {{ $variation->quantity }}
                                                </p>
                                            </div>
                                            <!-- Variation Price -->
                                            <div class="col-md-4">
                                                <label>Price:</label>
                                                <p class="form-control-static">
                                                    {{ $variation->price }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Variation Images -->
                                        @if($variation->images->count() > 0)
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label>Images:</label><br>
                                                    @foreach($variation->images as $img)
                                                        <img src="{{ asset($img->image_path) }}"
                                                             alt="Variation Image"
                                                             class="image-media-preview">
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Variation Videos -->
                                        @if($variation->videos->count() > 0)
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label>Videos:</label><br>
                                                    @foreach($variation->videos as $vid)
                                                        <video src="{{ asset($vid->video_path) }}"
                                                               class="video-media-preview"
                                                               controls></video>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p>No variations found for this product.</p>
                                @endforelse

                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        Developed By Voom
    </div>
@endsection
@section('js')


    {{-- <script src="https://cdn.tiny.cloud/1/7xkub943gzs7fr7f752zgwk0nuy67fopaxuhxh0qaavr14xt/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> --}}
    <script src="{{asset('/assets/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>

    <!-- =============================== -->
    <!-- JavaScript for dynamic block handling -->
    <!-- =============================== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let variationIndex = 0;

            const variationContainer = document.getElementById('variation-container');
            const variationTemplate = document.getElementById('variation-template').innerHTML;
            const addVariationBtn = document.getElementById('add-variation-btn');

            // ========== 1) ADD VARIATION BLOCK ==========
            addVariationBtn.addEventListener('click', () => {
                addVariationBlock();
            });

            // Optionally add 1 initial block on page load
            addVariationBlock();

            function addVariationBlock() {
                // Replace 'INDEX' with the current variationIndex
                const newBlockHtml = variationTemplate.replace(/INDEX/g, variationIndex);

                // Convert to DOM
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newBlockHtml;
                const variationBlock = tempDiv.firstElementChild;

                // Append to container
                variationContainer.appendChild(variationBlock);

                // Link up event handlers for images / videos
                const imageInput = variationBlock.querySelector('.variation-images-input');
                const videoInput = variationBlock.querySelector('.variation-videos-input');

                imageInput.addEventListener('change', handleImagesPreview);
                videoInput.addEventListener('change', handleVideosPreview);

                // Handle removing the entire variation block
                const removeBlockBtn = variationBlock.querySelector('.remove-variation-btn');
                removeBlockBtn.addEventListener('click', () => variationBlock.remove());

                // Increment for next block
                variationIndex++;
            }

            // ========== 2) PREVIEW IMAGES ==========
            function handleImagesPreview(e) {
                const input = e.target;
                const previewContainer = input
                    .closest('.col-md-6')
                    .querySelector('.images-preview');

                // Clear old previews
                previewContainer.innerHTML = '';

                const files = Array.from(input.files); // array of File objects
                files.forEach((file, index) => {
                    if (!file.type.startsWith('image/')) return;

                    const fileURL = URL.createObjectURL(file);

                    // Create a wrapper for the preview + remove button
                    const wrapper = createPreviewWrapper(fileURL, 'img', file, index, input);
                    previewContainer.appendChild(wrapper);
                });
            }

            // ========== 3) PREVIEW VIDEOS ==========
            function handleVideosPreview(e) {
                const input = e.target;
                const previewContainer = input
                    .closest('.col-md-6')
                    .querySelector('.videos-preview');

                // Clear old previews
                previewContainer.innerHTML = '';

                const files = Array.from(input.files);
                files.forEach((file, index) => {
                    if (!file.type.startsWith('video/')) return;

                    const fileURL = URL.createObjectURL(file);

                    // Create a wrapper for the preview + remove button
                    const wrapper = createPreviewWrapper(fileURL, 'video', file, index, input);
                    previewContainer.appendChild(wrapper);
                });
            }

            // ========== 4) HELPER: CREATE PREVIEW WRAPPER ==========
            function createPreviewWrapper(fileURL, mediaType, fileObj, fileIndex, inputElem) {
                // Container
                const previewWrapper = document.createElement('div');
                previewWrapper.style.display = 'inline-block';
                previewWrapper.style.position = 'relative';
                previewWrapper.style.marginRight = '10px';

                let previewEl;
                if (mediaType === 'img') {
                    // Image
                    previewEl = document.createElement('img');
                    previewEl.src = fileURL;
                    previewEl.style.width = '100px';
                    previewEl.style.height = '100px';
                    previewEl.style.objectFit = 'cover';
                } else {
                    // Video
                    previewEl = document.createElement('video');
                    previewEl.src = fileURL;
                    previewEl.style.width = '120px';
                    previewEl.style.height = '100px';
                    previewEl.controls = true;
                }

                // Remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.textContent = '×';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '0';
                removeBtn.style.backgroundColor = 'red';
                removeBtn.style.color = '#fff';
                removeBtn.style.border = 'none';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.width = '25px';
                removeBtn.style.height = '25px';
                removeBtn.style.cursor = 'pointer';

                // On click, remove this file from preview + input
                removeBtn.addEventListener('click', () => {
                    previewWrapper.remove();
                    removeFileFromInput(inputElem, fileIndex);
                });

                previewWrapper.appendChild(previewEl);
                previewWrapper.appendChild(removeBtn);
                return previewWrapper;
            }

            // ========== 5) REMOVE FILE FROM THE INPUT FILELIST ==========
            function removeFileFromInput(input, indexToRemove) {
                // Convert FileList to array
                const dt = new DataTransfer();
                const filesArray = Array.from(input.files);

                filesArray.forEach((file, idx) => {
                    if (idx !== indexToRemove) {
                        dt.items.add(file);
                    }
                });
                input.files = dt.files;
            }
        });
    </script>


    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea#description',
            height: 300,
            menubar: false,
            statusbar: false,
            forced_root_block: '',



            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],

            toolbar: 'undo redo | formatselect | bold italic backcolor | \
 alignleft aligncenter alignright alignjustify | \
 bullist numlist outdent indent | removeformat | help'
        });

        $(document).ready(function() {
            var imageFilesArray = [];
            var videoFilesArray = [];
            var imagesVariationArray=[];

            $('#images').change(function(e) {
                $('#imagePreviewContainer').empty();
                imageFilesArray = Array.from(e.target.files);
                previewFiles(imageFilesArray, '#imagePreviewContainer', 'image');
            });
            $('#images_variation').change(function(e) {
                $('#imagePreviewContainerVariation').empty();
                imagesVariationArray = Array.from(e.target.files);
                previewFiles(imageFilesArray, '#imagePreviewContainerVariation', 'image');
            });


            $('#videos').change(function(e) {
                $('#videoPreviewContainer').empty();
                videoFilesArray = Array.from(e.target.files);
                previewFiles(videoFilesArray, '#videoPreviewContainer', 'video');
            });
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            document.getElementById('addRow').addEventListener('click', function () {
                const tableBody = document.getElementById('tableBody');
                const newRow = `
                <tr>
                    <td><input type="number" name="price[]" class="form-control" placeholder="Enter Price" required></td>
                    <td><input type="file" id="images_variation" name="images_variation[]" class="form-control" placeholder="Image" accept="image/*" required>
                         <div class="col-md-6 col-12 row">
                                                            <div id="imagePreviewContainerVariation" class="col-md-12"></div>
                                                        </div>
                    </td>
                    <td><input type="number" name="qty[]" class="form-control" placeholder="Enter Quantity" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"> <span class="micon dw dw-trash1"></span></button></td>
                </tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);
            });

            // Event delegation for dynamically added remove buttons
            document.getElementById('productTable').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-row')) {
                    const row = event.target.closest('tr');
                    row.remove();
                }
            });



            $('#category_id').change(function() {
                var categoryId = $(this).val();

                // Clear existing subcategory options
                $('#subcategory_id').empty().append(new Option('There is no sub category for this category'
                    , '', false, false)).prop('disabled', true);

                $.ajax({
                    url: '{{route('subcategories.fetch')}}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    method: 'POST',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('#subcategory_id').empty();

                        if (response.subcategories.length > 0) {
                            // Populate subcategory dropdown
                            $.each(response.subcategories, function(index, subcategory) {
                                $('#subcategory_id').append(new Option(subcategory.name
                                    , subcategory.id));
                            });
                            $('#subcategory_id').prop('disabled', false);
                        } else {
                            // Handle no subcategories
                            $('#subcategory_id').append(new Option('No subcategories available'
                                , '', true, true)).prop('disabled', true);
                        }
                    },
                    // error: function(xhr) {
                    //     alert(xhr.responseJSON.message || 'An error occurred');
                    // }
                });
            });

            function previewFiles(files, container, type) {
                files.forEach((file, index) => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var mediaContainer = $('<div>').attr('class', type +
                            '-container image-container');
                        var media;
                        if (type === 'image') {
                            media = $('<img>').attr('src', e.target.result).attr('class'
                                , 'image-media-preview');
                        } else {
                            media = $('<video>').attr('src', e.target.result).attr('class'
                                , 'video-media-preview').attr('controls', true);
                        }
                        var deleteIcon = $('<span>').attr('class', 'delete-icon').html('&times;');

                        deleteIcon.click(function() {
                            mediaContainer.remove();
                            if (type === 'image') {
                                imageFilesArray = imageFilesArray.filter(f => f !== file);
                                updateInputField('#images', imageFilesArray);
                            } else {
                                videoFilesArray = videoFilesArray.filter(f => f !== file);
                                updateInputField('#videos', videoFilesArray);
                            }
                        });

                        mediaContainer.append(media).append(deleteIcon);
                        $(container).append(mediaContainer);
                    }
                    reader.readAsDataURL(file);
                });
            }

            function updateInputField(selector, files) {
                var dataTransfer = new DataTransfer();
                files.forEach(file => dataTransfer.items.add(file));
                $(selector)[0].files = dataTransfer.files;
            }
        });

        // percentage and dicount
        // Function to calculate discount price based on original price and discount percent
        function calculateDiscountPrice() {
            var originalPrice = parseInt(document.getElementById('originalPrice').value) || 0;
            var discountPercent = parseInt(document.getElementById('discountPercent').value) || 0;

            if (discountPercent > 0 && originalPrice > 0) {
                var discountPrice = originalPrice - (originalPrice * (discountPercent / 100));
                document.getElementById('discountPrice').value = Math.floor(discountPrice);
            } else {
                // Reset discount price to 0 if percent is cleared
                document.getElementById('discountPrice').value = 0;
            }
        }

        // Function to calculate discount percent based on original price and discount price
        function calculateDiscountPercent() {
            var originalPrice = parseInt(document.getElementById('originalPrice').value) || 0;
            var discountPrice = parseInt(document.getElementById('discountPrice').value) || 0;

            if (discountPrice > 0 && originalPrice > 0) {
                var discountPercent = Math.floor(((originalPrice - discountPrice) / originalPrice) * 100);
                document.getElementById('discountPercent').value = discountPercent;
            } else {
                // Reset discount percentage to 0 if discount price is cleared
                document.getElementById('discountPercent').value = 0;
            }
        }

        // Function to handle the display and reset of discount fields
        function handleDiscountSelection() {
            const discountYes = document.getElementById('isDiscountYes');
            const discountNo = document.getElementById('isDiscountNo');
            // const discountFields = document.getElementById('discountFields');
            const discountPercentFields = document.getElementById('discountPercentField');
            const discountPriceFields = document.getElementById('discountPriceField');
            const discountPercent = document.getElementById('discountPercent');
            const discountPrice = document.getElementById('discountPrice');

            if (discountYes.checked) {
                discountPercentFields.style.display = 'block';
                discountPriceFields.style.display = 'block';
                discountPercent.value = 0; // Reset values
                discountPrice.value = 0;
            } else if (discountNo.checked) {
                discountPercentFields.style.display = 'none';
                discountPriceFields.style.display = 'none';
                discountPercent.value = 0; // Set values to 0 when no discount
                discountPrice.value = 0;
            }
        }

        // Event listeners to trigger recalculations
        document.getElementById('discountPercent').addEventListener('input', function() {
            calculateDiscountPrice();
        });

        document.getElementById('discountPrice').addEventListener('input', function() {
            calculateDiscountPercent();
        });

        document.getElementById('originalPrice').addEventListener('input', function() {
            calculateDiscountPrice();
            calculateDiscountPercent();
        });

        // Event listeners for radio buttons
        document.getElementById('isDiscountYes').addEventListener('change', handleDiscountSelection);
        document.getElementById('isDiscountNo').addEventListener('change', handleDiscountSelection);

        // Initialize the function in case No is selected by default
        window.onload = handleDiscountSelection;



    </script>
@endsection
{{-- Product Quantity --}}
{{--                                    <div class="col-md-6 col-6">--}}
{{--                                        <div class="form-group custom">--}}
{{--											<label>Product Quantity:</label>--}}
{{--											<input type="number" class="form-control form-control-md" placeholder="Product Quantity" name="quantity" value="{{ old('quantity') }}" required>--}}
{{--                                            <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy dw dw-money1"></i></span>--}}
{{--                                            </div>--}}
{{--										</div>--}}
{{--                                    </div>--}}

{{-- Product Quantity --}}
{{--                                    <div class="col-md-6 col-6">--}}
{{--                                        <div class="form-group custom">--}}
{{--											<label>Product Price:</label>--}}
{{--											<input type="number" id="originalPrice" class="form-control form-control-lg" placeholder="Price" name="original_price" required>--}}
{{--										</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-3 col-12">--}}
{{--                                        <div class="form-group custom">--}}
{{--                                            --}}{{-- <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Is Discount?</span>--}}
{{--                                            </div> --}}
{{--                                            <label>Is Discount ?</label>--}}
{{--                                            <div class="form-control-lg d-flex ">--}}
{{--                                                <div class="custom-control custom-radio  mr-3">--}}
{{--                                                    <input type="radio" id="isDiscountYes" name="isDiscount" class="custom-control-input" value="TRUE" required>--}}
{{--                                                    <label class="custom-control-label" for="isDiscountYes">Yes</label>--}}
{{--                                                </div>--}}
{{--                                                <div class="custom-control custom-radio">--}}
{{--                                                    <input type="radio" id="isDiscountNo" name="isDiscount" class="custom-control-input" value="FALSE" required checked>--}}
{{--                                                    <label class="custom-control-label" for="isDiscountNo">No</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{-- Product Quantity --}}
{{--                                    <div class="col-md-6 col-6">--}}
{{--                                        <div class="form-group custom">--}}
{{--											<label>Product Quantity:</label>--}}
{{--											<input type="number" class="form-control form-control-md" placeholder="Product Quantity" name="quantity" value="{{ old('quantity') }}" required>--}}
{{--                                            <div class="input-group-append custom">--}}
{{--                                                <span class="input-group-text"><i class="icon-copy dw dw-money1"></i></span>--}}
{{--                                            </div>--}}
{{--										</div>--}}
{{--                                    </div>--}}

{{-- Product Quantity --}}
{{--                                    <div class="col-md-6 col-6">--}}
{{--                                        <div class="form-group custom">--}}
{{--											<label>Product Price:</label>--}}
{{--											<input type="number" id="originalPrice" class="form-control form-control-lg" placeholder="Price" name="original_price" required>--}}
{{--										</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-3 col-12">--}}
{{--                                        <div class="form-group custom">--}}
{{--                                            --}}{{-- <div class="input-group-prepend col-md-3">--}}
{{--                                                <span class="input-group-text">Is Discount?</span>--}}
{{--                                            </div> --}}
{{--                                            <label>Is Discount ?</label>--}}
{{--                                            <div class="form-control-lg d-flex ">--}}
{{--                                                <div class="custom-control custom-radio  mr-3">--}}
{{--                                                    <input type="radio" id="isDiscountYes" name="isDiscount" class="custom-control-input" value="TRUE" required>--}}
{{--                                                    <label class="custom-control-label" for="isDiscountYes">Yes</label>--}}
{{--                                                </div>--}}
{{--                                                <div class="custom-control custom-radio">--}}
{{--                                                    <input type="radio" id="isDiscountNo" name="isDiscount" class="custom-control-input" value="FALSE" required checked>--}}
{{--                                                    <label class="custom-control-label" for="isDiscountNo">No</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
