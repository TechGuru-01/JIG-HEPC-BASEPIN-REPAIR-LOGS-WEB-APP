<div class="form-section">
    <h2>1. Terminal Inspection</h2>
</div>

<div class="form-group">
    <label for="section">Section:</label>
    <select name="section" id="section" required>
        <option value="" disabled selected>Select your section</option>
        <option value="section_a">Section A</option>
        <option value="section_b">Section B</option>
        <option value="section_c">Section C</option>
    </select>
</div>

<div class="form-group">
    <label for="control-number">JIG/ Board Control No. :</label>
    <input type="text" id="control-number" name="control-number">
</div>

<div class="form-group">
    <label for="technician">Technician :</label>
    <input type="text" id="technician" name="technician">
</div>

<div class="form-group">
    <label for="date">Date of Verification:</label>
    <input type="date" id="date" name="date" required>
</div>

<div class="checkbox-group full-width">
    <div class="checkbox-text">
        <p>Select Quarter:</p>
    </div>
    <div class="checkbox-items">
        <div class="status-item">
            <input type="checkbox" id="q1" name="quarter" value="Q1">
            <label for="q1">
                <span class="hide-on-mobile">Quarter 1</span>
                <span class="mobile-only">Q1</span>
            </label>
        </div>
        <div class="status-item">
            <input type="checkbox" id="q2" name="quarter" value="Q2">
            <label for="q2">
                <span class="hide-on-mobile">Quarter 2</span>
                <span class="mobile-only">Q2</span>
            </label>
        </div>
        <div class="status-item">
            <input type="checkbox" id="q3" name="quarter" value="Q3">
            <label for="q3">
                <span class="hide-on-mobile">Quarter 3</span>
                <span class="mobile-only">Q3</span>
            </label>
        </div>
        <div class="status-item">
            <input type="checkbox" id="q4" name="quarter" value="Q4">
            <label for="q4">
                <span class="hide-on-mobile">Quarter 4</span>
                <span class="mobile-only">Q4</span>
            </label>
        </div>
    </div>
</div>

<div class="checkbox-group full-width">
    <div class="checkbox-text">
        <p>Evidence Photos (Optional):</p>
    </div>
    <div class="upload-container">
        <div class="upload-box">
            <label for="photo_before">Before Verification</label>
            <input type="file" id="photo_before" name="photo_before" accept="image/*" onchange="previewImage(this, 'preview_before')">
            <div id="preview_before" class="image-preview">
                <span class="preview-text">No image selected</span>
            </div>
        </div>
        <div class="upload-box">
            <label for="photo_after">After Verification</label>
            <input type="file" id="photo_after" name="photo_after" accept="image/*" onchange="previewImage(this, 'preview_after')">
            <div id="preview_after" class="image-preview">
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
                    <input type="checkbox" id="def_ok" name="def_status" value="ok" class="status-check">
                    <label for="def_ok" class="label-ok">OK</label>
                </div>
                <div class="status-item">
                    <input type="checkbox" id="def_ng" name="def_status" value="ng" class="status-check">
                    <label for="def_ng" class="label-ng">NG</label>
                </div>
            </div>
            <input type="text" name="def_remarks" placeholder="Remarks" class="remarks-input">
        </div>
    </div>

    <div class="appearance-row">
        <span class="condition-label">No Corrosion / Discoloration</span>
        <div class="action-container">
            <div class="status-group">
                <div class="status-item">
                    <input type="checkbox" id="corr_ok" name="corr_status" value="ok" class="status-check">
                    <label for="corr_ok" class="label-ok">OK</label>
                </div>
                <div class="status-item">
                    <input type="checkbox" id="corr_ng" name="corr_status" value="ng" class="status-check">
                    <label for="corr_ng" class="label-ng">NG</label>
                </div>
            </div>
            <input type="text" name="corr_remarks" placeholder="Remarks" class="remarks-input">
        </div>
    </div>

    <div class="appearance-row">
        <span class="condition-label">No Cracks / Dents</span>
        <div class="action-container">
            <div class="status-group">
                <div class="status-item">
                    <input type="checkbox" id="crack_ok" name="crack_status" value="ok" class="status-check">
                    <label for="crack_ok" class="label-ok">OK</label>
                </div>
                <div class="status-item">
                    <input type="checkbox" id="crack_ng" name="crack_status" value="ng" class="status-check">
                    <label for="crack_ng" class="label-ng">NG</label>
                </div>
            </div>
            <input type="text" name="crack_remarks" placeholder="Remarks" class="remarks-input">
        </div>
    </div>

    <div class="appearance-row">
        <span class="condition-label">No Foreign Material</span>
        <div class="action-container">
            <div class="status-group">
                <div class="status-item">
                    <input type="checkbox" id="mat_ok" name="mat_status" value="ok" class="status-check">
                    <label for="mat_ok" class="label-ok">OK</label>
                </div>
                <div class="status-item">
                    <input type="checkbox" id="mat_ng" name="mat_status" value="ng" class="status-check">
                    <label for="mat_ng" class="label-ng">NG</label>
                </div>
            </div>
            <input type="text" name="mat_remarks" placeholder="Remarks" class="remarks-input">
        </div>
    </div>

    <div class="appearance-row">
        <span class="alignment-label">Proper Alignment</span>
        <div class="action-container">
            <div class="status-group">
                <div class="status-item">
                    <input type="checkbox" id="align_ok" name="align_status" value="ok" class="status-check">
                    <label for="align_ok" class="label-ok">OK</label>
                </div>
                <div class="status-item">
                    <input type="checkbox" id="align_ng" name="align_status" value="ng" class="status-check">
                    <label for="align_ng" class="label-ng">NG</label>
                </div>
            </div>
            <input type="text" name="align_remarks" placeholder="Remarks" class="remarks-input">
        </div>
    </div>
</div>