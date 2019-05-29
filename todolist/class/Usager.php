<?php
class Usager
{
	public $id_usager;
	public $nom;
	public $prenom;

	public function __construct($id_usager = null, $nom = null, $prenom = null)
	{
		$this->id_usager = $id_usager;
		$this->nom = $nom;
		$this->prenom = $prenom;
	}
	public function getTabListe()
	{
		$req = "SELECT * FROM liste WHERE id_usager={$this->id_usager} ORDER BY nom";
		return DBMySQL::getInstance()->xeq($req)->tab(Liste::class);
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
		$req = "SELECT * FROM usager WHERE {$where} ORDER BY {$orderBy}" . ($limit ? "LIMIT {$limit}" : '');
		return DBMySQL::getInstance()->xeq($req)->tab(self::class);
	}
}