<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peduli Lingkungan</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body, html {
      height: 100%;
      margin: 0;
    }

    .jumbotron {
      background-image: url('picture/city2.jpeg');
      background-size: cover;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: white;
    }

    .button-container {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="jumbotron text-center">
    <h1>Peduli Lingkungan</h1>
    <p>Aduanmu Penting bagi kami!</p> 
    <div class="container">
      <div class="row justify-content-center button-container">
        <a href="/about" class="btn btn-dark  mr-2">About Us</a>
        <a href="{{ url('login') }}" class="btn btn-light  ml-2">Login</a>
      </div>
    </div>
  </div>
</body>
</html>
