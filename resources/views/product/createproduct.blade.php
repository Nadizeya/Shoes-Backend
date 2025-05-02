@extends('layouts.app')
@section('title', 'Add Product')
@section('css')
<style>
    .image-container,
    .video-container {
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
    }

    .video-media-preview {
        width: 250px;
        height: 250px;
    }

    .image-media-preview {
        width: 100px;
        height: 100px;
    }

</style>
@endsection

@section('content')
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
                            <h4>Product</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Product</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show Product</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Add Product</h5>
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

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    {{-- Name --}}
                                    <div class="col-md-6 col-6">
                                        <div class="form-group custom">
											<label>Product Name:</label>
											 <input type="text" class="form-control form-control-md" placeholder="Enter Your Product Name" name="name" value="{{ old('name') }}" required>

										</div>
                                    </div>

                                    {{-- Brand --}}
                                    <div class="col-md-6 col-6">
                                        <div class="form-group" data-select2-id="1">
                                            <label>Brand :</label>
                                            <select class="custom-select2 form-control form_control-lg select2-hidden-accessible" style="width: 100%; height: 38px;" data-select2-id="8" tabindex="-1" aria-hidden="true" id="brand_id" name="brand_id" required>
                                                            <option value="" selected disabled>Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Category --}}
                                    <div class="col-md-6 col-6">
                                        <div class="form-group" data-select2-id="8">
                                            <label>Category :</label>
                                            <select class="custom-select2 form-control form_control-lg select2-hidden-accessible" name="category_id" style="width: 100%; height: 80px;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="brand_id"  required>
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="form-group custom">

                                            <label>Recommend </label>
                                            <div class="form-control-lg d-flex align-items-center">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input type="radio" id="customRadioYes" name="is_recommended" class="custom-control-input" value="TRUE" required>
                                                    <label class="custom-control-label" for="customRadioYes">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadioNo" name="is_recommended" class="custom-control-input" value="FALSE" required checked>
                                                    <label class="custom-control-label" for="customRadioNo" selected >No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Discount Percent Input -->
                                    <div class="col-md-6 col-12" id="discountPercentField" style="display: none;">
                                        <div class="form-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Discount Percent (%)</span>
                                            </div>
                                            <input type="number" id="discountPercent" class="form-control form-control-lg" placeholder="Percentage (%)" name="discount_percent" value="0" required>

                                        </div>
                                    </div>

                                    <!-- Discount Price Input -->
                                    <div class="col-md-6 col-12" id="discountPriceField" style="display: none;">
                                        <div class="form-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Discount Price</span>
                                            </div>
                                            <input type="number" id="discountPrice" class="form-control form-control-lg" placeholder="Price" name="discount_price" value="0" required>

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group html-editor  custom">

                                            <label>Short Description :</label>

                                            <div class="html-editor  pd-20 card-box col-md-12">

                                                <textarea class="textarea_editor form-control pd-30 " placeholder="Enter Your Short Product Description" name="sh_description"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- Product Description --}}

                                    <div class="col-md-6 col-12">
                                         <div class="form-group custom">
                                            <label> Details :</label>
                                             <div class="col-md-12 card-box">
                                                <textarea class="textarea_editor form-control pd-30   " id="description" name="pd_description" rows="4">
                                                    {{ old('description') }}
                                                </textarea>

                                             </div>


                                         </div>
                                     </div>
                                    <hr />
                                </div>
                                <hr />
                                <!-- =========================================== -->
                                <!-- Container for Variations -->
                                <!-- =========================================== -->
                                <div class="container" id="variation-container">
                                    <h4>Product Variations</h4>
                                    <!-- Variation blocks will be added here via JS -->
                                </div>

                                <div class="container my-2">
                                    <!-- Button to add new variation -->
                                    <button type="button" class="btn btn-info" id="add-variation-btn">+ Add Variation</button>
                                </div>

                                <hr />

                                <!-- Added margin top for spacing -->
                                <div class="col-md-4 col-sm-12 mb-30"></div>
                                <div class="col-md-4 col-sm-12 mb-30 text-center"> <!-- Center align the button -->
                                    <button type="submit" class="btn btn-primary m0">Save</button>
                                </div>
                            </div>
                        </form>

                        <!-- =========================================== -->
                        <!-- HIDDEN TEMPLATE for Variation Block -->
                        <!-- =========================================== -->
                        <template id="variation-template">
                            <div class="variation-block border p-3 mb-3">
                                <div class="row">
                                    <!-- Size -->
                                    <div class="col-md-4">
                                        <label>Size</label>
                                        <input type="text" class="form-control" name="variation[INDEX][size]" required />
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-4">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" name="variation[INDEX][quantity]" required />
                                    </div>
                                    <!-- Price -->
                                    <div class="col-md-4">
                                        <label>Price</label>
                                        <input type="number" step="0.01" class="form-control" name="variation[INDEX][price]" required />
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <!-- Variation Images -->
                                    <div class="col-md-6">
                                        <label>Images (Multiple)</label>
                                        <input type="file"
                                               class="form-control variation-images-input"
                                               name="variation_images[INDEX][]"
                                               multiple
                                               accept="image/*" />

                                        <!-- Separate preview container for images -->
                                        <div class="preview-container images-preview mt-2"></div>
                                    </div>

                                    <!-- Variation Videos -->
                                    <div class="col-md-6">
                                        <label>Videos (Multiple)</label>
                                        <input type="file"
                                               class="form-control variation-videos-input"
                                               name="variation_videos[INDEX][]"
                                               multiple
                                               accept="video/mp4,video/quicktime,video/x-msvideo" />

                                        <!-- Separate preview container for videos -->
                                        <div class="preview-container videos-preview mt-2"></div>
                                    </div>
                                </div>

                                <!-- Remove Variation Block Button -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger remove-variation-btn">Remove This Variation</button>
                                    </div>
                                </div>
                            </div>
                        </template>
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

