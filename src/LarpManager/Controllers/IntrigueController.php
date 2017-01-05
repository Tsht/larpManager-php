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
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Doctrine\Common\Collections\ArrayCollection;
use JasonGrimes\Paginator;

use LarpManager\Form\Intrigue\IntrigueForm;
use LarpManager\Form\Intrigue\IntrigueFindForm;
use LarpManager\Form\Intrigue\IntrigueDeleteForm;
use LarpManager\Form\Intrigue\IntrigueRelectureForm;

use LarpManager\Entities\Intrigue;
use LarpManager\Entities\Relecture;

/**
 * LarpManager\Controllers\IntrigueController
 *
 * @author kevin
 */
class IntrigueController
{
	/**
	 * Liste de toutes les intrigues
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	function listAction(Request $request, Application $app)
	{
		$order_by = $request->get('order_by') ?: 'titre';
		$order_dir = $request->get('order_dir') == 'DESC' ? 'DESC' : 'ASC';
		$limit = (int)($request->get('limit') ?: 50);
		$page = (int)($request->get('page') ?: 1);
		$offset = ($page - 1) * $limit;
		$type= null;
		$value = null;
		
		$form = $app['form.factory']->createBuilder(new IntrigueFindForm())->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$data = $form->getData();
			$type = $data['type'];
			$value = $data['search'];
		}
		
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Intrigue');
		
		$intrigues = $repo->findList(
				$type,
				$value,
				array( 'by' =>  $order_by, 'dir' => $order_dir),
				$limit,
				$offset);
		
		$numResults = $repo->findCount($type, $value);
		
		$paginator = new Paginator($numResults, $limit, $page,
				$app['url_generator']->generate('intrigue.list') . '?page=(:num)&limit=' . $limit . '&order_by=' . $order_by . '&order_dir=' . $order_dir
				);
		
		
		return $app['twig']->render('admin/intrigue/list.twig', array(
				'form' => $form->createView(),
				'intrigues' => $intrigues,
				'paginator' => $paginator,
		));
	}
	
	/**
	 * Lire une intrigue
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Intrigue $intrigue
	 */
	function detailAction(Request $request, Application $app, Intrigue $intrigue)
	{
		return $app['twig']->render('admin/intrigue/detail.twig', array(
				'intrigue' => $intrigue,
		));
	}
	
	/**
	 * Ajouter une intrigue
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	function addAction(Request $request, Application $app)
	{
		$intrigue = new Intrigue();
		$form = $app['form.factory']->createBuilder(new IntrigueForm(), $intrigue)
			->add('add','submit', array('label' => 'Ajouter l\'intrigue'))->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$intrigue = $form->getData();
			$intrigue->setUser($app['user']);
			
			/**
			 * Pour tous les groupes de l'intrigue
			 */
			foreach ($intrigue->getIntrigueHasGroupes() as $intrigueHasGroupe)
			{
				$intrigueHasGroupe->setIntrigue($intrigue);
			}
			
			/**
			 * Pour tous les événements de l'intrigue
			 */
			foreach ($intrigue->getIntrigueHasEvenements() as $intrigueHasEvenement)
			{
				$intrigueHasEvenement->setIntrigue($intrigue);
			}
			
			/**
			 * Pour tous les objectifs de l'intrigue
			 */
			foreach ($intrigue->getIntrigueHasObjectifs() as $intrigueHasObjectif)
			{
				$intrigueHasObjectif->setIntrigue($intrigue);
			}
			
