﻿<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use SimpleUser\UserServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Silex\Provider\DoctrineOrmManagerRegistryProvider;
use Symfony\Component\HttpFoundation\Response;

$loader = require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
if(isset($_ENV['env']) && $_ENV['env'] == 'test')
{
	$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../config/test_settings.yml'));
}
else
{
	$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../config/normal_settings.yml'));
}
/**
 * Chemin pour le sql d'installation de larpmanager
 * 
 */
$app['db_user_install_path'] = __DIR__ . '/../vendor/jasongrimes/silex-simpleuser/sql/';
$app['db_install_path'] = __DIR__ . $app['config']['db_install_path'];
//*
$app['maintenance'] = file_exists($app['db_install_path'] . 'create_or_update.sql');
/*/
$app['maintenance'] = false;
/*/
/**
 * A décommenter pour passer en mode debug 
 */

$app['debug'] = true;

if(true == $app['debug'])
{
	//Ces logs ne contiennent pas que des infos de debug, il serait aussi possible de les activer
	//en prod si nécessaire.
	$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.logfile' => __DIR__.'/../logs/development.log',
	'monolog.level' => \Monolog\Logger::DEBUG
	));
}
/**
 * Enregistrer les libs dans l'application 
 */
 
// cache
$app->register(new HttpCacheServiceProvider(), array(
		'http_cache.cache_dir' => __DIR__.'/../cache/',
		'http_cache.esi'       => null,
));

// Formulaires
$app->register(new FormServiceProvider());

// add entity type on forms
$app->register(new DoctrineOrmManagerRegistryProvider());

// validation
$app->register(new ValidatorServiceProvider());

// traduction
$app->register(new TranslationServiceProvider(), array(
		'translator.domains' => array(),
));

// Twig
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/LarpManager/Views',
    'twig.options'    => array(
        'cache' => __DIR__ . '/../cache/',
    ),
));

// Email
$app->register(new SwiftmailerServiceProvider());

$app['swiftmailer.options'] = array(
		'host' => 'host',
		'port' => '25',
		'username' => 'username',
		'password' => 'password',
		'encryption' => null,
		'auth_mode' => null
);

// Doctrine DBAL
$app->register(new DoctrineServiceProvider(), array(
	    'db.options' => $app['config']['database'] //voir les settings yaml 
	));

// Doctrine ORM
$app->register(new DoctrineOrmServiceProvider(), array(
    "orm.proxies_dir" => __DIR__."/../cache/proxies",
    "orm.em.options" => array(
        "mappings" => array(
            array(
                "type" => "annotation",
                "namespace" => "LarpManager\Entities",
                "path" => __DIR__."/../src/LarpManager/Entities",
            ),
        ),
    ),
));

// Sessions
$app->register(new SessionServiceProvider());

// Security
$app->register(new SecurityServiceProvider());

// User management
$app->register(new ServiceControllerServiceProvider());
$app->register(new RememberMeServiceProvider());
$userServiceProvider = new UserServiceProvider();
$app->register($userServiceProvider);

$app['user.options'] = array(
      'templates' => array(
        'layout' => 'user/layout.twig',
        'register' => 'user/register.twig',
        'register-confirmation-sent' => 'user/register-confirmation-sent.twig',
        'login' => 'user/login.twig',
        'login-confirmation-needed' => 'user/login-confirmation-needed.twig',
        'forgot-password' => 'user/forgot-password.twig',
        'reset-password' => 'user/reset-password.twig',
        'view' => 'user/view.twig',
        'edit' => 'user/edit.twig',
        'list' => 'user/list.twig',
    ),
	'mailer' => array(
		'enabled' => true,
		'fromEmail' => array(
			'address' => 'do-not-reply@'. (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : gethostname()),
			'name' => null,
		)
	),
	'emailConfirmation' => array(
			'required' => false, // Whether to require email confirmation before enabling new accounts.
			'template' => '@user/email/confirm-email.twig',
	),
	
	'passwordReset' => array(
			'template' => '@user/email/reset-password.twig',
			'tokenTTL' => 86400, // How many seconds the reset token is valid for. Default: 1 day.
	),
	// Set this to use a custom User class.
	'userClass' => 'LarpManager\Entities\Users',
	
	// Whether to require that users have a username (default: false).
	// By default, users sign in with their email address instead.
	'isUsernameRequired' => false,
);


