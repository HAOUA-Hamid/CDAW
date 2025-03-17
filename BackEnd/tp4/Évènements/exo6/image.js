"use strict";

const upload = document.getElementById("upload");
const preview = document.getElementById("preview");
const dropbox = document.getElementById("dropbox");

// File input handler
upload.addEventListener("change", (e) => handleFiles(e.target.files));

// Click preview to trigger upload
preview.addEventListener("click", () => upload.click());

// Drag-and-drop handlers
dropbox.addEventListener("dragover", (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropbox.style.background = "#eee";
});

dropbox.addEventListener("dragleave", (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropbox.style.background = "";
});

dropbox.addEventListener("drop", (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropbox.style.background = "";
    handleFiles(e.dataTransfer.files);
});

function handleFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!file.type.startsWith("image/")) continue;

        const img = document.createElement("img");
        img.file = file;
        preview.appendChild(img);

        const reader = new FileReader();
        reader.onload = ((aImg) => (e) => { aImg.src = e.target.result; })(img);
        reader.readAsDataURL(file);
    }
}
