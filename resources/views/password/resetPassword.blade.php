<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(45deg, greenyellow, dodgerblue);
            font-family: "Sansita Swashed", cursive;
        }

        .center {
            /* position: relative; */
            padding: 50px 50px;
            background: #fff;
            border-radius: 10px;
        }

        .center h1 {
            font-size: 2em;
            padding: 10px;
            color: #000;
            letter-spacing: 5px;
            margin-bottom: 60px;
            font-weight: bold;
            padding-left: 10px;
        }

        .center .inputbox {
            position: relative;
            width: 300px;
            height: 50px;
            margin-bottom: 50px;
            text-align: center
        }

        .center .inputbox input {
            */ top: 0;
            left: 0;
            width: 100%;
            border: 2px solid #000;
            outline: none;
            background: none;
            padding: 10px;
            border-radius: 10px;
            font-size: 1.2em;
        }

        .center .inputbox:last-child {
            margin-bottom: 0;
        }

        .center .inputbox span {
            position: absolute;
            top: 14px;
            left: 20px;
            font-size: 1em;
            transition: 0.6s;
            font-family: sans-serif;
        }

        .center .inputbox input:focus~span,
        .center .inputbox input:valid~span {
            transform: translateX(-13px) translateY(-35px);
            font-size: 1em;
        }

        .center .inputbox [type="submit"] {
            width: 50%;
            background: dodgerblue;
            color: #fff;
            border: #fff;
        }

        .center .inputbox:hover [type="submit"] {
            background: linear-gradient(45deg, greenyellow, dodgerblue);
        }
    </style>
</head>


<body>
    <form action="{{ route('reset-password') }}" method="POST"s style="direction: rtl ; text-align: center">
        @csrf
        <div class="center">
            <h1>GoldenGym</h1>
            <form action="{{ route('reset-password') }}" method="POST" style="text-align: center">
                <input type="hidden" name="id" value="{{ $trainer->id }}">

                <div class="inputbox">
                    <input type="password" name="password" id="password" placeholder="كلمة المرورو الجديدة">
                </div>
                @error('password')
                    <p style="color: red ">{{ $message }}</p>
                @enderror
                <div class="inputbox">
                    <input type="password" name="password_confirmation" id="password_confarm"
                        placeholder="تأكيد كلمة المرور">
                </div>
                @error('password_confirmation')
                    <p style="color: red ">{{ $message }}</p>
                @enderror
                <div class="inputbox">
                    <input type="submit" value="submit">
                </div>
            </form>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

</body>

</html>
