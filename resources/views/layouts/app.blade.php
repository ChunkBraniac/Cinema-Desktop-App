<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CinemaHub - @yield('title')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ url('icons/video.png') }}" type="image/x-icon">

    {{-- bootstrap cdn --}}
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ url('css/style.css') }}">

    {{-- Carouse Slider --}}
    <link rel="stylesheet"
        href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css') }}"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css') }}"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="">

    @include('layouts._header')
    <br><br><br>

    @if (session('error'))
        <h6 class="alert alert-danger text-center" style="font-family: 'Roboto', sans-serif; font-weight: normal;">
            {{ session('error') }}</h6>
    @endif

    @yield('content')

    @include('layouts._footer')

    {{-- Carousel CDN --}}
    <script src="{{ url('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js') }}"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>

    {{-- <script src="js/script.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
        integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <script>
        $(document).ready(function() {
            $("img").lazyload();
        });
    </script> --}}
    <script>
        // document.addEventListener("DOMContentLoaded", function() {
        //     var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

        //     if ("IntersectionObserver" in window) {
        //         let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
        //             entries.forEach(function(entry) {
        //                 if (entry.isIntersecting) {
        //                     let lazyImage = entry.target;
        //                     lazyImage.src = lazyImage.dataset.src;
        //                     if (lazyImage.dataset.srcset) {
        //                         lazyImage.srcset = lazyImage.dataset.srcset;
        //                     }
        //                     lazyImage.classList.remove("lazy");
        //                     lazyImageObserver.unobserve(lazyImage);
        //                 }
        //             });
        //         }, {
        //             rootMargin: "200px" // Adjust the root margin as needed for your design
        //         });

        //         lazyImages.forEach(function(lazyImage) {
        //             lazyImageObserver.observe(lazyImage);
        //         });
        //     } else {
        //         // Fallback for browsers that don't support Intersection Observer
        //         lazyImages.forEach(function(lazyImage) {
        //             lazyImage.src = lazyImage.dataset.src;
        //             if (lazyImage.dataset.srcset) {
        //                 lazyImage.srcset = lazyImage.dataset.srcset;
        //             }
        //             lazyImage.classList.remove("lazy");
        //         });
        //     }
        // });

        // Create an Intersection Observer instance
        let observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Load the image when it comes into view
                    entry.target.src = entry.target.dataset.src;
                    observer.unobserve(entry.target); // Stop observing once loaded
                }
            });
        });

        // Select all images with data-src attribute
        document.querySelectorAll('img[data-src]').forEach(img => {
            observer.observe(img); // Start observing each image
        });
    </script>
</body>

</html>
