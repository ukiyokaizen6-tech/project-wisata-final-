<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PARIWISAIA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h1 { text-align: center; margin-bottom: 2rem; color: #2c3e50; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; }
        .login-btn { background: #3498db; color: white; border: none; padding: 0.7rem; border-radius: 4px; cursor: pointer; width: 100%; }
        .error { color: red; margin-top: 1rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login Admin</h1>
        <form method="POST">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        
        <?php
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // Simple authentication (in production, use secure password hashing)
            if ($username === 'admin' && $password === 'admin123') {
                session_start();
                $_SESSION['admin'] = true;
                header('Location: dashboard.php');
                exit;
            } else {
                echo '<p class="error">Username atau password salah!</p>';
            }
        }
        ?>
    </div>
</body>
</html>