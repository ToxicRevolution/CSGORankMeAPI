<?php

namespace App\Http\Controllers\Api\v1;

use App\RankMeAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



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
        $info = RankMeAPI::paginate(15);
        return response()->json($info,200,[],JSON_PRETTY_PRINT);
    }

    public function listAllPlayers(RankMeAPI $rankMeAPI)
    {
      $info = RankMeAPI::select('id', 'name', 'steam', 'kills', 'deaths')->get();
      return response()->json($info,200,[],JSON_PRETTY_PRINT);
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
