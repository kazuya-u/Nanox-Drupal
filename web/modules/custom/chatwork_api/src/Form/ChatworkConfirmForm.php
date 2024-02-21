<?php

namespace Drupal\chatwork_api\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Chatwork API  confirm form.
 */
final class ChatworkConfirmForm extends ConfirmFormBase {


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
    return 'chatwork_api_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('本当に送信しますか？');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('chatwork_api.chatwork');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('はい');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return $this->t('いいえ');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $this->privateTempStore->get('chatwork_api')->delete('form_values');
  }

}
