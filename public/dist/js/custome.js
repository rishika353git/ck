$(document).ready(function () {
    $('.statusSelect').change(function () {
        var selectValue = $(this).val();
        var statusResultDiv = $(this).closest('td').find('.status_result');

        if (selectValue == '2') {
            statusResultDiv.show();
            statusResultDiv.find('.reasonInput').attr('required', true);
        } else {
            statusResultDiv.hide();
            statusResultDiv.find('.reasonInput').removeAttr('required');
        }
    });
});


// Get all images with the 'clickable-image' class
var images = document.querySelectorAll('.clickable-image-back');

// Add click event listener to each image
images.forEach(function (image) {
    image.addEventListener('click', function () {
        // Create a modal element
        var modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <div class="modal-dialog modal-lg"> <!-- Adjust the modal-lg class for a larger modal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img class="img-fluid" src="${this.src}" alt="Photo">
                    </div>
                </div>
            </div>
        `;

        // Append the modal to the body
        document.body.appendChild(modal);

        // Show the modal
        $(modal).modal('show');
    });
});



// Get all images with the 'clickable-image' class
var images = document.querySelectorAll('.clickable-image-front');

// Add click event listener to each image
images.forEach(function (image) {
    image.addEventListener('click', function () {
        // Create a modal element
        var modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <div class="modal-dialog modal-lg"> <!-- Adjust the modal-lg class for a larger modal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img class="img-fluid" src="${this.src}" alt="Photo">
                    </div>
                </div>
            </div>
        `;

        // Append the modal to the body
        document.body.appendChild(modal);

        // Show the modal
        $(modal).modal('show');
    });
});
