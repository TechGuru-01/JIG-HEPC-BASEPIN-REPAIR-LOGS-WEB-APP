function moveToggle(index, type, element) {
    const slider = document.getElementById('slider');
    const headerText = document.querySelector('.header-text h1'); 
    
    slider.style.transform = `translateX(${index * 100}%)`; 
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.3s ease';

    setTimeout(() => {
        if (type === 'logs') {
            window.location.href = '../../pages/logs/log.php';
        } else {
            window.location.href = '../../pages/dashboard/dashboard.php'; 
        }
    }, 300); 
}

window.onload = function() {
    const currentPath = window.location.pathname;
    const headerText = document.querySelector('.header-text h1');
    const slider = document.getElementById('slider');
    const tabs = document.querySelectorAll('.tab');

    if (currentPath.includes('log.php')) {
        headerText.innerText = "VIEW LOGS";
        slider.style.transform = 'translateX(100%)'; // Itulak sa kanan
        tabs[0].classList.remove('active');
        tabs[1].classList.add('active');
    } else {
        headerText.innerText = "INPUT FORM";
        slider.style.transform = 'translateX(0%)'; // Ibalik sa kaliwa
        tabs[1].classList.remove('active');
        tabs[0].classList.add('active');
    }
};