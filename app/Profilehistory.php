<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profilehistory extends Model
{
  public static $rules = array(
      'profiles_id' => 'required',
      'edited_at' => 'required',
  );
}
