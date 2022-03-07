function deleteCategory(id){

    if(window.confirm("Do you realy want to delete this Category?")) {

        const data = new RequestData("deleteCategory", id);
        request(data, reload);

        const button = document.getElementById(`deleteButton${id}`);
        button.innerHTML = "";
        button.appendChild(spinner);

    }

}