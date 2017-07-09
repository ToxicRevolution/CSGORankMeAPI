<?php

namespace App\Http\Controllers\Api\v1;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination;

class RankMeWebMain extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

  public function listPlayers()
  {
    $info = DB::table('rankme')->get();
    return response()->json($info->toArray());
  }
  public function listPlayer($id)
  {
    $info = DB::table('rankme')->where('steam', $id)->get();
    return response()->json($info->toArray());
  }
}
