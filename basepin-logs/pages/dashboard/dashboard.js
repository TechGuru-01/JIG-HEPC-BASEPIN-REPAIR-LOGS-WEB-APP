const replaceYes = document.getElementById("replace_yes");
const replaceNo = document.getElementById("replace_no");
const subForm = document.getElementById("replacement-details");
const subInputs = subForm.querySelectorAll("input");

function toggleSubForm() {
  if (replaceYes.checked) {
    subForm.style.display = "block";
    subInputs.forEach((input) => (input.required = true));
  } else {
    subForm.style.display = "none";
    subInputs.forEach((input) => {
      input.required = false;
      input.value = "";
    });
  }
}

replaceYes.addEventListener("change", toggleSubForm);
replaceNo.addEventListener("change", toggleSubForm);

document.getElementById("form").addEventListener("submit", function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  fetch(this.action, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Saved!",
          text: data.msg,
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
        }).then(() => {
          this.reset();
          document.querySelectorAll(".image-preview").forEach((preview) => {
            preview.innerHTML =
              '<span class="preview-text">No image selected</span>';
          });
          if (typeof toggleSubForm === "function") toggleSubForm();
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: data.msg,
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "System Error",
        text: "Error connecting to the server.",
      });
    });
});

document.addEventListener("DOMContentLoaded", function () {
  const rstBtn = document.getElementById("rstBtn");

  if (rstBtn) {
    rstBtn.addEventListener("click", function (e) {
      e.preventDefault();

      Swal.fire({
        title: "Reset Form?",
        text: "All your inputs will be cleared. Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4ea726",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, reset it!",
        cancelButtonText: "No, keep it",
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = document.getElementById("form");
          if (formData) {
            formData.reset();
            document.querySelectorAll(".image-preview").forEach((preview) => {
              preview.innerHTML =
                '<span class="preview-text">No image selected</span>';
            });
            if (typeof toggleSubForm === "function") toggleSubForm();

            Swal.fire({
              title: "Reset!",
              text: "The form has been cleared.",
              icon: "success",
              timer: 1000,
              showConfirmButton: false,
            });
          }
        }
      });
    });
  }
});
