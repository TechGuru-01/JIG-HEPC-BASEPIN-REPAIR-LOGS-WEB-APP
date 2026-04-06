
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./signup.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
        <div class="login-container"> 
            <div class="login-wrapper">
                <div class="form-side">
                    <div class="form-header">
                        <div class="logo-box">
                            <img src="../../src/unnamed-2.png" alt="logo" class="mobile-logo">
                        </div>

                        <div class="header-text">
                            <h2>Sign Up</h2>
                            <p style="color: #999; font-size: 0.9rem;">Create your account</p>
                        </div>
                    </div>

                    <form action="../../include/signupResponseHandler.php" method="POST" id="signupForm">

                        <div class="input-box">
                            <span class="material-symbols-outlined">badge</span>
                            <input type="text" name="full_name" placeholder="Full Name" >
                        </div>

                        <div class="input-box">
                            <span class="material-symbols-outlined">business_center</span>
                            <input type="text" name="position" placeholder="Position" >
                        </div>

                        <div class="input-box">
                            <span class="material-symbols-outlined">person</span>
                            <input type="text" name="username" placeholder="Username" >
                        </div>

                        <div class="input-box">
                            <span class="material-symbols-outlined">lock</span>
                            <input type="password" name="password" placeholder="Password" >
                        </div>

                        <div class="input-box">
                            <span class="material-symbols-outlined">lock_reset</span>
                            <input type="password" name="confirm_password" placeholder="Confirm Password" >
                        </div>

                        <button type="submit" class="login-btn">
                            SIGN UP
                            <span class="material-symbols-outlined">double_arrow</span>
                        </button>
                    </form> 
                    
                    <p style="text-align:center; margin-top:15px; font-size:0.85rem; color:#666;">
                        Already have an account? <a href="../../index.php" style="color:#d32f2f; text-decoration:none; font-weight:bold;">Login</a>
                    </p>

                    <footer class="login-footer">
                        <p class="copyright">&copy; <?= date("Y"); ?> JIG B.I.R </p>
                        <p class="developer">Developed by Elijah Boon & Chaz Honrada</p>
                    </footer>

                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src = "./signup.js"></script>
</body>
</html>