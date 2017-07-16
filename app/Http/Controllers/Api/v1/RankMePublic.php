<?php

namespace App\Http\Controllers\Api\v1;

use App\RankMeAPI;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


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
        // Setting paginate value to default number if no number is specified in query string.
        if(null !== Input::get('number')){
          $num = Input::get('number');
        } else {
          $num = 15;
        }
        // Switch statement to deal with sorting, default sends back in order of id from database.
        switch (Request::get('sort')) {
          case 'asc':
            $info = RankMeAPI::select('id', 'name', 'steam', 'kills', 'deaths', 'assists', 'score')->orderBy('score', 'asc')->paginate($num);
            return response()->json($info,200,[],JSON_PRETTY_PRINT);
          case 'desc':
            $info = RankMeAPI::select('id', 'name', 'steam', 'kills', 'deaths', 'assists', 'score')->orderBy('score', 'desc')->paginate($num);
            return response()->json($info,200,[],JSON_PRETTY_PRINT);
          break;
          default:
            $info = RankMeAPI::select('id', 'name', 'steam', 'kills', 'deaths', 'assists', 'score')->paginate($num);
            return response()->json($info,200,[],JSON_PRETTY_PRINT);
          break;
        }
    }

    public function listTopPlayers(RankMeAPI $rankMeAPI, Request $request)
    {
        // Returning the Top 100 players in descending order.
        $info = RankMeAPI::select('id', 'name', 'steam', 'kills', 'deaths', 'assists', 'score')->orderBy('score', 'desc')->take(100)->get();
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
