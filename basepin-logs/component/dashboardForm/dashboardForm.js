const checkbox = document.getElementById('replace_yes');
const submitBtn = document.getElementById('submitBtn');

checkbox.addEventListener('change', function() {
    if (this.checked) {
        // Kapag naka-check, paganahin ang button
        submitBtn.disabled = false;
    } else {
        // Kapag tinanggal ang check, patayin ulit ang button
        submitBtn.disabled = true;
    }
});


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
