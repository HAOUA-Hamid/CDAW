"use strict";

const table = document.getElementById("mediaTable");

table.addEventListener("click", (e) => {
    const td = e.target.closest("td.media");
    if (!td || !table.contains(td)) return;
    const mediaId = td.querySelector("strong").textContent;
    alert(`${mediaId} added to playlist`);
});