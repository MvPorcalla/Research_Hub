<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetAlert Loader with Typing Effect</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
   <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center" style="height: 100vh;">
                <button class="btn btn-primary" onclick="showLoader()">Show Loader</button>
            </div>
        </div>
   </div>

    <script>
        function showLoader() {
            let loadingText = "Loading";
            let dots = "";
            let interval;

            swal.fire({
                html: `<strong id="loadingText">${loadingText}</strong><span id="dots"></span>`,
                allowOutsideClick: false,
                showConfirmButton: false,
                backdrop: 'rgba(0, 0, 123, 0.2)',
                didOpen: () => {
                    swal.showLoading();
                    const dotsElem = document.getElementById("dots");

                    interval = setInterval(() => {
                        dots += ".";
                        if (dots.length > 3) {
                            dots = "";
                        }
                        dotsElem.innerHTML = dots;
                    }, 300);
                },
                willClose: () => {
                    clearInterval(interval);
                }
            });

            // Simulate an async action (like a server request)
            setTimeout(() => {
                swal.close();
            }, 2000);
        }
    </script>
</body>
</html>
