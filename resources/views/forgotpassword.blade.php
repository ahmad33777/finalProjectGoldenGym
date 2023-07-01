<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>



    <div class="formbold-main-wrapper">

        <div class="formbold-form-wrapper">
            <div class="formbold-form-title">
                <h3> GoldenGym</h3>
                <p>أرسال بريد لتميكن عملية اعادة تعين كلمة المرورو</p>
            </div>
            <form action="{{ route('user.sendURL') }}" method="POST">
                @csrf
                <input type="email" name="email" id="email" placeholder="Enter your email address"
                    class="formbold-form-input" />
                @error('email')
                    <p style="color: red ; text-align: center">{{ $message }}</p>
                @enderror
                @if (Session()->has('status'))
                    @if (session('status') == true)
                        <div class="alert alert-success fw-bold" role="alert" style="text-align: center">
                            افحص البريد من اجل استرجاع كلمة المرورو
                        </div>
                    @else
                        <div class="alert alert-danger fw-bold" role="alert" style="text-align: center">
                            فشلت العملية
                        </div>
                    @endif
                @endif
                <button class="formbold-btn">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 200px;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
            text-align: center
        }

        .formbold-form-title {
            margin-bottom: 40px;
        }

        .formbold-form-title h3 {
            color: #07074D;
            font-weight: 700;
            font-size: 28px;
            line-height: 35px;
            width: 60%;
            margin-bottom: 20px;
        }

        .formbold-form-title p {
            font-size: 16px;
            line-height: 24px;
            color: #536387;
            width: 70%;
        }

        .formbold-form-input {
            text-align: center;
            width: 100%;
            padding: 14px 22px;
            border-radius: 6px;
            border: 1px solid #DDE3EC;
            background: #FAFAFA;
            font-weight: 500;
            font-size: 16px;
            color: #536387;
            outline: none;
            resize: none;
        }

        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold-btn {
            text-align: center;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            padding: 14px 25px;
            border: none;
            font-weight: 500;
            background-color: #6A64F1;
            color: white;
            cursor: pointer;
            margin-top: 15px;
        }

        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }
    </style>

</body>

</html>
