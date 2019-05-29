function annuler() {
	location = 'index.php';
}

function afficherPhoto(files) {
	if (!files || !files.length) { //si files nul ou vide on ne retourne rien.
		return;
	}
	let file = files[0];
	if (!file.size) {
		return alert('Fichier vide'); //partir de la methode (alert() retourne rien)  
	}
	if (file.size > MAX_FILE_SIZE) {
		return alert('Fichier trop lourd.'); //partir de la methode (alert() retourne rien)  
	}
	if ((TAB_MIME.lengthabMIME) && !TAB_MIME.includes(file.type)) {
		return alert( "Type MIME incorrect.");
	}
	let vignette = document.querySelector("#vignette");
	let reader = new FileReader();
	reader.onload = function () {
		vignette.style.backgroundImage = `url(${reader.result})`;
	};
	reader.readAsDataURL(files[0]); // ne mettre le readAsD.. avant le reader.onload
}