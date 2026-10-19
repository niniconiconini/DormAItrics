const roomImage = document.getElementById('room_image');

if (roomImage) {

    roomImage.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) return;

        const image = document.getElementById('preview-image');
        const text = document.getElementById('preview-text');

        image.src = URL.createObjectURL(file);

        image.style.display = 'block';
        text.style.display = 'none';
    });

}

const form = document.querySelector('.room-modal form');

if (form) {

    form.addEventListener('reset', () => {

        const image = document.getElementById('preview-image');
        const text = document.getElementById('preview-text');

        if (image && text) {

            image.src = '';

            image.style.display = 'none';

            text.style.display = 'block';
        }
    });

}