import './Game'
import './Category'
import './RequestData'

declare var $: any;

function getGame(id: number){
    request(new RequestData("getGame", id), setGame);
}

function request(requestData: RequestData, callback: (response: Object) => void) {
    $.ajax({
        type: "GET",
        url: `ajax.php?action=${requestData.action}&id=${requestData.id}`,
        success: callback
    })
}

function setGame(game: Game) {
    (document.getElementById("gameID") as HTMLInputElement).valueAsNumber = game.gameID;
    (document.getElementById("gameName") as HTMLInputElement).value = game.gameName;
    (document.getElementById("description") as HTMLInputElement).value = game.description;
    (document.getElementById("releaseDate") as HTMLInputElement).valueAsDate = new Date(game.releaseDate);
    (document.getElementById("price") as HTMLInputElement).valueAsNumber = game.price;
    (document.getElementById("purchaseDate") as HTMLInputElement).valueAsDate = new Date(game.purchaseDate);

    let categoryNames : string[] = [];
    game.categories.forEach(category => categoryNames.push(category.categoryName));
    (document.getElementById("categories") as HTMLInputElement).value = categoryNames.join();
}

function getCategory(id: number){
    request(new RequestData("getCategory", id), setCategory)
}

function setCategory(category: Category){
    (document.getElementById("categorieID") as HTMLInputElement).valueAsNumber = category.categoryID;
    (document.getElementById("categoryName") as HTMLInputElement).value = category.categoryName;
    (document.getElementById("deleted") as HTMLInputElement).checked = category.deleted;
}