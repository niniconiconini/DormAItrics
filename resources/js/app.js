const profilePicture = document.getElementById('profile_picture');
const previewImage = document.getElementById('preview-image');
const fileName = document.getElementById('file-name');

if (profilePicture && previewImage) {

    const originalImage = previewImage.src;
    const originalFileText = fileName
        ? fileName.textContent
        : 'No file chosen';

    profilePicture.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) return;

        previewImage.src = URL.createObjectURL(file);

        if (fileName) {
            fileName.textContent = file.name;
        }
    });

    const userForm = document.querySelector('.user-modal form');

    if (userForm) {
        userForm.addEventListener('reset', () => {

            setTimeout(() => {

                previewImage.src = originalImage;

                if (fileName) {
                    fileName.textContent = originalFileText;
                }

            }, 0);

        });
    }
}