@extends('layouts.app')

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
    }

    .avatar-lg {
        width: 100px;
        height: 100px;
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
                            <h4>Edit Receiving Account</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('account.index') }}">Receiving Accounts</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Receiving Account</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <h5 class="mb-20 h4 text-blue text-center">Edit Receiving Account</h5>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('account.update', $account->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="container">
                                <div class="row">
                                    <!-- Owner Name -->
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Owner Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Owner Name" name="holder_name" value="{{ $account->holder_name }}" required>
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
                                                       <option value="{{ $bank->id }}" {{ $bank->id == $account->bank_id ? 'selected' : '' }}>{{ $bank->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Bank Account Number -->
                                    <div class="col-md-12 col-12" id="bank_account_field" style="display: none;">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Bank Account Number</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Bank Account Number" name="account_number" value="{{ $account->account_number }}">
                                        </div>
                                    </div>

                                    <!-- Pay Phone Number -->
                                    <div class="col-md-12 col-12" id="pay_number_field" style="display: none;">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Pay Phone Number</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Pay Phone Number" name="paynumber" value="{{ $account->paynumber }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12 mb-30"></div>
                                <div class="col-md-4 col-sm-12 mb-30">
                                    <button type="submit" class="btn btn-primary m0">Update</button>
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
<script>
    $(document).ready(function () {
        const $bankDropdown = $('#bank_id');
        const $bankAccountField = $('#bank_account_field');
        const $bankAccountInput = $bankAccountField.find('input[name="bank_account"]');
        const $payNumberField = $('#pay_number_field');
        const $payNumberInput = $payNumberField.find('input[name="pay_number"]');

        // Initial field display based on selected bank type
        const initialBankType = "{{ $account->bank->bank_type }}";
        if (initialBankType === 'bank_account') {
            $bankAccountField.show();
            $payNumberField.hide();
        } else if (initialBankType === 'pay_number') {
            $bankAccountField.hide();
            $payNumberField.show();
        }

        // Update fields based on bank selection
        $bankDropdown.on('change', function () {
            const bankId = $(this).val();

            if (bankId) {
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
