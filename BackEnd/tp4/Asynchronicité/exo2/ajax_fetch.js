"use strict";

const cache = new Map(); // Cache for API responses

function fetchMediaData(animeId) {
    if (cache.has(animeId)) {
        return Promise.resolve(cache.get(animeId));
    }

    return fetch(`https://api.jikan.moe/v3/anime/${animeId}`)
        .then(response => response.json())
        .then(data => {
            cache.set(animeId, data);
            return data;
        });
}

// Test API with anime ID 10
fetchMediaData(10).then(data => {
    console.log(data); // Explore fields like title, synopsis, trailer_url
});

const mediaDiv = document.getElementById("m1");

mediaDiv.addEventListener("click", () => {
    const animeId = mediaDiv.dataset.anime;
    fetchMediaData(animeId).then(data => {
        const descr = mediaDiv.querySelector(".descr");
        descr.textContent = data.synopsis || "No description available";
        descr.hidden = false;
    });
});

mediaDiv.addEventListener("mouseover", () => {
    const animeId = mediaDiv.dataset.anime;
    fetchMediaData(animeId).then(data => {
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
    trailer.src = ""; // Reset to avoid continuous playback
});