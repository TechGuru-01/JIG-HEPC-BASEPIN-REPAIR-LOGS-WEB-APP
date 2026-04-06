document.addEventListener("DOMContentLoaded", function () {
  const avatarInput = document.getElementById("avatarInput");
  const currentAvatar = document.getElementById("currentAvatar");
  const saveProfileBtn = document.getElementById("saveProfileBtn");

  avatarInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        currentAvatar.src = e.target.result;
        saveProfileBtn.classList.remove("disabled");
      };
      reader.readAsDataURL(file);
    }
  });

  saveProfileBtn.addEventListener("click", function () {
    if (this.classList.contains("disabled")) return;
    const formData = new FormData(document.getElementById("avatarForm"));

    fetch("../../include/uploadAvatar.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        Swal.fire(
          data.status === "success" ? "Success" : "Error",
          data.msg,
          data.status,
        ).then(() => location.reload());
      });
  });
});


function resetPassword(id, name) {
  Swal.fire({
    title: `Reset Password for ${name}`,
    input: "password",
    inputLabel: "New Password",
    showCancelButton: true,
    confirmButtonText: "Update",
    preConfirm: (pass) => {
      if (!pass || pass.length < 6)
        return Swal.showValidationMessage("Min 6 characters");
      return fetch("../../include/adminActionHandler.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=reset_pass&user_id=${id}&new_pass=${pass}`,
      }).then((res) => res.json());
    },
  }).then((result) => {
    if (result.isConfirmed)
      Swal.fire("Updated!", "Password changed successfully.", "success");
  });
}

function removeUser(id, name) {
  Swal.fire({
    title: `Remove ${name}?`,
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d32f2f",
    confirmButtonText: "Yes, Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("../../include/adminActionHandler.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=delete_user&user_id=${id}`,
      })
        .then((res) => res.json())
        .then((data) => {
          Swal.fire("Deleted!", data.msg, "success").then(() =>
            location.reload(),
          );
        });
    }
  });
}
