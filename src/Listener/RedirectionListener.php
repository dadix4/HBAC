<?php
namespace App\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RedirectionListener
{

  public function __construct(ContainerInterface $container, Session $session)
  {
      $this->session = $session;
      $this->router = $container->get('router');
      $this->securityContext = $container->get('security.token_storage');
  }

  public function onKernelRequest(GetResponseEvent $event)
  {
      $route = $event->getRequest()->attributes->get('_route');
      //Contrainte a vérifier pour la route livraison ou validation
      if ($route == 'boutique_panier_livraison' || $route == 'boutique_panier_validation') {
        //on verifie si le panier n'est pas vide si oui on redirige.
          if ($this->session->has('panier')) {
              if (count($this->session->get('panier')) == 0) {
                  $this->session->getFlashBag()->add('error', 'Votre panier est vide !');
                  $event->setResponse(new RedirectResponse($this->router->generate('boutique_panier')));
              }
          }
          //on verifie que l'utilisateur est connecté si non on redirige vers la page login.
          if (!is_object($this->securityContext->getToken()->getUser())) {
              $this->session->getFlashBag()->add('warning', 'Vous devez vous identifier pour valider votre panier');
              $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
          }
      }
      if ($route == 'event_reservation' || $route == 'event_reservation') {
          //on verifie que l'utilisateur est connecté si non on redirige vers la page login.
          if (!is_object($this->securityContext->getToken()->getUser())) {
              $this->session->getFlashBag()->add('warning', 'Vous devez vous identifier pour vous inscrire à cette évènement');
              $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
          }
      }
  }
}
