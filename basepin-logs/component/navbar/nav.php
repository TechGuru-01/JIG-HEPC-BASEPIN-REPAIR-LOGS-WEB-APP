<header>
    <nav>
        <div class="menu">
            <div class="logo">
                <a href="../../pages/dashboard/dashboard.php">
                    <img src="../../src/unnamed-2.png" alt="HEPC LOGO">
                </a>
            </div>

            <div class="profile">
                <a href="../../pages/profile/profile.php" style="text-decoration: none; display: flex; align-items: center;">
                    <?php 
                    $nav_profile_pic = (!empty($_SESSION['profile_pic']) && file_exists($_SESSION['profile_pic'])) 
                                       ? $_SESSION['profile_pic'] 
                                       : '../../src/default_avatar.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($nav_profile_pic); ?>" 
                         alt="User Profile" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #d32f2f;">
                </a>
            </div>
        </div>
    </nav>
</header>