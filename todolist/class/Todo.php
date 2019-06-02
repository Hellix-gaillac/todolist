<?php
class Todo
{
	public $id_todo;
	public $titre;
	public $detail;
	public $dateDebut;

	public function __construct($id_todo = null, $titre = null, $detail = null, $dateDebut = null)
	{
		$this->id_todo = $id_todo;
		$this->titre = $titre;
		$this->detail = $detail;
		$this->dateDebut = $dateDebut;
	}
	public function getDetail()
	{
		$req = "SELECT detail FROM todo WHERE id_todo={$this->id_todo} ORDER BY titre";
		return DBMySQL::getInstance()->xeq($req)->prem(Todo::class);
	}

	public function charger()
	{
		//hydrate $this en se basant sur sa PK.
		if (!$this->id_usager) {
			return false;
		}
		$req = "SELECT * FROM usager WHERE id_usager={$this->id_usager}";
		return DBMySQL::getInstance()->xeq($req)->ins($this);
	}
	public function sauver()
	{
		//Persister $this en se basant sur sa PK.
		$id_usager = $this->id_usager ?: 'DEFAULT';
		$db = DBMySQL::getInstance();
		$req = "INSERT INTO usager VALUES({$id_usager}, {$db->esc($this->nom)},{$db->esc($this->prenom)}) ON DUPLICATE KEY UPDATE nom={$db->esc($this->nom)},{$db->esc($this->prenom)}";
		$db->xeq($req);
		$this->id_usager = $this->id_usager ?: $db->pk(); // recup du dernier id incrémenteé
		return $this;
	}
	public function supprimer()
	{
		//Supprimer l'enregistrement correspondant à $this.
		if (!$this->id_usager) {
			return false;
		}
		$req = "DELETE FROM usager WHERE id_usager={$this->id_usager}";
		return (bool)DBMySQL::getInstance()->xeq($req)->nb();
	}
	public static function tab($where = 1, $orderBy = 1, $limit = null)
	{ 	// pour faire Produit::tab("prix > 10")
		//Retourne un tableau d'enregistrement souus la forme d'instances.
		$req = "SELECT * FROM todo WHERE {$where} ORDER BY {$orderBy}" . ($limit ? "LIMIT {$limit}" : '');
		return DBMySQL::getInstance()->xeq($req)->tab(self::class);
	}
}