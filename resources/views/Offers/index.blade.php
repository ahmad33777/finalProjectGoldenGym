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
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">إدارة المنتجات</a></li>
                    <li class="breadcrumb-item active">قائمة المنتجات </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                نجحت العمليةالأضافة
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية
            </div>
        @endif
    @endif
    @if (Session()->has('updateStatus'))
        @if (session('updateStatus') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                نجحت عملية التحديث
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية التحديث
            </div>
        @endif
    @endif


    @if ($errors->any())
        <div class="alert  fw-bold" style="background-color: #da1313; color: white ; border-radius:15px " role="alert">
            فشلت العملية هناك خطأ في البيانات المدخلة من فضلك حاول مرة أخرى
        </div>
    @endif
    <div class="d-flex justify-content-between">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">

                <a href="{{ route('offer.create') }}" type="button" class="btn btn-primary">
                    <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                    إضافة عرض جديد
                </a>

            </div>
        </div>
        <br>
    </div>
    <hr>

    @if (isset($offers))
        <div class="row">

            @foreach ($offers as $offer)
                <div style="margin: 10px">
                    <div class="card" style="width: 15rem; padding: 5px">
                        <img src="{{ $offer->image }}" class="card-img-top" alt="offerimage" height="180px">
                        <div class="card-body">
                            <h5 class="card-title">العنوان : {{ $offer->title }}</h5>
                            <p class="card-text">الوصف : {{ $offer->description }}</p>
                            <p class="card-text">تاريخ بداية العرض : {{ $offer->offer_start }}</p>
                            <p class="card-text">تاريخ نهاية العرض : {{ $offer->offer_end }}</p>
                            <h5 class="card-title">الموظف : {{ $offer->emp->name }}</h5>

                            <div class="row" style="display: flex; justify-content: space-around">
                                <div class="col-3">
                                    <a href="{{ route('offer.edit', $offer->id) }}"
                                        class="btn btn-primary   edit btn-flat">
                                        <i class='fa fa-edit'></i></a>
                                </div>
                                <div class="col3">
                                    <a href="#" onclick="confirmDestroy({{ $offer->id }}, this)"
                                        class="btn btn-danger  "><i class="fas fa-trash"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

    <script>
        function confirmDestroy(id, td) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لا يمكن التراجع عن عملية الحذف",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, td);
                }
            });
        }

        function destroy(id, td) {
            axios.delete('/admin/offers/destroy/' + id)
                .then(function(response) {
                    // handle success 2xx 3xx
                    console.log(response.data);
                    td.closest('tr').remove();
                    showMessage(response.data);
                })
                .catch(function(error) {
                    // handle error 4xx 5xx
                    console.log(error.response);
                    showMessage(error.response.data);
                })
                .then(function() {
                    // always executed
                });
        }

        function showMessage(data) {
            Swal.fire({
                position: 'top-end',
                icon: data.icon,
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>






@endsection
