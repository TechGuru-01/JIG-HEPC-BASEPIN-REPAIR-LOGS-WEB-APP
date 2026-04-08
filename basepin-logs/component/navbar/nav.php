<header>
    <nav>
        <div class="menu">
            <div class="logo">
                <a href="../../pages/dashboard/dashboard.php">
                    <img src="../../src/unnamed-2.png" alt="HEPC LOGO">
                </a>
            </div>

        <div class="user-profile-wrapper">
            <div class="name">
                <p><?= $_SESSION['full_name'] ?></p>
            </div>

            <div class="profile-container">
                <div class="profile-trigger">
                    <?php 
                    $nav_profile_pic = (!empty($_SESSION['profile_pic']) && file_exists($_SESSION['profile_pic'])) 
                                       ? $_SESSION['profile_pic'] 
                                       : '../../src/default_avatar.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($nav_profile_pic); ?>" alt="User" class="nav-avatar">
                </div>

                <div class="dropdown-menu">
                    <div class="dropdown-header">Account</div>
                    <hr>
                    <a href="../../pages/profile/profile.php">
                        <span class="material-icons-outlined">manage_accounts</span>
                        My Profile
                    </a>
                    <a href="../../include/logout.php" class="logout-link">
                        <span class="material-icons-outlined">logout</span>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>