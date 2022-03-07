const spinner = document.createElement("i");
spinner.className = "fas fa-spinner fa-spin";

function getGame(id){
    request(new RequestData("getGame", id.toString()), setGame);
}

function request(requestData, callback) {
    $.ajax({
        type: "GET",
        url: `api.php?action=${requestData.action}&value=${requestData.value}`,
        success: callback
    })
}

function setGame(game) {
    game = JSON.parse(game);

    document.getElementById("gameID").valueAsNumber = game.gameID;
    document.getElementById("gameName").value = game.gameName;
    const description = document.getElementById("description");
    description.value = game.description;
    description.rows = Math.round(game.description.length / 50) + 3;
    document.getElementById("releaseDate").valueAsDate = new Date(game.releaseDate * 1000);
    document.getElementById("price").value = game.price;
    document.getElementById("review").value = game.review;
    document.getElementById("wishlisted").checked = game.wishlisted;

    const categoryNames = [];
    game.categories.forEach(category => categoryNames.push(category.categoryName));

    const categories = document.getElementById("categories");

    if(categoryNames.length > 0) {
        categories.value = categoryNames.join(", ") + ", ";
    }else{
        categories.value = "";
    }
}

function getCategory(id){
    request(new RequestData("getCategory", id.toString()), setCategory)
}

function setCategory(category){
    category = JSON.parse(category);

    document.getElementById("categorieID").valueAsNumber = category.categoryID;
    document.getElementById("categoryName").value = category.categoryName;
}

function reload(){
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    window.location = window.location.href;
}

function openFile(){
    $("#GameFile").click();
}

function fileChanged(input){
    if($(input).val()){
        $("#importForm").submit();
    }
}

function startTable(){

    let pageLength;
    const cookies = document.cookie.split("=");
    if(cookies.length > 1){
        pageLength = parseInt(cookies[1]);
    }else {
        pageLength = 10;
    }

    $('.datatable').DataTable({
        "order": [[1, "asc"]],
        "pageLength": pageLength
    });

    $(".custom-select").change(function (){
        document.cookie = "option=" + $(this).val();
    });

}