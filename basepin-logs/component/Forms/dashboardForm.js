function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `<img src="${e.target.result}" style="max-width:90%;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function viewFullImage(src, title) {
    const zoomModal = document.getElementById("imageZoomModal");
    const fullImg = document.getElementById("imgFullView");
    const captionText = document.getElementById("caption");
    const mainModal = document.querySelector(".modal-container");

    if (!zoomModal || !fullImg) return;

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

    if (zoomModal) zoomModal.style.display = "none";
    
    if (mainModal && mainModal.style.display === "flex") {
        document.body.style.overflow = "hidden";
        mainModal.style.overflow = "auto";
    } else {
        document.body.style.overflow = "auto";
    }
}

function calculateTotals() {
    const terminalCards = document.querySelectorAll('.terminal-inspection-card');
    let totalOk = 0;
    let totalNg = 0;

    terminalCards.forEach((card) => {
        const checkedRadios = card.querySelectorAll('input[type="radio"]:checked');
        
        let hasError = false;
        checkedRadios.forEach(radio => {
            if (radio.value.toLowerCase() === 'ng') {
                hasError = true;
            }
        });

        if (checkedRadios.length > 0) { 
            if (!hasError) {
                totalOk++; 
            } else {
                totalNg++; 
            }
        }
    });

    const replacementRows = document.querySelectorAll('.replacement-row-item');
    totalOk += replacementRows.length;

    const okField = document.getElementById("total-ok");
    const ngField = document.getElementById("total-ng");

    if (okField) okField.value = totalOk;
    if (ngField) ngField.value = totalNg;
}

function openInspectionModal() {
    const modal = document.getElementById("mainModalContainer");
    if (modal) {
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    }
}

function closeInspectionModal() {
    const modal = document.getElementById("mainModalContainer");
    if (modal) modal.style.display = "none";
    
    document.body.style.overflow = "auto";
    const form = document.getElementById("form");
    if (form) form.reset();
    
    document.getElementById("dynamic-terminals-container").innerHTML = "";
    document.getElementById("dynamic-replacement-container").innerHTML = "";
}

function openViewModal(id) {
    const modal = document.getElementById("mainModalContainer");
    const termContainer = document.getElementById("dynamic-terminals-container");
    const repContainer = document.getElementById("dynamic-replacement-container");
    
    termContainer.innerHTML = "<h3 style='text-align:center;'>Loading data...</h3>";
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";

    fetch(`../../include/logFunction.php?fetch_id=${id}`)
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success' && res.data) {
                const data = res.data;

                document.getElementById('section').value = data.section || '';
                document.getElementById('control-number').value = data.control_number || '';
                document.getElementById('technician').value = data.technician_name || '';
                document.getElementById('item_key').value = data.item_key || '';
                document.getElementById('customer').value = data.customer || '';
                document.getElementById('date').value = data.date_of_verification || '';

                if (data.quarter) {
                    const qEl = document.getElementById(data.quarter.toLowerCase());
                    if (qEl) qEl.checked = true;
                }

                const terminals = data.terminals || [];
                document.getElementById('terminal_qty').value = terminals.length;
                
                termContainer.innerHTML = ""; 
                if (typeof viewGeneratedRows === "function") viewGeneratedRows(); 
          

                terminals.forEach((term, index) => {
                    const i = index + 1;
                    
                    if (document.getElementById(`no_${i}`)) document.getElementById(`no_${i}`).value = term.row_no || ''; 
                    if (document.getElementById(`terminal_part_no_${i}`)) document.getElementById(`terminal_part_no_${i}`).value = term.terminal_part_no || '';

                    const conditions = [
                        { key: 'deformation', short: 'def' },
                        { key: 'corrosion', short: 'corr' },
                        { key: 'crack', short: 'crack' },
                        { key: 'foreign_material', short: 'mat' },
                        { key: 'alignment', short: 'align' }
                    ];

                    conditions.forEach(cond => {
                        const status = term[cond.key + '_status'];
                        const rb = document.getElementById(`${cond.short}_${status}_${i}`);
                        if (rb) rb.checked = true;

                        const remInput = document.getElementsByName(cond.key + '_remarks[]')[index];
                        if (remInput) remInput.value = term[cond.key + '_remarks'] || '';
                    });

                    const beforePrev = document.getElementById(`preview_before_${i}`);
                    const afterPrev = document.getElementById(`preview_after_${i}`);

                    if (beforePrev) {
                        beforePrev.innerHTML = term.photo_before_path 
                            ? `<img src="../../src/uploads/${term.photo_before_path}" style="max-width:90%; cursor: zoom-in;" onclick="viewFullImage('../../src/uploads/${term.photo_before_path}', 'Before Verification')">`
                            : "No image";
                    }
                    if (afterPrev) {
                        afterPrev.innerHTML = term.photo_after_path 
                            ? `<img src="../../src/uploads/${term.photo_after_path}" style="max-width:90%; cursor: zoom-in;" onclick="viewFullImage('../../src/uploads/${term.photo_after_path}', 'After Verification')">`
                            : "No image";
                    }
                });

                const replacements = data.replacements || [];
                const repYes = document.getElementById('replace_yes');
                const repNo = document.getElementById('replace_no');

                if (replacements.length > 0) {
                    if (repYes) repYes.checked = true;
                    document.getElementById('replacement_qty').value = replacements.length;
                    repContainer.innerHTML = ""; 
                    if (typeof viewGeneratedReplacementRows === "function") viewGeneratedReplacementRows();

                    replacements.forEach((rep, index) => {
                        const rIdx = index;
                        const fields = ['reason_replacement', 'date_replaced', 'replacement_technician', 'change_point_no', 'replacement_terminal_replace_no'];
                        fields.forEach(field => {
                            const elArr = document.getElementsByName(`${field}[]`);
                            if (elArr && elArr[rIdx]) elArr[rIdx].value = rep[field] || '';
                        });
                    });
                } else {
                    if (repNo) repNo.checked = true;
                    document.getElementById('replacement_qty').value = 0;
                    repContainer.innerHTML = "";
                }

                setTimeout(calculateTotals, 100);
            } else {
                alert("Error: " + (res.msg || "Could not fetch data."));
            }
        })
        .catch(err => {
            console.error("Fetch Error:", err);
            termContainer.innerHTML = "<h3 style='color:red;'>Failed to load data.</h3>";
        });
}

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("change", function (e) {
        if (e.target.name && e.target.name.includes("_status")) {
            calculateTotals();
        }
        if (e.target.name === 'replacement_required') {
            if (typeof toggleSubForm === "function") toggleSubForm();
        }
    });

    const exitBtn = document.getElementById("exit");
    if (exitBtn) {
        exitBtn.addEventListener("click", (e) => {
            e.preventDefault();
            closeInspectionModal();
        });
    }

    window.addEventListener("click", (event) => {
        const modal = document.getElementById("mainModalContainer");
        const zoomModal = document.getElementById("imageZoomModal");
        if (event.target === modal) closeInspectionModal();
        if (event.target === zoomModal) closeZoom();
    });
});