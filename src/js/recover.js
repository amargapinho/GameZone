function recover(id){

	const data = new RequestData("recover", id);
	request(data, reload);

	const button = document.getElementById(`recoverButton${id}`);
	button.innerHTML = "";
	button.append(spinner);

}