<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #F2F2F2F2;
        }

        .card-container {
            text-align: center;
        }

        #card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        #spinner {
            display: none;
            border: 8px solid rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card-container">
                <div id="card">
                    @if($spinner)
                        <div id="spinner"></div>
                    @endif
                    <h3 class="{{$h3Class}}">{{$h3}}</h3>
                        <p class="{{$pClass}}">{{$p}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
{!! $formHtml !!}
<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    document.getElementById('redirectForm').submit();
    // Show spinner on page load
    $(document).ready(function () {
        $('#spinner').show();
    });
</script>

</body>
</html>
