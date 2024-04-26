$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0: {
            items: 2,
            nav: false,
            dots: false
        },
        600: {
            items: 3,
            nav: false,
            dots: true
        },
        1000: {
            items: 5,
            nav: false,
            loop: false,
            dots: true
        }
    }
})