
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tela de Login</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f8f9fa;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .login-box {
        max-width: 400px;
        width: 100%;
        padding: 2rem;
        border-radius: 1rem;
        background-color: #ffffff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
    </style>
  </head>
  <body>

    @yield('content')

    <script src="/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
