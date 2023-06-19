@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item active">إدارة الطلبات الحجوزات </li>
                    <li class="breadcrumb-item active">قبول الحجوزات</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    {{-- main content --}}
    {{-- الرسالة عند الاضافة  --}}
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold bg-success"role="alert" style=" color: white ; border-radius:15px;">
                تم قبول الطلب 
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #dd1212; color: white ; border-radius:15px;">
                لم يتم قبول الطلب
            </div>
        @endif
    @endif

    @if (Session()->has('rejectstatus'))
        @if (session('rejectstatus') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #dd1212; color: white ; border-radius:15px;">
                 تم رفض الحجز       
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #dd1212; color: white ; border-radius:15px;">
                فشل الرفض
            </div>
        @endif
    @endif
    <br>
    <!-- row -->

    <div class="row row-sm">
        <div class="col-xl-12">
            <br>
            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table  mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <th>صاحب الحجز</th>
                                    <th>اسم المنتج</th>
                                    <th>تاريخ الحجز</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @if (isset($orders))
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->subscriber->name }}</td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        <a href="{{ route('order.acceptOrder', $order->id) }}" class="btn btn-success">قبول</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('order.rejectOrder', $order->id) }}" class="btn btn-danger">رفض</a>
                                    </td>
                                </tr>
                                    
                                @endforeach
                            @endif
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!--/div-->
    </div>




    </div>
    </div>
@endsection

@section('js')


@endsection
