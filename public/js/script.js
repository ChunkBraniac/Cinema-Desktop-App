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
                loop: false,
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


// Get the button
let mybutton = document.getElementById("backToTop");

// Show the button when the user scrolls down 20px from the top of the document
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// Scroll to the top of the document when the user clicks the button
mybutton.onclick = function() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
};
