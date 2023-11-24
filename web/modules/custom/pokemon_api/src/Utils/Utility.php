<?php

namespace Drupal\pokemon_api\Utils;

use GuzzleHttp\Psr7\Request;

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
  public static function getPokemonSpritesData(string $pokemon_number): array|FALSE {
    // Initialized.
    $array = [];

    // Set GuzzleHttp.
    $http_client = \Drupal::httpClient();

    // Exec.
    try {
      $data = $http_client
        ->get(self::POKEMON_API_ENDPOINT . $pokemon_number)
        ->getBody()
        ->getContents();
      if (($json_pokemon_data = json_decode($data))
        && ($pokemon_sprites_data = $json_pokemon_data->sprites)
      ) {
        foreach (self::POKEMON_SPRITES as $sprite) {
          if (empty($pokemon_sprites_data->$sprite)) {
            // Missing sprite data.
            continue;
          }
          $array[] = $pokemon_sprites_data->$sprite;
        }
      }
      return $array;
    }
    catch (\Throwable $th) {
      // No script.
      return FALSE;
    }
  }

  /**
   * Get request from "pokeapi".
   */
  public static function getPokemonPhotoData(array $urls, int $pokemon_number): bool {
    $http_client = \Drupal::httpClient();
    foreach ($urls as $i => $o) {
      $request = new Request('GET', $o);
      $http_client
        ->send($request, ['sink' => self::POKEMON_DIRECTORY . '/' . sprintf('%04d', $pokemon_number) . '/' . self::POKEMON_SPRITES[$i] . '.png']);
    }
    return TRUE;
  }

}
