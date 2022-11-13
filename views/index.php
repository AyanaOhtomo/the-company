<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body class = "bg-light">
    <div style ="height: 100vh;">
        <div class ="row h-100 m-0">
            <div class ="card w-25 m-auto">
                <div class ="card-header bg-white border-0 py-3">
                    <h1 class ="text-center">LOGIN</h1>
                </div>
                <div class="card-body">
                    <form action="../actions/login.php" method="post">
                        <input type="text" name ="username" placeholder = "USERNAME" class="text form-control mb-2" required autofocus>
                        <input type="password" name="password" id="password" placeholder = "PASSWORD" class="form-control mb-5" required>
                        <button type="submit" name = "btn_login" class ="btn btn-primary w-100">Log in</button>
                    </form>

                    <p class="text-center mt-3 small"><a href="register.php">Create account</a></p>

                </div>

            </div>
        </div>

    </div>

</body>
</html>