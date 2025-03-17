"use strict";

// Modify function: Replace comment text
function modify(e) {
    let userDiv = e.currentTarget.parentNode;
    let comment = userDiv.querySelector("p");
    comment.textContent = "Chaîne modifiée!!";
}

// Delete function: Remove the user div
function deleter(e) {
    let userDiv = e.currentTarget.parentNode;
    userDiv.remove(); // Removes the entire div from the DOM
}

// Add function: Add a new comment block with unique ID
function addNewComment() {
    let usersDiv = document.getElementById("users");
    let lastChild = usersDiv.lastElementChild; // Get the last user div
    let lastIdNum = lastChild ? parseInt(lastChild.id.replace("user", "")) : 0; // Extract number from last ID
    let newIdNum = lastIdNum + 1;
    let newId = "user" + newIdNum;

    // Create new comment block using innerHTML
    usersDiv.innerHTML += `
        <div id="${newId}">
            <h4>New User ${newIdNum}</h4>
            <p>New comment added dynamically.</p>
            <button class="modify">Modify Comment</button>
            <button class="remove">Remove Comment</button>
        </div>
    `;

    // Re-attach event listeners to new buttons
    let newModifyBtn = document.querySelector(`#${newId} .modify`);
    let newRemoveBtn = document.querySelector(`#${newId} .remove`);
    newModifyBtn.addEventListener("click", modify);
    newRemoveBtn.addEventListener("click", deleter);
}

// Initial event listeners
document.getElementById("addNew").addEventListener("click", addNewComment);

let modifiers = document.getElementsByClassName("modify");
Array.from(modifiers).forEach(m => m.addEventListener("click", modify));

let removers = document.getElementsByClassName("remove");
Array.from(removers).forEach(m => m.addEventListener("click", deleter));