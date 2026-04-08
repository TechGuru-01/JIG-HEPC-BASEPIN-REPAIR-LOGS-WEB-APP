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

function changeUsername(id, currentName) {
    Swal.fire({
        title: `Update Username`,
        html: `Updating for: <b>${currentName}</b>`,
        input: "text",
        inputLabel: "New Username",
        inputPlaceholder: "Enter new username...",
        showCancelButton: true,
        confirmButtonText: "Save Changes",
        showLoaderOnConfirm: true,
        preConfirm: (newUsername) => {
            if (!newUsername) {
                Swal.showValidationMessage("Huwag naman blanko, lodi.");
                return false;
            }
            
          
            let formData = new FormData();
            formData.append('action', 'change_username'); 
            formData.append('user_id', id);              
            formData.append('new_username', newUsername);

            return fetch("../../include/adminActionHandler.php", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server error or file not found.');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'error') {
                    throw new Error(data.msg);
                }
                return data;
            })
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error.message}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Success!", result.value.msg, "success").then(() => {
                location.reload(); 
            });
        }
    });
}

function resetPassword(id, name) {
    Swal.fire({
        title: `Reset Password for ${name}`,
        html: `
            <div style="text-align: left; width: 100%; box-sizing: border-box; padding: 0 10px;">
                <label for="swal-pass" style="font-weight: 600; font-size: 14px; color: #444;">New Password</label>
                <input type="password" id="swal-pass" class="swal2-input" 
                    style="width: 100%; margin: 8px 0 15px 0; box-sizing: border-box;" 
                    placeholder="Enter new password">
                
                <label for="swal-confirm" style="font-weight: 600; font-size: 14px; color: #444;">Confirm Password</label>
                <input type="password" id="swal-confirm" class="swal2-input" 
                    style="width: 100%; margin: 8px 0 5px 0; box-sizing: border-box;" 
                    placeholder="Confirm new password">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: "Update Password",
        confirmButtonColor: "rgb(20, 200, 38)",
        cancelButtonColor: "#d33",
        focusConfirm: false,
        customClass: {
            input: 'custom-swal-input'
        },
        preConfirm: () => {
            const pass = document.getElementById('swal-pass').value;
            const confirmPass = document.getElementById('swal-confirm').value;

            if (!pass || pass.length < 8) {
                return Swal.showValidationMessage("Minimum 8 characters required.");
            }
            if (!/[A-Z]/.test(pass)) {
                return Swal.showValidationMessage("At least one uppercase letter (A-Z) required.");
            }
            if (!/[0-9]/.test(pass)) {
                return Swal.showValidationMessage("At least one number (0-9) required.");
            }
            if (!/[!@#$%^&*]/.test(pass)) {
                return Swal.showValidationMessage("At least one special character (!@#$%^&*) required.");
            }
            if (pass !== confirmPass) {
                return Swal.showValidationMessage("Passwords do not match.");
            }

            return fetch("../../include/adminActionHandler.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `action=reset_pass&user_id=${id}&new_pass=${encodeURIComponent(pass)}`,
            })
            .then((res) => {
                if (!res.ok) throw new Error("Server error: " + res.statusText);
                return res.json();
            })
            .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value.status === "success") {
            Swal.fire("Updated!", "Password has been reset successfully.", "success");
        } else if (result.isConfirmed) {
            Swal.fire("Error", result.value.message || "An error occurred.", "error");
        }
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
