document.addEventListener("DOMContentLoaded", function(){

    var menuBtn = document.getElementById('menuBtn');
    var menuMob = document.getElementById('menuMob');
    if(menuBtn !== null) {
        menuBtn.addEventListener('click', function(el){
            menuBtn.classList.toggle('active');
            menuMob.classList.toggle('hide');
        });
    }


    document.querySelectorAll('.scrollTo').forEach(function(element){
        element.addEventListener('click', function(elm){
            let scrollTo = elm.target.getAttribute('data-scroll');
            registerCustomEvent('scrollToEvent', {el: scrollTo});
        })
    })


});


function registerCustomEvent(eventName, data){
    data = typeof data !== "undefined" ? data : null;
    var event = new CustomEvent(eventName,{'detail': data});
    window.dispatchEvent(event);
}


