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
    $info = DB::table('rankme')->select(['id', 'steam', 'name', 'score'])->get();
    return response()->json($info,200,[],JSON_PRETTY_PRINT);
  }
  public function listPlayer($id)
  {
    $idr = preg_replace('/^STEAM_0/', 'STEAM_1', $id);
    $info = DB::table('rankme')->where('steam', $idr)->first();
    return response()->json($info,200,[],JSON_PRETTY_PRINT);
  }
}