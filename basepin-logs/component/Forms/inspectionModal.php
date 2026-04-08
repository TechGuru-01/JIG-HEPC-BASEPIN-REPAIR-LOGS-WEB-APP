<div class="form-section">
    <h2>1. Terminal Inspection</h2>
</div>
<div class="form-group">
            <label for="section">Section:</label>
            <select name="section" id="section" disabled> 
                <option value="" disabled selected>Select your section</option>
                <option value="AOD">AOD</option>
                <option value="AUD">AUD</option>
                <option value="ABD 1">ABD 1</option>
                <option value="ABD 2">ABD 2</option>
                <option value="CID">CID</option>
                <option value="AED">AED</option>
                <option value="PAD">PAD</option>
            </select>
        </div>

        <div class="form-group">
            <label for="control-number">JIG/ Board Control No. :</label>
            <input type="text" id="control-number" name="control_number" readonly>
        </div>

        <div class="form-group">
            <label for="technician">Technician :</label>
            <input type="text" id="technician" name="technician_name" readonly>
        </div>

        <div class="form-group">
            <label for="item_key">Item Key :</label>
            <input type="text" id="item_key" name="item_key" readonly>
        </div>

        <div class="form-group">
            <label for="customer">Customer :</label>
            <input type="text" id="customer" name="customer" readonly>
        </div>

        <div class="form-group">
            <label for="date">Date of Verification:</label>
            <input type="date" id="date" name="date_of_verification" readonly>
        </div>

        <div class="checkbox-group full-width" style="margin-top:15px;">
            <div class="checkbox-text">
                <p>Select Quarter:</p>
            </div>
            <div class="checkbox-items">
                <div class="status-item">
                    <input type="radio" id="q1" name="quarter" value="Q1" disabled>
                    <label for="q1">
                        <span class="hide-on-mobile">Quarter 1</span>
                        <span class="mobile-only">Q1</span>
                    </label>
                </div>
                <div class="status-item">
                    <input type="radio" id="q2" name="quarter" value="Q2" disabled>
                    <label for="q2">
                        <span class="hide-on-mobile">Quarter 2</span>
                        <span class="mobile-only">Q2</span>
                    </label>
                </div>
                <div class="status-item">
                    <input type="radio" id="q3" name="quarter" value="Q3" disabled>
                    <label for="q3">
                        <span class="hide-on-mobile">Quarter 3</span>
                        <span class="mobile-only">Q3</span>
                    </label>
                </div>
                <div class="status-item">
                    <input type="radio" id="q4" name="quarter" value="Q4" disabled>
                    <label for="q4">
                        <span class="hide-on-mobile">Quarter 4</span>
                        <span class="mobile-only">Q4</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="main-form" style="= box-shadow: none; background: transparent; margin-bottom:15px; ">
            <div class="form-group">
                        <label for="no">No.:</label>
                        <input type="text" id="no" name="no" readonly>
            </div>

            <div class="form-group">
                        <label for="terminal_part_no">Terminal Part No.:</label>
                        <input type="text" id="terminal_part_no" name="terminal_part_no" readonly>
            </div>
         </div>


        <div class="checkbox-group full-width">
            <div class="checkbox-text">
                <p>Evidence Photos:</p>
            </div>
            
            <div class="upload-container">
                <div class="upload-box">
                    <label for="photo_before">Before Verification Photo</label>
                    <input type="file" id="photo_before" disabled disabled name="photo_before" accept="image/*" onchange="previewImage(this, 'preview_before')">
                    <div id="preview_before" class="image-preview" style="cursor: pointer;>
                        <span class="preview-text">No image selected</span>
                    </div>
                </div>

                <div class="upload-box">
                    <label for="photo_after">After Verification Photo</label>
                    <input type="file" id="photo_after" disabled name="photo_after" accept="image/*" onchange="previewImage(this, 'preview_after')">
                    <div id="preview_after" class="image-preview" style="cursor: pointer;>
                        <span class="preview-text">No image selected</span>
                    </div>
                </div>
            </div>
        </div>