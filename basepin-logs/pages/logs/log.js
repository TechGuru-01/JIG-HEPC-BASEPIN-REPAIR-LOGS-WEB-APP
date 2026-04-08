let selectedIds = 


document.addEventListener("click", function(e) {
    const btn = e.target.closest(".sel_btn");
    if (btn) {
        const id = btn.getAttribute("data-id");
        btn.classList.toggle("active");

        if (btn.classList.contains("active")) {
            if (!selectedIds.includes(id)) selectedIds.push(id);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: 'Record selected'
            });

        } else {
            selectedIds = selectedIds.filter(item => item !== id);
            
            const masterCb = document.getElementById('selectAllCheckbox');
            if (masterCb) masterCb.checked = false;
        }
        updateMasterCheckboxState(); 
        console.log("Current Selection:", selectedIds);
    }
});


document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'selectAllCheckbox') {
        const isChecked = e.target.checked;
        const visibleButtons = document.querySelectorAll('#logsTableContainer .sel_btn');

        visibleButtons.forEach(btn => {
            const id = btn.getAttribute("data-id");
            if(id == null || id = " "){
                continue;
            }
            if (isChecked) {
                btn.classList.add('active');
                if (!selectedIds.includes(id)) selectedIds.push(id);
            } else {
                btn.classList.remove('active');
                selectedIds = selectedIds.filter(item => item !== id);
            }
        });
        console.log("Current Selection (Select All):", selectedIds);
    }
});


function updateMasterCheckboxState() {
    const masterCb = document.getElementById('selectAllCheckbox');
    const visibleButtons = document.querySelectorAll('#logsTableContainer .sel_btn');
    
    if (masterCb && visibleButtons.length > 0) {
        const allVisibleSelected = Array.from(visibleButtons).every(btn => 
            selectedIds.includes(btn.getAttribute("data-id"))
        );
        masterCb.checked = allVisibleSelected;
    }
}


document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('mainSearch');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const tableContainer = document.getElementById('logsTableContainer'); 

    if (!tableContainer) return;

    function fetchFilteredData() {
        const query = searchInput.value || '';
        const from = dateFrom.value || '';
        const to = dateTo.value || '';

        fetch(`../../component/logsTableHandler/logsTableHandler.php?search=${encodeURIComponent(query)}&dateFrom=${from}&dateTo=${to}`)
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                reapplySelection(); 
                updateMasterCheckboxState(); 
            })
            .catch(error => console.error('Error:', error));
    }

    searchInput?.addEventListener('input', fetchFilteredData);
    dateFrom?.addEventListener('change', fetchFilteredData);
    dateTo?.addEventListener('change', fetchFilteredData);
});


function reapplySelection() {
    if (selectedIds.length > 0) {
        selectedIds.forEach(id => {
            const btn = document.querySelector(`.sel_btn[data-id="${id}"]`);
            if (btn) {
                btn.classList.add('active'); 
            }
        });
    }
}


function triggerExport() {
    if (selectedIds.length === 0) {
        Swal.fire({ icon: 'error', title: 'Oops!', text: 'Please select atleast one entry.' });
        return;
    }
     Swal.fire({
        title: 'Export to Excel?',
        text: `${selectedIds.length} record(s) will be exported`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#15c951',
        cancelButtonColor: '#ff0000',
        confirmButtonText: 'Export',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                text: 'Preparing your Excel File.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
            const idsParam = selectedIds.join(",");
            window.location.href = "../../include/exportHandler.php?ids=" + idsParam;
        }
    });
}