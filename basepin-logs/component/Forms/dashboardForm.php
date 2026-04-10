<form action="../../include/formResponseHandler.php" method="POST" id="form" class="main-form" enctype="multipart/form-data">
    
    <div class="form-section">
        <h2>1. Terminal Inspection</h2>
    </div>

    <div class="form-group">
        <label for="section">Section:</label>
        <select name="section" id="section"> 
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
        <input type="text" id="control-number" name="control_number">
    </div>

    <div class="form-group">
        <label for="technician">Technician :</label>
        <input type="text" id="technician" name="technician_name">
    </div>

    <div class="form-group">
        <label for="item_key">Item Key :</label>
        <input type="text" id="item_key" name="item_key">
    </div>

    <div class="form-group">
        <label for="customer">Customer :</label>
        <input type="text" id="customer" name="customer">
    </div>

    <div class="form-group">
        <label for="date">Date of Verification:</label>
        <input type="date" id="date" name="date_of_verification">
    </div>

    <div class="checkbox-group full-width">
        <div class="checkbox-text">
            <p>Select Quarter:</p>
        </div>
        <div class="checkbox-items">
            <div class="status-item">
                <input type="radio" id="q1" name="quarter" value="Q1">
                <label for="q1">
                    <span class="hide-on-mobile">Quarter 1</span>
                    <span class="mobile-only">Q1</span>
                </label>
            </div>
            <div class="status-item">
                <input type="radio" id="q2" name="quarter" value="Q2">
                <label for="q2">
                    <span class="hide-on-mobile">Quarter 2</span>
                    <span class="mobile-only">Q2</span>
                </label>
            </div>
            <div class="status-item">
                <input type="radio" id="q3" name="quarter" value="Q3">
                <label for="q3">
                    <span class="hide-on-mobile">Quarter 3</span>
                    <span class="mobile-only">Q3</span>
                </label>
            </div>
            <div class="status-item">
                <input type="radio" id="q4" name="quarter" value="Q4">
                <label for="q4">
                    <span class="hide-on-mobile">Quarter 4</span>
                    <span class="mobile-only">Q4</span>
                </label>
            </div>
        </div>
    </div>

    <div class=" full-width" style="background: #f8fafc; width:100%; padding: 10px 15px; border-radius: 6px; margin: 15px 0; border: 1px solid #e2e8f0; display: inline-block;">
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <label style="font-size: 0.9rem; font-weight: bold; color: #475569;">Qty to Inspect:</label>
            <input type="number" id="terminal_qty" value="1" min="1" max="50" 
                style="width: 60px; padding: 5px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem;">
            
            <button type="button" onclick="generateRows()" 
                    style="background: #ff0000; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: 0.2s;">
                Generate Rows
            </button>
        </div>
        <div id="dynamic-terminals-container">
            </div>
    </div>

    <div class="form-section" style="margin-top:30px;">
        <h2>2. Summary Findings</h2>
    </div>

    <div class="form-group">
        <label for="total-ok">Total OK:</label>
        <input type="text" id="total-ok" name="total_ok" readonly>
    </div>

    <div class="form-group">
        <label for="total-ng">Total NG:</label>
        <input type="text" id="total-ng" name="total_ng" readonly>
    </div>

    <div class="form-group">
        <label>Were there any immediate replacements required?</label>
        <div class="status-group" style="margin-top: 5px;">
            <div class="status-item">
                <input type="radio" id="replace_yes" name="replacement_required" value="yes">
                <label for="replace_yes" class="label-ok">YES</label>
            </div>
            <div class="status-item">
                <input type="radio" id="replace_no" name="replacement_required" value="no" checked>
                <label for="replace_no" class="label-ng">NO</label>
            </div>
        </div>
    </div>

    <div id="replacement-details" class="checkbox-group full-width" style="display: none;">
        <div class="full-width" style="background: #f8fafc; width:100%; padding: 10px 15px; border-radius: 6px; margin: 15px 0; border: 1px solid #e2e8f0; display: inline-block;">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <label style="font-size: 0.9rem; font-weight: bold; color: #475569;">Qty to Replace:</label>
                <input type="number" id="replacement_qty" value="1" min="1" max="50" 
                    style="width: 60px; padding: 5px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem;">
                
                <button type="button" onclick="generateReplacementRows()" 
                        style="background: #ff0000; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: 0.2s;">
                    Generate Rows
                </button>
            </div>
             <div class="form-group">
                        <label for="date_replaced_${i}">Date Replaced:</label>
                        <input type="date" id="date_replaced_${i}" name="date_replaced[]">
                    </div>
            <div id="dynamic-replacement-container">
                </div>
        </div>
    </div>
          

    <div class="button-container">
        <button type="button" id="rstBtn"><span class="material-icons-outlined">restore</span>Reset Form</button>
        <button type="submit" id="submitBtn"><span class="material-icons-outlined">check_circle_outline</span>Submit Form</button>
    </div>

   
</form>
 <div id="imageZoomModal" onclick="closeZoom()" style="display:none; position:fixed; z-index:99999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); align-items:center; justify-content:center; flex-direction:column;">
    <span style="position:absolute; top:20px; right:40px; color:white; font-size:50px; cursor:pointer;">&times;</span>
    <div id="caption" style="position:absolute; top:20px; color:white; font-weight:bold; width:100%; text-align:center;"></div>
    <img id="imgFullView" src="" style="max-width: 100%; max-height: 85vh; border: 3px solid white; border-radius: 5px; object-fit: contain;">
    <p style="color: white; margin-top: 10px; font-size: 14px;">Scroll to Zoom In/Out</p>
</div>