<?

class ClientController extends BaseController{
  private $leftjoin = array();
  
  private $fields = array(
      'id' =>
        array(
          'type' => 'string',
          'required' => true,
          'can_search' => array(
            'equals' => true
          )
        ),
      'secret' =>
        array(
          'type' => 'string',
          'required' => true,
          'can_search' => array(
            'equals' => true
          )
        ),
      'name' =>
        array(
          'type' => 'string',
          'required' => true,
          'can_search' => array(
            'equals' => true
          )
        ),
      'created_at' =>
        array(
          'type' => 'datetime',
          'required' => true
        ),
      'updated_at' =>
        array(
          'type' => 'datetime',
          'required' => true
        )
      );
      
  private $table = "oauth_clients";
  private $pk = 'id';

  private $limit = 10;
  
  public function showClient($id){
    $client = Client::find($id);
    
    return Response::json($client);
  }
  
  public function showClients(){
    return $this->executeSearch(array('fields' => $this->fields, 'table' => $this->table, 'limit' => $this->limit));
  }

  public function addClient(){
    Input::merge(array('id'=>'heresanid1','secret'=>'heresasecret1'));
    $added = false;
    if (!$added){
      try{
        $this->executeInsertStatement(array('pk' => $this->pk, 'fields' => $this->fields, 'table' => $this->table));
        $added = true;
        Input::replace(array('id'=>'anoterhid','secret'=>'anothersecret'));
      }
      catch (Exception $e){
        $added = false;
      }
    }
    if (!$added){
      try{
        $this->executeInsertStatement(array('pk' => $this->pk, 'fields' => $this->fields, 'table' => $this->table));
        $added = true;
        Input::replace(array('id'=>'anoterhid','secret'=>'anothersecret'));
      }
      catch (Exception $e){
        $added = false;
      }
    }
    return $this->executeSearch(array('fields' => $this->fields, 'table' => $this->table, 'limit' => $this->limit,'leftjoin'=>$this->leftjoin));
  }

  public function updateClient(){
    return $this->executeUpdateStatement(array('pk' => $this->pk, 'fields' => $this->fields, 'table' => $this->table));
  }
}

?>