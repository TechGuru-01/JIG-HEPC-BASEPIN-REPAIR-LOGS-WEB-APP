function generateRows() {
  const qty = document.getElementById("terminal_qty").value;
  const container = document.getElementById("dynamic-terminals-container");
  container.innerHTML = "";

  for (let i = 1; i <= qty; i++) {
    const rowHTML = `
            <div class="terminal-inspection-card" style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                <h3 style="color: #1565c0;">Terminal #${i}</h3>

                <div class="checkbox-group full-width">
                    <div class="form-group">
                        <label for="no_${i}">No.:</label>
                        <input type="text" id="no_${i}" name="no[]">
                    </div>

                    <div class="form-group">
                        <label for="terminal_part_no_${i}">Terminal Part No.:</label>
                        <input type="text" id="terminal_part_no_${i}" name="terminal_part_no[]">
                    </div>

                    <div class="checkbox-text">
                        <p>Evidence Photos:</p>
                    </div>

                    <div class="upload-container">
                        <div class="upload-box">
                            <label for="photo_before_${i}">Before Verification</label>
                            <input type="file" id="photo_before_${i}" name="photo_before[]" accept="image/*" onchange="previewImage(this, 'preview_before_${i}')">
                            <div id="preview_before_${i}" class="image-preview">
                                <span class="preview-text">No image selected</span>
                            </div>
                        </div>
                        <div class="upload-box">
                            <label for="photo_after_${i}">After Verification</label>
                            <input type="file" id="photo_after_${i}" name="photo_after[]" accept="image/*" onchange="previewImage(this, 'preview_after_${i}')">
                            <div id="preview_after_${i}" class="image-preview">
                                <span class="preview-text">No image selected</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checkbox-group full-width">
                    <div class="checkbox-text">
                        <p>Appearance Condition (Check all that Apply):</p>
                    </div>

                    <div class="appearance-row">
                        <span class="condition-label">No Deformation / Bending</span>
                        <div class="action-container">
                            <div class="status-group">
                                <div class="status-item">
                                    <input type="radio" id="def_ok_${i}" name="deformation_status_${i}" value="ok" class="status-check">
                                    <label for="def_ok_${i}" class="label-ok">OK</label>
                                </div>
                                <div class="status-item">
                                    <input type="radio" id="def_ng_${i}" name="deformation_status_${i}" value="ng" class="status-check">
                                    <label for="def_ng_${i}" class="label-ng">NG</label>
                                </div>
                            </div>
                            <input type="text" name="deformation_remarks[]" placeholder="Remarks" class="remarks-input">
                        </div>
                    </div>

                    <div class="appearance-row">
                        <span class="condition-label">No Corrosion / Discoloration</span>
                        <div class="action-container">
                            <div class="status-group">
                                <div class="status-item">
                                    <input type="radio" id="corr_ok_${i}" name="corrosion_status_${i}" value="ok" class="status-check">
                                    <label for="corr_ok_${i}" class="label-ok">OK</label>
                                </div>
                                <div class="status-item">
                                    <input type="radio" id="corr_ng_${i}" name="corrosion_status_${i}" value="ng" class="status-check">
                                    <label for="corr_ng_${i}" class="label-ng">NG</label>
                                </div>
                            </div>
                            <input type="text" name="corrosion_remarks[]" placeholder="Remarks" class="remarks-input">
                        </div>
                    </div>

                    <div class="appearance-row">
                        <span class="condition-label">No Cracks / Dents</span>
                        <div class="action-container">
                            <div class="status-group">
                                <div class="status-item">
                                    <input type="radio" id="crack_ok_${i}" name="crack_status_${i}" value="ok" class="status-check">
                                    <label for="crack_ok_${i}" class="label-ok">OK</label>
                                </div>
                                <div class="status-item">
                                    <input type="radio" id="crack_ng_${i}" name="crack_status_${i}" value="ng" class="status-check">
                                    <label for="crack_ng_${i}" class="label-ng">NG</label>
                                </div>
                            </div>
                            <input type="text" name="crack_remarks[]" placeholder="Remarks" class="remarks-input">
                        </div>
                    </div>

                    <div class="appearance-row">
                        <span class="condition-label">No Foreign Material</span>
                        <div class="action-container">
                            <div class="status-group">
                                <div class="status-item">
                                    <input type="radio" id="mat_ok_${i}" name="foreign_material_status_${i}" value="ok" class="status-check">
                                    <label for="mat_ok_${i}" class="label-ok">OK</label>
                                </div>
                                <div class="status-item">
                                    <input type="radio" id="mat_ng_${i}" name="foreign_material_status_${i}" value="ng" class="status-check">
                                    <label for="mat_ng_${i}" class="label-ng">NG</label>
                                </div>
                            </div>
                            <input type="text" name="foreign_material_remarks[]" placeholder="Remarks" class="remarks-input">
                        </div>
                    </div>

                    <div class="appearance-row">
                        <span class="alignment-label">Proper Alignment</span>
                        <div class="action-container">
                            <div class="status-group">
                                <div class="status-item">
                                    <input type="radio" id="align_ok_${i}" name="alignment_status_${i}" value="ok" class="status-check">
                                    <label for="align_ok_${i}" class="label-ok">OK</label>
                                </div>
                                <div class="status-item">
                                    <input type="radio" id="align_ng_${i}" name="alignment_status_${i}" value="ng" class="status-check">
                                    <label for="align_ng_${i}" class="label-ng">NG</label>
                                </div>
                            </div>
                            <input type="text" name="alignment_remarks[]" placeholder="Remarks" class="remarks-input">
                        </div>
                    </div>
                </div>
            </div>
        `;
    container.insertAdjacentHTML("beforeend", rowHTML);
  }
}
