@extends('layouts.app')

@section('content')
    <style>

        /* .about-us-section {
            background: #f8f9fa;
        } */

        .about-us-section h1 {
            font-size: 3rem;
        }

        .about-us-section p.lead {
            font-size: 1.25rem;
        }

        .team-section h2 {
            font-size: 2.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        footer {
            background-color: #343a40;
        }
    </style>

    
    <section class="about-us-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">About CinemaHub</h2>
                    <p class="lead mb-4" style="font-family: 'Roboto', sans-serif; font-size: 17px; font-weight: 100;">At CinemaHub, we are passionate about bringing the best cinematic experiences to you. From the latest blockbusters to timeless classics, we cover it all.</p>

                        <p style="font-family: 'Roboto', sans-serif; font-size: 17px; font-weight: 100;">Founded in 2022, our mission is to create a community of movie enthusiasts who can share, review, and enjoy movies together. Our team of experts and fans work tirelessly to keep you updated with the latest news, reviews, and trailers.</p>
                        
                        <h5>Our Vision:</h5>
                        <p class="mb-4" style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 100">At CinemaHub, we believe that movies have the power to bring people together, spark conversations, and inspire change. Our vision is to be the ultimate destination for movie lovers, providing a platform where you can discover new favorites, discuss your thoughts with fellow fans, and dive deep into the world of cinema.</p>
                        
                        <h5>What We Offer:</h5>
                        <p class="mb-4" style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 100">Comprehensive Reviews: Our team of seasoned critics and movie buffs provides in-depth reviews of the latest releases, ensuring you know what to expect before heading to the theater or streaming online.</p>
                        
                        <h5>Up-to-Date News: </h5>
                        <p class="mb-4" style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 100">Stay informed with the latest happenings in the movie world. From casting announcements to box office reports, we bring you timely updates on everything cinema-related.</p>
                        
                        <h5>Curated Lists and Recommendations: </h5>
                        <p class="mb-4" style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 100">Whether you're in the mood for a classic drama, an edge-of-your-seat thriller, or a heartwarming family film, our curated lists and recommendations will help you find the perfect movie for any occasion.</p>
                        
                        <h5>Community Engagement: </h5>
                        <p class="mb-4" style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 100">Join a vibrant community of movie enthusiasts. Share your thoughts, participate in discussions, and connect with other fans who share your passion for film.</p>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="" class="img-fluid rounded" alt="Cinema">
                </div>
            </div>
        </div>
    </section>

    <section class="team-section py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col">
                    <h2 class="display-5">Meet Our Team</h2>
                    <p class="lead">Our dedicated team works around the clock to bring you the latest and greatest in
                        the world of movies.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <img src="team_member_1.jpg" class="card-img-top" alt="Team Member 1">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">Founder & CEO</p>
                            <p>John's passion for movies led to the creation of MovieMania. He oversees all operations
                                and ensures the community gets the best content.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <img src="team_member_2.jpg" class="card-img-top" alt="Team Member 2">
                        <div class="card-body">
                            <h5 class="card-title">Jane Smith</h5>
                            <p class="card-text">Chief Editor</p>
                            <p>Jane is in charge of all the reviews and articles that go up on MovieMania. Her keen eye
                                for detail ensures quality content.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <img src="team_member_3.jpg" class="card-img-top" alt="Team Member 3">
                        <div class="card-body">
                            <h5 class="card-title">Mark Wilson</h5>
                            <p class="card-text">Head of Marketing</p>
                            <p>Mark's marketing strategies have brought MovieMania to a global audience, growing our
                                community exponentially.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
