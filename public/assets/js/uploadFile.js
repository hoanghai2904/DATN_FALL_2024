// Them ảnh
const imageInput = document.getElementById('imageInput');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
const addImageButton = document.getElementById('addImageButton');

addImageButton.addEventListener('click', () => {
    imageInput.click(); // Trigger the file input when the div is clicked
});

imageInput.addEventListener('change', handleImageUpload);

function handleImageUpload(event) {
    const files = event.target.files;
    if (files.length > 0) {
        addImageButton.classList.add('d-none');
    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const colDiv = document.createElement('div');
            colDiv.className = 'col-6 col-md-4 col-lg-12 image-preview';
            colDiv.innerHTML = `
                <img src="${e.target.result}" alt="Image Preview" class="img-thumbnail">
                <button class="remove-image" onclick="removeImage(this)">X</button>
            `;
            imagePreviewContainer.appendChild(colDiv);
        }
        reader.readAsDataURL(file);
    }
}

function removeImage(button) {
    const colDiv = button.parentElement;
    colDiv.remove();
    
    // Show the add image button again if no images are left
    if (imagePreviewContainer.children.length === 0) {
        addImageButton.classList.remove('d-none');
    }
}
// ------------------------------------------------------------------------------------------------

//Thêm Gallery
const galleryInput = document.getElementById("galleryInput");
const galleryPreviewContainer = document.getElementById("galleryPreviewContainer");
const addGalleryButton = document.getElementById("addGalleryButton");
const addGallery = document.getElementById("addGallery");

addGallery.addEventListener("click", (e) => {
    e.preventDefault();
    galleryInput.click();
});

addGalleryButton.addEventListener('click', () => {
    galleryInput.click(); // Trigger the file input when the div is clicked
});

galleryInput.addEventListener('change', handleGalleryUpload);

function handleGalleryUpload(event) {
    const files = event.target.files;
    if (files.length > 0) {
        addGalleryButton.classList.add('d-none');
        addGallery.classList.remove('d-none');
    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const colDiv = document.createElement('div');
            colDiv.className = 'col-6 col-md-4 col-lg-4 image-preview';
            colDiv.innerHTML = `
                <img src="${e.target.result}" alt="Image Preview" class="img-thumbnail">
                <button class="remove-image" onclick="removeGallery(this)">X</button>
            `;
            galleryPreviewContainer.appendChild(colDiv);
        }
        reader.readAsDataURL(file);
    }
}

function removeGallery(button) {
    const colDiv = button.parentElement;
    colDiv.remove();
    
    // Show the add image button again if no images are left
    if (galleryPreviewContainer.children.length === 0) {
        addGalleryButton.classList.remove('d-none');
        addGallery.classList.add('d-none');
    }
}


