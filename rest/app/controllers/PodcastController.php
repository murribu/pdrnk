<?
  class PodcastController extends BaseController {

    public function showPodcast($id){
        $podcast = Podcast::find($id);

        return Response::json($podcast);
    }

    public function showPodcasts(){
      $podcasts = Podcast::all();

      return Response::json($podcasts);
    }

    public function addPodcast(){
      $po_name = Input::get('po_name');
      $po_feed = Input::get('po_feed');
      $po_feeddev = Input::get('po_feeddev');
      $po_url = Input::get('po_url');
      $data = array(
        $po_name,
        $po_feed,
        $po_feeddev,
        $po_url
      );
      $num_rows = DB::insert('insert into podcasts (po_name, po_feed, po_feeddev, po_url) values (?,?,?,?)', $data);
      return Response::json(array('Result' => intval($num_rows)));
    }

}

?>