<div class="form-section">
    <h2>2. Summary Findings</h2>
</div>

<div class="form-group">
    <label for="total-ok">Total OK:</label>
    <input type="text" id="total-ok" name="total_ok">
</div>

<div class="form-group">
    <label for="total-ng">Total NG:</label>
    <input type="text" id="total-ng" name="total_ng">
</div>

<div class="form-group">
    <label>Were there any immediate replacements required?</label>
    <div class="status-group" style="margin-top: 5px;">
        <div class="status-item">
            <input type="radio" id="replace_yes" name="replacement_required" value="yes" >
            <label for="replace_yes" class="label-ok">YES</label>
        </div>
        <div class="status-item">
            <input type="radio" id="replace_no" name="replacement_required" value="no">
            <label for="replace_no" class="label-ng">NO</label>
        </div>
    </div>
</div>

<div id="replacement-details" class="checkbox-group full-width" style="display: none; border-left: 5px solid red; background-color: #fff0f0;">
    <div class="checkbox-text">
        <p>Replacement Details:</p>
    </div>
    
    <div class="main-form" style="padding: 0; box-shadow: none; background: transparent; margin-top: 0;">
        <div class="form-group">
            <label for="terminal_part_no">Terminal Part No.:</label>
            <input type="text" id="terminal_part_no" name="terminal_part_no">
        </div>

        <div class="form-group">
            <label for="reason_replacement">Reason for Replacement:</label>
            <input type="text" id="reason_replacement" name="reason_replacement">
        </div>

        <div class="form-group">
            <label for="date_replaced">Date Replaced:</label>
            <input type="date" id="date_replaced" name="date_replaced">
        </div>

        <div class="form-group">
            <label for="replacement_technician">Technician:</label>
            <input type="text" id="replacement_technician" name="replacement_technician">
        </div>

        <div class="form-group full-width">
            <label for="change_point_no">Change Point Control No.:</label>
            <input type="text" id="change_point_no" name="change_point_no">
        </div>
    </div>
</div>