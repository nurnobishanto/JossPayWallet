<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Qr Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .myBox{
            max-width: 450px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card myBox">
        <div class="card-header">
            <h5 class="card-title">{{$title}}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0"><strong>Store Name :</strong> {{$store->business_name}}</p>
                    <p class="mb-0"><strong>Store ID :</strong>  {{$store->store_id}}</p>
                    <hr>
                </div>
                <div class="col-12 text-center">

                    @if($qrCodeImage)
                        <img src="data:image/png;base64, {!!  base64_encode($qrCodeImage) !!}"/>
                    @else
                        {!! $qrCode !!}
                    @endif

                </div>
                <div class="col-12 text-center mt-2">
                    <a href="{{$link}}" />{{$link}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
