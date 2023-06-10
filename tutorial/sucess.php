<?php
// start session
session_start();

// check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); 
    exit;
}

// database connection
$server = "localhost";
$username = "root";
$password = "";
$database = "Sydney_travel";

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("connection to this database failed due to" . mysqli_connect_error());
}

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['location']) && isset($_POST['days']) && isset($_POST['accommodation'])) {
        // secure data before query
        $location = mysqli_real_escape_string($con, $_POST['location']);
        $days = intval($_POST['days']);
        $accommodation = mysqli_real_escape_string($con, $_POST['accommodation']);

        // form validation
        if ($days <= 0) {
            $errorMessage = 'Days should be a positive integer.';
        } else {
            // query to save voting data
            $sql = "UPDATE trip SET trip_location = '$location', trip_days = '$days', trip_accommodation = '$accommodation' WHERE email = '" . $_SESSION['email'] . "'";
            $result = mysqli_query($con, $sql);

            if ($result) {
                $successMessage = "Vote saved successfully!";
            } else {
                $errorMessage = "Error: " . mysqli_error($con);
            }
        }
    }
}

// query the database for all registered students and their votes
$result = mysqli_query($con, "SELECT `name`, `trip_location`, `trip_days`, `trip_accommodation` FROM `trip`");

// fetch all records and store them in $students
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($con); // Close connection
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="sucess.css">  
    
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Class Trip Planner</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing-details">Pricing and Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about-us">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#voting">Vote Now</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Welcome to the Class Trip Planner, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
                    <p class="mt-4">We're excited to help you plan your upcoming class trip. Use this website to vote for your preferred location, select the number of days you wish to stay, and choose your desired accommodation type. Once the votes are in, we'll use this information to create a trip that everyone will enjoy. It's a simple, interactive, and democratic way to ensure that everyone's preferences are taken into account. And remember, the journey is part of the adventure. Start voting now and let's make this trip unforgettable.</p>
                    <a href="#voting" class="btn btn-primary mt-4">Start Voting Now</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="mt-4">Trip Plan Features</h2>

                    <!-- Feature 1 -->
                    <div class="feature">
                        <i class="feature-icon fas fa-hiking"></i>
                        <h3 class="feature-title">Dedicated Guide</h3>
                        <p class="feature-description">
                            Every trip plan comes with a dedicated guide who is experienced and knowledgeable about the destination. They will assist you throughout your journey, ensuring a seamless and enjoyable experience.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature">
                        <i class="feature-icon fas fa-utensils"></i>
                        <h3 class="feature-title">Culinary Experiences</h3>
                        <p class="feature-description">
                            Enjoy local and international cuisine as part of your trip. Our guide will help you discover hidden gastronomic delights that you won't find in any travel guide.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature">
                        <i class="feature-icon fas fa-landmark"></i>
                        <h3 class="feature-title">Historical Sites</h3>
                        <p class="feature-description">
                            Our travel plan includes visits to key historical sites and monuments. Learn about the history and culture of the places you visit with insightful commentary from your guide.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature">
                        <i class="feature-icon fas fa-camera"></i>
                        <h3 class="feature-title">Photography Opportunities</h3>
                        <p class="feature-description">
                            Capture your memories with stunning photo opportunities. Our guide will show you the best spots for photography, helping you get that perfect shot.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="pricing_and_details" id="pricing-details">
        
            <h2 class="mt-4">Pricing for Different Places</h2>
                <div class="row">
                    <!-- example card layout for trip pricing -->
                    <div class="col-md-3 " style="margin: 10px ">

                        <!-- Card -->
                        <div class="card">
                            <img src="images/sydney.jpg" class="card-img-top" alt="Trip Image">
                            <div class="card-body">
                                <h5 class="card-title">Sydney</h5>
                                <p class="card-text">Experience the vibrant city life of Sydney! Our trip offers...</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sydneyModal">View More</button> 
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="sydneyModal" tabindex="-1" aria-labelledby="sydneyModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="sydneyModalLabel">Sydney</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Experience the vibrant city life of Sydney! Our trip offers students a unique opportunity to explore world-renowned landmarks like the Sydney Opera House, Sydney Harbour Bridge, and the beautiful Bondi Beach. Learn about Australia's history at the Australian Museum and enjoy the wildlife at Taronga Zoo. This trip is a perfect blend of education, exploration, and adventure. Join us as we journey to the heart of Australia and discover the rich culture, diverse landscapes, and bustling city life that make Sydney an unforgettable travel destination!
                                        <p class="price">Starting from $1000</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin: 10px;">
                        <!-- Card -->
                        <div class="card">
                            <img src="images/mebourne.jpg" class="card-img-top" alt="Trip Image">
                            <div class="card-body">
                                <h5 class="card-title">Melbourne</h5>
                                <p class="card-text">Explore the bustling city life of Melbourne! Our trip...</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#melbourneModal">View More</button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="melbourneModal" tabindex="-1" aria-labelledby="melbourneModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="melbourneModalLabel">Melbourne</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Explore the bustling city life of Melbourne! Our trip offers a rich tapestry of experiences, from the thriving arts scene to the coffee and culinary culture that the city is known for. Take a stroll in the beautiful Royal Botanic Gardens, explore the trendy neighbourhoods, or catch a game at the Melbourne Cricket Ground. For the history buffs, the immersive Melbourne Museum and National Gallery of Victoria are a must-see. This trip promises a diverse array of experiences, catering to every student's interests!
                                        <p class="price">Starting from $850</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" style="margin: 10px;">
                        <!-- Card -->
                        <div class="card">
                            <img src="images/brisbane.jpg" class="card-img-top" alt="Trip Image">
                            <div class="card-body">
                                <h5 class="card-title">Brisbane</h5>
                                <p class="card-text">Uncover the dynamic culture of Brisbane! Our trip...</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brisbaneModal">View More</button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="brisbaneModal" tabindex="-1" aria-labelledby="brisbaneModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="brisbaneModalLabel">Brisbane</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Uncover the dynamic culture of Brisbane! Our trip takes students on a journey through this vibrant city, known for its rich heritage, outdoor adventures, and world-class arts scene. Visit the iconic Story Bridge, enjoy the riverside greenspace of South Bank Parklands, and explore the city's artistic side at the Queensland Art Gallery and Gallery of Modern Art. Discover the city's history at the Museum of Brisbane or take a ferry down the Brisbane River. With its subtropical climate and an array of attractions, this trip offers an enriching and enjoyable experience for all.
                                        <p class="price">Starting from $800</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" style="margin: 10px;">
                        <!-- Card -->
                            <div class="card">
                                <img src="images/adelaide.jpg" class="card-img-top" alt="Trip Image">
                                <div class="card-body">
                                    <h5 class="card-title">Adelaide</h5>
                                    <p class="card-text">Immerse in the charming allure of Adelaide! Our trip...</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adelaideModal">View More</button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="adelaideModal" tabindex="-1" aria-labelledby="adelaideModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="adelaideModalLabel">Adelaide</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Immerse in the charming allure of Adelaide! Our trip provides students a chance to explore this beautiful coastal city known for its rich cultural heritage, picturesque landscapes, and a vibrant food and wine scene. Visit the historic Adelaide Central Market, enjoy a tranquil walk in the Adelaide Botanic Garden, or explore the city's art and history at the Art Gallery of South Australia and South Australian Museum. With a leisurely pace and a mix of city attractions and natural beauty, this trip offers a fulfilling and memorable experience.
                                            <p class="price">Starting from $600</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>

    <!-- Content Section -->
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img class="content-image" src="https://images.unsplash.com/photo-1536098561742-ca998e48cbcc" alt="Travel Image 1">
                    <p class="content-text">Experience breathtaking views and unforgettable adventures with our travel plans.</p>
                </div>
                <div class="col-lg-6">
                    <img class="content-image" src="https://images.unsplash.com/photo-1551632811-561732d1e306" alt="Travel Image 2">
                    <p class="content-text">Explore hidden gems and popular landmarks with a knowledgeable guide.</p>
                </div>
                <div class="col-lg-6">
                    <img class="content-image" src="https://images.unsplash.com/photo-1505761671935-60b3a7427bad" alt="Travel Image 3">
                    <p class="content-text">Our travel plans cater to all types of travelers. Whether you're an adventurer, a foodie, or a history buff, we've got you covered.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Voting Section -->
    <section class="voting">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if ($errorMessage) : ?>
                        <div class="alert alert-danger">
                            <?= $errorMessage ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($successMessage) : ?>
                        <div class="alert alert-success">
                            <?= $successMessage ?>
                        </div>
                    <?php endif; ?>

                    <div class="description-section">
                        <h2>Voting Section</h2>
                        <p>This is our trip voting section. Here, you can choose your preferred location, trip duration, and accommodation type. We value your input and want to make sure the trip is enjoyable for everyone. Don't forget to click on the 'Submit Vote' button when you're done!</p>
                    </div>

                    <form method="POST" class="form-vote" id="voting">
                        <div class="form-group">
                            <label for="location"><i class="fas fa-map-marker-alt"></i> Vote for Location:</label>
                            <select class="form-control" name="location" required>
                                <option value="">Select Location</option>
                                <option>Sydney</option>
                                <option>Melbourne</option>
                                <option>Brisbane</option>
                                <option>Adelaide</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="days"><i class="fas fa-calendar-day"></i> Vote for Trip Days:</label>
                            <input type="number" class="form-control" name="days" required>
                        </div>

                        <div class="form-group">
                            <label for="accommodation"><i class="fas fa-hotel"></i> Vote for Accommodation Type:</label>
                            <select class="form-control" name="accommodation" required>
                                <option value="">Select Accommodation</option>
                                <option>Hotel</option>
                                <option>Hostel</option>
                                <option>Motel</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit Vote</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="table-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="description-section">
                        <h2>Table Section</h2>
                        <p>After you've submitted your vote, you can find your entry in the table below. This table helps keep track of all student votes so we can plan the best trip possible based on the most popular choices. Feel free to browse and see what others are voting for!</p>
                    </div>

                    <input type="text" id="search" placeholder="Search by name..." class="search-bar">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Location</th>
                                <th scope="col">Days</th>
                                <th scope="col">Accommodation</th>
                            </tr>
                        </thead>
                        <tbody id="studentTable">
                            <?php foreach ($students as $student) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['name']) ?></td>
                                    <td><?= htmlspecialchars($student['trip_location']) ?></td>
                                    <td><?= htmlspecialchars($student['trip_days']) ?></td>
                                    <td><?= htmlspecialchars($student['trip_accommodation']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about-us" class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>About Us</h2>
                    <p>We are an enthusiastic group of travel professionals, passionate about creating unforgettable educational travel experiences for students. We believe that travel enhances learning and shapes young minds, making them global citizens of tomorrow. Our team comprises educators, travelers, and locals who love their hometowns and want to share them with the world. Our mission is to offer exciting, educational, and enjoyable trips for students of all ages, facilitating immersive learning experiences.</p>
                    <h3>Our History</h3>
                    <p>Founded in 2003, we have been organizing educational trips for schools for over 20 years. Over these years, we have grown both in terms of the number of trips we arrange and the range of destinations we cover. With more than 10,000 trips under our belt, we have a rich history of happy and satisfied students and teachers.</p>
                    <h3>Our Team</h3>
                    <p>Our team is our strength. We are a group of dedicated professionals who put our hearts and souls into every trip we plan. Our expert tour guides, proficient operations team, and friendly customer service representatives all work together to ensure that every trip is a memorable one.</p>
                    <h3>Testimonials</h3>
                    <div class="testimonials">
                        <blockquote>
                            "My students had an amazing time on the trip organized by this team. Everything was perfectly arranged, and we didn't have to worry about a thing. The team was supportive and friendly throughout. Highly recommended!" - <cite>Mrs. Johnson, School Teacher</cite>
                        </blockquote>
                        <blockquote>
                            "One of the best trips of my life! The team did an amazing job. I learned so much and had so much fun!" - <cite>Alex Smith, Student</cite>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5>Contact Us</h5>
                    <ul>
                        <li>Phone: +1234567890</li>
                        <li>Email: info@tripsforstudents.com</li>
                        <li>Address: 123 Main Street, City, Country</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#about-us">About Us</a></li>
                        <li><a href="#voting">Vote Now</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Follow Us</h5>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>&copy; 2023 Trips For Students. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Toggle feature description
        document.querySelectorAll('.feature').forEach(item => {
            item.addEventListener('click', event => {
                const featureDescription = item.children[2];

                if (featureDescription.style.display === "none") {
                    featureDescription.style.display = "block";
                } else {
                    featureDescription.style.display = "none";
                }
            });
        });

        // Table search 
        let search = document.getElementById('search');
        let tableBody = document.getElementById('studentTable');

        search.addEventListener('keyup', (e) => {
            let searchValue = e.target.value.toLowerCase();
            let tableRows = Array.from(tableBody.getElementsByTagName('tr'));

            tableRows.forEach(row => {
                let rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
</body>

</html>
