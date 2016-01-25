<?php
namespace LarpManager\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;

use LarpManager\Form\ChronologieForm;
use LarpManager\Form\ChronologieRemoveForm;

/**
 * LarpManager\Controllers\ChronologieController
 *
 */
class ChronologieController
{
	
	/**
	 * API : mettre à jour un événement
	 * POST /api/chronologies/{event}
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function apiUpdateAction(Request $request, Application $app)
	{
		$event = $request->get('event');
	
		$payload = json_decode($request->getContent());
	
		$territoire = $app['orm.em']->find('\LarpManager\Entities\Territoire',$payload->territoire_id);
		
		$event->setTerritoire($territoire);
		$event->setYear($payload->year);
		$event->setMonth($payload->month);
		$event->setDay($payload->day);
		$event->setVisibilite($payload->visibilite);
		$event->setDescription($payload->description);
			
		$app['orm.em']->persist($event);
		$app['orm.em']->flush();
	
		return new JsonResponse($payload);
	}
		
	/**
	 * API : supprimer un événement
	 * DELETE /api/chronologies/{event}
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function apiDeleteAction(Request $request, Application $app)
	{
		$event = $request->get('event');
		$app['orm.em']->remove($event);
		$app['orm.em']->flush();
		
		return new JsonResponse();
	}
	
	public function apiAddAction(Request $request, Application $app)
	{
		$payload = json_decode($request->getContent());
		
		$territoire = $app['orm.em']->find('\LarpManager\Entities\Territoire',$payload->territoire_id);
		
		$event = new \LarpManager\Entities\Chronologie();
		
		$event->setTerritoire($territoire);
		$event->setYear($payload->year);
		$event->setMonth($payload->month);
		$event->setDay($payload->day);
		$event->setVisibilite($payload->visibilite);
		$event->setDescription($payload->description);
		
		$app['orm.em']->persist($event);
		$app['orm.em']->flush();
		
		return new JsonResponse($payload);
	}
	
	/**
	 * @description affiche la vue index.twig
	 */
	public function indexAction(Request $request, Application $app)
	{
		$repo = $app['orm.em']->getRepository('\LarpManager\Entities\Chronologie');
		$chronologies = $repo->findAll();
		
		return $app['twig']->render('admin/chronologie/index.twig', array('chronologies' => $chronologies));
	}

	/**
	 * @description affiche le formulaire d'ajout d'une chrono
	 */
	public function addAction(Request $request, Application $app)
	{
		$chronologie = new \LarpManager\Entities\Chronologie();
		
		// Un territoire peut avoir été passé en paramètre
		$territoireId = $request->get('territoire');
		
		if ( $territoireId )
		{
			$territoire = $app['orm.em']->find('\LarpManager\Entities\Territoire', $territoireId);
			if ( $territoire )
			{
				$chronologie->setTerritoire($territoire);
			}
		}
		
		$form = $app['form.factory']->createBuilder(new ChronologieForm(), $chronologie)
			->add('visibilite','choice', array(
					'required' => true,
					'label' =>  'Visibilité',
					'choices' => $app['larp.manager']->getChronologieVisibility(),
			))
			->add('save','submit', array('label' => 'Sauvegarder'))
			->getForm();
		
		$form->handleRequest($request);
			
		if ( $form->isValid() )
		{
			$chronologie = $form->getData();
				
			$app['orm.em']->persist($chronologie);
			$app['orm.em']->flush();
				
			$app['session']->getFlashBag()->add('success', 'L\'événement a été ajouté.');
			return $app->redirect($app['url_generator']->generate('chronologie'));
		}
		
		return $app['twig']->render('admin/chronologie/add.twig', array(
				'form' => $form->createView()
		));
	}

	/**
	 * @description affiche le formulaire de modification d'une chrono
	 */
	public function updateAction(Request $request, Application $app)
	{
		$id = $request->get('index');
		
		$chronologie = $app['orm.em']->find('\LarpManager\Entities\Chronologie',$id);
		if ( !$chronologie )
		{
			return $app->redirect($app['url_generator']->generate('chronologie'));
		}
		
		$form = $app['form.factory']->createBuilder(new ChronologieForm(), $chronologie)
			->add('visibilite','choice', array(
					'required' => true,
					'label' =>  'Visibilité',
					'choices' => $app['larp.manager']->getChronologieVisibility(),
			))
			->add('save','submit', array('label' => 'Sauvegarder'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$chronologie = $form->getData();
				
			$app['orm.em']->persist($chronologie);
			$app['orm.em']->flush();
				
			$app['session']->getFlashBag()->add('success', 'L\'événement a été mis à jour.');
			return $app->redirect($app['url_generator']->generate('chronologie'));
		}
		
		return $app['twig']->render('admin/chronologie/update.twig', array(
				'form' => $form->createView(),
				'chronologie' => $chronologie
		));
	}
	
	/**
	 * @description affiche le formulaire de suppresion d'une chrono
	 */
	public function removeAction(Request $request, Application $app)
	{
		$id = $request->get('index');

		$chronologie = $app['orm.em']->find('\LarpManager\Entities\Chronologie',$id);
		if ( !$chronologie )
		{
			return $app->redirect($app['url_generator']->generate('chronologie'));
		}
		
		$form = $app['form.factory']->createBuilder(new ChronologieRemoveForm(), $chronologie)
			->add('save','submit', array('label' => 'Supprimer'))
			->getForm();
		
		$form->handleRequest($request);
		
		if ( $form->isValid() )
		{
			$chronologie = $form->getData();
			
			$app['orm.em']->remove($chronologie);
			$app['orm.em']->flush();
			
			$app['session']->getFlashBag()->add('success', 'L\'événement a été supprimé.');
			return $app->redirect($app['url_generator']->generate('chronologie'));
		}
		
		return $app['twig']->render('admin/chronologie/remove.twig', array(
				'chronologie' => $chronologie,
				'form' => $form->createView(),
		));
		
	}
}