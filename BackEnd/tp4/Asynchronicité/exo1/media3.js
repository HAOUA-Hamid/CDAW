"use strict";

document.getElementById("parseSimple").addEventListener("click", () => {
    const jsonString = `{
        "name": "Yojimbo",
        "type": "Film",
        "annotations": ["Drame", "Thriller"],
        "realisateur": "Akira Kurosawa"
    }`;
    let parsedMedia = JSON.parse(jsonString);
    document.getElementById("parseSimpleOutput").textContent = 
        `Name: ${parsedMedia.name}\nType: ${parsedMedia.type}\nAnnotations: ${parsedMedia.annotations.join(", ")}\nRéalisateur: ${parsedMedia.realisateur}`;
});