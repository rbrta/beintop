document.addEventListener("DOMContentLoaded", function(){

    var menuBtn = document.getElementById('menuBtn');
    var menuMob = document.getElementById('menuMob');
    if(menuBtn !== null) {
        menuBtn.addEventListener('click', function(el){
            menuBtn.classList.toggle('active');
            menuMob.classList.toggle('hide');
        });
    }
})
