<?php
class Todo implements ORM
{
	public $id_produit;
	public $id_categorie;
	public $nom;
	public $ref;
	public $prix;
	private $categorie = null;
	public function __construct($id_produit = null, $id_categorie = null, $nom = null, $ref = null, $prix = null)
	{
		$this->id_produit = $id_produit;
		$this->id_categorie = $id_categorie;
		$this->nom = $nom;
		$this->ref = $ref;
		$this->prix = $prix;
	}
	public function __get($nom)
	{
		$methode = "get_{$nom}";
		return $this->$methode(); // function magique: si $produit->categorie->nom demander alors php cherche méthode magique dans ce cas renvoie vers get_categorie.
	}
	public function get_categorie()
	{
		if (!$this->categorie) {
			$req = "SELECT * FROM categorie WHERE id_categorie={$this->id_categorie}";
			$this->categorie = DBMySQL::getInstance()->xeq($req)->prem(Categorie::class);
			//DBMySQL::getInstance() instance pdo, xeq execussion , prem=fetch();
		}
		return $this->categorie;
	}
	public function refExiste()
	{
		$id_produit = $this->id_produit ?: 0;
		$db = DBMySQL::getInstance();
		$req = "SELECT * FROM produit WHERE ref={$db->esc($this->ref)} AND id_produit!={$id_produit}";
		return (bool)$db->xeq($req)->prem(self::class);
	}
	public function charger()
	{
		//hydrate $this en se basant sur sa PK.
		if (!$this->id_produit) {
			return false;
		}
		$req = "SELECT * FROM produit WHERE id_produit={$this->id_produit}";
		return DBMySQL::getInstance()->xeq($req)->ins($this);
	}
	public function sauver()
	{
		//Persister $this en se basant sur sa PK.
		$id_produit = $this->id_produit ?: 'DEFAULT';
		$db = DBMySQL::getInstance();
		$req = "INSERT INTO produit VALUES({$id_produit}, {$this->id_categorie}, {$db->esc($this->nom)}, {$db->esc($this->ref)}, {$this->prix}) ON DUPLICATE KEY UPDATE id_categorie={$this->id_categorie}, nom={$db->esc($this->nom)}, ref={$db->esc($this->ref)}, prix={$this->prix}";
		$db->xeq($req);
		$this->id_produit = $this->id_produit ?: $db->pk(); // recup du dernier id incrémenteé
		return $this;
	}
	public function supprimer()
	{
		//Supprimer l'enregistrement correspondant à $this.
		if (!$this->id_produit) {
			return false;
		}
		$req = "DELETE FROM produit WHERE id_produit={$this->id_produit}";
		return (bool)DBMySQL::getInstance()->xeq($req)->nb();
	}
	public static function tab($where = 1, $orderBy = 1, $limit = null)
	{ 	// pour faire Produit::tab("prix > 10")
		//Retourne un tableau d'enregistrement souus la forme d'instances.
		$req = "SELECT * FROM produit WHERE {$where} ORDER BY {$orderBy}" . ($limit ? "LIMIT {$limit}" : '');
		return DBMySQL::getInstance()->xeq($req)->tab(self::class);
	}
	//todo modif à faire dans index... plus de requete sql dans les copntrôleur
}