			$app['orm.em']->persist($intrigue);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'Votre intrigue a été ajouté.');
			return $app->redirect($app['url_generator']->generate('intrigue.list'),301);
		}
		
		return $app['twig']->render('admin/intrigue/add.twig', array(
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Mettre à jour une intrigue
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Intrigue $intrigue
	 */
	function updateAction(Request $request, Application $app, Intrigue $intrigue)
	{
		$originalIntrigueHasGroupes = new ArrayCollection();
		$originalIntrigueHasEvenements = new ArrayCollection();
		$originalIntrigueHasObjectifs = new ArrayCollection();
		
		/**
		 *  Crée un tableau contenant les objets IntrigueHasGroupe de l'intrigue
		 */
		foreach ($intrigue->getIntrigueHasGroupes() as $intrigueHasGroupe)
		{
			$originalIntrigueHasGroupes->add($intrigueHasGroupe);
		}
		
		/**
		 *  Crée un tableau contenant les objets IntrigueHasEvenement de l'intrigue
		 */
		foreach ($intrigue->getIntrigueHasEvenements() as $intrigueHasEvenement)
		{
			$originalIntrigueHasEvenements->add($intrigueHasEvenement);
		}
		
		/**
		 *  Crée un tableau contenant les objets IntrigueHasObjectif de l'intrigue
		 */
		foreach ($intrigue->getIntrigueHasObjectifs() as $intrigueHasObjectif)
		{
			$originalIntrigueHasObjectifs->add($intrigueHasObjectif);
		}
		
		$form = $app['form.factory']->createBuilder(new IntrigueForm(), $intrigue)
			->add('enregistrer','submit', array('label' => 'Enregistrer'))->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$intrigue = $form->getData();
			$intrigue->setDateUpdate(new \Datetime('NOW'));
			
			/**
			 * Pour tous les groupes de l'intrigue
			 */
			foreach ($intrigue->getIntrigueHasGroupes() as $intrigueHasGroupe)
			{
				$intrigueHasGroupe->setIntrigue($intrigue);
			}
			
			/**
			 * Pour tous les événements de l'intrigue
			 */
			foreach ($intrigue->getIntrigueHasEvenements() as $intrigueHasEvenement)
			{
				$intrigueHasEvenement->setIntrigue($intrigue);
			}
			
			/**
			 * Pour tous les objectifs de l'intrigue
			 */
			foreach ($intrigue->getIntrigueHasObjectifs() as $intrigueHasObjectif)
			{
				$intrigueHasObjectif->setIntrigue($intrigue);
			}
			
			/**
			 *  supprime la relation entre intrigueHasGroupe et l'intrigue
			 */
			foreach ($originalIntrigueHasGroupes as $intrigueHasGroupe) {
				if ($intrigue->getIntrigueHasGroupes()->contains($intrigueHasGroupe) == false) {
					$app['orm.em']->remove($intrigueHasGroupe);
				}
			}
			
			/**
			 *  supprime la relation entre intrigueHasEvenement et l'intrigue
			 */
			foreach ($originalIntrigueHasEvenements as $intrigueHasEvenement) {
				if ($intrigue->getIntrigueHasEvenements()->contains($intrigueHasEvenement) == false) {
					$app['orm.em']->remove($intrigueHasEvenement);
				}
			}
			
			/**
			 *  supprime la relation entre intrigueHasObjectif et l'intrigue
			 */
			foreach ($originalIntrigueHasObjectifs as $intrigueHasObjectif) {
				if ($intrigue->getIntrigueHasObjectifs()->contains($intrigueHasObjectif) == false) {
					$app['orm.em']->remove($intrigueHasObjectif);
				}
			}
			
			$app['orm.em']->persist($intrigue);
			$app['orm.em']->flush();
				
			$app['session']->getFlashBag()->add('success', 'Votre intrigue a été modifiée.');
			return $app->redirect($app['url_generator']->generate('intrigue.detail', array('intrigue' => $intrigue->getId())),301);
		}
		return $app['twig']->render('admin/intrigue/update.twig', array(
				'form' => $form->createView(),
				'intrigue' => $intrigue,
		));
	}
	
	/**
	 * Supression d'une intrigue
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Intrigue $intrigue
	 */
	function deleteAction(Request $request, Application $app, Intrigue $intrigue)
	{
		$form = $app['form.factory']->createBuilder(new IntrigueDeleteForm(), $intrigue)
			->add('supprimer','submit', array('label' => 'Supprimer'))->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$intrigue = $form->getData();
			$app['orm.em']->remove($intrigue);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'L\'intrigue a été supprimée.');
			return $app->redirect($app['url_generator']->generate('intrigue.list'),301);
		}
		
		return $app['twig']->render('admin/intrigue/delete.twig', array(
				'form' => $form->createView(),
				'intrigue' => $intrigue,
		));
	}
	
	function relectureAddAction(Request $request, Application $app, Intrigue $intrigue)
	{
		$relecture = new Relecture();
		$form = $app['form.factory']->createBuilder(new IntrigueRelectureForm(), $relecture)
			->add('enregistrer','submit', array('label' => 'Enregistrer'))->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$relecture = $form->getData();
			$relecture->setUser($app['user']);
			$relecture->setIntrigue($intrigue);
				
			$app['orm.em']->persist($relecture);
			$app['orm.em']->flush();
				
			$app['session']->getFlashBag()->add('success', 'Votre relecture a été enregistrée.');
			return $app->redirect($app['url_generator']->generate('intrigue.detail', array('intrigue' => $intrigue->getId())),301);
		}
		
		return $app['twig']->render('admin/intrigue/relecture.twig', array(
				'form' => $form->createView(),
				'intrigue' => $intrigue,
		));
	}
}