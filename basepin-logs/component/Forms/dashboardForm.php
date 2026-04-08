<form action="../../include/formResponseHandler.php" method="POST" id="form" class="main-form" enctype="multipart/form-data">
   <?php 
    include "inspection.php";
    include "summary.php";
   ?>
    <div class="button-container">
        <button type="button" id="rstBtn"><span class="material-icons-outlined">restore</span>Reset Form</button>
        <button type="submit" id="submitBtn" ><span class="material-icons-outlined">check_circle_outline</span>Submit Form</button>
    </div>
</form>