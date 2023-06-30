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
                    <li class="breadcrumb-item"><a href="{{ route('subscribers.index') }}">قائمة المشتركين</a></li>
                    <li class="breadcrumb-item active">إدارة الإشتراكات </li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('sendAlert') }}" method="POST" style="float: left;">
            @csrf
            <button type="submit" class="btn btn-warning" style="margin:10px "> ارسال اشعار الي كل المشتركين&nbsp; &nbsp;
                <li class="fas fa-bell" style="color: red"></li>
            </button>
        </form>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #148c2e; color: white ; border-radius:15px;">
                تم ارسال الاشعار لكل المشتركين
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشل ارسال الاسعار للمشتركين
            </div>
        @endif
    @endif
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive  ">
                        <table class="table card-table  table-hover  text-nowrap mb-0 " style="text-align: center">
                            <thead>
                                <tr>
                                    <th>الإسم</th>
                                    <td> الهاتف</td>
                                    <th style="color: blue; font-weight: bold"> الإشتراك</td>
                                    <td style="color: blue; font-weight: bold">بداية الإشتراك</td>
                                    <td style="color: blue; font-weight: bold">نهاية الإشتراك</td>
                                    <td>المديونية</td>
                                    <td>الحالة</td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                    <tr>
                                        <td>{{ $subscriber->name }}</td>
                                        <td>{{ $subscriber->phone }}</td>
                                        <td>{{ $subscriber->subscription->subscription_type }}</td>
                                        <td style="color: red;font-weight: bold">{{ $subscriber->subscription_start ?? '' }}
                                        </td>
                                        <td style="color: red ;  font-weight: bold">
                                            {{ $subscriber->subscription_end ?? '' }}</td>
                                        <td>{{ $subscriber->indebtedness ?? '' }} - شيكل</td>
                                        <td>
                                            @if ($subscriber->status == 1)
                                                <span class="badge bg-success text-white">فعال</span>
                                            @else
                                                <span class="badge bg-danger ">غير فعال</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

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
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>


@endsection
