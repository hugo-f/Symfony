<?php

namespace hugo\TutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use hugo\TutoBundle\Entity\Advert;

class AdvertController extends Controller
{
	public function indexAction($page)
	{

		// if ($page < 1){
		// 	throw new Exception('Page "'.$page.'" inexistante.');
		// }

    	// stock dans $content le contenu du template 
    	// $this->get('service')
    	// nom du template ---> NomDuBundle:NomDuContrôleur:NomDeLAction

        // Ancienne Version 
        // $content = $this->get('templating')->render('hugoTutoBundle:Advert:index.html.twig', 
        // 												array('nom' => 'paul', 'page' => $page) );
        // return new Response($content);

    	// Version plus courte render + return
		// return $this->render('hugoTutoBundle:Advert:index.html.twig', 
		// 	array('nom' => 'paul', 'page' => $page) );


    // Notre liste d'annonce en dur
		$listAdverts = array(
			array(
				'title'   => 'Recherche développpeur Symfony2',
				'id'      => 1,
				'author'  => 'Alexandre',
				'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…'),
			array(
				'title'   => 'Mission de webmaster',
				'id'      => 2,
				'author'  => 'Hugo',
				'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…'),
			array(
				'title'   => 'Offre de stage webdesigner',
				'id'      => 3,
				'author'  => 'Mathieu',
				'content' => 'Nous proposons un poste pour webdesigner. Blabla…')
			);

    // Et modifiez le 2nd argument pour injecter notre liste
		return $this->render('hugoTutoBundle:Advert:index.html.twig', array(
			'listAdverts' => $listAdverts
			));
	}

	public function viewAction ($id) {
    	// $tag = $request->query->get('tag');
    	// return new Response ("Affichage de l'annonce ayant pour id :: " . $id . " dont le tag est ::: " . $tag);
    	// 
		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()
			);

		return $this->render( 'hugoTutoBundle:Advert:view.html.twig', array("advert" => $advert) );
	}

	

	public function addAction(Request $request){
		// if ($request->isMethod('POST')) {
  //     // Ici, on s'occupera de la création et de la gestion du formulaire

		// 	$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

  //     // Puis on redirige vers la page de visualisation de cettte annonce
		// 	return $this->redirect($this->generateUrl('oc_platform_view', array('id' => 5)));
		// }

  //   // Si on n'est pas en POST, alors on affiche le formulaire
		// return $this->render('hugoTutoBundle:Advert:add.html.twig');
		
		
		// $antispam = $this->container->get('hugo_tuto.antispam');
		// $text = " je suis un msg spam !! ";
		// if ($antispam->isSpam($text)) {
		// 	throw new \Exception('Votre message a été détecté comme spam !'); 
		// }
		
		
		$myAdvert = new Advert();
		$myAdvert->setDate (new \Datetime());
		$myAdvert->setTitle('mon Title =)');
		$myAdvert->setAuthor('hugo');
		$myAdvert->setContent("Nous recherchons des tuto angular Js qui déboitent tout tout tout !!!!!");

		$em = $this->getDoctrine()->getManager();

		$em->persist($myAdvert);
		$em->flush();

		if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag->add('notice', 'Annonce bien enregistrée.');
			return $this->redirect($this->generateUrl('hugo_tuto_view', array('id' => $myAdvert->getId())));
		}


		return $this->render('hugoTutoBundle:Advert:add.html.twig');
	}

	public function editAction($id, Request $request)
	{
    // Ici, on récupérera l'annonce correspondante à $id

    // Même mécanisme que pour l'ajout
		// if ($request->isMethod('POST')) {
		// 	$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

		// 	return $this->redirect($this->generateUrl('oc_platform_view', array('id' => 5)));
		// }

		// return $this->render('hugoTutoBundle:Advert:edit.html.twig');
		

		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()
			);

		return $this->render('hugoTutoBundle:Advert:edit.html.twig', array(
			'advert' => $advert
			));
	}

	public function deleteAction($id)
	{
    // Ici, on récupérera l'annonce correspondant à $id

    // Ici, on gérera la suppression de l'annonce en question

		return $this->render('hugoTutoBundle:Advert:delete.html.twig');
	}	


	public function menuAction($limit)
	{
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
		$listAdverts = array(
			array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
			array('id' => 5, 'title' => 'Mission de webmaster'),
			array('id' => 9, 'title' => 'Offre de stage webdesigner')
			);

		return $this->render('hugoTutoBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
			'listAdverts' => $listAdverts
			));
	}


	/**********************************************************************************************************/

	public function byebyeAction()
	{
		$contentTemp = $this->get('templating')->render('hugoTutoBundle:Advert:byebye.html.twig');
		return new Response($contentTemp);
	}

	public function viewSlugAction ($format, $year, $slug){
		return new Response ( "ici le slug ==> " . $slug . " puis le year ==> " . $year . " puis le format ==> ". $format);
	}

// Action redirection !! 
	public function testRedirAction() {
		$url = $this->get('router')->generate('hugo_tuto_home');
		return $this->redirect($url);
	}


	public function testSessionAction($id, Request $request) {
    	// récupérer la session
		$session = $request->getSession();

    	// on récupère le contenue de la session user_id
		$userId = $session->get('user_id');
		echo "Avant le set session ::::  ";
		echo ($session->get('user_id'));

    	// on définit une nouvelle valeure pour l'entrée de session user_id
		$session->set('user_id', 98);

    	// on renvoi une réponse
		echo "Apres le set Session ";
		echo ($session->get('user_id'));
		echo "<body></body>";
		return new Response("<br/>je suis la super réponse de testSession");
	}
}