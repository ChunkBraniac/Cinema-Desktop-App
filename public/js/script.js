$(document).ready(function(){
    var owl = $('.owl-carousel');

    owl.owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        nav: false, // Disable default navigation
        responsive: {
            0: {
                items: 2,
                dots: false
            },
            600: {
                items: 3
            },
            1000: {
                items: 6,
                loop: true,
                dots: false
            }
        }
    });

    // Custom Navigation Events
    $(".customNextBtn").click(function(){
        owl.trigger('next.owl.carousel');
    });
    $(".customPrevBtn").click(function(){
        owl.trigger('prev.owl.carousel');
    });
});
