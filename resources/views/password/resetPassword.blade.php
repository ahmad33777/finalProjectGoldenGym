<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>

<body>
    <form action="#" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $trainer->id }}">
        <input type="password" name="password" id="password" placeholder="كلمة المرورو الجديدة">
        <br>
        <br>
        <input type="password" name="password_confarm" id="password_confarm" placeholder="تأكيد كلمة المرور">
        <input type="submit">
    </form>
</body>

</html>
