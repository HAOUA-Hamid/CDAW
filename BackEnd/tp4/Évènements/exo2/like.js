"use strict";

const heart = document.querySelector(".like-b i");
const span = document.querySelector(".like-b span");

heart.addEventListener("click", () => {
    heart.classList.toggle("press");
    span.classList.toggle("press");
});
