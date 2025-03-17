"use strict";

document.getElementById("parseDate").addEventListener("click", () => {
    const jsonString = `{
        "name": "Yojimbo",
        "type": "Film",
        "annotations": ["Drame", "Thriller"],
        "realisateur": "Akira Kurosawa",
        "date": "1961-09-13T12:00:00.000Z"
    }`;
    let parsedMedia = JSON.parse(jsonString, (key, value) => {
        if (key === "date") return new Date(value);
        return value;
    });
    document.getElementById("parseDateOutput").textContent = 
        `Name: ${parsedMedia.name}\nType: ${parsedMedia.type}\nAnnotations: ${parsedMedia.annotations.join(", ")}\nRéalisateur: ${parsedMedia.realisateur}\nDate: ${parsedMedia.date.toLocaleDateString()} (Day: ${parsedMedia.date.getDate()})`;
});