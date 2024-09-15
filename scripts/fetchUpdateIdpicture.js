let cropper;

function showModal(event) {
    const input = event.target;
    const file = input.files[0];

    if (!file) {
        return; // No file selected
    }

    if (!file.type.startsWith('image/')) {
        alert('Please select an image file.');
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        const imageElement = document.getElementById('modalImage');
        imageElement.src = e.target.result;

        // Initialize Cropper.js after setting the image source
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(imageElement, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            scalable: true,
            zoomable: false,
            cropBoxResizable: true,
            cropBoxMovable: true,
            minContainerWidth: 400, // Minimum width of the cropper container
            minContainerHeight: 400, // Minimum height of the cropper container
            ready() {
                // Adjust cropper container size and initial crop box position
                const container = document.querySelector('.cropper-container');
                container.style.width = '400px'; // Full width of modal
                container.style.height = '400px'; // Fixed height, adjust as needed

                // Center the crop box
                const cropBoxData = cropper.getCropBoxData();
                const containerData = cropper.getContainerData();
                const cropBoxWidth = cropBoxData.width;
                const cropBoxHeight = cropBoxData.height;
                const centerX = (containerData.width - cropBoxWidth) / 2;
                const centerY = (containerData.height - cropBoxHeight) / 2;

                cropper.setCropBoxData({
                    left: centerX,
                    top: centerY
                });
            }
        });

        // Show the modal
        const myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }

    reader.readAsDataURL(file);
}

function saveImage() {
    const canvas = cropper.getCroppedCanvas();
    canvas.toBlob(function(blob) {
        const formData = new FormData();
        formData.append('profilePic', blob, 'profile-pic.jpg');

        fetch('../../backend/update_idpicture.php', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the image preview
                const url = URL.createObjectURL(blob);
                document.getElementById('idImage').src = url;

                // Show success message with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Hide the modal after showing the success message
                    const myModal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
                    myModal.hide();
                });
            } else {
                // Show error message with SweetAlert2
                Swal.fire({
                    title: 'Warning!',
                    text: data.message || 'Failed to update profile.',
                    icon: 'warning',
                    backdrop: `rgba(255, 255, 0 ,0.1)`,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Show error message with SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An unexpected error occurred. Please try again later.',
                confirmButtonText: 'OK'
            });
        });
    }, 'image/jpeg'); // Specify the image format
}



// Attach event listeners to file input and modal
document.addEventListener('DOMContentLoaded', function () {
    var profilePicInput = document.getElementById('profilePicInput');
    profilePicInput.addEventListener('change', showModal);

    var imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('hidden.bs.modal', function () {
        location.reload();
    });
});