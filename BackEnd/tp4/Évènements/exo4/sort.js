"use strict";

const grid = document.getElementById("grid");

grid.onclick = function(e) {
    if (e.target.tagName !== "TH") return;
    const colNum = e.target.cellIndex;
    const type = e.target.dataset.type;
    sortGrid(colNum, type);
};

function sortGrid(colNum, type) {
    let tbody = grid.querySelector("tbody");
    let rowsArray = Array.from(tbody.rows);
    let compare;

    switch (type) {
        case "number":
            compare = (rowA, rowB) => rowA.cells[colNum].innerHTML - rowB.cells[colNum].innerHTML;
            break;
        case "string":
            compare = (rowA, rowB) => rowA.cells[colNum].innerHTML > rowB.cells[colNum].innerHTML ? 1 : -1;
            break;
    }

    rowsArray.sort(compare);
    tbody.append(...rowsArray);
}