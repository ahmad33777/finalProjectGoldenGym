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
                    <li class="breadcrumb-item active"><a href="{{ route('offer.index') }}"> إدارة المنتجات المنتجات و العروض</a></li>
                    <li class="breadcrumb-item active"> اضافة عرض جديد </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card-header bg-primary text-white">
                    <div>
                        <h3>إضافة عرض جديدة</h3>
                    </div>
                </div>
                <div class="card ">

                    <form action="{{ route('offer.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <b>معلومات العروض الجديدة </b>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group text-primary">
                                        <label for="name" style="font-weight: 900">
                                            عنوان العرض
                                        </label>
                                        <input type="text" class="form-control" placeholder="ادخل عنوان العرض "
                                            name="offer_title" id="offer_title" value="{{ old('offer_title') }}">
                                    </div>
                                    @error('offer_title')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-primary">
                                        <label for="image">صورة العرض</label>
                                        <input class="form-control" type="file" id="offer_image" name="offer_image">
                                        @error('offer_image')
                                            <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-primary">
                                        </b> <label for="offer_start" style="font-weight: 900">
                                            تاريخ بداية العرض
                                        </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="offer_start"
                                                name="offer_start" value="{{ old('offer_start') }}">
                                        </div>
                                        @error('offer_start')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-primary">
                                        </b> <label for="offer_end" style="font-weight: 900">
                                            تاريخ نهاية العرض
                                        </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="offer_end"
                                                name="offer_end" value="{{ old('offer_end') }}">
                                        </div>
                                        @error('offer_end')
                                            <p style="color: red ">{{ $message }}</p>
                      a                  @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group text-primary">
                                        <label for="offer_description"> وصف العرض </label>
                                        <textarea class="form-control"
                                            placeholder="أدخل بعض الكلمات التي توصف العرض  الجديد حتى يسهل التعرف عليه من قبل المشتركين" id="offer_description"
                                            name="offer_description" style="height: 100px"></textarea>
                                    </div>
                                    @error('offer_description')
                                        <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-3" style="margin-top: 26px">
                                <button type="submit" style="border-radius:10px " class="btn btn-primary"> حفظ</button>
                            </div>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>

@endsection
