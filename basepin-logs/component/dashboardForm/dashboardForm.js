/**
 * HEPC JIG IMS - Terminal Inspection Logic
 * Main JavaScript Handler
 */

// --- 1. IMAGE PREVIEW ---
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

// --- 2. AUTO CALCULATE TOTALS ---
function calculateTotals() {
  const allRadios = document.querySelectorAll(
    'input[type="radio"][name$="_status"]:checked',
  );
  let totalOk = 0;
  let totalNg = 0;

  allRadios.forEach((radio) => {
    // Convert to uppercase para match kahit 'ok' o 'OK' ang value
    if (radio.value.toUpperCase() === "OK") totalOk++;
    else if (radio.value.toUpperCase() === "NG") totalNg++;
  });

  const okField = document.getElementById("total-ok");
  const ngField = document.getElementById("total-ng");

  if (okField) okField.value = totalOk;
  if (ngField) ngField.value = totalNg;
}

// --- 3. TOGGLE REPLACEMENT FORM ---
function toggleSubForm() {
  const replacementBox = document.getElementById("replacement-details");
  const replaceYes = document.getElementById("replace_yes");

  if (replacementBox && replaceYes) {
    replacementBox.style.display = replaceYes.checked ? "block" : "none";
  }
}

// --- 4. MODAL CONTROLS ---
function openInspectionModal() {
  const modal = document.querySelector(".modal-container");
  if (modal) {
    modal.style.display = "block";
    document.body.style.overflow = "hidden"; // Lock scroll
  }
}

function closeInspectionModal() {
  const modal = document.querySelector(".modal-container");
  const form = document.getElementById("form");

  if (modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto"; // Unlock scroll
    if (form) form.reset();

    // Reset previews to default text
    document.getElementById("preview_before").innerHTML =
      '<span class="preview-text">No image selected</span>';
    document.getElementById("preview_after").innerHTML =
      '<span class="preview-text">No image selected</span>';
  }
}

// --- 5. FETCH DATA FOR VIEW MODAL ---
function openViewModal(id) {
  // I-reset muna ang form para malinis
  const modalForm = document.getElementById("form");
  if (modalForm) modalForm.reset();

  document.getElementById("preview_before").innerHTML = "Loading...";
  document.getElementById("preview_after").innerHTML = "Loading...";

  fetch(`../../include/logFunction.php?fetch_id=${id}`)
    .then((response) => response.json())
    .then((res) => {
      if (res.status === "success") {
        const data = res.data;

        // A. Header Information (IDs from your HTML)
        document.getElementById("section").value = data.section || "";
        document.getElementById("control-number").value =
          data.control_number || "";
        document.getElementById("technician").value =
          data.technician_name || "";
        document.getElementById("item_key").value = data.item_key || "";
        document.getElementById("customer").value = data.customer || "";
        document.getElementById("date").value = data.date_of_verification || "";

        // B. Quarter Radio Buttons
        if (data.quarter) {
          const qRadio = document.querySelector(
            `input[name="quarter"][value="${data.quarter}"]`,
          );
          if (qRadio) qRadio.checked = true;
        }

        // C. Evidence Photos
        document.getElementById("preview_before").innerHTML =
          data.photo_before_path
            ? `<img src="../../src/uploads/${data.photo_before_path}" style="width:100%;">`
            : "No image";
        document.getElementById("preview_after").innerHTML =
          data.photo_after_path
            ? `<img src="../../src/uploads/${data.photo_after_path}" style="width:100%;">`
            : "No image";

        // D. Appearance Conditions (Radio Logic)
        const conditions = [
          "deformation",
          "corrosion",
          "crack",
          "foreign_material",
          "alignment",
        ];
        conditions.forEach((c) => {
          const statusVal = data[`${c}_status`]; // e.g., 'ok' from DB
          const remarksVal = data[`${c}_remarks`];

          // Match case (toLowerCase) to your HTML value="ok"
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

        // E. Replacement Details
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

        // F. Summary Findings
        document.getElementById("total-ok").value = data.total_ok || 0;
        document.getElementById("total-ng").value = data.total_ng || 0;

        // G. UI Refresh
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

// --- 6. EVENT LISTENERS (Initialize on Load) ---
document.addEventListener("DOMContentLoaded", function () {
  // A. Replacement Toggle Listener
  const replaceRadios = document.querySelectorAll(
    'input[name="replacement_required"]',
  );
  replaceRadios.forEach((radio) => {
    radio.addEventListener("change", toggleSubForm);
  });

  // B. Auto Calculate Listener (Para sa OK/NG radios)
  document.addEventListener("change", function (e) {
    if (e.target.name && e.target.name.includes("_status")) {
      calculateTotals();
    }
  });

  // C. Modal Exit Button
  const exitBtn = document.getElementById("exit");
  if (exitBtn) {
    exitBtn.addEventListener("click", (e) => {
      e.preventDefault();
      closeInspectionModal();
    });
  }

  // D. Click Outside Modal to Close
  const modal = document.querySelector(".modal-container");
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeInspectionModal();
    }
  });
});
