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
			
   		$status_values = '[{"text":"Выбирает из нескольких вариантов","value":"selects_options"},{"text":"Согласование с партнером","value":"coordination_partner"},{"text":"Не подтвердилось","value":"not_confirmed"},{"text":"Запланировано","value":"scheduled"},{"text":"Прошло успешно","value":"successful"},{"text":"Прошло неудачно","value":"unsuccessful"},{"text":"Не состоялось","value":"failed"},{"text":"Перенеслось","value":"transferred"}]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$first_show_values = '[{"text":"парень", "value":"male"},{"text":"девушка", "value":"female"}]';
			$first_show_values_text = "";
			foreach(json_decode($first_show_values, true) as $opt)
			{
			  $first_show_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  
$coordinator_id_values = json_encode(q("SELECT name as text, id as value FROM coordinators", []));
				  $coordinator_id_values_text = "";
			foreach(json_decode($coordinator_id_values, true) as $opt)
			{
			  $coordinator_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['male_name']='asc';
$next_order['male_phone']='asc';
$next_order['dt']='asc';
$next_order['female_name']='asc';
$next_order['female_phone']='asc';
$next_order['status']='asc';
$next_order['first_show']='asc';
$next_order['coordinator_id']='asc';

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
					$(\'.big-icon\').html(\'<i class="fas fa-calendar"></i>\');
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
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Свидания".' </h2>
				<button class="btn blue-inline add_button" data-toggle="modal" data-target="#modal-main">ДОБАВИТЬ</button>
				<p class="small res-cnt">Кол-во результатов: <span class="cnt-number-span">'.$cnt.'</span></p>
			</div>
			
		</div>
		<div>'.
		"<div class='col-md-12 text-center'> 
	<div class='btn-group' role='group' aria-label='Dates'>
	  <a href='dates.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Все свидания</a>
	  <a href='dates_old.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Прошедшие свидания</a>
	</div>
</div>"
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=male_name&sort_order='. ($next_order['male_name']) .'\' class=\'sort\' column=\'male_name\' sort_order=\''.$sort_order['male_name'].'\'>Парень'. $sort_icon['male_name'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="male_name_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=male_phone&sort_order='. ($next_order['male_phone']) .'\' class=\'sort\' column=\'male_phone\' sort_order=\''.$sort_order['male_phone'].'\'>тел.'. $sort_icon['male_phone'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=dt&sort_order='. ($next_order['dt']) .'\' class=\'sort\' column=\'dt\' sort_order=\''.$sort_order['dt'].'\'>Дата'. $sort_icon['dt'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input autocomplete="off" type="text" class="form-control daterange filter-date-range" name="dt_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=female_name&sort_order='. ($next_order['female_name']) .'\' class=\'sort\' column=\'female_name\' sort_order=\''.$sort_order['female_name'].'\'>Девушка'. $sort_icon['female_name'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="female_name_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=female_phone&sort_order='. ($next_order['female_phone']) .'\' class=\'sort\' column=\'female_phone\' sort_order=\''.$sort_order['female_phone'].'\'>тел.'. $sort_icon['female_phone'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=status&sort_order='. ($next_order['status']) .'\' class=\'sort\' column=\'status\' sort_order=\''.$sort_order['status'].'\'>Статус'. $sort_icon['status'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="status_filter">
							'. $status_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=first_show&sort_order='. ($next_order['first_show']) .'\' class=\'sort\' column=\'first_show\' sort_order=\''.$sort_order['first_show'].'\'>Сначала выбирает...'. $sort_icon['first_show'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=coordinator_id&sort_order='. ($next_order['coordinator_id']) .'\' class=\'sort\' column=\'coordinator_id\' sort_order=\''.$sort_order['coordinator_id'].'\'>Координатор'. $sort_icon['coordinator_id'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="coordinator_id_filter">
							'. $coordinator_id_values_text .'
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
<td>".htmlspecialchars($item['male_name'])."</td>
<td>".htmlspecialchars($item['male_phone'])."</td>
<td><span class='editable '  data-placeholder='' data-inp='date' data-url='engine/ajax.php?action=editable&table=dates' data-pk='{$item['id']}' data-name='dt'>".DateTime::createFromFormat('Y-m-d H:i:s', ($item['dt']?$item['dt']:"1970-01-01 00:00:00") )->format('Y-m-d H:i')."</span></td>
<td>".htmlspecialchars($item['female_name'])."</td>
<td>".htmlspecialchars($item['female_phone'])."</td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($status_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=dates' data-pk='{$item['id']}' data-name='status'>".select_mapping($status_values, $item['status'])."</span></td>
<td><span class=' '>".renderRadioGroup("first_show", $first_show_values, "dates", $item['id'], $item['first_show'])."</td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($coordinator_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=dates' data-pk='{$item['id']}' data-name='coordinator_id'>".select_mapping($coordinator_id_values, $item['coordinator_id'])."</span></td>
					<td><a href='#' class='edit_btn'><i class='fa fa-edit' style='color:grey;'></i></a> <a href='#' class='delete_btn'><i class='fa fa-trash' style='color:red;'></i></a></td>
				</tr>";
			}
			$show .= '</tbody></table></div>'.$pagination;

		}
		else
		{
			$show.=' </tbody></table><div class="empty_table">Нет информации</div>';
		}
		$show.="<div><div class='col-md-12 text-center btn_group'> 
	<div class='btn-group' role='group' aria-label='Dates'>
	  <a href='dates.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Все свидания</a>
	  <a href='dates_old.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Прошедшие свидания</a>
	</div>
</div></div>".'';
		return $show;

	};

	$actions['edit'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM _dates_info WHERE id=?",[$id]);
			$item = $item[0];
		}

		
			$male_id_options = q("SELECT concat(name,' ',ifnull(lastname,'')) as text, id as value FROM users where sex='male' and status='ready'",[]);
			$male_id_options_html = "";
			foreach($male_id_options as $o)
			{
				$male_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["male_id"]?"selected":"").">{$o['text']}</option>";
			}
		

			$female_id_options = q("SELECT concat(name,' ',ifnull(lastname,'')) as text, id as value FROM users where sex='female' and status='ready'",[]);
			$female_id_options_html = "";
			foreach($female_id_options as $o)
			{
				$female_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["female_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$first_show_values = '[{"text":"парень", "value":"male"},{"text":"девушка", "value":"female"}]';

			$coordinator_id_options = q("SELECT name as text, id as value FROM coordinators",[]);
			$coordinator_id_options_html = "";
			foreach($coordinator_id_options as $o)
			{
				$coordinator_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["coordinator_id"]?"selected":"").">{$o['text']}</option>";
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

					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          

			<div class="form-group">
				<label class="control-label" for="textinput">Парень</label>
				<div>
					<select id="male_id" name="male_id" class="form-control input-md " >
						'.$male_id_options_html.'
						</select>
				</div>
			</div>

		

			<div class="form-group">
				<label class="control-label" for="textinput">Девушка</label>
				<div>
					<select id="female_id" name="female_id" class="form-control input-md " >
						'.$female_id_options_html.'
						</select>
				</div>
			</div>

		


					<div class="form-group">
						<label class="control-label" for="textinput">Дата</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="selects_options" '.($item["status"]=="selects_options"?"selected":"").'>Выбирает из нескольких вариантов</option> 
<option value="coordination_partner" '.($item["status"]=="coordination_partner"?"selected":"").'>Согласование с партнером</option> 
<option value="not_confirmed" '.($item["status"]=="not_confirmed"?"selected":"").'>Не подтвердилось</option> 
<option value="scheduled" '.($item["status"]=="scheduled"?"selected":"").'>Запланировано</option> 
<option value="successful" '.($item["status"]=="successful"?"selected":"").'>Прошло успешно</option> 
<option value="unsuccessful" '.($item["status"]=="unsuccessful"?"selected":"").'>Прошло неудачно</option> 
<option value="failed" '.($item["status"]=="failed"?"selected":"").'>Не состоялось</option> 
<option value="transferred" '.($item["status"]=="transferred"?"selected":"").'>Перенеслось</option> 

						</select>
					</div>
				</div>

			



            <div class="form-group">
              <label class="control-label" for="textinput">Сначала выбирает...</label>
              <div class="" >'.renderEditRadioGroup("first_show", $first_show_values, $item["first_show"]).'
              </div>
            </div>

          

			<div class="form-group">
				<label class="control-label" for="textinput">Координатор</label>
				<div>
					<select id="coordinator_id" name="coordinator_id" class="form-control input-md " >
						'.$coordinator_id_options_html.'
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

		
			$male_id_options = q("SELECT concat(name,' ',ifnull(lastname,'')) as text, id as value FROM users where sex='male' and status='ready'",[]);
			$male_id_options_html = "";
			foreach($male_id_options as $o)
			{
				$male_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["male_id"]?"selected":"").">{$o['text']}</option>";
			}
		

			$female_id_options = q("SELECT concat(name,' ',ifnull(lastname,'')) as text, id as value FROM users where sex='female' and status='ready'",[]);
			$female_id_options_html = "";
			foreach($female_id_options as $o)
			{
				$female_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["female_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$first_show_values = '[{"text":"парень", "value":"male"},{"text":"девушка", "value":"female"}]';

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="create_execute">
					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          

			<div class="form-group">
				<label class="control-label" for="textinput">Парень</label>
				<div>
					<select id="male_id" name="male_id" class="form-control input-md " >
						'.$male_id_options_html.'
						</select>
				</div>
			</div>

		

			<div class="form-group">
				<label class="control-label" for="textinput">Девушка</label>
				<div>
					<select id="female_id" name="female_id" class="form-control input-md " >
						'.$female_id_options_html.'
						</select>
				</div>
			</div>

		


					<div class="form-group">
						<label class="control-label" for="textinput">Дата</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				

					<input id="status" name="status" type="hidden" value="'.htmlspecialchars("selects_options").'">
		



            <div class="form-group">
              <label class="control-label" for="textinput">Сначала выбирает...</label>
              <div class="" >'.renderEditRadioGroup("first_show", $first_show_values, $item["first_show"]).'
              </div>
            </div>

          

					<input id="coordinator_id" name="coordinator_id" type="hidden" value="'.htmlspecialchars("{$_SESSION["user"]["id"]}").'">
		
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
			$item = q("SELECT * FROM _dates_info WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		
			$male_id_options = q("SELECT concat(name,' ',ifnull(lastname,'')) as text, id as value FROM users where sex='male' and status='ready'",[]);
			$male_id_options_html = "";
			foreach($male_id_options as $o)
			{
				$male_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["male_id"]?"selected":"").">{$o['text']}</option>";
			}
		

			$female_id_options = q("SELECT concat(name,' ',ifnull(lastname,'')) as text, id as value FROM users where sex='female' and status='ready'",[]);
			$female_id_options_html = "";
			foreach($female_id_options as $o)
			{
				$female_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["female_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$first_show_values = '[{"text":"парень", "value":"male"},{"text":"девушка", "value":"female"}]';

			$coordinator_id_options = q("SELECT name as text, id as value FROM coordinators",[]);
			$coordinator_id_options_html = "";
			foreach($coordinator_id_options as $o)
			{
				$coordinator_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["coordinator_id"]?"selected":"").">{$o['text']}</option>";
			}
		


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Свидания".' #'.$id.'</small></h1>
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

					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          

			<div class="form-group">
				<label class="control-label" for="textinput">Парень</label>
				<div>
					<select id="male_id" name="male_id" class="form-control input-md " >
						'.$male_id_options_html.'
						</select>
				</div>
			</div>

		

			<div class="form-group">
				<label class="control-label" for="textinput">Девушка</label>
				<div>
					<select id="female_id" name="female_id" class="form-control input-md " >
						'.$female_id_options_html.'
						</select>
				</div>
			</div>

		


					<div class="form-group">
						<label class="control-label" for="textinput">Дата</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="selects_options" '.($item["status"]=="selects_options"?"selected":"").'>Выбирает из нескольких вариантов</option> 
<option value="coordination_partner" '.($item["status"]=="coordination_partner"?"selected":"").'>Согласование с партнером</option> 
<option value="not_confirmed" '.($item["status"]=="not_confirmed"?"selected":"").'>Не подтвердилось</option> 
<option value="scheduled" '.($item["status"]=="scheduled"?"selected":"").'>Запланировано</option> 
<option value="successful" '.($item["status"]=="successful"?"selected":"").'>Прошло успешно</option> 
<option value="unsuccessful" '.($item["status"]=="unsuccessful"?"selected":"").'>Прошло неудачно</option> 
<option value="failed" '.($item["status"]=="failed"?"selected":"").'>Не состоялось</option> 
<option value="transferred" '.($item["status"]=="transferred"?"selected":"").'>Перенеслось</option> 

						</select>
					</div>
				</div>

			



            <div class="form-group">
              <label class="control-label" for="textinput">Сначала выбирает...</label>
              <div class="" >'.renderEditRadioGroup("first_show", $first_show_values, $item["first_show"]).'
              </div>
            </div>

          

			<div class="form-group">
				<label class="control-label" for="textinput">Координатор</label>
				<div>
					<select id="coordinator_id" name="coordinator_id" class="form-control input-md " >
						'.$coordinator_id_options_html.'
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
			qi("UPDATE `dates` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
		}


		die(json_encode(['status'=>0]));

	};

	$actions['create_execute'] = function()
	{
		$male_id = $_REQUEST['male_id'];
$female_id = $_REQUEST['female_id'];
$dt = $_REQUEST['dt'];
$status = $_REQUEST['status'];
$first_show = $_REQUEST['first_show'];
$coordinator_id = $_REQUEST['coordinator_id'];

		qi("INSERT INTO dates (`male_id`, `female_id`, `dt`, `status`, `first_show`, `coordinator_id`) VALUES (?, ?, ?, ?, ?, ?)", [$male_id, $female_id, $dt, $status, $first_show, $coordinator_id]);
		$last_id = qInsertId();

		

		header("Location: ".$_SERVER['HTTP_REFERER']);
		die("");

	};

	$actions['edit_execute'] = function()
	{
		$id = $_REQUEST['id'];
		$set = [];

		$set[] = is_null($_REQUEST['male_id'])?"`male_id`=NULL":"`male_id`='".addslashes($_REQUEST['male_id'])."'";
$set[] = is_null($_REQUEST['female_id'])?"`female_id`=NULL":"`female_id`='".addslashes($_REQUEST['female_id'])."'";
$set[] = is_null($_REQUEST['dt'])?"`dt`=NULL":"`dt`='".addslashes($_REQUEST['dt'])."'";
$set[] = is_null($_REQUEST['status'])?"`status`=NULL":"`status`='".addslashes($_REQUEST['status'])."'";
$set[] = is_null($_REQUEST['first_show'])?"`first_show`=NULL":"`first_show`='".addslashes($_REQUEST['first_show'])."'";
$set[] = is_null($_REQUEST['coordinator_id'])?"`coordinator_id`=NULL":"`coordinator_id`='".addslashes($_REQUEST['coordinator_id'])."'";

		if(count($set)>0)
		{
			$set = implode(", ", $set);
			qi("UPDATE dates SET $set WHERE id=?", [$id]);
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
			qi("DELETE FROM dates WHERE id=?", [$id]);
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
		
		if(isset2($_REQUEST['male_name_filter']))
		{
			$filters[] = "`male_name` LIKE '%{$_REQUEST['male_name_filter']}%'";
		}
				

		if(isset2($_REQUEST['dt_filter_from']) && isset2($_REQUEST['dt_filter_to']))
		{
			$filters[] = "dt >= '{$_REQUEST['dt_filter_from']}' AND dt <= '{$_REQUEST['dt_filter_to']}'";
		}

		

		if(isset2($_REQUEST['female_name_filter']))
		{
			$filters[] = "`female_name` LIKE '%{$_REQUEST['female_name_filter']}%'";
		}
				

		if(isset2($_REQUEST['status_filter']))
		{
			$filters[] = "`status` = '{$_REQUEST['status_filter']}'";
		}
				

		if(isset2($_REQUEST['coordinator_id_filter']))
		{
			$filters[] = "`coordinator_id` = '{$_REQUEST['coordinator_id_filter']}'";
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
		$status_values = '[{"text":"Выбирает из нескольких вариантов","value":"selects_options"},{"text":"Согласование с партнером","value":"coordination_partner"},{"text":"Не подтвердилось","value":"not_confirmed"},{"text":"Запланировано","value":"scheduled"},{"text":"Прошло успешно","value":"successful"},{"text":"Прошло неудачно","value":"unsuccessful"},{"text":"Не состоялось","value":"failed"},{"text":"Перенеслось","value":"transferred"}]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$first_show_values = '[{"text":"парень", "value":"male"},{"text":"девушка", "value":"female"}]';
			$first_show_values_text = "";
			foreach(json_decode($first_show_values, true) as $opt)
			{
			  $first_show_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  
$coordinator_id_values = json_encode(q("SELECT name as text, id as value FROM coordinators", []));
				  $coordinator_id_values_text = "";
			foreach(json_decode($coordinator_id_values, true) as $opt)
			{
			  $coordinator_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
		
		if(isset2($_REQUEST['male_name_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='male_name_filter' value='{$_REQUEST['male_name_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Парень: <b>{$_REQUEST['male_name_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['dt_filter_from']))
		{
			$from = date('d.m.Y', strtotime($_REQUEST['dt_filter_from']));
			$to = date('d.m.Y', strtotime($_REQUEST['dt_filter_to']));
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='dt_filter_from' value='{$_REQUEST['dt_filter_from']}'>
					<input type='hidden' class='filter' name='dt_filter_to' value='{$_REQUEST['dt_filter_to']}'>
					<span class='fa fa-times remove-tag'></span> Дата: <b>{$from}–{$to}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['female_name_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='female_name_filter' value='{$_REQUEST['female_name_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Девушка: <b>{$_REQUEST['female_name_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($status_values, true), function($i)
		{
			return $i['value']==$_REQUEST['status_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['status_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='status_filter' value='{$_REQUEST['status_filter']}'>
					<span class='fa fa-times remove-tag'></span> Статус: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($coordinator_id_values, true), function($i)
		{
			return $i['value']==$_REQUEST['coordinator_id_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['coordinator_id_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='coordinator_id_filter' value='{$_REQUEST['coordinator_id_filter']}'>
					<span class='fa fa-times remove-tag'></span> Координатор: <b>{$text_option}</b>
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


		
				$default_sort_by = 'dt';
				$default_sort_order = 'desc';
			

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
			$items = q("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM _dates_info main_table) temp $srch $filter $where $order LIMIT :start, :limit",
				[
					'start' => MAX(($_GET['page']-1), 0)*RPP,
					'limit' => RPP
				]);
			$cnt = qRows();
			$pagination = pagination($cnt);
		}
		else
		{
			$items = q("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM _dates_info main_table) temp $srch $filter $where $order", []);
			$cnt = qRows();
			$pagination = "";
		}



		return [$items, $pagination, $cnt];
	}

	

	$content = $actions[$action]();
	echo masterRender("Свидания", $content, 9);
