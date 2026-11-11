// 
const fileInput = document.querySelector('#profile_picture, #room_image');
const previewImage = document.getElementById('preview-image');
const previewText = document.getElementById('preview-text');
const fileName = document.getElementById('file-name');

if (fileInput && previewImage) {
    const originalImage = previewImage.src;
    const originalFileText = fileName ? fileName.textContent : 'No file chosen';

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        previewImage.src = URL.createObjectURL(file);

        // show preview image
        previewImage.style.display = 'block';

        // hide placeholder text
        if (previewText) {
            previewText.style.display = 'none';
        }

        // update filename
        if (fileName) {
            fileName.textContent = file.name;
        }
    });

    const form = document.querySelector('.user-modal form') || document.querySelector('.room-modal form');

    if (form) {
        form.addEventListener('reset', () => {
            setTimeout(() => {
                previewImage.src = originalImage;
                if (fileName) { fileName.textContent = originalFileText; }

                // if add-room preview started empty
                if (!originalImage) {
                    previewImage.style.display = 'none';

                    if (previewText) { previewText.style.display = 'block'; }
                }
            }, 0);
        });
    }
}

// user management character validation
document.querySelectorAll('#last_name, #first_name, #middle_name, #nickname').forEach(input => {
    input.addEventListener('input', function () {
        const currentInput = this;
        setTimeout(() => {
            currentInput.value = currentInput.value.replace(/[^\p{L}\s.,-]/gu, '')
        }, 200)
    });
});