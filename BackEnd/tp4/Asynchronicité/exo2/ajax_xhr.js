"use strict";

const cache = new Map();

function fetchMediaData(animeId, callback) {
    if (cache.has(animeId)) {
        callback(cache.get(animeId));
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `https://api.jikan.moe/v3/anime/${animeId}`, true);
    xhr.onload = () => {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            cache.set(animeId, data);
            callback(data);
        }
    };
    xhr.send();
}

// Test with anime ID 10
fetchMediaData(10, data => {
    console.log(data);
});

const mediaDiv = document.getElementById("m1");

mediaDiv.addEventListener("click", () => {
    const animeId = mediaDiv.dataset.anime;
    fetchMediaData(animeId, data => {
        const descr = mediaDiv.querySelector(".descr");
        descr.textContent = data.synopsis || "No description available";
        descr.hidden = false;
    });
});

mediaDiv.addEventListener("mouseover", () => {
    const animeId = mediaDiv.dataset.anime;
    fetchMediaData(animeId, data => {
        const trailer = mediaDiv.querySelector(".trailer");
        if (data.trailer_url) {
            trailer.src = data.trailer_url;
            trailer.style.display = "block";
        }
    });
});

mediaDiv.addEventListener("mouseout", () => {
    const trailer = mediaDiv.querySelector(".trailer");
    trailer.style.display = "none";
    trailer.src = "";
});