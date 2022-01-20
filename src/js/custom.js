"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
require("./Game");
require("./Category");
require("./RequestData");
function getGame(id) {
    request(new RequestData("getGame", id), setGame);
}
function request(requestData, callback) {
    $.ajax({
        type: "GET",
        url: "ajax.php?action=" + requestData.action + "&id=" + requestData.id,
        success: callback
    });
}
function setGame(game) {
    document.getElementById("gameID").valueAsNumber = game.gameID;
    document.getElementById("gameName").value = game.gameName;
    document.getElementById("description").value = game.description;
    document.getElementById("releaseDate").valueAsDate = new Date(game.releaseDate);
    document.getElementById("price").valueAsNumber = game.price;
    document.getElementById("purchaseDate").valueAsDate = new Date(game.purchaseDate);
    var categoryNames = [];
    game.categories.forEach(function (category) { return categoryNames.push(category.categoryName); });
    document.getElementById("categories").value = categoryNames.join();
}
function getCategory(id) {
    request(new RequestData("getCategory", id), setCategory);
}
function setCategory(category) {
    document.getElementById("categorieID").valueAsNumber = category.categoryID;
    document.getElementById("categoryName").value = category.categoryName;
    document.getElementById("deleted").checked = category.deleted;
}
//# sourceMappingURL=custom.js.map