<?php

namespace Drupal\chatwork\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritDoc}
 */
class BeginningForm extends FormBase {

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'work_status_form';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $current_uid = $this->currentUser()->id();
    $room_id = \Drupal::entityTypeManager()->getStorage('user')->load($current_uid)->get('field_chatwork_api_room_id')->getString();
    $parts = explode(', ', $room_id);
    $chat_key = $parts[1];
    $chat_value = $parts[0];
    $form = [
      'room_id' => [
        '#type' => 'select',
        '#options' => [
          $chat_key => $chat_value,
        ],
      ],
    ];
    $form['actions'] = [
      '#type' => 'actions',
      'beggining' => [
        '#type' => 'submit',
        '#value' => '出勤する',
      ],
      'leaving' => [
        '#type' => 'submit',
        '#value' => '退勤する',
      ],
    ];
    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $room_id = $form_state->getValue('room_id');
    $current_uid = $this->currentUser()->id();
    $token = \Drupal::entityTypeManager()->getStorage('user')->load($current_uid)->get('field_chatwork_api_token')->getString();
    if ($form_state->getValues()['op'] === '出勤する') {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.chatwork.com/v2/rooms/' . $room_id . '/messages');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_POST, 1);

      $headers = [
        'X-ChatWorkToken: ' . $token,
      ];
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $data = [
        'body' => '出勤します',
        'self_unread' => 1,
      ];
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      $response = curl_exec($ch);
      curl_close($ch);
      \Drupal::messenger()->addMessage($response);
    }
    else {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.chatwork.com/v2/rooms/' . $room_id . '/messages');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_POST, 1);

      $headers = [
        'X-ChatWorkToken: ' . $token,
      ];
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $data = [
        'body' => '退勤します',
        'self_unread' => 1,
      ];
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      $response = curl_exec($ch);
      curl_close($ch);
      \Drupal::messenger()->addMessage($response);
    }

  }

}
