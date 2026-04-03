<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PulsaKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .card-login { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; padding: 30px; background: #fff; }
    </style>
</head>
<body>
    <div class="card-login">
        <h3 class="text-center fw-bold mb-4 text-primary">PulsaKita</h3>
        <form action="proses_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="user@mail.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 fw-bold py-2">Login</button>
        </form>
    </div>
</body>
</html>