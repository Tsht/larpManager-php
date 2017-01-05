<?php

/**
 * LarpManager - A Live Action Role Playing Manager
 * Copyright (C) 2016 Kevin Polez
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
namespace LarpManager\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use Silex\Application;

/**
 * LarpManager\Controllers\EconnomieController
 *
 * @author kevin
 *
 */
class EconnomieController
{
	/**
	 * Présentation des constructions
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function indexAction(Request $request, Application $app)
	{
		/* calcul de la masse monétaire :
		 * correspond à somme des revenus des groupes en jeu 
		 * les revenus d'un groupe provient des territoire qu'il contrôle 
		 * 
		 * calcul des ressources :
		 * Les ressources en jeu correspond à la totalité des ressources
		 * fourni par les territoires contrôlé par les groupes
		 * 
		 **/
		
		$territoires = new ArrayCollection();
		$ressources = new ArrayCollection();
		$ingredients = new ArrayCollection();
		$constructions = new ArrayCollection();
			
		// recherche le prochain GN
		$gnRepo = $app['orm.em']->getRepository('\LarpManager\Entities\Gn');
		$gn = $gnRepo->findNext();
		
		
		$groupeRepo = $app['orm.em']->getRepository('\LarpManager\Entities\Groupe');
		$groupes = $groupeRepo->findAll();
		
		foreach ($groupes as $groupe)
		{
			//  les groupes doivent participer au prochain GN
			if ( $groupe->getGroupeGnById($gn->getId())) {
				foreach ( $groupe->getTerritoires() as $territoire)
				{
					$territoires[] = $territoire;
				}	
			}
		}
				
		$masseMonetaire = 0;
		foreach ( $territoires as $territoire )
		{
			$masseMonetaire += $territoire->getTresor();

			// récupération des ressources
			foreach ( $territoire->getImportations() as $ressource)
			{
				if ( $ressources->containsKey($ressource->getId()) )
				{
					$value = $ressources->get($ressource->getId());
					$value['nombre'] += 1;
					$value['territoires'][] = $territoire;
					
					$ressources->set($ressource->getId(),$value);
				}
				else
				{
					$ressources->set($ressource->getId(),array(
							'label' => $ressource->getLabel(),
							'nombre' => 1,
							'territoires' => array($territoire)
					));
				}
			}
			
			// classement des résultats par ordre décroissant
			$iterator = $ressources->getIterator();
			$iterator->uasort(function ($first, $second) {
				return (int) $first['nombre'] < (int) $second['nombre'] ? 1 : -1;
			});				
			$ressources = new ArrayCollection(iterator_to_array($iterator));
			
			// récupération des ingrédients
			foreach ( $territoire->getIngredients() as $ingredient)
			{
				if ( $ingredients->containsKey($ingredient->getId()) )
				{
					$value = $ingredients->get($ingredient->getId());
					$value['nombre'] += 1;
					$value['territoires'][] = $territoire;
					
					$ingredients->set($ingredient->getId(),$value);
				}
				else
				{
					$ingredients->set($ingredient->getId(),array(
							'label' => $ingredient->getLabel(),
							'nombre' => 1,
							'territoires' => array($territoire)
					));
				}
			}
			// classement des résultats par ordre décroissant
			$iterator = $ingredients->getIterator();
			$iterator->uasort(function ($first, $second) {
				return (int) $first['nombre'] < (int) $second['nombre'] ? 1 : -1;
			});
			$ingredients = new ArrayCollection(iterator_to_array($iterator));
			
			// récupération des constructions
			foreach ( $territoire->getConstructions() as $construction)
			{
				if ( $constructions->containsKey($construction->getId()) )
				{
					$value = $constructions->get($construction->getId());
					$value['nombre'] += 1;
					$value['territoires'][] = $territoire;
					
					$constructions->set($construction->getId(),$value);
				}
				else
				{
					$constructions->set($construction->getId(),array(
							'label' => $construction->getLabel(),
							'nombre' => 1,
							'territoires' => array($territoire)
					));
				}	
			}
			// classement des résultats par ordre décroissant
			$iterator = $constructions->getIterator();
			$iterator->uasort(function ($first, $second) {
				return (int) $first['nombre'] < (int) $second['nombre'] ? 1 : -1;
			});
			$constructions = new ArrayCollection(iterator_to_array($iterator));
		}
		
		return $app['twig']->render('admin/econnomie/index.twig', array(
				'gn' => $gn,
				'masseMonetaire' => $masseMonetaire,
				'ressources' => $ressources,
				'ingredients' => $ingredients,
				'constructions' => $constructions,
				));
	}

}