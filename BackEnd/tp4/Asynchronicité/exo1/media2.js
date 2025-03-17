"use strict";

class Media {
    constructor(name, type) {
        this.name = name;
        this.type = type;
    }

    printMe() {
        console.log("Hey ! I'm " + this.name + "!");
    }
}

document.getElementById("createCycle").addEventListener("click", () => {
    let likers = {
        likeScore: 87,
        users: [
            { "name": "user1" },
            { "name": "user2" }
        ]
    };
    let myMedia = new Media("Sword of the Stranger", "Anime");
    myMedia.score = likers;
    likers.associatedTo = myMedia;

    try {
        let jsonMedia = JSON.stringify(myMedia, (key, value) => {
            if (key === "associatedTo") return undefined; // Avoid circular reference
            return value;
        });
        document.getElementById("cycleOutput").textContent = jsonMedia;
    } catch (e) {
        document.getElementById("cycleOutput").textContent = "Error: " + e.message;
    }
});