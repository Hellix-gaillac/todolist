function detail(id_liste) {
	location = `detail.php?id_liste=${id_liste}`;
}

function ajouter(id_usager) {
	location = `editer.php?id_usager=${id_usager}`;
}

function modifier(evt, id_liste) {
	evt.stopPropagation();
	location = `editer.php?id_liste=${id_liste}`;
}

function supprimer(evt, id_liste) {
	evt.stopPropagation();
	let url = `supprimer.php?id_liste=${id_liste}`;

	if (confirm(`Voulez vous supprimer`)) {
		fetch(url)
			.then(response => {
				if (response.ok) {
					location.reload();
				}
			}) // then et catch retourne une promesse 'this' dans tous les cas avec erreur ou pas
			.catch(error => console.log(error));


	}
}