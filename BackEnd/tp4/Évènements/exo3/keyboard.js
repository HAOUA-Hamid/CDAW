"use strict";

const medias = Array.from(document.querySelectorAll("#medias > div"));
let currentIndex = 0;

function updateFocus() {
    const media = medias[currentIndex];
    const title = media.querySelector(".title").textContent;
    const descr = media.querySelector(".descr").textContent;
    document.getElementById("focus").textContent = `${title}: ${descr}`;
}

document.addEventListener("keydown", (e) => {
    if (!e.ctrlKey) return;

    if (e.key === "ArrowRight" && currentIndex < medias.length - 1) {
        currentIndex++;
        updateFocus();
    } else if (e.key === "ArrowLeft" && currentIndex > 0) {
        currentIndex--;
        updateFocus();
    }
});

updateFocus();