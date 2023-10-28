<?php

namespace Drupal\pokemon_api\Utils;

/**
 * The Utility for pokemon api.
 */
class Utility {

  /**
   * The maximum number of Pokemon.
   *
   * @var string
   */
  const POKEMON_MAX_NUMBER = 1010;

  /**
   * The Save Base Directory.
   *
   * @var string
   */
  const POKEMON_DIRECTORY = DRUPAL_ROOT . '/sites/default/files/api/pokemon';

  /**
   * The Target api endpoint.
   *
   * @var string
   */
  const POKEMON_API_ENDPOINT = 'https://pokeapi.co/api/v2/pokemon/';

  /**
   * The Pokemon sprites.
   *
   * @var array
   */
  const POKEMON_SPRITES = [
    'back_default',
    'back_shiny',
    'front_default',
    'front_shiny',
  ];

  /**
   * Get request from "pokeapi".
   */
  public static function getPokemonData(string $pokemon_number): string|FALSE {
    $client = \Drupal::httpClient();
    try {
      $request = $client->get(self::POKEMON_API_ENDPOINT . $pokemon_number);
      $response = $request->getBody();
      return $response;
    }
    catch (\Throwable $th) {
      // No script.
    }
    return FALSE;
  }

}
