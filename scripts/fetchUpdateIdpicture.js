let cropper;

async function showModal(event) {
    const input = event.target;
    const file = input.files[0];

    if (!file) return; // No file selected
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file.');
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        const imageElement = document.getElementById('modalImage');
        imageElement.src = e.target.result;

        // Initialize Cropper.js
        if (cropper) cropper.destroy();
        cropper = new Cropper(imageElement, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            scalable: true,
            zoomable: false,
            cropBoxResizable: true,
            cropBoxMovable: true,
            minContainerWidth: 400,
            minContainerHeight: 400,
            ready() {
                const container = document.querySelector('.cropper-container');
                container.style.width = '400px';
                container.style.height = '400px';

                // Center the crop box
                const cropBoxData = cropper.getCropBoxData();
                const containerData = cropper.getContainerData();
                cropper.setCropBoxData({
                    left: (containerData.width - cropBoxData.width) / 2,
                    top: (containerData.height - cropBoxData.height) / 2
                });
            }
        });

        // Show the modal
        const myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    };

    reader.readAsDataURL(file);
}

async function saveImage() {
    const canvas = cropper.getCroppedCanvas();
    canvas.toBlob(async function(blob) {
        const formData = new FormData();
        formData.append('profilePic', blob, 'profile-pic.jpg');

        try {
            const response = await fetch('../../backend/update_idpicture.php', { 
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            if (data.status === 'success') {
                // Update the image preview
                document.getElementById('idImage').src = URL.createObjectURL(blob);

                // Show success message with SweetAlert2
                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });

                // Hide the modal
                const myModal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
                myModal.hide();
            } else {
                // Show error message with SweetAlert2
                await Swal.fire({
                    title: 'Warning!',
                    text: data.message || 'Failed to update profile.',
                    icon: 'warning',
                    backdrop: 'rgba(255, 255, 0, 0.1)',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error('Error:', error);

            // Show error message with SweetAlert2
            await Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An unexpected error occurred. Please try again later.',
                confirmButtonText: 'OK'
            });
        }
    }, 'image/jpeg'); // Specify the image format
}

// Attach event listeners to file input and modal
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('profilePicInput').addEventListener('change', showModal);

    document.getElementById('imageModal').addEventListener('hidden.bs.modal', () => {
        // No need to reload the page, image updates in real-time
    });
});
