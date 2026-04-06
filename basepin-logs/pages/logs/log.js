let selectedIds = [];

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
        }
        console.log("Current Selection:", selectedIds);
    }
});

function triggerExport() {
    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Please select atleast one entry.',
            confirmButtonColor: '#15c951'
        });
        return;
    }
    Swal.fire({
        title: 'Export to Excel?',
        text: `I-e-export natin ang ${selectedIds.length} na record(s).`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#15c951',
        cancelButtonColor: '#8392ab',
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('mainSearch');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const tableContainer = document.getElementById('logsTableContainer'); 


    if (!tableContainer) {
        console.error("No logsTableHandler found in the HTML");
        return;
    }


    function fetchFilteredData() {
        const query = searchInput.value || '';
        const from = dateFrom.value || '';
        const to = dateTo.value || '';

        fetch(`../../component/logsTableHandler/logsTableHandler.php?search=${encodeURIComponent(query)}&dateFrom=${from}&dateTo=${to}`)
            .then(response => {
                if (!response.ok) throw new Error("Server Error");
                return response.text();
            })
            .then(html => {
                tableContainer.innerHTML = html;
                reapplySelection();
            })
            .catch(error => console.error('Error:', error));
    }
    searchInput?.addEventListener('input', fetchFilteredData);
    dateFrom?.addEventListener('change', fetchFilteredData);
    dateTo?.addEventListener('change', fetchFilteredData);
});


function reapplySelection() {
    if (typeof selectedIds !== 'undefined' && Array.isArray(selectedIds) && selectedIds.length > 0) {
        selectedIds.forEach(id => {
            const btn = document.querySelector(`.sel_btn[data-id="${id}"]`);
            if (btn) {
                btn.classList.add('active'); 
            }
        });
    }
}