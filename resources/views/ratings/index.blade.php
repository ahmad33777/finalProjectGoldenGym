@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> <a href="{{ route('home') }}">الصفحة الرئيسية
                    </a>/</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    قائمة التقيمات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <td>اسم المدرب</td>
                                    <td>عدد التقيمات</td>
                                    <td>نسبة التقيم</td>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($ratings))
                                    @foreach ($ratings as $rating)
                                        <tr>
                                            <td>{{ $rating->trainer->name }}</td>
                                            <td>{{ $rating->countRate }}</td>

                                            <td>{{ $rating->averageRate }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>





@endsection

@section('js')


@endsection
