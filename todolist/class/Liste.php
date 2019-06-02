<?php
class Liste
{
	public $id_liste;
	public $titre;
	private $usager = null;
	private $todo = null;

	public function __construct($id_liste = null, $titre = null)
	{
		$this->id_liste = $id_liste;
		$this->titre = $titre;
	}
	public function getTabTodo()
	{
		$req = "SELECT * FROM todo WHERE id_liste={$this->id_liste} ORDER BY titre";
		return DBMySQL::getInstance()->xeq($req)->tab(Todo::class);
	}
	public function __get($nom)
	{
		$methode = "get_{$nom}";
		return $this->$methode(); // function magique: si $produit->usager->nom demander alors php cherche méthode magique dans ce cas renvoie vers get_categorie.
	}
	public function get_usager()
	{
		if (!$this->usager) {
			$req = "SELECT * FROM usager WHERE id_usager={$this->id_usager}";
			return DBMySQL::getInstance()->xeq($req)->prem(Liste::class);
		}
		return $this->usager;
	}
	public function get_todo()
	{
		if (!$this->todo) {
			$req = "SELECT * FROM todo WHERE id_liste={$this->id_liste}";
			return DBMySQL::getInstance()->xeq($req)->tab(Todo::class);
		}
		return $this->todo;
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
		$req = "INSERT INTO liste VALUES({$id_liste},{$this->id_usager}, {$db->esc($this->titre)}) ON DUPLICATE KEY UPDATE titre={$db->esc($this->titre)}";
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
		$req = "SELECT * FROM todo WHERE {$where} ORDER BY {$orderBy}" . ($limit ? "LIMIT {$limit}" : '');
		return DBMySQL::getInstance()->xeq($req)->tab(self::class);
	}
}