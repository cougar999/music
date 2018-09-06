//Animation init
new WOW().init();
/* init Jarallax */
jarallax(document.querySelectorAll('.jarallax'));

$(function () {
    $(".sticky").sticky({
        //topSpacing: 90,
        zIndex: 2,
        //getWidthFrom: '#left-menu'
        //, stopper: "#YourStopperId"
    });
});