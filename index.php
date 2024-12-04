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

        #lNHS-icon-container {
          position: fixed;
          bottom: 20px;
          left: 30px;
          z-index: 9999;
          display: flex;
          align-items: center;
        }
        #lNHS-icon {
          width: 35px;
          height: auto;
          margin-right:
        }
        #lNHS-icon-container p {
          margin: 0;
          margin-left: 10px;
          font-size: 14px;
          color: #000;
        }

        /* animated button */
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
          
          background-origin: border-box;
          background-clip: content-box, border-box;
          font-family: "Helvetica", "Arial", sans-serif;
        }

        .animated-btn-color {
          background-image: linear-gradient(#161a25, #161a25),
            linear-gradient(
              137.48deg,
              #00008B 5%,    
              #00c6ff 25%,  
              #000000 50%,
              #f44336 75%,   
              #ff6f00 95%   
            );
        }

        .login-btn-color {
          background-image: linear-gradient(#161a25, #161a25),
            linear-gradient(
              137.48deg,
              #0000FF 5%,
              #00c6ff 25%, 
              #000000 50%, 
              #800080 75%,
              #4B0082 95%  
            );
        }
        .register-btn-color {
          background-image: linear-gradient(#161a25, #161a25),
            linear-gradient(
              137.48deg,
              #f5434f  5%,    
              #631e29 25%,  
              #000000 50%,
              #f44336 75%,   
              #ff6f00 95%   
            );
        }

        #container-border {
          position: absolute;
          z-index: -1;
          width: 100%;
          height: 100%;
          overflow: hidden;
          transition: 0.5s;
          backdrop-filter: blur(1rem);
          border-radius: 5rem;
        }

        .button-title {
          z-index: 2;
          font-family: "Helvetica", "Arial", sans-serif;
          font-size: 16px;
          letter-spacing: 5px;
          color: #ffffff;
          text-shadow: 0 0 3px white;
        }

        .animated-btn:hover #container-border {
          z-index: 1;
          background-color: #161a25;
        }

        .animated-btn:hover {
          transform: scale(1.1);
        }

        .animated-btn:active {
          border: double 4px #f44336;
          background-origin: border-box;
          background-clip: content-box, border-box;
          animation: none;
        }

        .animated-btn:active .circle {
          background: #f44336;
        }

        @keyframes orbit {
          from {
            transform: rotate(0deg) translateX(100px) rotate(0deg);
          }
          to {
            transform: rotate(360deg) translateX(100px) rotate(-360deg);
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
                        <a href="./login.php" class="btn animated-btn login-btn-color me-3" role="button" aria-label="Login">
                            <strong class="button-title ">LOGIN</strong>
                            <div id="container-border"></div>
                        </a>

                        <!-- Register Link -->
                        <a href="./register.php" class="btn animated-btn register-btn-color" role="button" aria-label="Register">
                            <strong class="button-title ">REGISTER</strong>
                            <div id="container-border"></div>
                        </a>
                    </div>

                </div>
            </div>
        </div>

      <!-- LNHS Research Hub Icon -->
      <a href="https://www.facebook.com/LigaoNationalHS" target="_blank" id="lNHS-link">
          <div id="lNHS-icon-container">
              <img src="./assets/icons/LNHS-icon.png" alt="LNHS Research Hub Icon" class="ms-5" id="lNHS-icon">
              <p>LNHS Facebook page</p>
          </div>
      </a>



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
