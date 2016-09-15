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

use LarpManager\Form\Groupe\GroupeForm;
use LarpManager\Form\Groupe\GroupeDescriptionForm;
use LarpManager\Form\Groupe\GroupeScenaristeForm;
use LarpManager\Form\Groupe\GroupeCompositionForm;

use LarpManager\Form\GroupFindForm;
use LarpManager\Form\BackgroundForm;
use LarpManager\Form\RequestAllianceForm;
use LarpManager\Form\AcceptAllianceForm;
use LarpManager\Form\CancelRequestedAllianceForm;
use LarpManager\Form\RefuseAllianceForm;
use LarpManager\Form\BreakAllianceForm;
use LarpManager\Form\DeclareWarForm;
use LarpManager\Form\RequestPeaceForm;
use LarpManager\Form\AcceptPeaceForm;
use LarpManager\Form\RefusePeaceForm;
use LarpManager\Form\CancelRequestedPeaceForm;
use LarpManager\Form\GroupeDocumentForm;


use LarpManager\Entities\Groupe;
use LarpManager\Entities\GroupeGn;
use LarpManager\Entities\Document;


/**
 * LarpManager\Controllers\GroupeController
 *
 * @author kevin
 */
class GroupeController
{		
	
	/**
	 * Modifier la composition du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Groupe $groupe
	 */
	public function compositionAction(Request $request, Application $app, Groupe $groupe)
	{
		$originalGroupeClasses = new ArrayCollection();
		
		/**
		 *  Crée un tableau contenant les objets GroupeClasse du groupe
		 */
		foreach ($groupe->getGroupeClasses() as $groupeClasse)
		{
			$originalGroupeClasses->add($groupeClasse);
		}
		
		$form = $app['form.factory']->createBuilder(new GroupeCompositionForm(), $groupe)
			->add('submit','submit', array('label' => 'Enregistrer'))
			->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$groupe = $form->getData();
			
			/**
			 * Pour toutes les classes du groupe
			 */
			foreach ( $groupe->getGroupeClasses() as $groupeClasses)
			{
				$groupeClasses->setGroupe($groupe);
			}
			
			/**
			 *  supprime la relation entre le groupeClasse et le groupe
			 */
			foreach ($originalGroupeClasses as $groupeClasse) {
				if ($groupe->getGroupeClasses()->contains($groupeClasse) == false) {
					$app['orm.em']->remove($groupeClasse);
				}
			}
			
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'La composition du groupe a été sauvegardé.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/composition.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Modification de la description du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Groupe $groupe
	 */
	public function descriptionAction(Request $request, Application $app, Groupe $groupe)
	{
		$form = $app['form.factory']->createBuilder(new GroupeDescriptionForm(), $groupe)
			->add('submit','submit', array('label' => 'Enregistrer'))
			->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$groupe = $form->getData();
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
		
			$app['session']->getFlashBag()->add('success', 'La description du groupe a été sauvegardé.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/description.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Choix du scenariste
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Groupe $groupe
	 */
	public function scenaristeAction(Request $request, Application $app, Groupe $groupe)
	{
		$form = $app['form.factory']->createBuilder(new GroupeScenaristeForm(), $groupe)
			->add('submit','submit', array('label' => 'Enregistrer'))
			->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$groupe = $form->getData();
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
				
			$app['session']->getFlashBag()->add('success', 'Le groupe a été sauvegardé.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/scenariste.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
		
	/**
	 * fourni le tableau de quête pour tous les groupes
	 * @param Request $request
	 * @param Application $app
	 */
	public  function quetesAction(Request $request, Application $app)
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Groupe');
		$groupes = $repo->findAllOrderByNumero();
		$ressourceRares = new ArrayCollection($app['orm.em']->getRepository('\LarpManager\Entities\Ressource')->findRare());
		$ressourceCommunes = new ArrayCollection($app['orm.em']->getRepository('\LarpManager\Entities\Ressource')->findCommun());
		
		$quetes = new ArrayCollection();
		$stats = array();
		
		foreach ( $groupes as $groupe )
		{
			$quete = $app['larp.manager']->generateQuete($groupe, $ressourceCommunes, $ressourceRares);
			$quetes[] = array(
				'quete' => $quete,
				'groupe' => $groupe,
			);
			foreach ( $quete['needs'] as $ressources)
			{
				if ( isset($stats[$ressources->getLabel()]))
				{
					$stats[$ressources->getLabel()] += 1;
				}
				else
				{
					$stats[$ressources->getLabel()] = 1;
				}
			}		
		}
		
		if ( $request->get('csv'))
		{
			header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=eveoniris_quetes_".date("Ymd").".csv");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			$output = fopen("php://output", "w");
			
			// header
			fputcsv($output,
			array(
			'nom',
			'pays',
			'res 1',
			'res 2',
			'res 3',
			'res 4',
			'res 5',
			'res 6',
			'res 7',
			'Départ',
			'Arrivée',
			'recompense 1',
			'recompense 2',
			'recompense 3',
			'recompense 4',
			'recompense 5',
			'description'), ';');
			
			foreach ($quetes as $quete)
			{
				$line = array();
				$line[] = utf8_decode('#'.$quete['groupe']->getNumero().' '. $quete['groupe']->getNom());
				if ( $quete['groupe']->getTerritoire())
				{
					$line[] = utf8_decode($quete['groupe']->getTerritoire()->getNom());
				}
				else 
				{
					$line[] = '';
				}
				
				foreach ( $quete['quete']['needs'] as $ressources)
				{
					$line[] = utf8_decode($ressources->getLabel());
				}
				$line[] = '';
				$line[] = '';
				foreach ( $quete['quete']['recompenses'] as $recompense)
				{
					$line[] =  utf8_decode($recompense);
				}	
				$line[] = '';
				fputcsv($output, $line, ';');
			}
			
			fclose($output);
			exit();
		}
			
		return $app['twig']->render('admin/groupe/quetes.twig', array(
				'quetes' => $quetes,
				'stats' => $stats
		));
	}
	
	/**
	 * Générateur de quêtes commerciales
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function queteAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$ressourceRares = new ArrayCollection($app['orm.em']->getRepository('\LarpManager\Entities\Ressource')->findRare());
		$ressourceCommunes = new ArrayCollection($app['orm.em']->getRepository('\LarpManager\Entities\Ressource')->findCommun());
		$quete = $app['larp.manager']->generateQuete($groupe,$ressourceCommunes, $ressourceRares);
			
		return $app['twig']->render('admin/groupe/quete.twig', array(
				'groupe' => $groupe,
				'needs' => $quete['needs'],
				'valeur' => $quete['valeur'],
				'px' => $quete['px'],
				'recompenses' => $quete['recompenses'],
			));
	}
	
	/**
	 * Ajoute un document dans le matériel du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function adminDocumentAction(Request $request, Application $app, Groupe $groupe)
	{
		$form = $app['form.factory']->createBuilder(new GroupeDocumentForm(), $groupe)
			->add('submit','submit', array('label' => 'Enregistrer'))
			->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$groupe = $form->getData();
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'Le document a été ajouté au groupe.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/documents.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		)); 
	}
	
	/**
	 * Gestion de l'enveloppe de groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Groupe $groupe
	 */
	public function envelopeAction(Request $request, Application $app, Groupe $groupe)
	{
		return $app['twig']->render('admin/groupe/envelope.twig', array(
				'groupe' => $groupe,
		));
	}
	
	/**
	 * Gestion des membres du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @param Groupe $groupe
	 */
	public function usersAction(Request $request, Application $app, Groupe $groupe)
	{
		return $app['twig']->render('admin/groupe/users.twig', array(
				'groupe' => $groupe,
		));
	}
	
	/**
	 * vérouillage d'un groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function lockAction(Request $request, Application $app, Groupe $groupe)
	{
		$groupe->setLock(true);
		$app['orm.em']->persist($groupe);
		$app['orm.em']->flush();
		
		$app['session']->getFlashBag()->add('success', 'Le groupe est verrouillé. Cela bloque la création et la modification des personnages membres de ce groupe');
		return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
	}
	
	/**
	 * devérouillage d'un groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function unlockAction(Request $request, Application $app, Groupe $groupe)
	{	
		$groupe->setLock(false);
		$app['orm.em']->persist($groupe);
		$app['orm.em']->flush();
	
		$app['session']->getFlashBag()->add('success', 'Le groupe est dévérouillé');
		return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
	}
	
	/**
	 * rendre disponible un groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function availableAction(Request $request, Application $app, Groupe $groupe)
	{
		$groupe->setFree(true);
		$app['orm.em']->persist($groupe);
		$app['orm.em']->flush();
	
		$app['session']->getFlashBag()->add('success', 'Le groupe est maintenant disponible. Il pourra être réservé par un joueur');
		return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
	}
	
	/**
	 * rendre indisponible un groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function unvailableAction(Request $request, Application $app, Groupe $groupe)
	{	
		$groupe->setFree(false);
		$app['orm.em']->persist($groupe);
		$app['orm.em']->flush();
	
		$app['session']->getFlashBag()->add('success', 'Le groupe est maintenant réservé. Il ne pourra plus être réservé par un joueur');
		return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
	}
	
	/**
	 * Lier un pays à un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function paysAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		
		$form = $app['form.factory']->createBuilder()
			->add('territoire', 'entity', array(
					'required' => true,
					'class' => 'LarpManager\Entities\Territoire',
					'property' => 'nomComplet',
					'label' => 'choisissez le territoire',
					'expanded' => true,
					'query_builder' => function (\LarpManager\Repository\TerritoireRepository $er) {
						$qb = $er->createQueryBuilder('t');
						$qb->andWhere($qb->expr()->isNull('t.territoire'));
						$qb->orderBy('t.nom', 'ASC');
						return $qb;
					},
			))
			->add('add','submit', array('label' => 'Ajouter le territoire'))->getForm();
			
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$data = $form->getData();
			$territoire = $data['territoire'];
				
			$groupe->setTerritoire($territoire);
		
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
		
			$app['session']->getFlashBag()->add('success', 'Le groupe est lié au pays');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/pays.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Ajout d'un territoire sous le controle du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function territoireAddAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		
		$form = $app['form.factory']->createBuilder()
			->add('territoire', 'entity', array(
					'required' => true,
					'class' => 'LarpManager\Entities\Territoire',
					'property' => 'nomComplet',
					'label' => 'choisissez le territoire',
					'expanded' => true,
			))
			->add('add','submit', array('label' => 'Ajouter le territoire'))->getForm();
			
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$data = $form->getData();
			$territoire = $data['territoire'];
			
			$territoire->setGroupe($groupe);
				
			$app['orm.em']->persist($territoire);
			$app['orm.em']->flush();
				
			$app['session']->getFlashBag()->add('success', 'Le territoire est contrôlé par le groupe');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/addTerritoire.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Retirer un territoire du controle du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function territoireRemoveAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$territoire = $request->get('territoire');
		
		$form = $app['form.factory']->createBuilder()
			->add('remove','submit', array('label' => 'Retirer le territoire'))->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$territoire->setGroupeNull();
			
			$app['orm.em']->persist($territoire);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'Le territoire n\'est plus controlé par le groupe');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
		}
		
		return $app['twig']->render('admin/groupe/removeTerritoire.twig', array(
				'groupe' => $groupe,
				'territoire' => $territoire,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Gestion de la restauration d'un groupe
	 * @param Request $request
	 * @param Application $app
	 */
	public function restaurationAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$availableTaverns = $app['larp.manager']->getAvailableTaverns();
		
		$formBuilder = $app['form.factory']->createBuilder();
			
		$participants = $groupe->getParticipants();
		
		$iterator = $participants->getIterator();
		$iterator->uasort(function ($first, $second) {
			if ($first === $second) {
				return 0;
			}
			return $first->getUser()->getEtatCivil()->getNom() < $second->getUser()->getEtatCivil()->getNom() ? -1 : 1;
		});
		$participants = new ArrayCollection(iterator_to_array($iterator));
		
		foreach ( $participants as $participant )
		{
			$formBuilder->add($participant->getId(),'choice', array(
					'label' =>  $participant->getUser()->getEtatCivil()->getNom() . ' ' . $participant->getUser()->getEtatCivil()->getPrenom() . ' ' . $participant->getUser()->getEmail(),
					'choices' => $availableTaverns,
					'data' => $participant->getTavernId(),
					'multiple' => false,
					'expanded' => false,
			));
		}
		
		$form = $formBuilder->add('save','submit', array('label' => 'Enregistrer'))->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$result = $form->getData();
			foreach ( $result as $joueur => $tavern)
			{
				$j = $app['orm.em']->getRepository('\LarpManager\Entities\Participant')->find($joueur);
				if ( $j && $j->getTavernId() != $tavern )
				{
						
					$j->setTavernId($tavern);
					$app['orm.em']->persist($j);
				}
			}
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'Les options de restauration sont enregistrés.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $groupe->getId())));
			
		}
		
		
		return $app['twig']->render('admin/groupe/restauration.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Impression matériel pour les personnages du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function printMaterielAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		
		return $app['twig']->render('admin/groupe/printMateriel.twig', array(
				'groupe' => $groupe
		));
	}
	
	/**
	 * Impression background pour les personnages du groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function printBackgroundAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
	
		return $app['twig']->render('admin/groupe/printBackground.twig', array(
				'groupe' => $groupe
		));
	}
	
	/**
	 * Impression matériel pour le groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function printMaterielGroupeAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
	
		$html = $app['twig']->render('admin/groupe/printMaterielGroupe.twig', array(
				'groupe' => $groupe
		));
		
		$filename = sprintf('test-%s.pdf', date('Y-m-d'));
		
		return new Response(
				$app['snappy.pdf']->getOutputFromHtml($html),
				200,
				[
						'Content-Type'        => 'application/pdf',
						'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
				]);
	}
	
	/**
	 * Impression fiche de perso pour le groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function printPersoAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
	
		return $app['twig']->render('admin/groupe/printPerso.twig', array(
				'groupe' => $groupe
		));
	}
		
	/**
	 * Visualisation des liens entre groupes
	 * @param Request $request
	 * @param Application $app
	 */
	public function diplomatieAction(Request $request, Application $app)
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Groupe');
		$groupes = $repo->findBy(array('pj' => true), array('nom' => 'ASC'));
		
		return $app['twig']->render('admin/diplomatie.twig', array(
				'groupes' => $groupes
		));
	}
	
	/**
	 * Impression des liens entre groupes
	 * @param Request $request
	 * @param Application $app
	 */
	public function diplomatiePrintAction(Request $request, Application $app)
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\GroupeAllie');
		$alliances = $repo->findByAlliances();
		$demandeAlliances = $repo->findByDemandeAlliances();
		
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\GroupeEnemy');
		$guerres = $repo->findByWar();
		$demandePaix = $repo->findByRequestPeace();
		
		return $app['twig']->render('admin/diplomatiePrint.twig', array(
				'alliances' => $alliances,
				'demandeAlliances' => $demandeAlliances,
				'guerres' => $guerres,
				'demandePaix' => $demandePaix,
		));
	}
	
	/**
	 * Demander une nouvelle alliance
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function requestAllianceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
	
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}			
		
		// un groupe ne peux pas avoir plus de 3 alliances
		if ( $groupe->getAlliances()->count() >= 3 )
		{
			$app['session']->getFlashBag()->add('error', 'Désolé, vous avez déjà 3 alliances, ce qui est le maximum possible.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
		
		// un groupe ne peux pas avoir plus d'alliances que d'ennemis
		if ( $groupe->getEnnemies()->count() - $groupe->getAlliances()->count() <= 0 )
		{
			$app['session']->getFlashBag()->add('error', 'Désolé, vous n\'avez pas suffisement d\'ennemis pour pouvoir vous choisir un allié.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
		
		$alliance = new \LarpManager\Entities\GroupeAllie();
		$alliance->setGroupe($groupe);
		
		$form = $app['form.factory']->createBuilder(new RequestAllianceForm(), $alliance)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ($request->isMethod('POST')) {
			
			$alliance = $form->getData();
			$alliance->setGroupeAccepted(true);
			$alliance->setGroupeAllieAccepted(false);
			
			// vérification des conditions pour le groupe choisi
			$requestedGroupe = $alliance->getRequestedGroupe();
			if ( $requestedGroupe == $groupe)
			{
				$app['session']->getFlashBag()->add('error', 'Désolé, vous ne pouvez pas choisir votre propre groupe pour faire une alliance ...');
				return $app->redirect($app['url_generator']->generate('groupe'));
			}
			
			if ( $groupe->isAllyTo($requestedGroupe))
			{
				$app['session']->getFlashBag()->add('error', 'Désolé, vous êtes déjà allié avec ce groupe');
				return $app->redirect($app['url_generator']->generate('groupe'));
			}
			
			if ( $groupe->isEnemyTo($requestedGroupe))
			{
				$app['session']->getFlashBag()->add('error', 'Désolé, vous êtes ennemi avec ce groupe. Impossible de faire une alliance, faites d\'abord la paix !');
				return $app->redirect($app['url_generator']->generate('groupe'));
			}
			
			if ( $requestedGroupe->getAlliances()->count() >= 3 )
			{
				$app['session']->getFlashBag()->add('error', 'Désolé, le groupe demandé dispose déjà de 3 alliances, ce qui est le maximum possible.');
				return $app->redirect($app['url_generator']->generate('groupe'));
			}
			
			if ( $requestedGroupe->getEnnemies()->count() - $requestedGroupe->getAlliances()->count() <= 0 )
			{
				$app['session']->getFlashBag()->add('error', 'Désolé, le groupe demandé n\'a pas suffisement d\'ennemis pour pouvoir obtenir un allié supplémentaire.');
				return $app->redirect($app['url_generator']->generate('groupe'));
			}
			
			$app['orm.em']->persist($alliance);
			$app['orm.em']->flush();
			
			$app['user.mailer']->sendRequestAlliance($alliance);
			
			$app['session']->getFlashBag()->add('success', 'Votre demande a été envoyé.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
		
		return $app['twig']->render('public/groupe/requestAlliance.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Annuler une demande d'alliance
	 * @param Request $request
	 * @param Application $app
	 */
	public function cancelRequestedAllianceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$alliance = $request->get('alliance');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new CancelRequestedAllianceForm(), $alliance)
			->add('send','submit', array('label' => 'Oui, j\'annule ma demande'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ($request->isMethod('POST')) {
			
			$alliance = $form->getData();
			
			$app['orm.em']->remove($alliance);
			$app['orm.em']->flush();
			
			$app['user.mailer']->sendCancelAlliance($alliance);
			
			$app['session']->getFlashBag()->add('success', 'Votre demande d\'alliance a été annulée.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
		
		return $app['twig']->render('public/groupe/cancelAlliance.twig', array(
				'alliance' => $alliance,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Accepter une alliance
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function acceptAllianceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$alliance = $request->get('alliance');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new AcceptAllianceForm(), $alliance)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();

		$form->handleRequest($request);
		
		if ($request->isMethod('POST')) {
		
			$alliance = $form->getData();
			
			$alliance->setGroupeAllieAccepted(true);
			$app['orm.em']->persist($alliance);
			$app['orm.em']->flush();
		
			$app['user.mailer']->sendAcceptAlliance($alliance);
		
			$app['session']->getFlashBag()->add('success', 'Vous avez accepté la proposition d\'alliance.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
			
		return $app['twig']->render('public/groupe/acceptAlliance.twig', array(
				'alliance' => $alliance,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Refuser une alliance
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function refuseAllianceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$alliance = $request->get('alliance');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new RefuseAllianceForm(), $alliance)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ($request->isMethod('POST')) {
				
			$alliance = $form->getData();
				
			$app['orm.em']->remove($alliance);
			$app['orm.em']->flush();
				
			$app['user.mailer']->sendRefuseAlliance($alliance);
				
			$app['session']->getFlashBag()->add('success', 'Vous avez refusé la proposition d\'alliance.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
			
		return $app['twig']->render('public/groupe/refuseAlliance.twig', array(
				'alliance' => $alliance,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Briser une alliance
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function breakAllianceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$alliance = $request->get('alliance');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new BreakAllianceForm(), $alliance)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();

		$form->handleRequest($request);
		
		if ($request->isMethod('POST')) {
		
			$alliance = $form->getData();
						
		
			$app['orm.em']->remove($alliance);
			$app['orm.em']->flush();
		
			if  ( $alliance->getGroupe() == $groupe )
			{
				$app['user.mailer']->sendBreakAlliance($alliance, $alliance->getRequestedGroupe());
			}
			else
			{
				$app['user.mailer']->sendBreakAlliance($alliance, $groupe);
			}
			
		
			$app['session']->getFlashBag()->add('success', 'Vous avez brisé une alliance.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
			
		return $app['twig']->render('public/groupe/breakAlliance.twig', array(
				'alliance' => $alliance,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Déclarer la guerre
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function declareWarAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		// un groupe ne peux pas faire de déclaration de guerre si il a 3 ou plus ennemis
		if ( $groupe->getEnnemies()->count() >= 3 )
		{
			$app['session']->getFlashBag()->add('error', 'Désolé, vous avez déjà 3 ennemis ou plus, impossible de faire une nouvelle déclaration de guerre .');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
		
		$war = new \LarpManager\Entities\GroupeEnemy();
		$war->setGroupe($groupe);
		$war->setGroupePeace(false);
		$war->setGroupeEnemyPeace(false);
		
		$form = $app['form.factory']->createBuilder(new DeclareWarForm(), $war)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
		
		if ($request->isMethod('POST')) {
			
				$form->handleRequest($request);
					
				$war = $form->getData();
				$war->setGroupePeace(false);
				$war->setGroupeEnemyPeace(false);
				
				// vérification des conditions pour le groupe choisi
				$requestedGroupe = $war->getRequestedGroupe();
				if ( $requestedGroupe == $groupe)
				{
					$app['session']->getFlashBag()->add('error', 'Désolé, vous ne pouvez pas choisir votre propre groupe comme ennemi ...');
					return $app->redirect($app['url_generator']->generate('groupe'));
				}
				
				if ( $groupe->isEnemyTo($requestedGroupe))
				{
					$app['session']->getFlashBag()->add('error', 'Désolé, vous êtes déjà en guerre avec ce groupe');
					return $app->redirect($app['url_generator']->generate('groupe'));
				}
					
				if ( $requestedGroupe->getEnnemies()->count() >= 5 )
				{
					$app['session']->getFlashBag()->add('error', 'Désolé, le groupe demandé dispose déjà de 5 ennemis, ce qui est le maximum possible.');
					return $app->redirect($app['url_generator']->generate('groupe'));
				}
				
				if ( $groupe->isEnemyTo($requestedGroupe))
				{
					$app['session']->getFlashBag()->add('error', 'Désolé, vous êtes déjà allié avec ce groupe');
					return $app->redirect($app['url_generator']->generate('groupe'));
				}
				
				$app['orm.em']->persist($war);
				$app['orm.em']->flush();
					
				$app['user.mailer']->sendDeclareWar($war);
					
				$app['session']->getFlashBag()->add('success', 'Votre déclaration de guerre vient d\'être envoyé.');
				return $app->redirect($app['url_generator']->generate('groupe'));
				
		}
			
		return $app['twig']->render('public/groupe/declareWar.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}

	/**
	 * Demander la paix
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function requestPeaceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$war = $request->get('enemy');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new RequestPeaceForm(), $war)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
		
		if ($request->isMethod('POST')) {
				
			$form->handleRequest($request);
			$war = $form->getData();
			
			if ( $groupe == $war->getGroupe() )
			{
				$war->setGroupePeace(true);
			}
			else
			{
				$war->setGroupeEnemyPeace(true);
			}
			
			$app['orm.em']->persist($war);
			$app['orm.em']->flush();
			
			$app['user.mailer']->sendRequestPeace($war, $groupe);
			
			$app['session']->getFlashBag()->add('success', 'Votre demande de paix vient d\'être envoyé.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
		
		return $app['twig']->render('public/groupe/requestPeace.twig', array(
				'war' => $war,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Accepter la paix
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function acceptPeaceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$war = $request->get('enemy');
		
	
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new AcceptPeaceForm(), $war)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
	
		if ($request->isMethod('POST')) {
		
			$form->handleRequest($request);
			$war = $form->getData();
				
			if ( $groupe == $war->getGroupe() )
			{
				$war->setGroupePeace(true);
			}
			else
			{
				$war->setGroupeEnemyPeace(true);
			}
			
			$app['orm.em']->persist($war);
			$app['orm.em']->flush();
				
			$app['user.mailer']->sendAcceptPeace($war, $groupe);
			
			$app['session']->getFlashBag()->add('success', 'Vous avez fait la paix !');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}	
			
		return $app['twig']->render('public/groupe/acceptPeace.twig', array(
				'war' => $war,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Refuser la paix
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function refusePeaceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$war = $request->get('enemy');
		
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new RefusePeaceForm(), $war)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
		
		if ($request->isMethod('POST')) {
		
			$form->handleRequest($request);
			$war = $form->getData();
		
			$war->setGroupePeace(false);
			$war->setGroupeEnemyPeace(false);

			$app['orm.em']->persist($war);
			$app['orm.em']->flush();
		
			$app['user.mailer']->sendRefusePeace($war, $groupe);
			
			$app['session']->getFlashBag()->add('success', 'Vous avez refusé la proposition de paix.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
			
		return $app['twig']->render('public/groupe/refusePeace.twig', array(
				'war' => $war,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	/**
	 * Annuler la demande de paix
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function cancelRequestedPeaceAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		$war = $request->get('enemy');
	
		if ( $groupe->getLock() == true)
		{
			$app['session']->getFlashBag()->add('error','Les relations diplomatiques entre pays sont actuellement gelées jusqu’au GN (pour que nous puissions avoir un état de la situation). Vous pourrez les modifier en jeu désormais (voir le jeu diplomatique)');
			return $app->redirect($app['url_generator']->generate('homepage',array('index'=>$id)),301);
		}
		
		$form = $app['form.factory']->createBuilder(new CancelRequestedPeaceForm(), $war)
			->add('send','submit', array('label' => 'Envoyer'))
			->getForm();
	
		if ($request->isMethod('POST')) {
	
			$form->handleRequest($request);
			$war = $form->getData();
	
			if ( $groupe == $war->getGroupe() )
			{
				$war->setGroupePeace(false);
			}
			else
			{
				$war->setGroupeEnemyPeace(false);
			}
						
			$app['orm.em']->persist($war);
			$app['orm.em']->flush();
	
			$app['user.mailer']->sendRefusePeace($war, $groupe);
				
			$app['session']->getFlashBag()->add('success', 'Vous avez annulé votre proposition de paix.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
			
		return $app['twig']->render('public/groupe/cancelPeace.twig', array(
				'war' => $war,
				'groupe' => $groupe,
				'form' => $form->createView()
		));
	}
	
	
	
	/**
	 * Liste des groupes
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function adminListAction(Request $request, Application $app)
	{
		$order_by = $request->get('order_by') ?: 'numero';
		$order_dir = $request->get('order_dir') == 'DESC' ? 'DESC' : 'ASC';
		$limit = (int)($request->get('limit') ?: 50);
		$page = (int)($request->get('page') ?: 1);
		$offset = ($page - 1) * $limit;
		$type= null;
		$value = null;
		
		$form = $app['form.factory']->createBuilder(new GroupFindForm())->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$data = $form->getData();
			$type = $data['type'];
			$value = $data['search'];
		}
				
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Groupe');
		
		$groupes = $repo->findList(
				$type,
				$value,
				array( 'by' =>  $order_by, 'dir' => $order_dir),
				$limit,
				$offset);
		
		$numResults = $repo->findCount($type, $value);
		
		$paginator = new Paginator($numResults, $limit, $page,
				$app['url_generator']->generate('groupe.admin.list') . '?page=(:num)&limit=' . $limit . '&order_by=' . $order_by . '&order_dir=' . $order_dir
				);
		
		return $app['twig']->render('admin/groupe/list.twig', array(
				'form' => $form->createView(),
				'groupes' => $groupes,
				'paginator' => $paginator,
		));
	}
	
	/**
	 * Ajouter un participant dans un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function adminParticipantAddAction(Request $request, Application $app)
	{
		$groupe = $request->get('groupe');
		
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Participant');
		
		// trouve tous les participants n'étant pas dans un groupe
		$participants = $repo->findAllByGroupeNull();
		
		// creation du formulaire
		$form = $app['form.factory']->createBuilder()
			->add('participant', 'entity', array(
				'label' => 'Choisissez le nouveau membre du groupe',
				'required' => false,
				'expanded' => true,
				'multiple' => false,
				'property' => 'userIdentity',
				'class' => 'LarpManager\Entities\Participant',
				'choices' => $participants,
				
			))
			->add('submit','submit', array('label' => 'Ajouter'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$data = $form->getData();
			$participant = $data['participant'];
			
			$groupe->addParticipant($participant);
			$participant->setGroupe($groupe);
			// le personnage du joueur doit aussi changer de groupe
			if ( $participant->getPersonnage())
			{
				$personnage = $participant->getPersonnage();
				$personnage->setGroupe($groupe);
				$app['orm.em']->persist($personnage);
			}
			$app['orm.em']->persist($groupe);
			$app['orm.em']->persist($participant);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'Le participant a été ajouté au groupe.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index'=> $groupe->getId())));			
		}
		
		return $app['twig']->render('admin/groupe/addParticipant.twig', array(
				'groupe' => $groupe,
				'participants' => $participants,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Retirer un participant du groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function adminParticipantRemoveAction(Request $request, Application $app)
	{
		$participantId = $request->get('participant');
		$groupe = $request->get('groupe');
		
		$participant = $app['orm.em']->find('\LarpManager\Entities\Participant',$participantId);

		
		if ($request->isMethod('POST')) {
			
			$personnage = $participant->getPersonnage();
			if ( $personnage )
			{
				if ( $personnage->getGroupe() == $groupe)
				{
					$personnage->removeGroupe($groupe);
				}
				$app['orm.em']->persist($personnage);
			}

			$participant->removeGroupe($groupe);
			$app['orm.em']->persist($participant);
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'Le participant a été retiré du groupe.');
			return $app->redirect($app['url_generator']->generate('groupe.detail', array('index'=> $groupe->getId())));
		}
				
		return $app['twig']->render('admin/groupe/removeParticipant.twig', array(
				'groupe' => $groupe,
				'participant' => $participant,
		));
	}
	
	/**
	 * Recherche d'un groupe
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function searchAction(Request $request, Application $app)
	{
		$form = $app['form.factory']->createBuilder(new FindGroupeForm(), array())
			->add('submit','submit', array('label' => 'Rechercher'))
			->getForm();
	
		$form->handleRequest($request);
	
		if ( $form->isValid() )
		{
			$data = $form->getData();
				
			$type = $data['type'];
			$search = $data['search'];
	
			$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Groupe');
				
			$groupes = null;
				
			switch ($type)
			{
				case 'label' :
					$groupes = $repo->findByName($search);
					break;
				case 'numero' :
					$groupes = $repo->findByNumero($search);
					break;
			}
				
			if ( $joueurs != null )
			{
				if ( count($joueurs) == 1 )
				{
					$app['session']->getFlashBag()->add('success', 'Le joueur a été trouvé.');
					return $app->redirect($app['url_generator']->generate('joueur.detail', array('index'=> $joueurs[0])));
				}
				else
				{
					$app['session']->getFlashBag()->add('success', 'Il y a plusieurs résultats à votre recherche.');
					return $app['twig']->render('joueur/search_result.twig', array(
							'joueurs' => $joueurs,
					));
				}
			}
				
			$app['session']->getFlashBag()->add('error', 'Désolé, le joueur n\'a pas été trouvé.');
		}
	
		return $app['twig']->render('joueur/search.twig', array(
				'form' => $form->createView(),
		));
	}
	
	

	
	/**
	 * Modification du nombre de place disponibles dans un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function placeAction(Request $request, Application $app)
	{
		$id = $request->get('index');
		$groupe = $app['orm.em']->find('\LarpManager\Entities\Groupe', $id);
				
		if ( $request->getMethod() == 'POST')
		{
			$newPlaces = $request->get('place');
			
			/**
			 * Met à jour uniquement si la valeur à changé
			 */
			if ( $groupe->getClasseOpen() != $newPlaces)
			{
				$groupe->setClasseOpen($newPlaces);
				$app['orm.em']->persist($groupe);
			}
		
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success','Le nombre de place disponible a été mis à jour');
			return $app->redirect($app['url_generator']->generate('groupe.admin.list'),301);
		}
		
		return $app['twig']->render('admin/groupe/place.twig', array(
				'groupe' => $groupe));
	}
	
	/**
	 * Ajout d'un background à un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function addBackgroundAction(Request $request, Application $app)
	{
		$id = $request->get('index');
		$groupe = $app['orm.em']->find('\LarpManager\Entities\Groupe', $id);
		
		$background = new \LarpManager\Entities\Background();
		$background->setGroupe($groupe);
		
		$form = $app['form.factory']->createBuilder(new BackgroundForm(), $background)
			->add('save','submit', array('label' => 'Sauvegarder'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$app['session']->getFlashBag()->add('success','Le background du groupe a été créé');
			return $app->redirect($app['url_generator']->generate('groupe.admin.detail', array('index'=> $groupe->getId()) ),301);
		}
		
		return $app['twig']->render('admin/groupe/background/add.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
			));
	}
	
	/**
	 * Mise à jour du background d'un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function updateBackgroundAction(Request $request, Application $app)
	{
		
		$id = $request->get('index');
		$groupe = $app['orm.em']->find('\LarpManager\Entities\Groupe', $id);
		
		$form = $app['form.factory']->createBuilder(new BackgroundForm(), $groupe->getBackground())
			->add('save','submit', array('label' => 'Sauvegarder'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$background = $form->getData();
			
			$app['orm.em']->persist($background);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success','Le background du groupe a été mis à jour');
			return $app->redirect($app['url_generator']->generate('groupe.admin.detail', array('index'=> $groupe->getId()) ),301);
		}
		
		return $app['twig']->render('admin/groupe/background/update.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Ajout d'un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function addAction(Request $request, Application $app)
	{
		$groupe = new \LarpManager\Entities\Groupe();
		
		$form = $app['form.factory']->createBuilder(new GroupeForm(), $groupe)
			->add('responsable', 'entity', array(
					'label' => 'Responsable',
					'required' => false,
					'property' => 'username',
					'class' => 'LarpManager\Entities\User',
					'choices' => $choices,
					'empty_data'  => null,
			))
			->add('save','submit', array('label' => 'Sauvegarder et fermer'))
			->add('save_continue','submit',array('label' => 'Sauvegarder et nouveau'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$groupe = $form->getData();
			
			/**
			 * Pour toutes les classes du groupe
			 */
			foreach ( $groupe->getGroupeClasses() as $groupeClasses)
			{
				$groupeClasses->setGroupe($groupe);
			}
			
			/**
			 * Pour tous les gns du groupe
			 */
			foreach ( $groupe->getGns() as $gn )
			{
				$gn->addGroupe($groupe);
			}
			
			/**
			 * Création des topics associés à ce groupe
			 * un topic doit être créé par GN auquel ce groupe est inscrit
			 * @var \LarpManager\Entities\Topic $topic
			 */
			$topic = new \LarpManager\Entities\Topic();
			$topic->setTitle($groupe->getNom());
			$topic->setDescription($groupe->getDescription());
			$topic->setUser($app['user']);
			// défini les droits d'accés à ce forum
			// (les membres du groupe ont le droit d'accéder à ce forum)
			$topic->setRight('GROUPE_MEMBER');
			$topic->setTopic($app['larp.manager']->findTopic('TOPIC_GROUPE'));
			
			$groupe->setTopic($topic);
			
			$app['orm.em']->persist($topic);
			$app['orm.em']->persist($groupe);
			$app['orm.em']->flush();
			
			$topic->setObjectId($groupe->getId());
			$app['orm.em']->persist($topic);
			$app['orm.em']->flush();
		
			$app['session']->getFlashBag()->add('success','Le groupe été sauvegardé');
			
			/**
			 * Si l'utilisateur a cliqué sur "save", renvoi vers la liste des groupes
			 * Si l'utilisateur a cliqué sur "save_continue", renvoi vers un nouveau formulaire d'ajout 
			 */
			if ( $form->get('save')->isClicked())
			{
				return $app->redirect($app['url_generator']->generate('groupe.admin.list'),301);
			}
			else if ( $form->get('save_continue')->isClicked())
			{
				return $app->redirect($app['url_generator']->generate('groupe.add'),301);
			}
		}
		
		return $app['twig']->render('admin/groupe/add.twig', array('form' => $form->createView()));
	}
	
	/**
	 * Modification d'un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function updateAction(Request $request, Application $app)
	{
		$id = $request->get('index');
		
		$groupe = $app['orm.em']->find('\LarpManager\Entities\Groupe',$id);
		
		$originalGroupeClasses = new ArrayCollection();
		$originalGns = new ArrayCollection();
		$originalTerritoires = new ArrayCollection();

		/**
		 *  Crée un tableau contenant les objets GroupeClasse du groupe
		 */
		foreach ($groupe->getGroupeClasses() as $groupeClasse) 
		{
			$originalGroupeClasses->add($groupeClasse);
		}
		
		
		/**
		 * Crée un tableau contenant les territoires que ce groupe posséde
		 */
		foreach ( $groupe->getTerritoires() as $territoire)
		{
			$originalTerritoires->add($territoire);
		}
		
		
		
		$form = $app['form.factory']->createBuilder(new GroupeForm(), $groupe)
			->add('update','submit', array('label' => "Sauvegarder"))
			->add('delete','submit', array('label' => "Supprimer"))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$groupe = $form->getData();

			/**
			 * Pour toutes les classes du groupe
			 */
			foreach ( $groupe->getGroupeClasses() as $groupeClasses)
			{
				$groupeClasses->setGroupe($groupe);
			}		
				
			/**
			 *  supprime la relation entre le groupeClasse et le groupe
			 */
			foreach ($originalGroupeClasses as $groupeClasse) {
				if ($groupe->getGroupeClasses()->contains($groupeClasse) == false) {
					$app['orm.em']->remove($groupeClasse);
				}
			}
						
			/**
			 * Pour tous les territoire du groupe
			 */
			foreach ( $groupe->getTerritoires() as $territoire )
			{
				$territoire->setGroupe($groupe);
			}
				
			foreach ($originalTerritoires as $territoire)
			{
				if ( $groupe->getTerritoires()->contains($territoire) == false)
					$territoire->setGroupe(null);
			}
			
			
			/**
			 * Si l'utilisateur a cliquer sur "update", on met à jour le groupe
			 * Si l'utilisateur a cliquer sur "delete", on supprime le groupe
			 */
			if ($form->get('update')->isClicked())
			{				
				$app['orm.em']->persist($groupe);
				$app['orm.em']->flush();
				$app['session']->getFlashBag()->add('success', 'Le groupe a été mis à jour.');
				return $app->redirect($app['url_generator']->generate('groupe.detail', array('index' => $id)));
			}
			else if ($form->get('delete')->isClicked())
			{
				// supprime le lien entre les personnages et le groupe
				foreach ( $groupe->getPersonnages() as $personnage)
				{
					$personnage->setGroupe(null);
					$app['orm.em']->persist($personnage);
				}
				
				// supprime le lien entre les participants et le groupe
				foreach ( $groupe->getParticipants() as $participant)
				{
					$participant->setGroupe(null);
					$app['orm.em']->persist($participant);
				}
				
				// supprime la relation entre le groupeClasse et le groupe
				foreach ($groupe->getGroupeClasses() as $groupeClasse) {
					$app['orm.em']->remove($groupeClasse);
				}
				
				// supprime la relation entre les territoires et le groupe
				foreach ( $groupe->getTerritoires() as $territoire)
				{
					$territoire->setGroupe(null);
					$app['orm.em']->persist($territoire);
				}
				
				// supprime la relation entre un background et le groupe
				foreach ( $groupe->getBackgrounds() as $background)
				{
					$app['orm.em']->remove($background);
				}
				
				$app['orm.em']->remove($groupe);
				$app['orm.em']->flush();
					
				$app['session']->getFlashBag()->add('success', 'Le groupe a été supprimé.');
				return $app->redirect($app['url_generator']->generate('groupe.admin.list'));
			}
		
			
		}
			
		return $app['twig']->render('admin/groupe/update.twig', array(
				'groupe' => $groupe,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Affiche le détail d'un groupe
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function detailAction(Request $request, Application $app)
	{
		$id = $request->get('index');
		
		$groupe = $app['orm.em']->find('\LarpManager\Entities\Groupe',$id);
		
		/**
		 * Si le groupe existe, on affiche son détail
		 * Sinon on envoi une erreur
		 */
		if ( $groupe )
		{
			return $app['twig']->render('admin/groupe/detail.twig', array('groupe' => $groupe));
		}
		else
		{
			$app['session']->getFlashBag()->add('error', 'Le groupe n\'a pas été trouvée.');
			return $app->redirect($app['url_generator']->generate('groupe'));
		}
	}
	
	/**
	 * Exportation de la liste des groupes au format CSV
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function exportAction(Request $request, Application $app)
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Groupe');
		$groupes = $repo->findAll();
		
		
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=eveoniris_groupe_".date("Ymd").".csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$output = fopen("php://output", "w");
		
		// header
		fputcsv($output,
					array(
					'nom',
					'description',
					'code',
					'creation_date'), ',');
		
		foreach ($groupes as $groupe)
		{
			fputcsv($output, $groupe->getExportValue(), ',');
		}
		
		fclose($output);
		exit();
	}
}
