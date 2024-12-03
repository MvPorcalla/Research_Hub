<?php include_once "includes/db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Background container with overlay */
        #background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
            overflow: hidden;
            transition: background-image 1.5s ease-in-out; /* Smooth transition for image change */
        }

        /* Black overlay */
        #background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* Main content container */
        #content {
            position: relative;
            z-index: 2;
            color: white;
            padding-top: 180px; /* Add padding to create space for the header */
        }

        .hpTitle {
            font-family: 'Archivo Black', sans-serif;
            font-weight: 900;
            font-size: 5rem;
            text-transform: uppercase;
            text-shadow: -10px 5px 0px #000; 
            background-color: rgba(148, 199, 227, 0.6); /* Light blue color with 30% opacity */
            padding: 20px;
            border-radius: 20px;
            display: inline-block;
        }


.animated-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 15rem;
  overflow: hidden;
  height: 3.5rem;
  background-size: 300% 300%;
  backdrop-filter: blur(1rem);
  border-radius: 5rem;
  transition: 0.5s;
  animation: gradient_301 5s ease infinite;
  border: double 4px transparent;
  background-image: linear-gradient(#161a25, #161a25),
    linear-gradient(
        137.48deg,
        #00008B  0%,    /* Purple */
        #00c6ff 25%,   /* Sky Blue */
        #000000 50%,   /* Black */
        #f44336 75%,   /* Orange */
        #ff6f00 100%    /* Red */
    );
  background-origin: border-box;
  background-clip: content-box, border-box;
  font-family: "Orbitron", sans-serif;
}

#container-stars {
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  overflow: hidden;
  transition: 0.5s;
  backdrop-filter: blur(1rem);
  border-radius: 5rem;
}

strong {
  z-index: 2;
  font-family: "Orbitron", sans-serif;
  font-size: 15px;
  letter-spacing: 5px;
  color: #ffffff;
  text-shadow: 0 0 4px white;
}

#glow {
  position: absolute;
  display: flex;
  width: 12rem;
}

.circle-container {
  position: relative;
  width: 100%;
  height: 100%;
  animation: orbit 5s linear infinite;
}

.circle {
  position: absolute;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  filter: blur(2rem);
}

.circle:nth-of-type(1) {
  background: rgba(0, 198, 255, 0.636);  /* Sky Blue */
  animation: orbit 8s linear infinite;
}

.circle:nth-of-type(2) {
  background: rgba(106, 13, 173, 0.704);  /* Purple */
  animation: orbit 10s linear infinite;
}

.animated-btn:hover #container-stars {
  z-index: 1;
  background-color: #161a25;
}

.animated-btn:hover {
  transform: scale(1.1);
}

.animated-btn:active {
  border: double 4px #f44336;  /* Red */
  background-origin: border-box;
  background-clip: content-box, border-box;
  animation: none;
}

.animated-btn:active .circle {
  background: #f44336;  /* Red */
}

@keyframes orbit {
  from {
    transform: rotate(0deg) translateX(100px) rotate(0deg);
  }
  to {
    transform: rotate(360deg) translateX(100px) rotate(-360deg);
  }
}

#stars {
  position: relative;
  background: transparent;
  width: 200rem;
  height: 200rem;
}

#stars::after {
  content: "";
  position: absolute;
  top: -10rem;
  left: -100rem;
  width: 100%;
  height: 100%;
  animation: animStarRotate 90s linear infinite;
}

#stars::after {
  background-image: radial-gradient(#ffffff 1px, transparent 1%);
  background-size: 50px 50px;
}

#stars::before {
  content: "";
  position: absolute;
  top: 0;
  left: -50%;
  width: 170%;
  height: 500%;
  animation: animStar 60s linear infinite;
}

#stars::before {
  background-image: radial-gradient(#ffffff 1px, transparent 1%);
  background-size: 50px 50px;
  opacity: 0.5;
}

@keyframes animStar {
  from {
    transform: translateY(0);
  }

  to {
    transform: translateY(-135rem);
  }
}

@keyframes animStarRotate {
  from {
    transform: rotate(360deg);
  }

  to {
    transform: rotate(0);
  }
}

@keyframes gradient_301 {
  0% {
    background-position: 0% 50%;
  }

  50% {
    background-position: 100% 50%;
  }

  100% {
    background-position: 0% 50%;
  }
}

@keyframes pulse_3011 {
  0% {
    transform: scale(0.75);
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
  }

  70% {
    transform: scale(1);
    box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
  }

  100% {
    transform: scale(0.75);
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
  }
}



#lNHS-icon-container {
    position: fixed; /* Fix position to the bottom left */
    bottom: 20px; /* Distance from the bottom of the screen */
    left: 20px; /* Distance from the left side of the screen */
    z-index: 9999; /* Ensure it's above other content */
    display: flex; /* Use flexbox to align the icon and text */
    align-items: center; /* Vertically center the text and icon */
}

#lNHS-icon {
    width: 35px; /* Adjust the icon size */
    height: auto; /* Maintain aspect ratio */
    margin-right: 10px; /* Add space between icon and text */
}

#lNHS-icon-container p {
    margin: 0; /* Remove default margin */
    line-height: 35px; /* Match the icon size to center the text vertically */
    color: white; /* Text color */
    font-size: 1rem; /* Adjust font size */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Optional: Add shadow for readability */
}




    </style>
</head>

<body>
    <!-- Background Image -->
    <div id="background"></div>

    <!-- Main Content -->
    <div id="content">
        <!-- Header -->
        <?php include 'includes/header.php'; ?>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 ms-5 mt-4">
                    <div class="ms-5">
                        <!-- <img src="./assets/images/hpTitle.png" class="img-fluid" alt="Sample Image"> -->

                        <div class="title-container">
                            <h1 class="hpTitle px-5">Start Your <br> Research Journey <br> With Research Hub</h1>
                        </div>

                        <div class="mt-3 d-flex justify-content-start">
                        <!-- Login Link -->
                        <a href="./login.php" class="btn animated-btn me-3" role="button" aria-label="Login">
                            <strong>LOGIN</strong>
                            <div id="container-stars">
                                <div id="stars"></div>
                            </div>
                            <div id="glow">
                                <div class="circle"></div>
                                <div class="circle"></div>
                            </div>
                        </a>

                        <!-- Register Link -->
                        <a href="./register.php" class="btn animated-btn" role="button" aria-label="Register">
                            <strong>REGISTER</strong>
                            <div id="container-stars">
                                <div id="stars"></div>
                            </div>
                            <div id="glow">
                                <div class="circle"></div>
                                <div class="circle"></div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- LNHS Research Hub Icon -->
        <div id="lNHS-icon-container">
            <img src="./assets/icons/LNHS-icon.png" alt="LNHS Research Hub Icon" class="ms-5" id="lNHS-icon">
            <p class="fs-5">LNHS Facebook page</p>
        </div>


    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="includes/functions.js"></script>

    <script>
        const images = [
            './assets/images/hp_1.png',
            './assets/images/hp_2.png',
            './assets/images/hp_3.png',
            './assets/images/hp_4.png',
            './assets/images/hp_5.png',
        ];

        let currentImageIndex = 0;

        const changeBackground = () => {
            const background = document.getElementById('background');

            // Set the new background image
            background.style.backgroundImage = `url(${images[currentImageIndex]})`;

            // Update image index for next cycle
            currentImageIndex = (currentImageIndex + 1) % images.length;
        };

        // Change background every 5 seconds
        setInterval(changeBackground, 5000);

        // Initialize first background
        changeBackground();
    </script>
</body>

</html>
