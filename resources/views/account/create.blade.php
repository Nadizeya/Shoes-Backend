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
                            <h4>Add Receiving Account</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('account.index')}}">Receiving Accounts</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Receiving Account</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Add Receiving Account</h5>
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

                        <form action="{{ route('account.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Owner Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Bank Name" name="holder_name" value="{{ old('holder_name') }}">
                                            <div class="input-group-append custom">
                                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Select Bank</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="custom-select2 form-control form_control-lg" name="bank_id" id="bank_id" style="width: 100%;" required>
                                                    <option value="" selected disabled>Select Bank Name</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Conditional Fields -->
                                    <div class="col-md-12 col-12" id="bank_account_field" style="display: none;">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Bank Account Number</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Bank Account Number" name="bank_account">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12" id="pay_number_field" style="display: none;">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Pay Phone Number</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Pay Phone Number" name="pay_number">
                                        </div>
                                    </div>




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
    Developed By Voom
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        const $bankDropdown = $('#bank_id');
        const $bankAccountField = $('#bank_account_field');
        const $bankAccountInput = $bankAccountField.find('input[name="bank_account"]');
        const $payNumberField = $('#pay_number_field');
        const $payNumberInput = $payNumberField.find('input[name="pay_number"]');

        // Initially hide both fields
        $bankAccountField.hide();
        $payNumberField.hide();

        // Event listener for dropdown change
        $bankDropdown.on('change', function () {
            const bankId = $(this).val();

            if (bankId) {
                // Make an AJAX request to fetch the bank type
                $.ajax({
                    url: "{{ route('get.bank.type') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bank_id: bankId
                    },
                    success: function (data) {
                        if (data.bank_type === 'bank_account') {
                            $bankAccountField.show();
                            $payNumberField.hide();
                            $bankAccountInput.prop('required', true);
                            $payNumberInput.prop('required', false);
                        } else if (data.bank_type === 'pay_number') {
                            $bankAccountField.hide();
                            $payNumberField.show();
                            $bankAccountInput.prop('required', false);
                            $payNumberInput.prop('required', true);
                        } else {
                            $bankAccountField.hide();
                            $payNumberField.hide();
                            $bankAccountInput.prop('required', false);
                            $payNumberInput.prop('required', false);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $bankAccountField.hide();
                $payNumberField.hide();
                $bankAccountInput.prop('required', false);
                $payNumberInput.prop('required', false);
            }
        });
    });
</script>
@endsection
