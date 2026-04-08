<?php require_once __DIR__ . '/include/config.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
     <link rel="stylesheet" href="./pages/signup/signup.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class = "login-container"> 
        <div class="login-wrapper">
            <div class="form-side">
                    <div class="form-head">
                        <div class="logo-box">
                            <img src="./src/unnamed-2.png" alt="logo" class="mobile-logo">
                        </div>

                        <div class="header-text">
                            <h2>Login</h2>
                            <p style="color: #999; font-size: 0.9rem;">Welcome to JIG Basepin Inspection Records </p>
                        </div>
                    </div>

                    <form action="include/loginResponseHandler.php" method="POST" id="loginForm">
                        <div class="input-box">
                            <span class="material-symbols-outlined">person</span>
                            <input type="text" name="username" placeholder="Username" >
                        </div>

                        <div class="input-box">
                            <span class="material-symbols-outlined">lock</span>
                            <input type="password" name="password" placeholder="Password" >
                        </div>

                        <button type="submit" class="login-btn">
                            LOGIN
                            <span class="material-symbols-outlined">double_arrow</span>
                        </button>
                    </form> 

                    <p style="text-align:center; margin-top:20px; font-size:0.9rem; color:#666; text-decoration: underline;">
                        <a href="./pages/umtd/manuals.html" style="color:#1e293b; text-decoration:none; font-weight:bold;">Manual & Documentation</a>
                    </p>

                    <p style="text-align:center; margin-top:20px; font-size:0.9rem; color:#666;">
                        Don't have an account? <a href="./pages/signup/signup.php" style="color:#d32f2f; text-decoration:none; font-weight:bold;">Sign Up</a>
                    </p>

                    <footer class="login-footer">
                        <p class="copyright">&copy; <?= date("Y"); ?> JIG B.I.R </p>
                        <p class="developer">Developed by Elijah Boon & Chaz Honrada</p>
                    </footer>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>
</html>