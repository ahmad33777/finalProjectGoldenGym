@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <!-- Maps css -->
@section('title')
    الصفحة الرئيسية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصفحة الرئيسية</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الأحصائيات </span>
            </div>
        </div>
        <div style="float: left;">
            <form action="{{ route('expiredSubscriptions') }}" method="get">
                @csrf
                <button type="submit" class="btn btn-warning">نهايات الإشتراك&nbsp; &nbsp;
                    <li class="fas fa-bell" style="color: red"></li>
                   <span style="color: #000; font-weight: bold; font-size: 20px;"> {{ $showExpiredSubscriptionsCount }}</span>
                </button>
            </form>
        </div>
    </div>

    <!-- breadcrumb -->
@endsection
@section('content')

    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #0d9e03; color: white ; border-radius:15px;">
                تم اضافة المصروفات
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت العملية
            </div>
        @endif
    @endif
    <!-- row -->
    <div class="row row-sm">
        @role(['admin', 'accountant'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-primary-gradient text-white ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">المشتركين</span>
                                    <h2 class="text-white mb-0">{{ $subscribers }}</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('subscribers.index') }}" style="color: white">
                                    <div class="icon1 mt-2 text-center">
                                        <i class="fe fe-users tx-40"></i>
                                    </div>

                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role(['admin'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-danger-gradient text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">الموظفين</span>
                                    <h2 class="text-white mb-0">{{ $employees }}</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('users.index') }}" style="color: white">

                                    <div class="icon1 mt-2 text-center">
                                        <i class="fe fe-users tx-40"></i>
                                    </div>
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role(['admin'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-success-gradient text-white">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">المدربين</span>
                                    <h2 class="text-white mb-0">{{ $trainers }}</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('trainers.index') }}" style="color: white">
                                    <div class="icon1 mt-2 text-center">
                                        <i class="fe fe-users tx-40"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role(['admin'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-warning-gradient text-white">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">الواردات الكلية </span>
                                    <h2 class="text-white mb-0"> {{ $incomings }} </h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fas fa-dollar-sign tx-40"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role(['admin', 'accountant'])
            <div class="col-sm-12 col-lg-6 col-xl-3">
                <div class="card card-img-holder">
                    <div class="card-body list-icons">
                        <div class="clearfix">
                            <div class="float-right text-right">
                                <p class="card-text text-muted mb-1">الواردات اليومية</p>
                                <h3>{{ $dailyIncoming }} ₪.</h3>
                            </div>
                            <div class="float-left  mt-2">
                                <span class="text-primary ">
                                    <i class="si si-credit-card tx-30"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 col-xl-3">
                <div class="card card-img-holder">
                    <div class="card-body list-icons">
                        <div class="clearfix">
                            <div class="float-right text-right">
                                <p class="card-text text-muted mb-1">المصروفات اليومية</p>
                                <h3>{{ $dailyExpenses }} ₪.</h3>
                            </div>
                            <div class="float-left  mt-2">
                                <span class="text-primary ">
                                    <i class="si si-credit-card tx-30"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-6 col-xl-3">
                <div class="card card-img-holder">
                    <div class="card-body list-icons">
                        <div class="clearfix">
                            <div class="float-right text-right">
                                <p class="card-text text-muted mb-1" style="color: red">عدد المشتركين الفعالين</p>
                                <h3>{{ $dailyExpenses }} ₪.</h3>
                            </div>
                            <div class="float-left  mt-2">
                                <span class="text-primary ">
                                    <i class="fa fa-mobile tx-30"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endrole

        @role('vendor')
            <div class="col-xl-3 col-lg-6 col-sm-6 col-md-6">
                <div class="card text-center">
                    <div class="card-body ">
                        @php
                            $CategoryCOuntr = App\Models\Category::count();
                        @endphp
                        <h6 class="mb-1 text-muted">عدد الفئات الموجودة</h6>
                        <h3 class="font-weight-semibold">{{ $CategoryCOuntr }} فئات</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4" style=" border-radius:8px ; color: white">
                <div class="card">
                    <div class="card-body" style="background-color:blue ; border-radius:8px ">
                        <form>
                            <div class="mb-3">
                                <label for="" class="form-label" style=" color: white">Email address</label>
                                <input type="text" class="form-control" id=" " aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="" style=" color: white" class="form-label">Password</label>
                                <input type="" class="form-control" id="">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endrole
    </div>
    @role(['admin'])
        <div class="row row-sm">
            {{-- احصائيات المشتركين السنوبية --}}
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="main-content-label">
                            إحصائيات المشتركين السنوية
                        </div>
                        <p class="mg-b-20">نسبة المشتركين الجدد مع المشتركين الحالين</p>
                        <div>
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- احصائيات الواردات --}}
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="main-content-label">
                            إحصائيات الواردات السنوية
                        </div>
                        <p class="mg-b-20"> الواردات المالية خلال السنة</p>

                        <div>
                            <canvas id="incommingChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- add new incomming  --}}
            <div class="col-sm-12 col-md-6  " style=" border-radius:8px ; color: white ; ">
                <div class="card">
                    <div class="card-body" style="border-radius:8px ">
                        <div class="main-content-label">
                            الصادرات
                        </div>
                        <p class="mg-b-20" style="color:#000">
                            اضافة مصاريف تشغيلية جديدة
                        </p>
                        <form action="{{ route('expenses.store') }}" method="post">
                            @csrf
                            <input list="types" placeholder="ادخل نوع الصادر " class="form-control" id=""
                                name="type" id="type" style=" border: 1px solid #1196db">
                            <datalist id="types">
                                <option value="مصاريف تشغيلية"> مصاريف تشغيلية</option>
                                <option value="حجوزات ساونا">حجوزات ساونا</option>
                                <option value="بيع منتج">بيع منتج</option>
                                <option value="مصاريف شحن الكهرباء">مصاريف شحن الكهرباء</option>
                            </datalist>
                            @error('type')
                                <p style="color: red ">{{ $message }}</p>
                            @enderror
                            <br>
                            <input type="number" class="form-control" min="0" placeholder="ادخل قيمة الصادر بالشيكل"
                                style=" border: 1px solid #1196db; margin-bottom: 17px" name="amount" id="amount">

                            @error('amount')
                                <p style="color: red ">{{ $message }}</p>
                            @enderror
                            <input type="text" class="form-control" min="0" placeholder="ملاحظات"
                                style=" border: 1px solid #1196db; margin-bottom: 17px" name="note" id="note">

                            @error('note')
                                <p style="color: red ">{{ $message }}</p>
                            @enderror
                            <div style="text-align: center">
                                <button type="submit" class="btn btn-warning">تصدير وارد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endrole



@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- تحليل  المشتركين --}}
    <script>
        console.log({!! json_encode($datasets) !!});
        var ctx = document.getElementById('chart2');
        var subscriberchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasets) !!},
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },

                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'عدد المشتركين'
                        },

                    }
                },


            },


        });
    </script>

    {{-- incommin cgart --}}
    <script>
        console.log({!! json_encode($datasets) !!});
        var ctx = document.getElementById('incommingChart');
        var incommingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasetIncomming) !!},
            },

            options: {
                plugins: {
                    legend: {
                        display: false,
                    },

                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        },
                        title: {
                            display: true,
                            text: 'مجموع الواردات بالشيكل  خلال الاشهر',

                        }
                    }
                },


            },


        });
    </script>
@endsection
