function openModal(btn) {
  const modal = document.getElementById("detailsModal");

  // Kunin ang data mula sa attributes ng button
  document.getElementById("m-tech").innerText = btn.getAttribute("data-tech");
  document.getElementById("m-quarter").innerText =
    btn.getAttribute("data-quarter");
  document.getElementById("m-inspected").innerText =
    btn.getAttribute("data-inspected");

  const ok = btn.getAttribute("data-ok");
  const ng = btn.getAttribute("data-ng");
  document.getElementById("m-summary").innerText = `OK: ${ok} | NG: ${ng}`;

  // Replacement logic
  const hasReplacement = btn.getAttribute("data-replacement");
  const replacementSection = document.getElementById("m-replacement-section");

  if (hasReplacement == "1" || hasReplacement == "yes") {
    replacementSection.style.display = "block";
    document.getElementById("m-partno").innerText =
      btn.getAttribute("data-partno");
    document.getElementById("m-reason").innerText =
      btn.getAttribute("data-reason");
    document.getElementById("m-cp").innerText = btn.getAttribute("data-cp");
  } else {
    replacementSection.style.display = "none";
  }

  modal.style.display = "block";
}

function closeModal() {
  document.getElementById("detailsModal").style.display = "none";
}

// Close modal pag clinick sa labas ng box
window.onclick = function (event) {
  const modal = document.getElementById("detailsModal");
  if (event.target == modal) {
    closeModal();
  }
};
