<?php
class Liste //implements ORM
{
	public $id_liste;
	public $id_usager;
	public $nom;
	public $ref;
	public $prix;
	private $categorie = null;
	public function __construct($id_liste = null, $id_usager = null, $nom = null, $ref = null, $prix = null)
	{
		$this->id_liste = $id_liste;
		$this->id_usager = $id_usager;
		$this->nom = $nom;
		$this->ref = $ref;
		$this->prix = $prix;
	}
	public function __get($nom)
	{
		$methode = "get_{$nom}";
		return $this->$methode(); // function magique: si $produit->categorie->nom demander alors php cherche méthode magique dans ce cas renvoie vers get_categorie.
	}
	public function get_usager()
	{
		if (!$this->usager) {
			$req = "SELECT * FROM usager WHERE id_usager={$this->id_usager}";
			$this->categorie = DBMySQL::getInstance()->xeq($req)->prem(Usager::class);
			//DBMySQL::getInstance() instance pdo, xeq execussion , prem=fetch();
		}
		return $this->categorie;
	}
	public function refExiste()
	{
		$id_liste = $this->id_liste ?: 0;
		$db = DBMySQL::getInstance();
		$req = "SELECT * FROM produit WHERE ref={$db->esc($this->ref)} AND id_liste!={$id_liste}";
		return (bool)$db->xeq($req)->prem(self::class);
	}
	public function charger()
	{
		//hydrate $this en se basant sur sa PK.
		if (!$this->id_liste) {
			return false;
		}
		$req = "SELECT * FROM liste WHERE id_liste={$this->id_liste}";
		return DBMySQL::getInstance()->xeq($req)->ins($this);
	}
	public function sauver()
	{
		//Persister $this en se basant sur sa PK.
		$id_liste = $this->id_liste ?: 'DEFAULT';
		$db = DBMySQL::getInstance();
		$req = "INSERT INTO liste VALUES({$id_liste}, {$this->id_usager}, {$db->esc($this->nom)}, {$db->esc($this->ref)}, {$this->prix}) ON DUPLICATE KEY UPDATE id_usager={$this->id_usager}, nom={$db->esc($this->nom)}, ref={$db->esc($this->ref)}, prix={$this->prix}";
		$db->xeq($req);
		$this->id_liste = $this->id_liste ?: $db->pk(); // recup du dernier id incrémenteé
		return $this;
	}
	public function supprimer()
	{
		//Supprimer l'enregistrement correspondant à $this.
		if (!$this->id_liste) {
			return false;
		}
		$req = "DELETE FROM liste WHERE id_liste={$this->id_liste}";
		return (bool)DBMySQL::getInstance()->xeq($req)->nb();
	}
	public static function tab($where = 1, $orderBy = 1, $limit = null)
	{ 	// pour faire Produit::tab("prix > 10")
		//Retourne un tableau d'enregistrement souus la forme d'instances.
		$req = "SELECT * FROM liste WHERE {$where} ORDER BY {$orderBy}" . ($limit ? "LIMIT {$limit}" : '');
		return DBMySQL::getInstance()->xeq($req)->tab(self::class);
	}
	//todo modif à faire dans index... plus de requete sql dans les copntrôleur
}