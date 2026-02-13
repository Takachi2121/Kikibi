<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coming Soon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <style>
        html,body{
            background: linear-gradient(75deg, #A30029 0%, #DC2629 100%);
            font-family: 'Lexend', sans-serif;
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100dvh;
            margin-top: 120px;
            overflow: hidden;
            width: 100%;
        }

        h1{
            font-size: calc(120px + 1vw);
            margin-top: 40px;
            text-transform: uppercase;
        }

        .image-decoration{
            width: 832.9px;
            height: 175.98px;
        }

        .image-decoration img{
            width: 100%;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <h1 class="fw-bolder">Coming Soon</h1>
    <p class="fs-1 mt-0 mb-5">This website is under contruction</p>
    <div class="image-decoration">
        <img src="{{ asset('assets/img/decoration.png') }}" alt="Constrution Image">
    </div>
</body>
</html>
