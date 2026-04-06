document.addEventListener("submit", function (e) {

  if (e.target && e.target.classList.contains("delete-form")) {
    e.preventDefault();

    const form = e.target;
    const row = form.closest("tr"); 

    Swal.fire({
      title: "Are you sure?",
      text: "This action cannot be undone!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "rgb(4, 245, 4)",
      cancelButtonColor: "#f00808",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        
        Swal.showLoading();

        let formData = new FormData(form);

        fetch(form.action, {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "success") {
              Swal.fire({
                icon: "success",
                title: "Deleted!",
                text: data.msg,
                timer: 1000,
                showConfirmButton: false,
              }).then(() => {
                if (row) {
                  row.style.transition = "0.5s";
                  row.style.opacity = "0";
                  setTimeout(() => {
                    row.remove();
                  }, 500);
                }
              });
            } else {
              Swal.fire("Error!", data.msg, "error");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            Swal.fire("System Error", "Failed to connect to server.", "error");
          });
      }
    });
  }
});