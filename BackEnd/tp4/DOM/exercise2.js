"use strict";

// Change background of all <p> with class "descr"
let descrParagraphs = document.getElementsByClassName("descr");
Array.from(descrParagraphs).forEach(p => {
    p.style.background = "yellow";
});

// Get #caroussel and change background of its first <p>
let caroussel = document.getElementById("caroussel");
let firstParagraph = caroussel.getElementsByTagName("p")[0];
firstParagraph.style.background = "lightblue";