@extends('layouts.app')
@section('title', 'Edit Product')
@section('css')
    <style>
        .media-wrapper {
            position: relative;
            display: inline-block;
            margin: 5px;
        }
        .remove-media {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 3px;
            cursor: pointer;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            border: none;
        }
        .image-media-preview, .video-media-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
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
                                <h4>Edit Product</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Product</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <label>Product Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                            </div>
                            <div class="col-md-6 col-6">
                                <label>Brand Name:</label>
                                <select class="form-control" name="brand_id" required>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-6">
                                <label>Category Name:</label>
                                <select class="form-control" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-6">
                                <label>Recommend:</label>
                                <select class="form-control" name="is_recommended">
                                    <option value="1" {{ $product->is_recommended ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$product->is_recommended ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-6">
                                <label>Short Description :</label>
                                <input type="text" class="form-control" name="sh_description" value="{{ $product->short_description }}" required>
                            </div>
                            <div class="col-md-6 col-6">
                                <label> Description :</label>
                                <input type="text" class="form-control" name="pd_description"value="{{ $product->description }}" required>
                            </div>
                        </div>
                        <hr>
                        <h4>Product Variations</h4>
                        <div id="variation-container">
                            @foreach($product->variations as $variation)
                                <div class="card mb-3 p-3 variation-block">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Size:</label>
                                            <input type="text" class="form-control" name="variation[{{ $variation->id }}][size]" value="{{ $variation->size }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Quantity:</label>
                                            <input type="number" class="form-control" name="variation[{{ $variation->id }}][quantity]" value="{{ $variation->quantity }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Price:</label>
                                            <input type="number" class="form-control" name="variation[{{ $variation->id }}][price]" value="{{ $variation->price }}" required>
                                        </div>
                                    </div>

                                    <!-- Existing Images -->
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label>Existing Images:</label><br>
                                            <div class="existing-images">
                                                @foreach($variation->images as $img)
                                                    <div class="media-wrapper">
                                                        <img src="{{ asset($img->image_path) }}" class="image-media-preview">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <label>Add New Images:</label>
                                            <input type="file" class="new-images-input form-control" name="new_variation_images[{{ $variation->id }}][]" multiple accept="image/*">
                                            <div class="new-image-preview"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Existing Videos:</label><br>
                                            <div class="existing-videos">
                                                @foreach($variation->videos as $vid)
                                                    <div class="media-wrapper">
                                                        <video src="{{ asset($vid->video_path) }}" class="video-media-preview" controls></video>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <label>Add New Videos:</label>
                                            <input type="file" class="new-videos-input form-control" name="new_variation_videos[{{ $variation->id }}][]" multiple accept="video/*">
                                            <div class="new-video-preview"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-info my-3" id="add-variation-btn">+ Add Variation</button>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        Developed By Nay Oo Lwin
    </div>
@endsection

@section('js')


<script >

    // document.addEventListener('DOMContentLoaded', function() {
    //     let variationIndex = 1000;
    //
    //     // Add new variation dynamically
    //     document.getElementById('add-variation-btn').addEventListener('click', function() {
    //         let variationContainer = document.getElementById('variation-container');
    //         let newVariation = `
    //         <div class="card mb-3 p-3 variation-block">
    //             <div class="row">
    //                 <div class="col-md-4"><label>Size:</label><input type="text" class="form-control" name="new_variation[${variationIndex}][size]" required></div>
    //                 <div class="col-md-4"><label>Quantity:</label><input type="number" class="form-control" name="new_variation[${variationIndex}][quantity]" required></div>
    //                 <div class="col-md-4"><label>Price:</label><input type="number" class="form-control" name="new_variation[${variationIndex}][price]" required></div>
    //             </div>
    //             <div class="row mt-2">
    //                 <div class="col-md-6">
    //                     <label>Images:</label>
    //                     <input type="file" class="new-images-input form-control" name="new_variation_images[${variationIndex}][]" multiple accept="image/*">
    //                     <div class="new-image-preview"></div>
    //                 </div>
    //                 <div class="col-md-6">
    //                     <label>Videos:</label>
    //                     <input type="file" class="new-videos-input form-control" name="new_variation_videos[${variationIndex}][]" multiple accept="video/*">
    //                     <div class="new-video-preview"></div>
    //                 </div>
    //             </div>
    //         </div>`;
    //         variationContainer.insertAdjacentHTML('beforeend', newVariation);
    //         variationIndex++;
    //     });
    //
    //     // Display image preview with remove button
    //     document.addEventListener('change', function(event) {
    //         if (event.target.classList.contains('new-images-input')) {
    //             let previewContainer = event.target.closest('.col-md-6').querySelector('.new-image-preview');
    //             previewContainer.innerHTML = ""; // Clear previous previews
    //
    //             Array.from(event.target.files).forEach((file, index) => {
    //                 let reader = new FileReader();
    //                 reader.onload = function(e) {
    //                     let wrapper = document.createElement('div');
    //                     wrapper.classList.add('media-wrapper');
    //
    //                     let imgElement = document.createElement('img');
    //                     imgElement.src = e.target.result;
    //                     imgElement.classList.add('image-media-preview');
    //
    //                     let removeButton = document.createElement('button');
    //                     removeButton.classList.add('remove-media');
    //                     removeButton.innerHTML = "×"; // Remove icon
    //                     removeButton.addEventListener('click', function() {
    //                         wrapper.remove();
    //                     });
    //
    //                     wrapper.appendChild(imgElement);
    //                     wrapper.appendChild(removeButton);
    //                     previewContainer.appendChild(wrapper);
    //                 };
    //                 reader.readAsDataURL(file);
    //             });
    //         }
    //     });
    //
    //     // Display video preview with remove button
    //     document.addEventListener('change', function(event) {
    //         if (event.target.classList.contains('new-videos-input')) {
    //             let previewContainer = event.target.closest('.col-md-6').querySelector('.new-video-preview');
    //             previewContainer.innerHTML = ""; // Clear previous previews
    //
    //             Array.from(event.target.files).forEach((file, index) => {
    //                 let reader = new FileReader();
    //                 reader.onload = function(e) {
    //                     let wrapper = document.createElement('div');
    //                     wrapper.classList.add('media-wrapper');
    //
    //                     let videoElement = document.createElement('video');
    //                     videoElement.src = e.target.result;
    //                     videoElement.classList.add('video-media-preview');
    //                     videoElement.controls = true;
    //
    //                     let removeButton = document.createElement('button');
    //                     removeButton.classList.add('remove-media');
    //                     removeButton.innerHTML = "×"; // Remove icon
    //                     removeButton.addEventListener('click', function() {
    //                         wrapper.remove();
    //                     });
    //
    //                     wrapper.appendChild(videoElement);
    //                     wrapper.appendChild(removeButton);
    //                     previewContainer.appendChild(wrapper);
    //                 };
    //                 reader.readAsDataURL(file);
    //             });
    //         }
    //     });
    // });

    document.addEventListener('DOMContentLoaded', function() {
        let variationIndex = 1000;

        // Function to check if all images are removed and show "Choose Image" input
        function checkImagePreview(previewContainer, inputField) {
            if (previewContainer.children.length === 0) {
                inputField.style.display = "block";
                inputField.value = ""; // Reset input field to avoid duplicate uploads
            }
        }

        // Display image preview with remove button
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('new-images-input')) {
                let previewContainer = event.target.closest('.col-md-6').querySelector('.new-image-preview');
                let inputField = event.target;
                previewContainer.innerHTML = ""; // Clear previous previews

                Array.from(event.target.files).forEach((file) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let wrapper = document.createElement('div');
                        wrapper.classList.add('media-wrapper');

                        let imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.classList.add('image-media-preview');

                        let removeButton = document.createElement('button');
                        removeButton.classList.add('remove-media');
                        removeButton.innerHTML = "×"; // Remove icon
                        removeButton.addEventListener('click', function() {
                            wrapper.remove();
                            checkImagePreview(previewContainer, inputField);
                        });

                        wrapper.appendChild(imgElement);
                        wrapper.appendChild(removeButton);
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });

                // Hide input field when images are selected
                inputField.style.display = "none";
            }
        });

        // Display video preview with remove button
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('new-videos-input')) {
                let previewContainer = event.target.closest('.col-md-6').querySelector('.new-video-preview');
                let inputField = event.target;
                previewContainer.innerHTML = ""; // Clear previous previews

                Array.from(event.target.files).forEach((file) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let wrapper = document.createElement('div');
                        wrapper.classList.add('media-wrapper');

                        let videoElement = document.createElement('video');
                        videoElement.src = e.target.result;
                        videoElement.classList.add('video-media-preview');
                        videoElement.controls = true;

                        let removeButton = document.createElement('button');
                        removeButton.classList.add('remove-media');
                        removeButton.innerHTML = "×"; // Remove icon
                        removeButton.addEventListener('click', function() {
                            wrapper.remove();
                            checkImagePreview(previewContainer, inputField);
                        });

                        wrapper.appendChild(videoElement);
                        wrapper.appendChild(removeButton);
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });

                // Hide input field when videos are selected
                inputField.style.display = "none";
            }
        });
    });
</script>
@endsection
