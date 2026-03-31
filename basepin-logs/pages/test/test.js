function openModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("fullImage");
    
    modal.style.display = "block";
    modalImg.src = src;
}

function closeModal() {
    const modal = document.getElementById("imageModal");
    modal.style.display = "none";
}

// Close modal pag clinick sa labas ng image
window.onclick = function(event) {
    const modal = document.getElementById("imageModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}