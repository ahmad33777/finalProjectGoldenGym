@extends('layouts.master')
@section('title')
    Golden Gym
@stop
@section('page-header')
    <!-- breadcrumb -->
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item active">إدارة الاشعارات</li>
                    <li class="breadcrumb-item active">إرسال إشعار</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                تم ارسال الاشعار
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية الارسال
            </div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">إرسالة إشعار </h3>
                    </div>
                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="text" class="form-control" name="title" id="title" cols="150"
                                    rows="10" placeholder="أدخل عنوان الاشعار ">
                            </div>
                            <br>
                            @error('title')
                                <p style="color: red ">{{ $message }}</p>
                            @enderror
                            <br>
                            <div class="row">
                                <textarea class="form-control" name="body" id="body" cols="150" rows="10"
                                    placeholder="أدخل محتوى الاشعار "></textarea>
                            </div>
                            <br>
                            @error('body')
                                <p style="color: red ">{{ $message }}</p>
                            @enderror
                            <button type="submit" style="border-radius:10px ; width: 100px"
                                class="btn btn-success">نشر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
