var menuBtn = document.getElementById('menuBtn');
if(menuBtn !== null) {
    menuBtn.addEventListener('click', function(el){
        menuBtn.classList.toggle('active');
    });
}

