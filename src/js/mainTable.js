async function getImages(ids){

    const imageRequest = new RequestData("getImage", "");

    for (const id of ids) {
        const element = document.getElementById(`image${id}`);
        imageRequest.value = element.dataset.name;

        request(imageRequest, (src) => {

            let image;

            if(src.length > 0) {
                image = document.createElement("img");
                image.src = src;
                image.className = "w-auto";
                image.height = 72;
            }else {
                image = document.createElement("span");
                image.innerText = "Kein Bild gefunden";
            }

            element.innerHTML = "";
            element.appendChild(image);
        });

        await sleep(250);
    }

    startTable();

    const params = getParams();
    if(params.hasOwnProperty("query")){
        search(params.query);
    }
}

function sleep(ms) {
    return new Promise((resolve) => {
        setTimeout(resolve, ms);
    });
}

function switchFavorite(id){

    const switchRequest = new RequestData("switchFavorite", id);
    request(switchRequest, reload);

    const button = document.getElementById(`favorButton${id}`);
    button.innerHTML = "";
    button.appendChild(spinner);

}

function deleteGame(id){
    if(window.confirm("Do you really want to delete this game?")) {

        const deleteRequest = new RequestData("deleteGame", id);
        request(deleteRequest, reload);

        const button = document.getElementById(`deleteButton${id}`);
        button.innerHTML = "";
        button.appendChild(spinner);

    }
}

function search(query){
    $(".dataTable").DataTable().search(query).draw();
}

function getParams (){
    const result = {};
    let tmp = [];

    location.search
        .substring(1)
        .split("&")
        .forEach(function (item)
        {
            tmp = item.split ("=");
            result[tmp[0]] = decodeURIComponent(tmp[1]);
        });

    return result;
}