// Define firewall
$app['security.firewalls'] = array(
    'public_area' => array(
		'pattern' => '^.*$',
        'anonymous' => true,
		'remember_me' => array(),
        'form' => array(
            'login_path' => '/user/login',
            'check_path' => '/user/login_check',
        ),
        'logout' => array(
            'logout_path' => '/user/logout',
        ),
        'users' => $app->share(function($app) { return $app['user.manager']; }),
    ),
    'secured_area' => array(	// le reste necessite d'être connecté
    		'pattern' => '^/stock/.*$',
    		'anonymous' => false,
    		'remember_me' => array(),
    		'form' => array(
    				'login_path' => '/user/login',
    				'check_path' => '/user/login_check',
    		),
    		'logout' => array(
    				'logout_path' => '/user/logout',
    		),
    		'users' => $app->share(function($app) { return $app['user.manager']; }),
    		),
);

// Gestion des urls
$app->register(new UrlGeneratorServiceProvider());


/**
 * Définition des routes
 */

if($app['maintenance'])
{
	
	$app->mount('/install', new LarpManager\InstallControllerProvider());
	
	//On n'enregistre qu'un utilisateur admin, s'il n'existe pas, et via une fonction particuliere.
	//cf. install controller
	$app->match('/user/register', function(Silex\Application $app) {
		return new Response('Sorry, registration has been disabled.');
	});
	
	$app->match('/user/list', function(Silex\Application $app) {
		return new Response('Sorry, user list has been disabled.');
	});
	
	//$app->match('/user/{id}', function(Silex\Application $app) {
	//	return new Response('Sorry, user view has been disabled.');
	//});
	
	$app->match('/user/{id}/edit', function(Silex\Application $app) {
		return new Response('Sorry, user edit has been disabled.');
	});
	
	$app->mount('/user', $userServiceProvider);
	
	$app['user.options'] = array(
			// ...
			'templates' => array(
					'layout' => 'user/layout_maintenance.twig',
					'login' => 'user/login_maintenance.twig',
					'forgot-password' => 'user/forgot-password.twig',
					'reset-password' => 'user/reset-password.twig'
			),
	);
	
	$app['security.firewalls'] = array(
			'install' => array(	// install doit être accessible à tous
					'pattern' => '^/install$',
			),
			'login' => array(	// login doit être accessible à tous
					'pattern' => '^/user/login$',
			),
			'secured_area' => array(	// le reste necessite d'être connecté
					'pattern' => '^/.*$',
					'anonymous' => true,
					'remember_me' => array(),
					'form' => array(
							'login_path' => '/user/login',
							'check_path' => '/user/login_check',
							'default_target_path' => '/install/'
					),
					'logout' => array(
							'logout_path' => '/user/logout',
					),
					'users' => $app->share(function($app) { return $app['user.manager']; }),
					),
					);
	$app['security.access_rules'] = array(
  	  	array('^/install/larpupdate', 'ROLE_ADMIN')
	);
	
	$app->error(function (\Exception $e, $code) use ($app) 
	{
		if ($e instanceof Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException)
		{
			return $app['twig']->render('denied.twig');
		}
		if($e instanceof Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
		{
			return $app['twig']->render('maintenance.twig');
		}
	});

}
else
{
	$app->error(function (\Exception $e, $code) use ($app)
	{
		if($code == 404)
			return $app->redirect($app['url_generator']->generate('homepage'));
	});
	
	$app->mount('/', new LarpManager\HomepageControllerProvider());
	$app->mount('/user', $userServiceProvider);
	$app->mount('/gn', new LarpManager\GnControllerProvider());
	$app->mount('/chronologie', new LarpManager\ChronologieControllerProvider());
	$app->mount('/pays', new LarpManager\PaysControllerProvider());
	$app->mount('/guilde', new LarpManager\GuildeControllerProvider());
	$app->mount('/stock', new LarpManager\StockControllerProvider());
	$app->mount('/stock/objet', new LarpManager\StockObjetControllerProvider());
	$app->mount('/stock/tag', new LarpManager\StockTagControllerProvider());
	$app->mount('/stock/etat', new LarpManager\StockEtatControllerProvider());
	$app->mount('/stock/proprietaire', new LarpManager\StockProprietaireControllerProvider());
	$app->mount('/stock/localisation', new LarpManager\StockLocalisationControllerProvider());
	

}


/**
 * API
 */
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
 
/**
 * Permet de formatter correctement la requête de l'utilisateur si celui-ci
 * indique content-type = application/json
 * Important pour les requêtes HTTP sur l'API
 */
$app->before(function (Request $request) {
	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
		$data = json_decode($request->getContent(), true);
		$request->request->replace(is_array($data) ? $data : array());
	}
});


return $app;
