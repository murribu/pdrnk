<?
class EpisodeController extends BaseController {

  private $fields = array(
      'ep_name' =>
        array(
          'type' => 'string',
          'required' => true
        ),
      'ep_description' =>
        array(
          'type' => 'string',
          'required' => false
        ),
      'ep_duration' =>
        array(
          'type' => 'timetoint',
          'required' => false
        ),
      'ep_explicit' =>
        array(
          'type' => 'bool',
          'required' => true
        ),
      'ep_filesize' =>
        array(
          'type' => 'int',
          'required' => false
        ),
      'ep_img' =>
        array(
          'type' => 'string',
          'required' => false
        ),
      'ep_link' =>
        array(
          'type' => 'string',
          'required' => false
        ),
      'ep_pubdate' =>
        array(
          'type' => 'datetime',
          'required' => true
        ),
      'ep_url' =>
        array(
          'type' => 'string',
          'required' => false
        ),
      'ep_po_key' =>
        array(
          'type' => 'int',
          'fk' => 'podcasts.po_key'
          'required' => true
        )
    );
  private $table = "episodes";
  private $pk = 'ep_key';

  public function showEpisode($id){
      $episode = Episode::find($id);

      return Response::json($episode);
  }

  public function showEpisodes(){
    $episodes = Episode::all();

    return Response::json($episodes);
  }

  public function addEpisode(){
    return $this->executeInsertStatement(array('pk' => $this-pk, 'fields' => $this->fields, 'table' => $this->table));
  }

  public function updateEpisode(){
    return $this->executeUpdateStatement(array('pk' => $this->pk, 'fields' => $this->fields, 'table' => $this->table));
  }
}

?>