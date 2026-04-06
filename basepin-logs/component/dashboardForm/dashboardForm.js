function previewImage(input, previewId) {
  const preview = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.innerHTML = `<img src="${e.target.result}">`;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

document.querySelectorAll(".appearance-row").forEach((row) => {
  const checks = row.querySelectorAll(".status-check");
  checks.forEach((check) => {
    check.addEventListener("change", () => {
      if (check.checked) {
        checks.forEach((other) => {
          if (other !== check) other.checked = false;
        });
      }
    });
  });
});

document.addEventListener("change", function(e) {
    if (e.target.name.includes("_status")) {
        calculateTotals();
    }
});

function calculateTotals() {
    const allRadios = document.querySelectorAll('input[type="radio"][name$="_status"]:checked');
    
    let totalOk = 0;
    let totalNg = 0;

    allRadios.forEach(radio => {
        if (radio.value.toUpperCase() === "OK") {
            totalOk++;
        } else if (radio.value.toUpperCase() === "NG") {
            totalNg++;
        }
    });

    document.getElementById("total-ok").value = totalOk;
    document.getElementById("total-ng").value = totalNg;
}