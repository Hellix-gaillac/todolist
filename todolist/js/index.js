function detail(id_produit) {
	location = `detail.php?id_produit=${id_produit}`;
}

function ajouter(id_categorie) {
	location = `editer.php?id_categorie=${id_categorie}`;
}

function modifier(evt, id_produit) {
	evt.stopPropagation();
	location = `editer.php?id_produit=${id_produit}`;
}

function supprimer(evt, id_produit) {
	evt.stopPropagation();
	let url = `supprimer.php?id_produit=${id_produit}`;

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