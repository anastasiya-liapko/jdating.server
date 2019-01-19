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
			
   		$sex_values = '[{"text":"Парень", "value":"male"},{"text":"Девушка", "value":"female"}]';
		$sex_values_text = "";
		foreach(json_decode($sex_values, true) as $opt)
		{
			$sex_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$has_giyur_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$has_giyur_values_text = "";
		foreach(json_decode($has_giyur_values, true) as $opt)
		{
			$has_giyur_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$status_values = '[{"text":"Новый","value":"new"},{"text":"Ожидание звонка","value":"waiting_for_call"},{"text":"Загружает документы через бота","value":"will_upload_documents"},{"text":"Привезет документы в офис","value":"will_bring_documents"},{"text":"Документы внесены нужно проверить","value":"documents_check"},{"text":"Подтвержденный","value":"confirmed"},{"text":"Ожидает заполнения координатором","value":"filled_by_coordinator"},{"text":"Готов к свиданиям","value":"ready"},{"text":"В отношениях","value":"in_relationship"},{"text":"Сделал хупу","value":"married"},{"text":"Отклоненный","value":"rejected"}]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$allow_processing_personal_data_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$allow_processing_personal_data_values_text = "";
		foreach(json_decode($allow_processing_personal_data_values, true) as $opt)
		{
			$allow_processing_personal_data_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$communication_method_values = '[ { "text": "email", "value": "email" }, { "text": "Мессенджер", "value": "bot" }, { "text": "Звонок", "value": "phone" }, { "text": "Встреча", "value": "meet" } ]';
		$communication_method_values_text = "";
		foreach(json_decode($communication_method_values, true) as $opt)
		{
			$communication_method_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['name']='asc';
$next_order['lastname']='asc';
$next_order['phone']='asc';
$next_order['age']='asc';
$next_order['sex']='asc';
$next_order['has_giyur']='asc';
$next_order['dt']='asc';
$next_order['status']='asc';
$next_order['']='asc';
$next_order['']='asc';
$next_order['']='asc';
$next_order['allow_processing_personal_data']='asc';
$next_order['communication_method']='asc';
$next_order['not_accept_in_partner']='asc';

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
					$(\'.big-icon\').html(\'<i class="fas fa-users"></i>\');
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
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Анкеты краткие".' </h2>
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
		"<div class='col-md-12 text-center'> 
	<div class='btn-group' role='group' aria-label='Users'>
	  <a href='users.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Все анкеты</a>
	  <a href='users_call.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Ждут звонка</a>
	  <a href='users_check.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Подтверждение документов</a>
	  <a href='users_without_dates.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Без свиданий</a>
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
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=lastname&sort_order='. ($next_order['lastname']) .'\' class=\'sort\' column=\'lastname\' sort_order=\''.$sort_order['lastname'].'\'>Фамилия'. $sort_icon['lastname'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=phone&sort_order='. ($next_order['phone']) .'\' class=\'sort\' column=\'phone\' sort_order=\''.$sort_order['phone'].'\'>Телефон'. $sort_icon['phone'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="phone_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=age&sort_order='. ($next_order['age']) .'\' class=\'sort\' column=\'age\' sort_order=\''.$sort_order['age'].'\'>Возраст'. $sort_icon['age'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=sex&sort_order='. ($next_order['sex']) .'\' class=\'sort\' column=\'sex\' sort_order=\''.$sort_order['sex'].'\'>Пол'. $sort_icon['sex'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="sex_filter">
							'. $sex_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=has_giyur&sort_order='. ($next_order['has_giyur']) .'\' class=\'sort\' column=\'has_giyur\' sort_order=\''.$sort_order['has_giyur'].'\'>Принял гиюр'. $sort_icon['has_giyur'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="has_giyur_filter">
							'. $has_giyur_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=dt&sort_order='. ($next_order['dt']) .'\' class=\'sort\' column=\'dt\' sort_order=\''.$sort_order['dt'].'\'>Дата регистрации'. $sort_icon['dt'].'</a>
					
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
				   Документы
			</th>

			<th>
				   Фото
			</th>

			<th>
				   Комментарии
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=allow_processing_personal_data&sort_order='. ($next_order['allow_processing_personal_data']) .'\' class=\'sort\' column=\'allow_processing_personal_data\' sort_order=\''.$sort_order['allow_processing_personal_data'].'\'>Согласие ПНД'. $sort_icon['allow_processing_personal_data'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="allow_processing_personal_data_filter">
							'. $allow_processing_personal_data_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=communication_method&sort_order='. ($next_order['communication_method']) .'\' class=\'sort\' column=\'communication_method\' sort_order=\''.$sort_order['communication_method'].'\'>Способ связи'. $sort_icon['communication_method'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="communication_method_filter">
							'. $communication_method_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=not_accept_in_partner&sort_order='. ($next_order['not_accept_in_partner']) .'\' class=\'sort\' column=\'not_accept_in_partner\' sort_order=\''.$sort_order['not_accept_in_partner'].'\'>Не приемлет в партнере'. $sort_icon['not_accept_in_partner'].'</a>
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
<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='lastname'>".htmlspecialchars($item['lastname'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='phone'>".htmlspecialchars($item['phone'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='number' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='age'>".htmlspecialchars($item['age'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($sex_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='sex'>".select_mapping($sex_values, $item['sex'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($has_giyur_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='has_giyur'>".select_mapping($has_giyur_values, $item['has_giyur'])."</span></td>
<td><span class='editable '  data-placeholder='' data-inp='date' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='dt'>".DateTime::createFromFormat('Y-m-d H:i:s', ($item['dt']?$item['dt']:"1970-01-01 00:00:00") )->format('Y-m-d H:i')."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($status_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='status'>".select_mapping($status_values, $item['status'])."</span></td>

		<td>
			<div class='text-center'>
				<a href='documents.php?user_id={$item["id"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-passport'></span> 
				</a>
			</div>
		</td>

		

		<td>
			<div class='text-center'>
				<a href='photos.php?user_id={$item["id"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-camera'></span> 
				</a>
			</div>
		</td>

		

		<td>
			<div class='text-center'>
				<a href='comments.php?user_id={$item["id"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-comments'></span> 
				</a>
			</div>
		</td>

		
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($allow_processing_personal_data_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='allow_processing_personal_data'>".select_mapping($allow_processing_personal_data_values, $item['allow_processing_personal_data'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($communication_method_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='communication_method'>".select_mapping($communication_method_values, $item['communication_method'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='not_accept_in_partner'>".htmlspecialchars($item['not_accept_in_partner'])."</span></td>
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
	<div class='btn-group' role='group' aria-label='Users'>
	  <a href='users.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Все анкеты</a>
	  <a href='users_call.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Ждут звонка</a>
	  <a href='users_check.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Подтверждение документов</a>
	  <a href='users_without_dates.php' class='btn btn-secondary active' style='background-color: #747D87' role='button' aria-pressed='true'>Без свиданий</a>
	</div> 
</div></div>".'';
		return $show;

	};

	$actions['edit'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM _users_info WHERE id=?",[$id]);
			$item = $item[0];
		}

		
			$coordinator_id_options = q("SELECT name as text, id as value FROM coordinators where role='coordinator'",[]);
			$coordinator_id_options_html = "";
			foreach($coordinator_id_options as $o)
			{
				$coordinator_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["coordinator_id"]?"selected":"").">{$o['text']}</option>";
			}
		

			$city_id_options = q("SELECT name as text, id as value FROM cities",[]);
			$city_id_options_html = "";
			foreach($city_id_options as $o)
			{
				$city_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["city_id"]?"selected":"").">{$o['text']}</option>";
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
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Фамилия</label>
									<div>
										<input id="lastname" name="lastname" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["lastname"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Телефон</label>
									<div>
										<input id="phone" name="phone" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["phone"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Возраст</label>
									<div>
										<input id="age" name="age" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["age"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Пол</label>
					<div>
						<select id="sex" name="sex" class="form-control input-md ">
							<option value="male" '.($item["sex"]=="male"?"selected":"").'>Парень</option> 
<option value="female" '.($item["sex"]=="female"?"selected":"").'>Девушка</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Принял гиюр</label>
					<div>
						<select id="has_giyur" name="has_giyur" class="form-control input-md ">
							<option value="1" '.($item["has_giyur"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["has_giyur"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Дата регистрации</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="waiting_for_call" '.($item["status"]=="waiting_for_call"?"selected":"").'>Ожидание звонка</option> 
<option value="will_upload_documents" '.($item["status"]=="will_upload_documents"?"selected":"").'>Загружает документы через бота</option> 
<option value="will_bring_documents" '.($item["status"]=="will_bring_documents"?"selected":"").'>Привезет документы в офис</option> 
<option value="documents_check" '.($item["status"]=="documents_check"?"selected":"").'>Документы внесены нужно проверить</option> 
<option value="confirmed" '.($item["status"]=="confirmed"?"selected":"").'>Подтвержденный</option> 
<option value="filled_by_coordinator" '.($item["status"]=="filled_by_coordinator"?"selected":"").'>Ожидает заполнения координатором</option> 
<option value="ready" '.($item["status"]=="ready"?"selected":"").'>Готов к свиданиям</option> 
<option value="in_relationship" '.($item["status"]=="in_relationship"?"selected":"").'>В отношениях</option> 
<option value="married" '.($item["status"]=="married"?"selected":"").'>Сделал хупу</option> 
<option value="rejected" '.($item["status"]=="rejected"?"selected":"").'>Отклоненный</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Согласие ПНД</label>
					<div>
						<select id="allow_processing_personal_data" name="allow_processing_personal_data" class="form-control input-md ">
							<option value="1" '.($item["allow_processing_personal_data"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["allow_processing_personal_data"]=="0"?"selected":"").'>Нет</option> 

						</select>
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

		



				<div class="form-group">
					<label class="control-label" for="textinput">Способ связи</label>
					<div>
						<select id="communication_method" name="communication_method" class="form-control input-md ">
							<option value="email" '.($item["communication_method"]=="email"?"selected":"").'>email</option> 
<option value="bot" '.($item["communication_method"]=="bot"?"selected":"").'>Мессенджер</option> 
<option value="phone" '.($item["communication_method"]=="phone"?"selected":"").'>Звонок</option> 
<option value="meet" '.($item["communication_method"]=="meet"?"selected":"").'>Встреча</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Пол координатора</label>
					<div>
						<select id="coordinator_gender" name="coordinator_gender" class="form-control input-md ">
							<option value="male" '.($item["coordinator_gender"]=="male"?"selected":"").'>Мужской</option> 
<option value="female" '.($item["coordinator_gender"]=="female"?"selected":"").'>Женский</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Ссылки соцсетей</label>
								<div>
									<textarea id="social_networks_links" name="social_networks_links" class="form-control input-md  "  >'.htmlspecialchars($item["social_networks_links"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Разрешить соцсети</label>
					<div>
						<select id="allow_show_social_networks_links" name="allow_show_social_networks_links" class="form-control input-md ">
							<option value="1" '.($item["allow_show_social_networks_links"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["allow_show_social_networks_links"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Дата рождения</label>
						<div>
							<input autocomplete="off" id="birthday" placeholder="" name="birthday" type="text" class="form-control datepicker "  value="'.(isset($item["birthday"])?$item["birthday"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				


								<div class="form-group">
									<label class="control-label" for="textinput">Город рождения</label>
									<div>
										<input id="city_born" name="city_born" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["city_born"]).'">
									</div>
								</div>

							

			<div class="form-group">
				<label class="control-label" for="textinput">Город проживания</label>
				<div>
					<select id="city_id" name="city_id" class="form-control input-md " >
						'.$city_id_options_html.'
						</select>
				</div>
			</div>

		



				<div class="form-group">
					<label class="control-label" for="textinput">Иногородние</label>
					<div>
						<select id="offers_other_cities" name="offers_other_cities" class="form-control input-md ">
							<option value="1" '.($item["offers_other_cities"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["offers_other_cities"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Образование</label>
					<div>
						<select id="education" name="education" class="form-control input-md ">
							<option value="secondary" '.($item["education"]=="secondary"?"selected":"").'>Среднее</option> 
<option value="unfinished_higher" '.($item["education"]=="unfinished_higher"?"selected":"").'>Незаконченное высшее</option> 
<option value="bachelor" '.($item["education"]=="bachelor"?"selected":"").'>Бакалавр</option> 
<option value="master" '.($item["education"]=="master"?"selected":"").'>Магистратура</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Где учился</label>
								<div>
									<textarea id="education_text" name="education_text" class="form-control input-md  "  >'.htmlspecialchars($item["education_text"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Русский</label>
					<div>
						<select id="speak_russian" name="speak_russian" class="form-control input-md ">
							<option value="1" '.($item["speak_russian"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["speak_russian"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Английский</label>
					<div>
						<select id="speak_english" name="speak_english" class="form-control input-md ">
							<option value="1" '.($item["speak_english"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["speak_english"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Иврит</label>
					<div>
						<select id="speak_hebrew" name="speak_hebrew" class="form-control input-md ">
							<option value="1" '.($item["speak_hebrew"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["speak_hebrew"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


								<div class="form-group">
									<label class="control-label" for="textinput">Другие языки</label>
									<div>
										<input id="other_languages" name="other_languages" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["other_languages"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Работает</label>
					<div>
						<select id="is_working_now" name="is_working_now" class="form-control input-md ">
							<option value="1" '.($item["is_working_now"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["is_working_now"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">О работе</label>
								<div>
									<textarea id="about_work" name="about_work" class="form-control input-md  "  >'.htmlspecialchars($item["about_work"]).'</textarea>
								</div>
							</div>

						


								<div class="form-group">
									<label class="control-label" for="textinput">Ежемесячные доход</label>
									<div>
										<input id="monthly_income" name="monthly_income" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["monthly_income"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Накопления</label>
									<div>
										<input id="amount_savings" name="amount_savings" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["amount_savings"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Недвижимость</label>
					<div>
						<select id="have_a_property" name="have_a_property" class="form-control input-md ">
							<option value="1" '.($item["have_a_property"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["have_a_property"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Хобби</label>
								<div>
									<textarea id="have_a_hobby" name="have_a_hobby" class="form-control input-md  "  >'.htmlspecialchars($item["have_a_hobby"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Планы</label>
					<div>
						<select id="plans_for_life" name="plans_for_life" class="form-control input-md ">
							<option value="find_a_friend" '.($item["plans_for_life"]=="find_a_friend"?"selected":"").'>Найти девушку</option> 
<option value="get_married" '.($item["plans_for_life"]=="get_married"?"selected":"").'>Создать семейную пару</option> 
<option value="have_children" '.($item["plans_for_life"]=="have_children"?"selected":"").'>Завести детей</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Спорт</label>
					<div>
						<select id="play_sports" name="play_sports" class="form-control input-md ">
							<option value="1" '.($item["play_sports"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["play_sports"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Соблюдаете шаббат</label>
					<div>
						<select id="keep_shabbat" name="keep_shabbat" class="form-control input-md ">
							<option value="1" '.($item["keep_shabbat"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["keep_shabbat"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Кашрут?</label>
					<div>
						<select id="keep_kosher" name="keep_kosher" class="form-control input-md ">
							<option value="1" '.($item["keep_kosher"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["keep_kosher"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Ходите в синагогу?</label>
					<div>
						<select id="go_to_synagogue" name="go_to_synagogue" class="form-control input-md ">
							<option value="1" '.($item["go_to_synagogue"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["go_to_synagogue"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Цниют</label>
					<div>
						<select id="keep_tsniyut" name="keep_tsniyut" class="form-control input-md ">
							<option value="1" '.($item["keep_tsniyut"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["keep_tsniyut"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Брит мила</label>
					<div>
						<select id="did_brit_mila" name="did_brit_mila" class="form-control input-md ">
							<option value="1" '.($item["did_brit_mila"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["did_brit_mila"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Тфилин</label>
					<div>
						<select id="apply_tefillin" name="apply_tefillin" class="form-control input-md ">
							<option value="1" '.($item["apply_tefillin"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["apply_tefillin"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Шаббатние свечи</label>
					<div>
						<select id="light_shabbat_candles" name="light_shabbat_candles" class="form-control input-md ">
							<option value="1" '.($item["light_shabbat_candles"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["light_shabbat_candles"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Еврейская "Ориентация"</label>
					<div>
						<select id="religious_views" name="religious_views" class="form-control input-md ">
							<option value="traditional" '.($item["religious_views"]=="traditional"?"selected":"").'>Традиционая</option> 
<option value="orthodox" '.($item["religious_views"]=="orthodox"?"selected":"").'>Ортодоксальная</option> 
<option value="reform" '.($item["religious_views"]=="reform"?"selected":"").'>Реформистская</option> 
<option value="militant_atheist" '.($item["religious_views"]=="militant_atheist"?"selected":"").'>Воинствуюший атеист</option> 
<option value="i_observe_a_little" '.($item["religious_views"]=="i_observe_a_little"?"selected":"").'>Немного соблюдаю</option> 
<option value="kosher_style" '.($item["religious_views"]=="kosher_style"?"selected":"").'>Кошер-стайл</option> 

						</select>
					</div>
				</div>

			


								<div class="form-group">
									<label class="control-label" for="textinput">Еврейские организации</label>
									<div>
										<input id="jewish_organizations" name="jewish_organizations" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["jewish_organizations"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Три достоинства</label>
								<div>
									<textarea id="your_three_virtues" name="your_three_virtues" class="form-control input-md  "  >'.htmlspecialchars($item["your_three_virtues"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Три недостатка</label>
								<div>
									<textarea id="your_three_faults" name="your_three_faults" class="form-control input-md  "  >'.htmlspecialchars($item["your_three_faults"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">О партнере</label>
								<div>
									<textarea id="about_partner" name="about_partner" class="form-control input-md  "  >'.htmlspecialchars($item["about_partner"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Не приемлет в партнере</label>
								<div>
									<textarea id="not_accept_in_partner" name="not_accept_in_partner" class="form-control input-md  "  >'.htmlspecialchars($item["not_accept_in_partner"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Еврейское имя</label>
					<div>
						<select id="jewish_name" name="jewish_name" class="form-control input-md ">
							<option value="1" '.($item["jewish_name"]=="1"?"selected":"").'>Есть</option> 
<option value="0" '.($item["jewish_name"]=="0"?"selected":"").'>Нет</option> 

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
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Фамилия</label>
									<div>
										<input id="lastname" name="lastname" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["lastname"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Телефон</label>
									<div>
										<input id="phone" name="phone" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["phone"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Возраст</label>
									<div>
										<input id="age" name="age" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["age"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Пол</label>
					<div>
						<select id="sex" name="sex" class="form-control input-md ">
							<option value="male" '.($item["sex"]=="male"?"selected":"").'>Парень</option> 
<option value="female" '.($item["sex"]=="female"?"selected":"").'>Девушка</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Принял гиюр</label>
					<div>
						<select id="has_giyur" name="has_giyur" class="form-control input-md ">
							<option value="1" '.($item["has_giyur"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["has_giyur"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Дата регистрации</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="waiting_for_call" '.($item["status"]=="waiting_for_call"?"selected":"").'>Ожидание звонка</option> 
<option value="will_upload_documents" '.($item["status"]=="will_upload_documents"?"selected":"").'>Загружает документы через бота</option> 
<option value="will_bring_documents" '.($item["status"]=="will_bring_documents"?"selected":"").'>Привезет документы в офис</option> 
<option value="documents_check" '.($item["status"]=="documents_check"?"selected":"").'>Документы внесены нужно проверить</option> 
<option value="confirmed" '.($item["status"]=="confirmed"?"selected":"").'>Подтвержденный</option> 
<option value="filled_by_coordinator" '.($item["status"]=="filled_by_coordinator"?"selected":"").'>Ожидает заполнения координатором</option> 
<option value="ready" '.($item["status"]=="ready"?"selected":"").'>Готов к свиданиям</option> 
<option value="in_relationship" '.($item["status"]=="in_relationship"?"selected":"").'>В отношениях</option> 
<option value="married" '.($item["status"]=="married"?"selected":"").'>Сделал хупу</option> 
<option value="rejected" '.($item["status"]=="rejected"?"selected":"").'>Отклоненный</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Согласие ПНД</label>
					<div>
						<select id="allow_processing_personal_data" name="allow_processing_personal_data" class="form-control input-md ">
							<option value="1" '.($item["allow_processing_personal_data"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["allow_processing_personal_data"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Способ связи</label>
					<div>
						<select id="communication_method" name="communication_method" class="form-control input-md ">
							<option value="email" '.($item["communication_method"]=="email"?"selected":"").'>email</option> 
<option value="bot" '.($item["communication_method"]=="bot"?"selected":"").'>Мессенджер</option> 
<option value="phone" '.($item["communication_method"]=="phone"?"selected":"").'>Звонок</option> 
<option value="meet" '.($item["communication_method"]=="meet"?"selected":"").'>Встреча</option> 

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
			$item = q("SELECT * FROM _users_info WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		
			$coordinator_id_options = q("SELECT name as text, id as value FROM coordinators where role='coordinator'",[]);
			$coordinator_id_options_html = "";
			foreach($coordinator_id_options as $o)
			{
				$coordinator_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["coordinator_id"]?"selected":"").">{$o['text']}</option>";
			}
		

			$city_id_options = q("SELECT name as text, id as value FROM cities",[]);
			$city_id_options_html = "";
			foreach($city_id_options as $o)
			{
				$city_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["city_id"]?"selected":"").">{$o['text']}</option>";
			}
		


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Анкеты краткие".' #'.$id.'</small></h1>
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
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Фамилия</label>
									<div>
										<input id="lastname" name="lastname" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["lastname"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Телефон</label>
									<div>
										<input id="phone" name="phone" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["phone"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Возраст</label>
									<div>
										<input id="age" name="age" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["age"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Пол</label>
					<div>
						<select id="sex" name="sex" class="form-control input-md ">
							<option value="male" '.($item["sex"]=="male"?"selected":"").'>Парень</option> 
<option value="female" '.($item["sex"]=="female"?"selected":"").'>Девушка</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Принял гиюр</label>
					<div>
						<select id="has_giyur" name="has_giyur" class="form-control input-md ">
							<option value="1" '.($item["has_giyur"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["has_giyur"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Дата регистрации</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="waiting_for_call" '.($item["status"]=="waiting_for_call"?"selected":"").'>Ожидание звонка</option> 
<option value="will_upload_documents" '.($item["status"]=="will_upload_documents"?"selected":"").'>Загружает документы через бота</option> 
<option value="will_bring_documents" '.($item["status"]=="will_bring_documents"?"selected":"").'>Привезет документы в офис</option> 
<option value="documents_check" '.($item["status"]=="documents_check"?"selected":"").'>Документы внесены нужно проверить</option> 
<option value="confirmed" '.($item["status"]=="confirmed"?"selected":"").'>Подтвержденный</option> 
<option value="filled_by_coordinator" '.($item["status"]=="filled_by_coordinator"?"selected":"").'>Ожидает заполнения координатором</option> 
<option value="ready" '.($item["status"]=="ready"?"selected":"").'>Готов к свиданиям</option> 
<option value="in_relationship" '.($item["status"]=="in_relationship"?"selected":"").'>В отношениях</option> 
<option value="married" '.($item["status"]=="married"?"selected":"").'>Сделал хупу</option> 
<option value="rejected" '.($item["status"]=="rejected"?"selected":"").'>Отклоненный</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Согласие ПНД</label>
					<div>
						<select id="allow_processing_personal_data" name="allow_processing_personal_data" class="form-control input-md ">
							<option value="1" '.($item["allow_processing_personal_data"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["allow_processing_personal_data"]=="0"?"selected":"").'>Нет</option> 

						</select>
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

		



				<div class="form-group">
					<label class="control-label" for="textinput">Способ связи</label>
					<div>
						<select id="communication_method" name="communication_method" class="form-control input-md ">
							<option value="email" '.($item["communication_method"]=="email"?"selected":"").'>email</option> 
<option value="bot" '.($item["communication_method"]=="bot"?"selected":"").'>Мессенджер</option> 
<option value="phone" '.($item["communication_method"]=="phone"?"selected":"").'>Звонок</option> 
<option value="meet" '.($item["communication_method"]=="meet"?"selected":"").'>Встреча</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Пол координатора</label>
					<div>
						<select id="coordinator_gender" name="coordinator_gender" class="form-control input-md ">
							<option value="male" '.($item["coordinator_gender"]=="male"?"selected":"").'>Мужской</option> 
<option value="female" '.($item["coordinator_gender"]=="female"?"selected":"").'>Женский</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Ссылки соцсетей</label>
								<div>
									<textarea id="social_networks_links" name="social_networks_links" class="form-control input-md  "  >'.htmlspecialchars($item["social_networks_links"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Разрешить соцсети</label>
					<div>
						<select id="allow_show_social_networks_links" name="allow_show_social_networks_links" class="form-control input-md ">
							<option value="1" '.($item["allow_show_social_networks_links"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["allow_show_social_networks_links"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Дата рождения</label>
						<div>
							<input autocomplete="off" id="birthday" placeholder="" name="birthday" type="text" class="form-control datepicker "  value="'.(isset($item["birthday"])?$item["birthday"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				


								<div class="form-group">
									<label class="control-label" for="textinput">Город рождения</label>
									<div>
										<input id="city_born" name="city_born" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["city_born"]).'">
									</div>
								</div>

							

			<div class="form-group">
				<label class="control-label" for="textinput">Город проживания</label>
				<div>
					<select id="city_id" name="city_id" class="form-control input-md " >
						'.$city_id_options_html.'
						</select>
				</div>
			</div>

		



				<div class="form-group">
					<label class="control-label" for="textinput">Иногородние</label>
					<div>
						<select id="offers_other_cities" name="offers_other_cities" class="form-control input-md ">
							<option value="1" '.($item["offers_other_cities"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["offers_other_cities"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Образование</label>
					<div>
						<select id="education" name="education" class="form-control input-md ">
							<option value="secondary" '.($item["education"]=="secondary"?"selected":"").'>Среднее</option> 
<option value="unfinished_higher" '.($item["education"]=="unfinished_higher"?"selected":"").'>Незаконченное высшее</option> 
<option value="bachelor" '.($item["education"]=="bachelor"?"selected":"").'>Бакалавр</option> 
<option value="master" '.($item["education"]=="master"?"selected":"").'>Магистратура</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Где учился</label>
								<div>
									<textarea id="education_text" name="education_text" class="form-control input-md  "  >'.htmlspecialchars($item["education_text"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Русский</label>
					<div>
						<select id="speak_russian" name="speak_russian" class="form-control input-md ">
							<option value="1" '.($item["speak_russian"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["speak_russian"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Английский</label>
					<div>
						<select id="speak_english" name="speak_english" class="form-control input-md ">
							<option value="1" '.($item["speak_english"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["speak_english"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Иврит</label>
					<div>
						<select id="speak_hebrew" name="speak_hebrew" class="form-control input-md ">
							<option value="1" '.($item["speak_hebrew"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["speak_hebrew"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


								<div class="form-group">
									<label class="control-label" for="textinput">Другие языки</label>
									<div>
										<input id="other_languages" name="other_languages" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["other_languages"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Работает</label>
					<div>
						<select id="is_working_now" name="is_working_now" class="form-control input-md ">
							<option value="1" '.($item["is_working_now"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["is_working_now"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">О работе</label>
								<div>
									<textarea id="about_work" name="about_work" class="form-control input-md  "  >'.htmlspecialchars($item["about_work"]).'</textarea>
								</div>
							</div>

						


								<div class="form-group">
									<label class="control-label" for="textinput">Ежемесячные доход</label>
									<div>
										<input id="monthly_income" name="monthly_income" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["monthly_income"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Накопления</label>
									<div>
										<input id="amount_savings" name="amount_savings" type="number" placeholder="" class="form-control input-md "  value="'.htmlspecialchars($item["amount_savings"]).'">
									</div>
								</div>

							



				<div class="form-group">
					<label class="control-label" for="textinput">Недвижимость</label>
					<div>
						<select id="have_a_property" name="have_a_property" class="form-control input-md ">
							<option value="1" '.($item["have_a_property"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["have_a_property"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Хобби</label>
								<div>
									<textarea id="have_a_hobby" name="have_a_hobby" class="form-control input-md  "  >'.htmlspecialchars($item["have_a_hobby"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Планы</label>
					<div>
						<select id="plans_for_life" name="plans_for_life" class="form-control input-md ">
							<option value="find_a_friend" '.($item["plans_for_life"]=="find_a_friend"?"selected":"").'>Найти девушку</option> 
<option value="get_married" '.($item["plans_for_life"]=="get_married"?"selected":"").'>Создать семейную пару</option> 
<option value="have_children" '.($item["plans_for_life"]=="have_children"?"selected":"").'>Завести детей</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Спорт</label>
					<div>
						<select id="play_sports" name="play_sports" class="form-control input-md ">
							<option value="1" '.($item["play_sports"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["play_sports"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Соблюдаете шаббат</label>
					<div>
						<select id="keep_shabbat" name="keep_shabbat" class="form-control input-md ">
							<option value="1" '.($item["keep_shabbat"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["keep_shabbat"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Кашрут?</label>
					<div>
						<select id="keep_kosher" name="keep_kosher" class="form-control input-md ">
							<option value="1" '.($item["keep_kosher"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["keep_kosher"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Ходите в синагогу?</label>
					<div>
						<select id="go_to_synagogue" name="go_to_synagogue" class="form-control input-md ">
							<option value="1" '.($item["go_to_synagogue"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["go_to_synagogue"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Цниют</label>
					<div>
						<select id="keep_tsniyut" name="keep_tsniyut" class="form-control input-md ">
							<option value="1" '.($item["keep_tsniyut"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["keep_tsniyut"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Брит мила</label>
					<div>
						<select id="did_brit_mila" name="did_brit_mila" class="form-control input-md ">
							<option value="1" '.($item["did_brit_mila"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["did_brit_mila"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Тфилин</label>
					<div>
						<select id="apply_tefillin" name="apply_tefillin" class="form-control input-md ">
							<option value="1" '.($item["apply_tefillin"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["apply_tefillin"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Шаббатние свечи</label>
					<div>
						<select id="light_shabbat_candles" name="light_shabbat_candles" class="form-control input-md ">
							<option value="1" '.($item["light_shabbat_candles"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["light_shabbat_candles"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Еврейская "Ориентация"</label>
					<div>
						<select id="religious_views" name="religious_views" class="form-control input-md ">
							<option value="traditional" '.($item["religious_views"]=="traditional"?"selected":"").'>Традиционая</option> 
<option value="orthodox" '.($item["religious_views"]=="orthodox"?"selected":"").'>Ортодоксальная</option> 
<option value="reform" '.($item["religious_views"]=="reform"?"selected":"").'>Реформистская</option> 
<option value="militant_atheist" '.($item["religious_views"]=="militant_atheist"?"selected":"").'>Воинствуюший атеист</option> 
<option value="i_observe_a_little" '.($item["religious_views"]=="i_observe_a_little"?"selected":"").'>Немного соблюдаю</option> 
<option value="kosher_style" '.($item["religious_views"]=="kosher_style"?"selected":"").'>Кошер-стайл</option> 

						</select>
					</div>
				</div>

			


								<div class="form-group">
									<label class="control-label" for="textinput">Еврейские организации</label>
									<div>
										<input id="jewish_organizations" name="jewish_organizations" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["jewish_organizations"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Три достоинства</label>
								<div>
									<textarea id="your_three_virtues" name="your_three_virtues" class="form-control input-md  "  >'.htmlspecialchars($item["your_three_virtues"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Три недостатка</label>
								<div>
									<textarea id="your_three_faults" name="your_three_faults" class="form-control input-md  "  >'.htmlspecialchars($item["your_three_faults"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">О партнере</label>
								<div>
									<textarea id="about_partner" name="about_partner" class="form-control input-md  "  >'.htmlspecialchars($item["about_partner"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Не приемлет в партнере</label>
								<div>
									<textarea id="not_accept_in_partner" name="not_accept_in_partner" class="form-control input-md  "  >'.htmlspecialchars($item["not_accept_in_partner"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Еврейское имя</label>
					<div>
						<select id="jewish_name" name="jewish_name" class="form-control input-md ">
							<option value="1" '.($item["jewish_name"]=="1"?"selected":"").'>Есть</option> 
<option value="0" '.($item["jewish_name"]=="0"?"selected":"").'>Нет</option> 

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
			qi("UPDATE `users` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
		}


		die(json_encode(['status'=>0]));

	};

	$actions['create_execute'] = function()
	{
		$name = $_REQUEST['name'];
$lastname = $_REQUEST['lastname'];
$phone = $_REQUEST['phone'];
$age = $_REQUEST['age'];
$sex = $_REQUEST['sex'];
$has_giyur = $_REQUEST['has_giyur'];
$dt = $_REQUEST['dt'];
$status = $_REQUEST['status'];
$allow_processing_personal_data = $_REQUEST['allow_processing_personal_data'];
$communication_method = $_REQUEST['communication_method'];

		qi("INSERT INTO users (`name`, `lastname`, `phone`, `age`, `sex`, `has_giyur`, `dt`, `status`, `allow_processing_personal_data`, `communication_method`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $lastname, $phone, $age, $sex, $has_giyur, $dt, $status, $allow_processing_personal_data, $communication_method]);
		$last_id = qInsertId();

		

		header("Location: ".$_SERVER['HTTP_REFERER']);
		die("");

	};

	$actions['edit_execute'] = function()
	{
		$id = $_REQUEST['id'];
		$set = [];

		$set[] = is_null($_REQUEST['name'])?"`name`=NULL":"`name`='".addslashes($_REQUEST['name'])."'";
$set[] = is_null($_REQUEST['lastname'])?"`lastname`=NULL":"`lastname`='".addslashes($_REQUEST['lastname'])."'";
$set[] = is_null($_REQUEST['phone'])?"`phone`=NULL":"`phone`='".addslashes($_REQUEST['phone'])."'";
$set[] = is_null($_REQUEST['sex'])?"`sex`=NULL":"`sex`='".addslashes($_REQUEST['sex'])."'";
$set[] = is_null($_REQUEST['has_giyur'])?"`has_giyur`=NULL":"`has_giyur`='".addslashes($_REQUEST['has_giyur'])."'";
$set[] = is_null($_REQUEST['dt'])?"`dt`=NULL":"`dt`='".addslashes($_REQUEST['dt'])."'";
$set[] = is_null($_REQUEST['status'])?"`status`=NULL":"`status`='".addslashes($_REQUEST['status'])."'";
$set[] = is_null($_REQUEST['allow_processing_personal_data'])?"`allow_processing_personal_data`=NULL":"`allow_processing_personal_data`='".addslashes($_REQUEST['allow_processing_personal_data'])."'";
$set[] = is_null($_REQUEST['coordinator_id'])?"`coordinator_id`=NULL":"`coordinator_id`='".addslashes($_REQUEST['coordinator_id'])."'";
$set[] = is_null($_REQUEST['communication_method'])?"`communication_method`=NULL":"`communication_method`='".addslashes($_REQUEST['communication_method'])."'";
$set[] = is_null($_REQUEST['coordinator_gender'])?"`coordinator_gender`=NULL":"`coordinator_gender`='".addslashes($_REQUEST['coordinator_gender'])."'";
$set[] = is_null($_REQUEST['social_networks_links'])?"`social_networks_links`=NULL":"`social_networks_links`='".addslashes($_REQUEST['social_networks_links'])."'";
$set[] = is_null($_REQUEST['allow_show_social_networks_links'])?"`allow_show_social_networks_links`=NULL":"`allow_show_social_networks_links`='".addslashes($_REQUEST['allow_show_social_networks_links'])."'";
$set[] = is_null($_REQUEST['birthday'])?"`birthday`=NULL":"`birthday`='".addslashes($_REQUEST['birthday'])."'";
$set[] = is_null($_REQUEST['city_born'])?"`city_born`=NULL":"`city_born`='".addslashes($_REQUEST['city_born'])."'";
$set[] = is_null($_REQUEST['city_id'])?"`city_id`=NULL":"`city_id`='".addslashes($_REQUEST['city_id'])."'";
$set[] = is_null($_REQUEST['offers_other_cities'])?"`offers_other_cities`=NULL":"`offers_other_cities`='".addslashes($_REQUEST['offers_other_cities'])."'";
$set[] = is_null($_REQUEST['education'])?"`education`=NULL":"`education`='".addslashes($_REQUEST['education'])."'";
$set[] = is_null($_REQUEST['education_text'])?"`education_text`=NULL":"`education_text`='".addslashes($_REQUEST['education_text'])."'";
$set[] = is_null($_REQUEST['speak_russian'])?"`speak_russian`=NULL":"`speak_russian`='".addslashes($_REQUEST['speak_russian'])."'";
$set[] = is_null($_REQUEST['speak_english'])?"`speak_english`=NULL":"`speak_english`='".addslashes($_REQUEST['speak_english'])."'";
$set[] = is_null($_REQUEST['speak_hebrew'])?"`speak_hebrew`=NULL":"`speak_hebrew`='".addslashes($_REQUEST['speak_hebrew'])."'";
$set[] = is_null($_REQUEST['other_languages'])?"`other_languages`=NULL":"`other_languages`='".addslashes($_REQUEST['other_languages'])."'";
$set[] = is_null($_REQUEST['is_working_now'])?"`is_working_now`=NULL":"`is_working_now`='".addslashes($_REQUEST['is_working_now'])."'";
$set[] = is_null($_REQUEST['about_work'])?"`about_work`=NULL":"`about_work`='".addslashes($_REQUEST['about_work'])."'";
$set[] = is_null($_REQUEST['have_a_property'])?"`have_a_property`=NULL":"`have_a_property`='".addslashes($_REQUEST['have_a_property'])."'";
$set[] = is_null($_REQUEST['have_a_hobby'])?"`have_a_hobby`=NULL":"`have_a_hobby`='".addslashes($_REQUEST['have_a_hobby'])."'";
$set[] = is_null($_REQUEST['plans_for_life'])?"`plans_for_life`=NULL":"`plans_for_life`='".addslashes($_REQUEST['plans_for_life'])."'";
$set[] = is_null($_REQUEST['play_sports'])?"`play_sports`=NULL":"`play_sports`='".addslashes($_REQUEST['play_sports'])."'";
$set[] = is_null($_REQUEST['keep_shabbat'])?"`keep_shabbat`=NULL":"`keep_shabbat`='".addslashes($_REQUEST['keep_shabbat'])."'";
$set[] = is_null($_REQUEST['keep_kosher'])?"`keep_kosher`=NULL":"`keep_kosher`='".addslashes($_REQUEST['keep_kosher'])."'";
$set[] = is_null($_REQUEST['go_to_synagogue'])?"`go_to_synagogue`=NULL":"`go_to_synagogue`='".addslashes($_REQUEST['go_to_synagogue'])."'";
$set[] = is_null($_REQUEST['keep_tsniyut'])?"`keep_tsniyut`=NULL":"`keep_tsniyut`='".addslashes($_REQUEST['keep_tsniyut'])."'";
$set[] = is_null($_REQUEST['did_brit_mila'])?"`did_brit_mila`=NULL":"`did_brit_mila`='".addslashes($_REQUEST['did_brit_mila'])."'";
$set[] = is_null($_REQUEST['apply_tefillin'])?"`apply_tefillin`=NULL":"`apply_tefillin`='".addslashes($_REQUEST['apply_tefillin'])."'";
$set[] = is_null($_REQUEST['light_shabbat_candles'])?"`light_shabbat_candles`=NULL":"`light_shabbat_candles`='".addslashes($_REQUEST['light_shabbat_candles'])."'";
$set[] = is_null($_REQUEST['religious_views'])?"`religious_views`=NULL":"`religious_views`='".addslashes($_REQUEST['religious_views'])."'";
$set[] = is_null($_REQUEST['jewish_organizations'])?"`jewish_organizations`=NULL":"`jewish_organizations`='".addslashes($_REQUEST['jewish_organizations'])."'";
$set[] = is_null($_REQUEST['your_three_virtues'])?"`your_three_virtues`=NULL":"`your_three_virtues`='".addslashes($_REQUEST['your_three_virtues'])."'";
$set[] = is_null($_REQUEST['your_three_faults'])?"`your_three_faults`=NULL":"`your_three_faults`='".addslashes($_REQUEST['your_three_faults'])."'";
$set[] = is_null($_REQUEST['about_partner'])?"`about_partner`=NULL":"`about_partner`='".addslashes($_REQUEST['about_partner'])."'";
$set[] = is_null($_REQUEST['not_accept_in_partner'])?"`not_accept_in_partner`=NULL":"`not_accept_in_partner`='".addslashes($_REQUEST['not_accept_in_partner'])."'";
$set[] = is_null($_REQUEST['jewish_name'])?"`jewish_name`=NULL":"`jewish_name`='".addslashes($_REQUEST['jewish_name'])."'";

		if(count($set)>0)
		{
			$set = implode(", ", $set);
			qi("UPDATE users SET $set WHERE id=?", [$id]);
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
			qi("DELETE FROM users WHERE id=?", [$id]);
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
				

		if(isset2($_REQUEST['phone_filter']))
		{
			$filters[] = "`phone` LIKE '%{$_REQUEST['phone_filter']}%'";
		}
				

		if(isset2($_REQUEST['sex_filter']))
		{
			$filters[] = "`sex` = '{$_REQUEST['sex_filter']}'";
		}
				

		if(isset2($_REQUEST['has_giyur_filter']))
		{
			$filters[] = "`has_giyur` = '{$_REQUEST['has_giyur_filter']}'";
		}
				

		if(isset2($_REQUEST['dt_filter_from']) && isset2($_REQUEST['dt_filter_to']))
		{
			$filters[] = "dt >= '{$_REQUEST['dt_filter_from']}' AND dt <= '{$_REQUEST['dt_filter_to']}'";
		}

		

		if(isset2($_REQUEST['status_filter']))
		{
			$filters[] = "`status` = '{$_REQUEST['status_filter']}'";
		}
				

		if(isset2($_REQUEST['allow_processing_personal_data_filter']))
		{
			$filters[] = "`allow_processing_personal_data` = '{$_REQUEST['allow_processing_personal_data_filter']}'";
		}
				

		if(isset2($_REQUEST['communication_method_filter']))
		{
			$filters[] = "`communication_method` = '{$_REQUEST['communication_method_filter']}'";
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
		$sex_values = '[{"text":"Парень", "value":"male"},{"text":"Девушка", "value":"female"}]';
		$sex_values_text = "";
		foreach(json_decode($sex_values, true) as $opt)
		{
			$sex_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$has_giyur_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$has_giyur_values_text = "";
		foreach(json_decode($has_giyur_values, true) as $opt)
		{
			$has_giyur_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$status_values = '[{"text":"Новый","value":"new"},{"text":"Ожидание звонка","value":"waiting_for_call"},{"text":"Загружает документы через бота","value":"will_upload_documents"},{"text":"Привезет документы в офис","value":"will_bring_documents"},{"text":"Документы внесены нужно проверить","value":"documents_check"},{"text":"Подтвержденный","value":"confirmed"},{"text":"Ожидает заполнения координатором","value":"filled_by_coordinator"},{"text":"Готов к свиданиям","value":"ready"},{"text":"В отношениях","value":"in_relationship"},{"text":"Сделал хупу","value":"married"},{"text":"Отклоненный","value":"rejected"}]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$allow_processing_personal_data_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$allow_processing_personal_data_values_text = "";
		foreach(json_decode($allow_processing_personal_data_values, true) as $opt)
		{
			$allow_processing_personal_data_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$communication_method_values = '[ { "text": "email", "value": "email" }, { "text": "Мессенджер", "value": "bot" }, { "text": "Звонок", "value": "phone" }, { "text": "Встреча", "value": "meet" } ]';
		$communication_method_values_text = "";
		foreach(json_decode($communication_method_values, true) as $opt)
		{
			$communication_method_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
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

		

		if(isset2($_REQUEST['phone_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='phone_filter' value='{$_REQUEST['phone_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Телефон: <b>{$_REQUEST['phone_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($sex_values, true), function($i)
		{
			return $i['value']==$_REQUEST['sex_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['sex_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='sex_filter' value='{$_REQUEST['sex_filter']}'>
					<span class='fa fa-times remove-tag'></span> Пол: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($has_giyur_values, true), function($i)
		{
			return $i['value']==$_REQUEST['has_giyur_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['has_giyur_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='has_giyur_filter' value='{$_REQUEST['has_giyur_filter']}'>
					<span class='fa fa-times remove-tag'></span> Принял гиюр: <b>{$text_option}</b>
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
					<span class='fa fa-times remove-tag'></span> Дата регистрации: <b>{$from}–{$to}</b>
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
				

		$text_option = array_filter(json_decode($allow_processing_personal_data_values, true), function($i)
		{
			return $i['value']==$_REQUEST['allow_processing_personal_data_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['allow_processing_personal_data_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='allow_processing_personal_data_filter' value='{$_REQUEST['allow_processing_personal_data_filter']}'>
					<span class='fa fa-times remove-tag'></span> Согласие ПНД: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($communication_method_values, true), function($i)
		{
			return $i['value']==$_REQUEST['communication_method_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['communication_method_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='communication_method_filter' value='{$_REQUEST['communication_method_filter']}'>
					<span class='fa fa-times remove-tag'></span> Способ связи: <b>{$text_option}</b>
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
			$items = q("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM _users_info main_table) temp $srch $filter $where $order LIMIT :start, :limit",
				[
					'start' => MAX(($_GET['page']-1), 0)*RPP,
					'limit' => RPP
				]);
			$cnt = qRows();
			$pagination = pagination($cnt);
		}
		else
		{
			$items = q("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM _users_info main_table) temp $srch $filter $where $order", []);
			$cnt = qRows();
			$pagination = "";
		}



		return [$items, $pagination, $cnt];
	}

	

	$content = $actions[$action]();
	echo masterRender("Анкеты краткие", $content, 5);
