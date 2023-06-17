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
                       قائمة شكاوي المدربين </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #13c113; color: white ; border-radius:15px;text-align: center">
                تمت قرأة الشكوى 
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                   حاول مرة أخرى
            </div>
        @endif
    @endif
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <td>رقم الشكاوي</td>
                                    <td>الرسالة</td>
                                    <td>التاريخ</td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($trainer_complaints))
                                    @foreach ($trainer_complaints as $trainer_complaint)
                                        <tr>
                                            <td>{{ $trainer_complaint->id }}</td>
                                            <td>{{ $trainer_complaint->message }}</td>
                                            <td>{{ $trainer_complaint->created_at }}</td>

                                            <td>
                                                <a href="{{ Route('readTrainerComplaint', $trainer_complaint->id) }}"
                                                    class="btn btn-success" style="color: #FFF">قرأة</a>

                                            </td>
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
