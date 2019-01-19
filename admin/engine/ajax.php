<?php

include_once __DIR__."/core.php";

$action = $_GET['action'];
function editable_ajax($pk, $table, $name, $value)
{
	if(function_exists(onInlineValueChange))
	{
		onInlineValueChange($table, $pk, $name, $value);
	}

    if($value=="NULL") $value = null;
    if(qi("UPDATE `{$table}` SET `{$name}` = :val WHERE id = :id", array('id' => $pk, 'val' => $value), 1)) {

        return array(
            'status' => 1
        );
    } else {
        return array(
            'status' => 0,
            'msg' => 'Произошла ошибка'
        );
    }

}

function onInlineValueChange($table, $id, $column, $value)
{
    if($table=='users' && $column=='status')
    {
        switch ($value){
            case "confirmed":
                $action = "coordinator_gender";
                break;
            case "ready":
                $action = "ready";
                break;
            case "will_upload_documents":
                $action = "will_upload_documents";
                break;
            default:
                $action = null;
        }
        if ($action==null) {return;}
        
        $userData = q1("select chat_user_id,chat_platform from users where id=? limit 1;",[$id]);
        
        if ($userData['chat_platform']==null || $userData['chat_user_id']==null) {return;}
        
        $postdata = http_build_query(
            array(
                'action' => $action, // экран кэлвин, на который попадет пользователь.
                'platform' => $userData['chat_platform'], //берется из БД, users—>chat_platoform
                'user_id' => $userData['chat_user_id'], //берется из БД, users—>chat_user_id
                'key' => 'uavyicybfiaygisbci628345dxfabvydsfua', //захардкоженное значение, всегда должно быть равно uavyicybfiaygisbci628345dxfabvydsfua, иначе не будет работать
            )
        );
        
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        
        $context  = stream_context_create($opts);
        
        $result = file_get_contents('http://test-calvin.alef.im/api.php', false, $context);
    }
    
}



switch($action)
{

    case 'editable':
      try
      {
        $req = editable_ajax($_REQUEST['pk'], $_REQUEST['table'], $_REQUEST['name'], $_REQUEST['value']);

        if($req['status'] != 1)
        {
            header('HTTP 400 Bad Request', true, 400);
            die($req['msg']);
        }
      }
      catch (Exception $e)
      {
        header('HTTP 400 Bad Request', true, 400);
        die("Ошибка");
      }

        break;
    case 'tags_editable':
        $formula = $_REQUEST['formula'];
        $id = $_REQUEST['pk'];
        $values = explode(", ", $_REQUEST['value']);

        $parts = explode("->", $formula);
        $middle = trim($parts[0]);
        $target = trim($parts[1]);

        $parts = explode("(", $target);
        $target_table = trim($parts[0]);
        $target_table_field = trim(str_replace(')', '', $parts[1]));

        $parts = explode("(", $middle);

        $middle_table = trim($parts[0]);
        $middle_fields = trim(str_replace(')', '', $parts[1]));
        $parts = explode(",", $middle_fields);

        $middle_table_field1 = trim($parts[0]);
        $middle_table_field2 = trim($parts[1]);

        if(count($values)>0)
        {
          foreach ($values as $k)
          {
            $vals[] = '("'.$k.'")';
            $vals2[] = '"'.$k.'"';
          }
          $vals = implode(", ", $vals);
          $vals2 = implode(", ", $vals2);
          qi("DELETE FROM {$middle_table} WHERE {$middle_table_field1}=?",[$id]);
          qi("INSERT IGNORE INTO {$target_table} ({$target_table_field}) VALUES {$vals}", []);
          qi("INSERT INTO {$middle_table} ({$middle_table_field1}, {$middle_table_field2}) SELECT $id, id FROM {$target_table} WHERE nm IN ({$vals2})",[]);
        }
    break;
}

?>
