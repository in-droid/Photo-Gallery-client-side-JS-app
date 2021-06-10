"use strict";

let allImages = [];
let selectedImages = [];
let imagesForDeleting = [];


function deleteImages() {
    allImages.filter(element => imagesForDeleting.includes(element));
    for(const image of imagesForDeleting) {
        for(const atribute in image) {
            if (image[atribute] instanceof Element)
                image[atribute].parentElement.removeChild(image[atribute]);
        }
    }
    imagesForDeleting = [];


}

function updatePhotos(photoGallery, photo) {
    if (!photo.type.startsWith("image/")) {
        document.querySelector(".drop-zone__prompt").innerText = "The selected file is not an image!";
        return;
    }

    const image = document.createElement("img");
    image.classList.add("added-photos");

    photoGallery.appendChild(image);
    image.onload = () => {
        URL.revokeObjectURL(image.src);
    }
    image.src = URL.createObjectURL(photo);
    const editMode = document.getElementById("editMode");
    if (!editMode.checked) {
        image.addEventListener("click", openModal);
    }
    image.classList.add("hover-shadow");

    const imageObject = createImageObject(image);
    allImages.push(imageObject);
    document.querySelector(".drop-zone__prompt").innerText = "Drop image here or click to upload";

}

function openModal(event) {
    const imgObj = allImages.find(element => element.image === event.target);
    imgObj.modal.style.display = "block";


}

function closeModal(event) {
    const imgObj = allImages.find(element => element.modal === event.target.parentElement);
    imgObj.modal.style.display = "none";
}

function createImageObject(image) {
    const modalImage = document.createElement("img");
    const modal = document.createElement("div");
    const exitButton = document.createElement("span");
    const caption = document.createElement("div");

    caption.id = "caption";
    exitButton.classList.add("close");
    exitButton.innerHTML = "&times;";
    exitButton.addEventListener("click", closeModal);
    modal.classList.add("modal");
    document.body.appendChild(modal);
    modalImage.classList.add("modal-content");
    modalImage.src = image.src;

    modal.appendChild(modalImage);
    modal.appendChild(exitButton);
    modal.appendChild(caption);

    const imageObject = {
        image: image,
        modal: modal,
        modalImage: modalImage,
        id: allImages.length,
        caption: caption,
        tags: []
    };

    return imageObject

}

function addSelectedStyle(e) {
    e.target.classList.add("added-photos-selected");
    const selectedImage = allImages.find(element => element.image === e.target);
    selectedImages.push(selectedImage);
}

function addTags() {
    let newTags = document.querySelector("#tagInputText").value.trim();
    if(newTags.replace(/\s/g, '').length) {
        newTags = newTags.split(" ");
        selectedImages.forEach(element => {
            for(const tag of newTags) {
                if(!element.tags.includes(tag))
                    element.tags.push(tag);
            }

            element.caption.innerText = element.tags.join(" #");
            element.caption.innerText = "#" + element.caption.innerText;
        });
    }
}

function searchTags() {
    let searchedTags = document.getElementById("searchText").value.trim();
    allImages.forEach(element => element.image.style.display = "");

    if(!searchedTags.length) {
        return;
    }
    searchedTags = searchedTags.split(" ");
    allImages.forEach(element => {
        for(const tag of searchedTags) {
            if(element.tags.includes(tag))
                break;
            element.image.style.display = "none";
        }
    });
}

function changeModes() {
    const checkBox = document.getElementById("editMode");
    if (checkBox.checked) {
        document.querySelectorAll(".added-photos").forEach(e =>{
            e.removeEventListener("click", openModal);
            e.addEventListener("click", addSelectedStyle);
            e.addEventListener("contextmenu", addDeleted);
        });
    }
    else {
        document.querySelectorAll(".added-photos").forEach(e =>{
            e.removeEventListener("click", addSelectedStyle);
            e.removeEventListener("contextmenu ", addDeleted);
            e.addEventListener("click", openModal);
        });
        selectedImages.forEach(e => e.image.classList.remove("added-photos-selected"));
        imagesForDeleting.forEach(e => e.image.classList.remove("added-photos-for-deleting"));
        selectedImages = [];
        imagesForDeleting = [];
    }

}

function addDeleted(e) {
    e.target.classList.add("added-photos-for-deleting");
    const selectedImage = allImages.find(element => element.image === e.target);
    imagesForDeleting.push(selectedImage);
}

function dragDropFoo(inputElement) {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", e => {
        inputElement.click();
    });

    inputElement.addEventListener("change", e => {
        if(inputElement.files.length) {
            const gallery =  document.getElementById("gallery");
            updatePhotos(gallery, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", e=> {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach(type => {
        dropZoneElement.addEventListener(type, e => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", e => {
        e.preventDefault();
        const photos = document.getElementById("gallery");
        if(e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updatePhotos(photos, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
}


document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("drop", e => {
        e.preventDefault();
    });

    document.body.addEventListener("dragover", e => {
        e.preventDefault();
    });

    document.body.addEventListener("contextmenu", e => {
        e.preventDefault();
    });

    document.querySelectorAll(".drop-zone__input").forEach(dragDropFoo);
    document.getElementById("editMode").addEventListener("change", changeModes);
    document.getElementById("submitTags").addEventListener("click", addTags);
    document.getElementById("deleteSelected").addEventListener("click", deleteImages);
    document.getElementById("submitSearch").addEventListener("click", searchTags);
    document.getElementById("showAll").addEventListener("click", () => {
        allImages.forEach(element => element.image.style.display = "");
    });
});



