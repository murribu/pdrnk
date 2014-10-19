<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout(){
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

  function executeUpdateStatement($args){
    extract($args);
    $set = "";
    $data = array();
    foreach($fields as $field=>$v){
      if (Input::has($field)){
        $set .= ",$field = ?";
        switch ($v['type']){
          case 'timetoint':
            $arr = rsort(explode(":",Input::get($field)));
            $val = 0;
            $i = 0;
            foreach($arr as $t){
              $val += $t*pow(60,$i++);
            }
            $data[] = $val;
            break;
          case 'bool':
            if (Input::get($field) == "yes" || Input::get($field) == "1"){
              $data[] = 1;
            }else{
              $data[] = 0;
            }
            break;
          case 'int':
            $data[] = intval(Input::get($field));
            break;
          case 'datetime':
            $data[] = date("Y-m-d G:i:s",strtotime(Input::get($field)));
            break;
          default:
            $data[] = Input::get($field);
            break;
        }
      }
    }
    if ($set != "" && Input::has($pk)){
      $data[] = Input::get($pk);
      $num_rows = DB::update("update $table set ".substr($set, 1)." where $pk = ?",$data);
      return Response::json(array('Result' => intval($num_rows)));
    }else{
      return Response::json(array('Result' => 0));
    }
  }

  function executeInsertStatement($args){
    extract($args);
    $vals = "";
    $fieldlist = "";
    $data = array();
    foreach($fields as $field=>$v){
      if (Input::has($field)){
        switch ($v['type']){
          case 'timetoint':
            $arr = rsort(explode(":",Input::get($field)));
            $val = 0;
            $i = 0;
            foreach($arr as $t){
              $val += $t*pow(60,$i++);
            }
            $data[] = $val;
            break;
          case 'bool':
            if (Input::get($field) == "yes" || Input::get($field) == "1"){
              $data[] = 1;
            }else{
              $data[] = 0;
            }
            break;
          case 'int':
            $data[] = intval(Input::get($field));
            break;
          case 'datetime':
            $data[] = date("Y-m-d G:i:s",strtotime(Input::get($field)));
            break;
          default:
            $data[] = Input::get($field);
            break;
        }
        $vals .= ",?";
        $fieldlist .= ",$field";
      }else{
        if ($v['required']){
          switch ($v['type']){
            case 'bool':
              $vals .= ",?";
              $fieldlist .= ",$field";
              $data[] = 0; //default all booleans to 0??????
              break;
            case 'datetime':
              $vals .= ",?";
              $fieldlist .= ",$field";
              $data[] = gmdate("Y-m-d G:i:s"); //default all datetimes to now??????
            default:
              return Response::json(array('Error' => "$field is required"));
              break;
          }
        }
      }
    }
    if ($vals != ""){
      $num_rows = DB::insert("insert into $table (".substr($fieldlist,1).") values (".substr($vals,1).")", $data);
      return Response::json(array('Result' => intval($num_rows)));
    }else{
      return Response::json(array('Result' => 0));
    }
  }
}
