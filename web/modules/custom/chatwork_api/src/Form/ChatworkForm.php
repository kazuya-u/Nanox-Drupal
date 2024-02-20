<?php

namespace Drupal\chatwork_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Chatwork API form.
 */
final class ChatworkForm extends FormBase {

  /**
   * The private tmp store.
   */
  protected PrivateTempStoreFactory $privateTempStore;

  /**
   * {@inheritDoc}
   */
  public function __construct(
    PrivateTempStoreFactory $private_temp_store
  ) {
    $this->privateTempStore = $private_temp_store;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tempstore.private'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'chatwork_api_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form = [
      'message' => [
        '#type' => 'textarea',
        '#title' => $this->t('Message'),
        '#required' => TRUE,
      ],
      'actions' => [
        '#type' => 'submit',
        '#value' => $this->t('確認'),
        '#attributes' => [
          'class' => ['button'],
        ],
        '#ajax' => [
          'callback' => '::showConfirmationForm',
          'event' => 'click',
        ],
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $tempstore = $this->privateTempStore->get('chatwork_api');
    $tempstore->set('form_values', $form_state->getValues());
    $form_state->setRedirectUrl(Url::fromRoute('chatwork_api.confirm'));
  }

}
