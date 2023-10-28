<?php

namespace Drupal\pokemon_api\Utils;

/**
 * The Utility for pokemon api.
 */
class Utility {

  /**
   * The Save Base Directory.
   *
   * @var string
   */
  const POKEMON_DIRECTORY = 'private://api/pokemon';

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
    // Request.
    $request_option = [
      CURLOPT_URL => self::POKEMON_API_ENDPOINT . $pokemon_number,
      CURLOPT_RETURNTRANSFER  => TRUE,
    ];
    $request_ch = curl_init();
    curl_setopt_array($request_ch, $request_option);
    if ($request_result = curl_exec($request_ch)) {
      return $request_result;
    }
    curl_close($request_ch);
    return FALSE;
  }

}
