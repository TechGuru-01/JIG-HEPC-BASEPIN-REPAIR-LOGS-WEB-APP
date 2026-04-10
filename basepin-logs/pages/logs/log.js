let selectedIds = [];

document.addEventListener("click", function(e) {
    const btn = e.target.closest(".sel_btn");
    if (btn) {
        const id = btn.getAttribute("data-id");
        btn.classList.toggle("active");

        if (btn.classList.contains("active")) {
            if (!selectedIds.includes(id)) {
                selectedIds.push(id);
                
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
            }
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
            if (isChecked) {
                btn.classList.add('active');
                if (!selectedIds.includes(id)) selectedIds.push(id);
            } else {
                btn.classList.remove('active');
                selectedIds = selectedIds.filter(item => item !== id);
            }
        });
        console.log("Selection updated via Master Checkbox:", selectedIds);
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

    let timeout = null;
    function fetchFilteredData() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const query = searchInput ? searchInput.value : '';
            const from = dateFrom ? dateFrom.value : '';
            const to = dateTo ? dateTo.value : '';

            fetch(`../../component/logsTableHandler/logsTableHandler.php?search=${encodeURIComponent(query)}&dateFrom=${from}&dateTo=${to}`)
                .then(response => response.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    reapplySelection(); 
                    updateMasterCheckboxState(); 
                })
                .catch(error => console.error('Error fetching filtered data:', error));
        }, 300); 
    }

    searchInput?.addEventListener('input', fetchFilteredData);
    dateFrom?.addEventListener('change', fetchFilteredData);
    dateTo?.addEventListener('change', fetchFilteredData);
});

function reapplySelection() {
    selectedIds.forEach(id => {
        const btn = document.querySelector(`.sel_btn[data-id="${id}"]`);
        if (btn) {
            btn.classList.add('active'); 
        }
    });
}

function triggerExport() {
    if (selectedIds.length === 0) {
        Swal.fire({ 
            icon: 'error', 
            title: 'No records selected!', 
            text: 'You must select at least one record before you can proceed with the export.',
            confirmButtonColor: '#15c951'
        });
        return;
    }

    Swal.fire({
        title: 'Export to Excel?',
        text: `Preparing ${selectedIds.length} record(s) for download.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#15c951',
        cancelButtonColor: '#ff0000',
        confirmButtonText: 'Export Now',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                text: 'Generating Excel file, please hold on.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });

            const idsParam = selectedIds.join(",");
            window.location.href = "../../include/exportHandler.php?ids=" + idsParam;
        }
    });
}