<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<form action="{{route('huskadian')}}" method="GET" >
    @csrf
    <div class="input-group mb-3" style="text-align: center">
        <label class="input-group-text" for="">Mời nhập tên Store:</label>
        <input type="text" name="shop" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" value="huskadian2" aria-describedby="basic-addon2">
        <span class="input-group-text" id="basic-addon2">.myshopify.com</span>
    </div>
    <input type="submit" value="Submit">
</form>
</body>
</html>
