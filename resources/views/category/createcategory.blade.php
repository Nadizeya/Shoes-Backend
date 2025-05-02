@extends('layouts.app')
@section('title','POS')
@section('css')

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
                            <h4>Category</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Category</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            <h5 class="mb-20 h4 text-blue text-center">Add Category</h5>
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

                        <form action="{{ route('categories.store') }}" method="POST">

                            @csrf
                            <div class="container">
                                 <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Main Category Name</span>

                                            </div>
                                            <select name="main_category_id" class="form-select form-control form-control-lg" aria-label="Default select example">

                                                <option selected="">Select Main Category Name </option>
                                                @foreach($main as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="input-group custom">
                                            <div class="input-group-prepend col-md-3">
                                                <span class="input-group-text">Category Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Category name" name="name" value="{{ old('name') }}">
                                            <div class="input-group-append custom">
                                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
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
    Developed By Nay Oo Lwin
</div>

@endsection

@section('js')

@endsection
