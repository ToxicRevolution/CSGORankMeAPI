<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RankMeAPI extends Model
{
  protected $connection = 'rankme';

  protected $hidden = [
      'lastip', // makes the last IP of client not accessable in the API
  ];

  protected $table = 'rankme';
}
