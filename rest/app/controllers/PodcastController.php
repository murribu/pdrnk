<?php
class PodcastController extends BaseController {

  private $fields = array(
      'po_name' =>
        array(
          'type' => 'string',
          'required' => true
        ),
      'po_feed' =>
        array(
          'type' => 'string',
          'required' => true
        ),
      'po_feeddev' =>
        array(
          'type' => 'string',
          'required' => false
        ),
      'po_url' =>
        array(
          'type' => 'string',
          'required' => false
        )
    );
  private $table = "podcasts";
  private $pk = 'po_key';

  public function showPodcast($id){
      $podcast = Podcast::find($id);

      return Response::json($podcast);
  }

  public function showPodcasts(){
    $podcasts = Podcast::all();

    return Response::json($podcasts);
  }

  public function addPodcast(){
    //How do I get scope info here? I want to post what user and/or client added the podcast, etc.
    return $this->executeInsertStatement(array('pk' => $this->pk, 'fields' => $this->fields, 'table' => $this->table));
  }

  public function updatePodcast(){
    return $this->executeUpdateStatement(array('pk' => $this->pk, 'fields' => $this->fields, 'table' => $this->table));
  }
}

?>