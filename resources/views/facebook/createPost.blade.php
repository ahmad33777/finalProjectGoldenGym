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
                    <li class="breadcrumb-item active">نشر منشور</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')
@if (Session()->has('status'))
@if (session('status') == true)
    <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
        نجحت عملية نشر المنشور
  
    </div>
@else
    <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
        فشلت عملية نشر المنشور

    </div>
@endif
@endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">إضافة منشور جديد على الصفحة الخاصة بالنادي</h3>
                    </div>
                    <form action="{{ route('facebook_post') }}" method="POST" >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <textarea class="form-control" name="post_body" id="post_body" cols="150" rows="10"
                                    placeholder="أدخل محتوى المنشور "></textarea>
                            </div>
                            <br>
                            <button type="submit" style="border-radius:10px ; width: 100px" class="btn btn-success">نشر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
