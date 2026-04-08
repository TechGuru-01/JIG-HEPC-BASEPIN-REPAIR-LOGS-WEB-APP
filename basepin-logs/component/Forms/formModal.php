<div class="modal-container" id="mainModalContainer">
    <form action="" method="POST" id="form" class="main-form-modal" enctype="multipart/form-data">
        <div class="form-section">
            <?php 
                include "inspectionModal.php";
                include "summaryModal.php";
            ?>
        </div> <div class="button-container">
            <button type="button" id="exit" onclick="closeInspectionModal()">Exit</button>
        </div>
    </form>
</div> 

<div id="imageZoomModal" onclick="closeZoom()" style="display:none; position:fixed; z-index:99999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); align-items:center; justify-content:center; flex-direction:column;">
    
    <span onclick="closeZoom()" style="position:absolute; top:20px; right:40px; color:white; font-size:50px; cursor:pointer; z-index:100000;">&times;</span>
    
    <div id="caption" style="position:absolute; top:20px; color:white; font-weight:bold; width:100%; text-align:center;"></div>
    
    <img id="imgFullView" src="" style="max-width: 90%; max-height: 85vh; border: 3px solid white; border-radius: 5px; object-fit: contain; pointer-events: auto;">

    <p style="color: white; margin-top: 10px; font-size: 14px;">Scroll to Zoom In/Out</p>
</div>