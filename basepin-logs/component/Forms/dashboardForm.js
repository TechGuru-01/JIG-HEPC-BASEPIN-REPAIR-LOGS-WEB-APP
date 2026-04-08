function previewImage(input, previewId) {
  const preview = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.innerHTML = `<img src="${e.target.result}" style="max-width:100%;">`;
    };
    reader.readAsDataURL(input.files[0]);
  }
}


function calculateTotals() {
  const allRadios = document.querySelectorAll(
    'input[type="radio"][name$="_status"]:checked',
  );
  let totalOk = 0;
  let totalNg = 0;

  allRadios.forEach((radio) => {
    if (radio.value.toUpperCase() === "OK") totalOk++;
    else if (radio.value.toUpperCase() === "NG") totalNg++;
  });

  const okField = document.getElementById("total-ok");
  const ngField = document.getElementById("total-ng");

  if (okField) okField.value = totalOk;
  if (ngField) ngField.value = totalNg;
}

function toggleSubForm() {
  const replacementBox = document.getElementById("replacement-details");
  const replaceYes = document.getElementById("replace_yes");

  if (replacementBox && replaceYes) {
    replacementBox.style.display = replaceYes.checked ? "block" : "none";
  }
}

function openInspectionModal() {
  const modal = document.querySelector(".modal-container");
  if (modal) {
    modal.style.display = "block";
    document.body.style.overflow = "hidden"; 
  }
}

function closeInspectionModal() {
  const modal = document.querySelector(".modal-container");
  const form = document.getElementById("form");

  if (modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto"; 
    if (form) form.reset();
    document.getElementById("preview_before").innerHTML =
      '<span class="preview-text">No image selected</span>';
    document.getElementById("preview_after").innerHTML =
      '<span class="preview-text">No image selected</span>';
  }
}

function openViewModal(id) {
  const modalForm = document.getElementById("form");
  if (modalForm) modalForm.reset();

  document.getElementById("preview_before").innerHTML = "Loading...";
  document.getElementById("preview_after").innerHTML = "Loading...";

  fetch(`../../include/logFunction.php?fetch_id=${id}`)
    .then((response) => response.json())
    .then((res) => {
      if (res.status === "success") {
        const data = res.data;
        document.getElementById("section").value = data.section || "";
        document.getElementById("control-number").value =
          data.control_number || "";
        document.getElementById("no").value =
          data.no || "";
        document.getElementById("terminal_part_no").value =
          data.terminal_part_no || "";
        document.getElementById("technician").value =
          data.technician_name || "";
        document.getElementById("item_key").value = data.item_key || "";
        document.getElementById("customer").value = data.customer || "";
        document.getElementById("date").value = data.date_of_verification || "";

        if (data.quarter) {
          const qRadio = document.querySelector(
            `input[name="quarter"][value="${data.quarter}"]`,
          );
          if (qRadio) qRadio.checked = true;
        }

        document.getElementById("preview_before").innerHTML =
          data.photo_before_path
            ? `<img src="../../src/uploads/${data.photo_before_path}" 
                  style="width:100%; cursor: zoom-in;" 
                  onclick="viewFullImage('../../src/uploads/${data.photo_before_path}', 'Before Verification')">`
            : "No image";

        document.getElementById("preview_after").innerHTML =
          data.photo_after_path
            ? `<img src="../../src/uploads/${data.photo_after_path}" 
                  style="width:100%; cursor: zoom-in;" 
                  onclick="viewFullImage('../../src/uploads/${data.photo_after_path}', 'After Verification')">`
            : "No image";

        const conditions = [
          "deformation",
          "corrosion",
          "crack",
          "foreign_material",
          "alignment",
        ];
        conditions.forEach((c) => {
          const statusVal = data[`${c}_status`]; 
          const remarksVal = data[`${c}_remarks`];

          if (statusVal) {
            const radio = document.querySelector(
              `input[name="${c}_status"][value="${statusVal.toLowerCase()}"]`,
            );
            if (radio) radio.checked = true;
          }

          const remarksInput = document.querySelector(
            `input[name="${c}_remarks"]`,
          );
          if (remarksInput) remarksInput.value = remarksVal || "";
        });

        if (data.replacement_required === "yes") {
          document.getElementById("replace_yes").checked = true;
          document.getElementById("terminal_part_no").value =
            data.terminal_part_no || "";
          document.getElementById("reason_replacement").value =
            data.reason_replacement || "";
          document.getElementById("date_replaced").value =
            data.date_replaced || "";
          document.getElementById("replacement_technician").value =
            data.replacement_technician || "";
          document.getElementById("change_point_no").value =
            data.change_point_no || "";
        } else {
          document.getElementById("replace_no").checked = true;
        }

        document.getElementById("total-ok").value = data.total_ok || 0;
        document.getElementById("total-ng").value = data.total_ng || 0;

        toggleSubForm();
        openInspectionModal();
      } else {
        alert("Error: " + res.msg);
      }
    })
    .catch((err) => {
      console.error("Fetch Error:", err);
      alert("Failed to fetch record. Check console for details.");
    });
}

function viewFullImage(src, title) {
    const zoomModal = document.getElementById("imageZoomModal");
    const fullImg = document.getElementById("imgFullView");
    const captionText = document.getElementById("caption");
    const mainModal = document.querySelector(".modal-container");

    fullImg.src = src;
    captionText.innerText = title;
    fullImg.currentScale = 1; 
    fullImg.style.transform = `scale(1)`;
    
    zoomModal.style.display = "flex";

    document.body.style.overflow = "hidden";
    if(mainModal) mainModal.style.overflow = "hidden"; 

    zoomModal.onwheel = function(event) {
        event.preventDefault();
        const zoomSpeed = 0.1;
        if (event.deltaY < 0) {
            fullImg.currentScale += zoomSpeed;
        } else {
            fullImg.currentScale = Math.max(1, fullImg.currentScale - zoomSpeed);
        }
        fullImg.style.transform = `scale(${fullImg.currentScale})`;
    };
}

function closeZoom() {
    const zoomModal = document.getElementById("imageZoomModal");
    const mainModal = document.querySelector(".modal-container");

    zoomModal.style.display = "none";
    
    document.body.style.overflow = "auto";
    if(mainModal) mainModal.style.overflow = "auto";
}

document.addEventListener("DOMContentLoaded", function () {
  const replaceRadios = document.querySelectorAll(
    'input[name="replacement_required"]',
  );
  replaceRadios.forEach((radio) => {
    radio.addEventListener("change", toggleSubForm);
  });

  document.addEventListener("change", function (e) {
    if (e.target.name && e.target.name.includes("_status")) {
      calculateTotals();
    }
  });

  const exitBtn = document.getElementById("exit");
  if (exitBtn) {
    exitBtn.addEventListener("click", (e) => {
      e.preventDefault();
      closeInspectionModal();
    });
  }

  const modal = document.querySelector(".modal-container");
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeInspectionModal();
    }
  });
});
