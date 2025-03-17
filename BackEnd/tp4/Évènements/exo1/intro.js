"use strict";

function handleB1Click() {
    alert("B1 clicked!");
    b1.removeEventListener("click", handleB1Click);
    b2.addEventListener("click", handleB2Click);
}

function handleB2Click() {
    alert("B2 clicked!");
    b2.removeEventListener("click", handleB2Click);
    b1.addEventListener("click", handleB1Click);
}

const b1 = document.getElementById("b1");
const b2 = document.getElementById("b2");

b1.addEventListener("click", handleB1Click);