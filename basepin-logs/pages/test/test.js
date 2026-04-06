document.getElementById('saveBtn').addEventListener('click', function() {
    const nameInput = document.getElementById('nameInput');
    const taskInput = document.getElementById('taskInput');
    const logContainer = document.getElementById('logContainer');

    // Validation
    if (nameInput.value.trim() === "" || taskInput.value.trim() === "") {
        alert("Paki-fill up lahat, boss.");
        return;
    }

    // Alisin ang empty message
    const emptyMsg = logContainer.querySelector('.empty-msg');
    if (emptyMsg) emptyMsg.remove();

    // Kunin ang oras
    const now = new Date();
    const timeStr = now.getHours() + ":" + now.getMinutes().toString().padStart(2, '0');

    // Create log element
    const logEntry = document.createElement('div');
    logEntry.className = 'log-item';
    logEntry.innerHTML = `<strong>[${timeStr}]</strong> ${nameInput.value}: ${taskInput.value}`;

    // I-add sa taas ng listahan
    logContainer.prepend(logEntry);

    // Clear inputs
    nameInput.value = "";
    taskInput.value = "";
});