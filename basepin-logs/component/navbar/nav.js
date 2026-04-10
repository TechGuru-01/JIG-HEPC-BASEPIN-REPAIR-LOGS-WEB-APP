

document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.querySelector('.profile-trigger');
    const dropdown = document.querySelector('.dropdown-menu');


    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });


    window.addEventListener('click', function() {
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    });
});