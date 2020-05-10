<?php

namespace wishlist\models;

/**
 * Opérations de base associées aux modèles
 */
interface modelOperations{
	
	/**
	 * Récupère un objet à partir de son id
	 * @static
	 * @param int[$id] id de l'objet
	 * @return object object
	 */
	public static function getById($id);
	
	/**
	 * Retourne tous les objets du même type
	 * @static
	 * @return array objets
	 */
	public static function getAll();

	/**
	 * Crée un objet
	 * @static
	 * @param array[$attributs] attributs associés à l'objet
	 * @return object objet créé
	 */
	public static function create($attributs);

	/**
	 * Modifie un objet
	 * @param array[$attributs] attributs associés à l'objet
	 */
	public function edit($attributs);

	/**
	 * Supprime un objet
	 */
	public function delete();

}