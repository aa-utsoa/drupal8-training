<?php

/**
 * @file
 * Definition of Drupal\Core\EventSubscriber\ContentFormControllerSubscriber.
 */

namespace Drupal\Core\EventSubscriber;

use Drupal\Core\Controller\HtmlFormController;
use Drupal\Core\Controller\ControllerResolverInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Subscriber for setting wrapping form logic.
 */
class ContentFormControllerSubscriber implements EventSubscriberInterface {

  /**
   * The service container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * The controller resolver.
   *
   * @var \Drupal\Core\Controller\ControllerResolverInterface
   */
  protected $resolver;

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new ContentFormControllerSubscriber object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   * @param \Drupal\Core\Controller\ControllerResolverInterface $resolver
   *   The controller resolver.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder.
   */
  public function __construct(ContainerInterface $container, ControllerResolverInterface $resolver, FormBuilderInterface $form_builder) {
    $this->container = $container;
    $this->resolver = $resolver;
    $this->formBuilder = $form_builder;
  }

  /**
   * Sets the _controllere on a request based on the request format.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event to process.
   */
  public function onRequestDeriveFormWrapper(GetResponseEvent $event) {
    $request = $event->getRequest();

    if ($form = $request->attributes->get('_form')) {
      $wrapper = new HtmlFormController($this->resolver, $this->container, $form, $this->formBuilder);
      $request->attributes->set('_content', array($wrapper, 'getContentResult'));
    }
  }

  /**
   * Registers the methods in this class that should be listeners.
   *
   * @return array
   *   An array of event listener definitions.
   */
  static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('onRequestDeriveFormWrapper', 29);

    return $events;
  }
}
