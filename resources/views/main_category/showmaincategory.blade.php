@extends('layouts.app')
@section('title','POS')
@section('css')
<style>
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
                            <h4>Main Category</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('main_categories.index')}}">Main Category</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Show Details Main Category</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-info card-box">
                            {{-- <h5 class="mb-20 h4 text-blue text-center">Show Details Category</h5> --}}
                            <div class="row">
                                <div class="col-md-4 col-sm-12">

                                </div>


                                <div class="col-md-4 col-sm-12 ">
                                    <h5 class=" h3 text-dark text-center">Show Details Main Category</h5>

                                </div>
                                <div class="col-md-4 col-sm-12 ">

                                    <h2 class="card-title text-primary text-right text-decoration">
                                        <a href="{{ route('main_categories.edit', $category->id) }}" class="badge badge-primary"> Edit <i class="fas fa-edit"></i></a>

                                    </h2>


                                </div>



                            </div>
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
                                                <span class="input-group-text">Main Category Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" placeholder="Enter Your Category name" name="name" value="{{$category->name}}" readonly>
                                            <div class="input-group-append custom">
                                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                            </div>
                                        </div>
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

@endsection
