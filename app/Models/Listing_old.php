<?php
  namespace App\Models;

  class Listing_old {
    public static function all() {
      return [
        [
          'id' => 1,
          'title' => 'Listing One',
          'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam in leo sed turpis vehicula condimentum vel id metus. Ut elementum bibendum ante, in mattis tellus sagittis nec. ',
        ],
        [
          'id' => 2,
          'title' => 'Listing Two',
          'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam in leo sed turpis vehicula condimentum vel id metus. Ut elementum bibendum ante, in mattis tellus sagittis nec. ',
        ]
      ];
    }

    public static function find($id) {
      $listings = self::all();

      foreach($listings as $listing) {
        if ($listing['id'] == $id) {
          return $listing;
        }
      }
    }
  }