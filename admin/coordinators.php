<?php
	include "engine/core.php";
	

	class GLOBAL_STORAGE
	{
	   static $parent_object;
	}
	

	$action = $_REQUEST['action'];
	$actions = [];

	define("RPP", 50); //кол-во строк на странице

	function array2csv($array)
	{
	   if (count($array) == 0)
	   {
	     return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   fputcsv($df, array_keys($array[0]));
	   foreach ($array as $row)
	   {
	      fputcsv($df, array_values($row));
	   }
	   fclose($df);
	   return ob_get_clean();
	}

	function download_send_headers($filename)
	{
	    // disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");
	}

	$actions['csv'] = function()
	{
		download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo array2csv(get_data(true)[0]);
		die();
	};

	$actions[''] = function()
	{
			
   		$role_values = '[{"text":"Администратор", "value":"admin"},{"text":"Координатор", "value":"coordinator"}]';
		$role_values_text = "";
		foreach(json_decode($role_values, true) as $opt)
		{
			$role_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['name']='asc';
$next_order['login']='asc';
$next_order['pass']='asc';
$next_order['role']='asc';

		if($_REQUEST['sort_order']=='asc')
		{
			$sort_icon[$_REQUEST['sort_by']] = '<span class="fa fa-long-arrow-up" style="margin-left:5px;"></span>';
			$next_order[$_REQUEST['sort_by']] = 'desc';
		}
		else if($_REQUEST['sort_order']=='desc')
		{
			$sort_icon[$_REQUEST['sort_by']] = '<span class="fa fa-long-arrow-down" style="margin-left:5px;"></span>';
			$next_order[$_REQUEST['sort_by']] = '';
		}
		else if($_REQUEST['sort_order']=='')
		{
			$next_order[$_REQUEST['sort_by']] = 'asc';
		}
		$filter_caption = "";
		$show = '
		<script>
				window.onload = function ()
				{
					$(\'.big-icon\').html(\'<i class="fas fa-user"></i>\');
				};


		</script>
		
		<style>
			html body.concept, html body.concept header, body.concept .table
			{
				background-color:;
				color:;
			}

			#tableMain tr:nth-child(even)
			{
  				background-color: ;
			}
		</style>
		<div class="content-header">
			<div class="btn-wrap">
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Координаторы".' </h2>
				<button class="btn blue-inline add_button" data-toggle="modal" data-target="#modal-main">ДОБАВИТЬ</button>
				<p class="small res-cnt">Кол-во результатов: <span class="cnt-number-span">'.$cnt.'</span></p>
			</div>
			
			<form class="navbar-form search-form" role="search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск" name="srch-term" id="srch-term" value="'.$_REQUEST['srch-term'].'">
					<button class="input-group-addon"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</div>
		<div>'.
		""
		.'</div>';

		$show .= filter_divs();

		$show.='

		<div class="table-wrap" data-fl-scrolls>
			<table class="table table-bordered table-clickable" id="tableMain">
			<thead>
				<tr>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>ID'. $sort_icon['id'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>Имя'. $sort_icon['name'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="name_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=login&sort_order='. ($next_order['login']) .'\' class=\'sort\' column=\'login\' sort_order=\''.$sort_order['login'].'\'>Логин'. $sort_icon['login'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="login_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=pass&sort_order='. ($next_order['pass']) .'\' class=\'sort\' column=\'pass\' sort_order=\''.$sort_order['pass'].'\'>Пароль'. $sort_icon['pass'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=role&sort_order='. ($next_order['role']) .'\' class=\'sort\' column=\'role\' sort_order=\''.$sort_order['role'].'\'>Роль'. $sort_icon['role'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="role_filter">
							'. $role_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>
					<th></th>
				</tr>
		</thead><tbody>';

		if(count($items) > 0)
		{
			foreach($items as $item)
			{
				$master = ($item['master'] == 1) ? 'Да' : 'Нет';

				$show .= "

				<tr pk='{$item['id']}'>
					
					<td>".htmlspecialchars($item['id'])."</td>
<td><span class='editable ' data-placeholder='Имя' data-inp='text' data-url='engine/ajax.php?action=editable&table=coordinators' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span></td>
<td><span class='editable ' data-placeholder='Логин' data-inp='text' data-url='engine/ajax.php?action=editable&table=coordinators' data-pk='{$item['id']}' data-name='login'>".htmlspecialchars($item['login'])."</span></td>
<td><span class='editable ' data-type='password' data-display=false data-inp='pass' data-url='engine/ajax.php?action=editable&table=coordinators' data-pk='{$item['id']}' data-name='pass'></span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($role_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=coordinators' data-pk='{$item['id']}' data-name='role'>".select_mapping($role_values, $item['role'])."</span></td>
					<td><a href='#' class='edit_btn'><i class='fa fa-edit' style='color:grey;'></i></a> <a href='#' class='delete_btn'><i class='fa fa-trash' style='color:red;'></i></a></td>
				</tr>";
			}
			$show .= '</tbody></table></div>'.$pagination;

		}
		else
		{
			$show.=' </tbody></table><div class="empty_table">Нет информации</div>';
		}
		$show.="<div></div>".'';
		return $show;

	};

	$actions['edit'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM coordinators WHERE id=?",[$id]);
			$item = $item[0];
		}

		

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>'.
					(isset($id)?
					'<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="action" value="edit_execute">'
					:
					'<input type="hidden" name="action" value="create_execute">'
					)
					.'

					

								<div class="form-group">
									<label class="control-label" for="textinput">Имя</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="Имя" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Логин</label>
									<div>
										<input id="login" name="login" type="text"  placeholder="Логин" class="form-control input-md " value="'.htmlspecialchars($item["login"]).'">
									</div>
								</div>

							

	            '. (!isset($id)?'
							<div class="form-group">
								<label class="control-label" for="textinput">Пароль</label>
								<div>
									<input id="pass" name="pass" type="password"  class="form-control input-md " value="">
								</div>
							</div>':
	            ''
	            ).'
						



				<div class="form-group">
					<label class="control-label" for="textinput">Роль</label>
					<div>
						<select id="role" name="role" class="form-control input-md ">
							<option value="admin" '.($item["role"]=="admin"?"selected":"").'>Администратор</option> 
<option value="coordinator" '.($item["role"]=="coordinator"?"selected":"").'>Координатор</option> 

						</select>
					</div>
				</div>

			
					<div class="text-center not-editable">
						
					</div>

				</fieldset>
			</form>

		';
		die($html);
	};

	$actions['create'] = function()
	{

		

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="create_execute">
					

								<div class="form-group">
									<label class="control-label" for="textinput">Имя</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="Имя" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Логин</label>
									<div>
										<input id="login" name="login" type="text"  placeholder="Логин" class="form-control input-md " value="'.htmlspecialchars($item["login"]).'">
									</div>
								</div>

							

	            '. (!isset($id)?'
							<div class="form-group">
								<label class="control-label" for="textinput">Пароль</label>
								<div>
									<input id="pass" name="pass" type="password"  class="form-control input-md " value="">
								</div>
							</div>':
	            ''
	            ).'
						



				<div class="form-group">
					<label class="control-label" for="textinput">Роль</label>
					<div>
						<select id="role" name="role" class="form-control input-md ">
							<option value="admin" '.($item["role"]=="admin"?"selected":"").'>Администратор</option> 
<option value="coordinator" '.($item["role"]=="coordinator"?"selected":"").'>Координатор</option> 

						</select>
					</div>
				</div>

			
					<div class="text-center not-editable">
						
					</div>
				</fieldset>
			</form>

		';
		die($html);
	};


	$actions['edit_page'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM coordinators WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Координаторы".' #'.$id.'</small></h1>
			<form class="form" enctype="multipart/form-data" method="POST">
				<input type="hidden" name="back" value="'.$_SERVER['HTTP_REFERER'].'">
				<fieldset>'.
					(isset($id)?
					'<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="action" value="edit_execute">'
					:
					'<input type="hidden" name="action" value="create_execute">'
					)
					.'

					

								<div class="form-group">
									<label class="control-label" for="textinput">Имя</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="Имя" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Логин</label>
									<div>
										<input id="login" name="login" type="text"  placeholder="Логин" class="form-control input-md " value="'.htmlspecialchars($item["login"]).'">
									</div>
								</div>

							

	            '. (!isset($id)?'
							<div class="form-group">
								<label class="control-label" for="textinput">Пароль</label>
								<div>
									<input id="pass" name="pass" type="password"  class="form-control input-md " value="">
								</div>
							</div>':
	            ''
	            ).'
						



				<div class="form-group">
					<label class="control-label" for="textinput">Роль</label>
					<div>
						<select id="role" name="role" class="form-control input-md ">
							<option value="admin" '.($item["role"]=="admin"?"selected":"").'>Администратор</option> 
<option value="coordinator" '.($item["role"]=="coordinator"?"selected":"").'>Координатор</option> 

						</select>
					</div>
				</div>

			

				</fieldset>
				<div>
					<a href="?'.(http_build_query(array_filter($_REQUEST, function($k){return !in_array($k, ['action', 'genesis_edit_id']);}, ARRAY_FILTER_USE_KEY))).'" class="btn cancel" >Закрыть</a>
					<button type="button" class="btn blue-inline" id="edit_page_save">Сохранить</a>
				</div>
			</form>

		';

		return $html;
	};

	$actions['reorder'] = function()
	{
		$line = json_decode($_REQUEST['genesis_ids_in_order'], true);
		for ($i=0; $i < count($line); $i++)
		{
			qi("UPDATE `coordinators` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
		}


		die(json_encode(['status'=>0]));

	};

	$actions['create_execute'] = function()
	{
		$name = $_REQUEST['name'];
$login = $_REQUEST['login'];
$pass = md5($_REQUEST['pass']);
$role = $_REQUEST['role'];

		qi("INSERT INTO coordinators (`name`, `login`, `pass`, `role`) VALUES (?, ?, ?, ?)", [$name, $login, $pass, $role]);
		$last_id = qInsertId();

		

		header("Location: ".$_SERVER['HTTP_REFERER']);
		die("");

	};

	$actions['edit_execute'] = function()
	{
		$id = $_REQUEST['id'];
		$set = [];

		$set[] = is_null($_REQUEST['name'])?"`name`=NULL":"`name`='".addslashes($_REQUEST['name'])."'";
$set[] = is_null($_REQUEST['login'])?"`login`=NULL":"`login`='".addslashes($_REQUEST['login'])."'";
$set[] = is_null($_REQUEST['role'])?"`role`=NULL":"`role`='".addslashes($_REQUEST['role'])."'";

		if(count($set)>0)
		{
			$set = implode(", ", $set);
			qi("UPDATE coordinators SET $set WHERE id=?", [$id]);
		}

		if(isset($_REQUEST['back']))
		{
			header("Location: {$_REQUEST['back']}");
		}
		else
		{
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		die("");
	};



	$actions['delete'] = function()
	{
		$id = $_REQUEST['id'];
		try
		{
			qi("DELETE FROM coordinators WHERE id=?", [$id]);
			echo "1";
		}
		catch (Exception $e)
		{
			echo "0";
		}

		die("");
	};

	function filter_query($srch)
	{
		$filters = [];
		
		if(isset2($_REQUEST['name_filter']))
		{
			$filters[] = "`name` LIKE '%{$_REQUEST['name_filter']}%'";
		}
				

		if(isset2($_REQUEST['login_filter']))
		{
			$filters[] = "`login` LIKE '%{$_REQUEST['login_filter']}%'";
		}
				

		if(isset2($_REQUEST['role_filter']))
		{
			$filters[] = "`role` = '{$_REQUEST['role_filter']}'";
		}
				

		$filter="";
		if(count($filters)>0)
		{
			$filter = implode(" AND ", $filters);
			if($srch=="")
			{
				$filter = " WHERE $filter";
			}
			else
			{
				$filter = " AND ($filter)";
			}
		}
		return $filter;
	}

	function filter_divs()
	{
		$role_values = '[{"text":"Администратор", "value":"admin"},{"text":"Координатор", "value":"coordinator"}]';
		$role_values_text = "";
		foreach(json_decode($role_values, true) as $opt)
		{
			$role_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
		
		if(isset2($_REQUEST['name_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='name_filter' value='{$_REQUEST['name_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Имя: <b>{$_REQUEST['name_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['login_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='login_filter' value='{$_REQUEST['login_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Логин: <b>{$_REQUEST['login_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($role_values, true), function($i)
		{
			return $i['value']==$_REQUEST['role_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['role_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='role_filter' value='{$_REQUEST['role_filter']}'>
					<span class='fa fa-times remove-tag'></span> Роль: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				
		$show = $filter_caption.$filter_divs;

		return $show;
	}


	function get_data($force_kill_pagination=false)
	{

		$pagination = 1;
		if($force_kill_pagination==true)
		{
			$pagination = 0;
		}
		$items = [];

		$srch = "";
		
			if($_REQUEST['srch-term'])
			{
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%'))";
			}

		$filter = filter_query($srch);
		$where = "";
		if($where != "")
		{
			if($filter!='' || $srch !='')
			{
				$where = " AND ($where)";
			}
			else
			{
				$where = " WHERE ($where)";
			}
		}


		
				$default_sort_by = 'role,name';
				$default_sort_order = '';
			

		if(isset($default_sort_by) && $default_sort_by)
		{
			$order = "ORDER BY $default_sort_by $default_sort_order";
		}

		if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by']!="")
		{
			$order = "ORDER BY {$_REQUEST['sort_by']} {$_REQUEST['sort_order']}";
		}


		if($pagination == 1)
		{
			$items = q("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM coordinators main_table) temp $srch $filter $where $order LIMIT :start, :limit",
				[
					'start' => MAX(($_GET['page']-1), 0)*RPP,
					'limit' => RPP
				]);
			$cnt = qRows();
			$pagination = pagination($cnt);
		}
		else
		{
			$items = q("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM coordinators main_table) temp $srch $filter $where $order", []);
			$cnt = qRows();
			$pagination = "";
		}



		return [$items, $pagination, $cnt];
	}

	

	$content = $actions[$action]();
	echo masterRender("Координаторы", $content, 1);
