"use strict";

// Global variable to track which user’s comment is being modified
let currentUserDiv = null;

// Modify function: Show form and populate textarea
function modify(e) {
    currentUserDiv = e.currentTarget.parentNode;
    let comment = currentUserDiv.querySelector("p").textContent;
    let form = document.getElementById("myForm");
    let textarea = form.elements["commentText"];
    let submitBtn = form.querySelector("input[type='submit']");

    // Populate textarea and show form
    textarea.value = comment;
    form.style.display = "block";
    submitBtn.disabled = false;
}

// Delete function: Remove the user div
function deleter(e) {
    let userDiv = e.currentTarget.parentNode;
    userDiv.remove();
}

// Add function: Add a new comment block with unique ID
function addNewComment() {
    let usersDiv = document.getElementById("users");
    let lastChild = usersDiv.lastElementChild;
    let lastIdNum = lastChild ? parseInt(lastChild.id.replace("user", "")) : 0;
    let newIdNum = lastIdNum + 1;
    let newId = "user" + newIdNum;

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

// Form submission handler
function handleSubmit(e) {
    e.preventDefault(); // Prevent default submission for now (no server)

    let textarea = e.currentTarget.elements["commentText"];
    let newComment = textarea.value.trim();

    // Validation: Check if comment is non-empty
    if (newComment === "") {
        alert("Error: Comment cannot be empty!");
        return;
    }

    // Update the comment and hide the form
    if (currentUserDiv) {
        let userId = currentUserDiv.id;
        currentUserDiv.querySelector("p").textContent = newComment;
        alert(`Comment updated for ${userId}`);
        hideForm();
    }
}

// Helper function to hide the form
function hideForm() {
    let form = document.getElementById("myForm");
    let submitBtn = form.querySelector("input[type='submit']");
    form.style.display = "none";
    submitBtn.disabled = true;
    form.elements["commentText"].value = ""; // Clear textarea
    currentUserDiv = null; // Reset current user
}

// Initial event listeners
document.getElementById("addNew").addEventListener("click", addNewComment);

let modifiers = document.getElementsByClassName("modify");
Array.from(modifiers).forEach(m => m.addEventListener("click", modify));

let removers = document.getElementsByClassName("remove");
Array.from(removers).forEach(m => m.addEventListener("click", deleter));

document.getElementById("myForm").addEventListener("submit", handleSubmit);