<?php 
require_once "../../include/auth_checker.php"; 
require_once "../../include/config.php"; 

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, full_name, position, profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();

$_SESSION['username'] = $user_data['username'];
$_SESSION['full_name'] = $user_data['full_name'];
$_SESSION['position'] = $user_data['position'];

$profile_pic = (!empty($user_data['profile_pic']) && file_exists($user_data['profile_pic'])) 
               ? $user_data['profile_pic'] 
               : '../../src/default_avatar.jpg';
$all_users = null;
if ($user_role === 'admin') {
    $all_users = $conn->query("SELECT id, username, full_name, position, created_at FROM users WHERE id != $user_id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile & Management | JIG B.I.R</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="../../style.css">
      <link rel="stylesheet" href="../../component/navbar/nav.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
      <?php include '../../component/navbar/nav.php'?>
    <div class="main-container">
      
        <header class="page-header">
            <h1>Account Settings</h1>
            <p>Manage your profile and system users</p>
        </header>

        <div class="profile-grid">
            <div class="profile-card bento-item">
                <div class="profile-header">
                    <div class="avatar-container">
                        <img id="currentAvatar" src="<?= htmlspecialchars($profile_pic); ?>" alt="avatar" class="profile-avatar">
                        <form id="avatarForm" enctype="multipart/form-data">
                            <label for="avatarInput" class="upload-btn">
                                <span class="material-symbols-outlined">add_a_photo</span>
                            </label>
                            <input type="file" name="avatar" id="avatarInput" accept="image/*" hidden>
                        </form>
                    </div>
                    <div class="user-main-info">
                        <h3><?= htmlspecialchars($user_data['full_name']); ?></h3>
                        <span class="role-badge"><?= ucfirst($user_role); ?></span>
                    </div>
                </div>
                <hr class="divider">
                <div class="detail-item">
                    <label>Username</label>
                    <p><?= htmlspecialchars($user_data['username']); ?></p>
                </div>
                <div class="detail-item">
                    <label>Position</label>
                    <p><?= htmlspecialchars($user_data['position']); ?></p>
                </div>
                <button class="save-changes-btn disabled" id="saveProfileBtn">Save Photo</button>
            </div>

            <?php if ($user_role === 'admin'): ?>
            <div class="management-card bento-item">
                <div class="card-header">
                    <h3>User Management</h3>
                </div>
                <div class="table-responsive">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($all_users && $all_users->num_rows > 0): ?>
                                <?php while($row = $all_users->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['full_name']); ?></td>
                                    <td><span class="position-tag"><?= htmlspecialchars($row['position']); ?></span></td>
                                    <td><?= date("M d, Y", strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="icon-btn" onclick="resetPassword(<?= $row['id']; ?>, '<?= $row['full_name']; ?>')" title="Reset Password">
                                                <span class="material-symbols-outlined">lock_reset</span>
                                            </button>
                                            <button class="icon-btn delete" onclick="removeUser(<?= $row['id']; ?>, '<?= $row['full_name']; ?>')" title="Remove User">
                                                <span class="material-symbols-outlined">person_remove</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" style="text-align:center;">No other users found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="profile.js"></script>
</body>
</html>