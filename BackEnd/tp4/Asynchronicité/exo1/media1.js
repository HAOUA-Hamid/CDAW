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

document.getElementById("createSimple").addEventListener("click", () => {
    let myMedia = new Media("Hope", "Drama");
    myMedia.printMe();
    let jsonMedia = JSON.stringify(myMedia);
    document.getElementById("simpleOutput").textContent = jsonMedia;
});