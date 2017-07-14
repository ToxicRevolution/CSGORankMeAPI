<?php

namespace App\Http\Controllers\Api\v1;

use App\RankMeAPI;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;


class RankMePublic extends Controller
{
    protected function playerNotFound($message='Record Not Found', $statusCode=404)
    {
     return response()->json(['error'=> $message],$statusCode,[]);
    }

    public function home($version="v1")
    {
      $base = request()->root();
      $url =  "$base/api/$version/";
      return view('api.home', ['version'=>$version, 'url'=>$url]);
    }

    public function listAllPaginate(RankMeAPI $rankMeAPI)
    {
        $info = RankMeAPI::orderBy('score', 'desc')->paginate(15);
        return response()->json($info,200,[],JSON_PRETTY_PRINT);
    }

    public function listAllPlayers(RankMeAPI $rankMeAPI, Request $request)
    {
      $info = RankMeAPI::select('id', 'name', 'steam', 'kills', 'deaths')->get();
      // Switch statement to deal with sorting of data based of query string
      switch (Request::get('sort')){
        case '':
          return response()->json($info,200,[],JSON_PRETTY_PRINT);
        case 'desc':
          $info = RankMeAPI::orderBy('score', 'desc')->get();
          return response()->json($info,200,[],JSON_PRETTY_PRINT);
        case 'asc':
          $info = RankMeAPI::orderBy('score', 'asc')->get();
          return response()->json($info,200,[],JSON_PRETTY_PRINT);
        break;
      }
    }

    public function listPlayer(RankMeAPI $rankMeAPI, $id)
    {
      // RankMe stores all steamids with STEAM_1 not STEAM_0 even if they are STEAM_0 from steamid.co or anywhere that gives you your steamid
      $idr = preg_replace('/^STEAM_0/', 'STEAM_1', $id);
      // Getting user info from database
      $info = RankMeAPI::all()->where('steam', $idr);
      // if to return 404 if no data is found in db
      if($info->count() < 1){
        return $this->playerNotFound();
      }
      return response()->json($info,200,[],JSON_PRETTY_PRINT);
    }

}
