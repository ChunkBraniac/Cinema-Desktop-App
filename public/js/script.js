$(document).ready(function () {
    var owl = $('.owl-carousel');

    owl.owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        nav: false, // Disable default navigation
        responsive: {
            0: {
                items: 2,
                dots: false,
                loop: false,
            },
            600: {
                items: 3,
                dots: false,
                loop: false,
            },
            1000: {
                items: 5,
                dots: false,
                loop: false,
            },
            1200: {
                items: 6,
                loop: false,
                dots: false
            }
        }
    });

    // Custom Navigation Events
    $(".customNextBtn").click(function () {
        owl.trigger('next.owl.carousel');
    });
    $(".customPrevBtn").click(function () {
        owl.trigger('prev.owl.carousel');
    });
});


// Get the button
let mybutton = document.getElementById("backToTop");

// Show the button when the user scrolls down 20px from the top of the document
window.onscroll = function () {
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
mybutton.onclick = function () {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
};


document.getElementById('downloadButton').addEventListener('click', function () {
    // Retrieve the download URL and filename from the data attributes
    const fileUrl = this.getAttribute('data-url');
    const filename = this.getAttribute('data-filename');

    if (fileUrl && filename) {
        // Create a new link element
        const link = document.createElement('a');

        // Set the download attribute with the dynamic filename
        link.download = filename;

        // Set the href attribute to the file URL
        link.href = fileUrl;

        // Append the link to the body (required for Firefox)
        document.body.appendChild(link);

        // Programmatically click the link to trigger the download
        link.click();

        // Remove the link from the document
        document.body.removeChild(link);
    } else {
        console.error('File URL or filename not found.');
    }
});


