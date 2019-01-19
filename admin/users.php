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

		
$coordinator_id_values = json_encode(q("SELECT name as text, id as value FROM coordinators where role='coordinator'", []));
				  $coordinator_id_values_text = "";
			foreach(json_decode($coordinator_id_values, true) as $opt)
			{
			  $coordinator_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
$communication_method_values = '[ { "text": "email", "value": "email" }, { "text": "Мессенджер", "value": "bot" }, { "text": "Звонок", "value": "phone" }, { "text": "Встреча", "value": "meet" } ]';
		$communication_method_values_text = "";
		foreach(json_decode($communication_method_values, true) as $opt)
		{
			$communication_method_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$coordinator_gender_values = '[ { "text": "Мужской", "value": "male" }, { "text": "Женский", "value": "female" } ]';
		$coordinator_gender_values_text = "";
		foreach(json_decode($coordinator_gender_values, true) as $opt)
		{
			$coordinator_gender_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$allow_show_social_networks_links_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$allow_show_social_networks_links_values_text = "";
		foreach(json_decode($allow_show_social_networks_links_values, true) as $opt)
		{
			$allow_show_social_networks_links_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$offers_other_cities_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$offers_other_cities_values_text = "";
		foreach(json_decode($offers_other_cities_values, true) as $opt)
		{
			$offers_other_cities_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$education_values = '[ { "text": "Среднее", "value": "secondary" }, { "text": "Незаконченное высшее", "value": "unfinished_higher" }, { "text": "Бакалавр", "value": "bachelor" }, { "text": "Магистратура", "value": "master" } ]';
		$education_values_text = "";
		foreach(json_decode($education_values, true) as $opt)
		{
			$education_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$speak_russian_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$speak_russian_values_text = "";
		foreach(json_decode($speak_russian_values, true) as $opt)
		{
			$speak_russian_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$speak_english_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$speak_english_values_text = "";
		foreach(json_decode($speak_english_values, true) as $opt)
		{
			$speak_english_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$speak_hebrew_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$speak_hebrew_values_text = "";
		foreach(json_decode($speak_hebrew_values, true) as $opt)
		{
			$speak_hebrew_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$is_working_now_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$is_working_now_values_text = "";
		foreach(json_decode($is_working_now_values, true) as $opt)
		{
			$is_working_now_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$have_a_property_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$have_a_property_values_text = "";
		foreach(json_decode($have_a_property_values, true) as $opt)
		{
			$have_a_property_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$plans_for_life_values = '[ { "text": "Найти девушку", "value": "find_a_friend" }, { "text": "Создать семейную пару", "value": "get_married" }, { "text": "Завести детей", "value": "have_children" } ]';
		$plans_for_life_values_text = "";
		foreach(json_decode($plans_for_life_values, true) as $opt)
		{
			$plans_for_life_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$play_sports_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$play_sports_values_text = "";
		foreach(json_decode($play_sports_values, true) as $opt)
		{
			$play_sports_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$keep_shabbat_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$keep_shabbat_values_text = "";
		foreach(json_decode($keep_shabbat_values, true) as $opt)
		{
			$keep_shabbat_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$keep_kosher_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$keep_kosher_values_text = "";
		foreach(json_decode($keep_kosher_values, true) as $opt)
		{
			$keep_kosher_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$go_to_synagogue_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$go_to_synagogue_values_text = "";
		foreach(json_decode($go_to_synagogue_values, true) as $opt)
		{
			$go_to_synagogue_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$keep_tsniyut_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$keep_tsniyut_values_text = "";
		foreach(json_decode($keep_tsniyut_values, true) as $opt)
		{
			$keep_tsniyut_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$did_brit_mila_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$did_brit_mila_values_text = "";
		foreach(json_decode($did_brit_mila_values, true) as $opt)
		{
			$did_brit_mila_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$apply_tefillin_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$apply_tefillin_values_text = "";
		foreach(json_decode($apply_tefillin_values, true) as $opt)
		{
			$apply_tefillin_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$light_shabbat_candles_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$light_shabbat_candles_values_text = "";
		foreach(json_decode($light_shabbat_candles_values, true) as $opt)
		{
			$light_shabbat_candles_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$religious_views_values = '[{"text":"Традиционая", "value":"traditional"},{"text":"Ортодоксальная", "value":"orthodox"},{"text":"Реформистская", "value":"reform"},{"text":"Воинствуюший атеист", "value":"militant_atheist"},{"text":"Немного соблюдаю", "value":"i_observe_a_little"},{"text":"Кошер-стайл", "value":"kosher_style"}]';
		$religious_views_values_text = "";
		foreach(json_decode($religious_views_values, true) as $opt)
		{
			$religious_views_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$jewish_name_values = '[{"text":"Есть", "value":"1"},{"text":"Нет", "value":"0"}]';
		$jewish_name_values_text = "";
		foreach(json_decode($jewish_name_values, true) as $opt)
		{
			$jewish_name_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
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
$next_order['coordinator_id']='asc';
$next_order['communication_method']='asc';
$next_order['coordinator_gender']='asc';
$next_order['social_networks_links']='asc';
$next_order['allow_show_social_networks_links']='asc';
$next_order['birthday']='asc';
$next_order['city_born']='asc';
$next_order['city_name']='asc';
$next_order['offers_other_cities']='asc';
$next_order['education']='asc';
$next_order['education_text']='asc';
$next_order['speak_russian']='asc';
$next_order['speak_english']='asc';
$next_order['speak_hebrew']='asc';
$next_order['other_languages']='asc';
$next_order['is_working_now']='asc';
$next_order['about_work']='asc';
$next_order['monthly_income']='asc';
$next_order['amount_savings']='asc';
$next_order['have_a_property']='asc';
$next_order['have_a_hobby']='asc';
$next_order['plans_for_life']='asc';
$next_order['play_sports']='asc';
$next_order['keep_shabbat']='asc';
$next_order['keep_kosher']='asc';
$next_order['go_to_synagogue']='asc';
$next_order['keep_tsniyut']='asc';
$next_order['did_brit_mila']='asc';
$next_order['apply_tefillin']='asc';
$next_order['light_shabbat_candles']='asc';
$next_order['religious_views']='asc';
$next_order['jewish_organizations']='asc';
$next_order['your_three_virtues']='asc';
$next_order['your_three_faults']='asc';
$next_order['about_partner']='asc';
$next_order['not_accept_in_partner']='asc';
$next_order['jewish_name']='asc';

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
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Анкеты полные".' </h2>
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
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=coordinator_gender&sort_order='. ($next_order['coordinator_gender']) .'\' class=\'sort\' column=\'coordinator_gender\' sort_order=\''.$sort_order['coordinator_gender'].'\'>Пол координатора'. $sort_icon['coordinator_gender'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="coordinator_gender_filter">
							'. $coordinator_gender_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=social_networks_links&sort_order='. ($next_order['social_networks_links']) .'\' class=\'sort\' column=\'social_networks_links\' sort_order=\''.$sort_order['social_networks_links'].'\'>Ссылки соцсетей'. $sort_icon['social_networks_links'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="social_networks_links_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=allow_show_social_networks_links&sort_order='. ($next_order['allow_show_social_networks_links']) .'\' class=\'sort\' column=\'allow_show_social_networks_links\' sort_order=\''.$sort_order['allow_show_social_networks_links'].'\'>Разрешить соцсети'. $sort_icon['allow_show_social_networks_links'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="allow_show_social_networks_links_filter">
							'. $allow_show_social_networks_links_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=birthday&sort_order='. ($next_order['birthday']) .'\' class=\'sort\' column=\'birthday\' sort_order=\''.$sort_order['birthday'].'\'>Дата рождения'. $sort_icon['birthday'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input autocomplete="off" type="text" class="form-control daterange filter-date-range" name="birthday_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=city_born&sort_order='. ($next_order['city_born']) .'\' class=\'sort\' column=\'city_born\' sort_order=\''.$sort_order['city_born'].'\'>Город рождения'. $sort_icon['city_born'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="city_born_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=city_name&sort_order='. ($next_order['city_name']) .'\' class=\'sort\' column=\'city_name\' sort_order=\''.$sort_order['city_name'].'\'>Город проживания'. $sort_icon['city_name'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=offers_other_cities&sort_order='. ($next_order['offers_other_cities']) .'\' class=\'sort\' column=\'offers_other_cities\' sort_order=\''.$sort_order['offers_other_cities'].'\'>Иногородние'. $sort_icon['offers_other_cities'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="offers_other_cities_filter">
							'. $offers_other_cities_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=education&sort_order='. ($next_order['education']) .'\' class=\'sort\' column=\'education\' sort_order=\''.$sort_order['education'].'\'>Образование'. $sort_icon['education'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="education_filter">
							'. $education_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=education_text&sort_order='. ($next_order['education_text']) .'\' class=\'sort\' column=\'education_text\' sort_order=\''.$sort_order['education_text'].'\'>Где учился'. $sort_icon['education_text'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="education_text_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=speak_russian&sort_order='. ($next_order['speak_russian']) .'\' class=\'sort\' column=\'speak_russian\' sort_order=\''.$sort_order['speak_russian'].'\'>Русский'. $sort_icon['speak_russian'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="speak_russian_filter">
							'. $speak_russian_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=speak_english&sort_order='. ($next_order['speak_english']) .'\' class=\'sort\' column=\'speak_english\' sort_order=\''.$sort_order['speak_english'].'\'>Английский'. $sort_icon['speak_english'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="speak_english_filter">
							'. $speak_english_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=speak_hebrew&sort_order='. ($next_order['speak_hebrew']) .'\' class=\'sort\' column=\'speak_hebrew\' sort_order=\''.$sort_order['speak_hebrew'].'\'>Иврит'. $sort_icon['speak_hebrew'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="speak_hebrew_filter">
							'. $speak_hebrew_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=other_languages&sort_order='. ($next_order['other_languages']) .'\' class=\'sort\' column=\'other_languages\' sort_order=\''.$sort_order['other_languages'].'\'>Другие языки'. $sort_icon['other_languages'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="other_languages_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_working_now&sort_order='. ($next_order['is_working_now']) .'\' class=\'sort\' column=\'is_working_now\' sort_order=\''.$sort_order['is_working_now'].'\'>Работает'. $sort_icon['is_working_now'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="is_working_now_filter">
							'. $is_working_now_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=about_work&sort_order='. ($next_order['about_work']) .'\' class=\'sort\' column=\'about_work\' sort_order=\''.$sort_order['about_work'].'\'>О работе'. $sort_icon['about_work'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="about_work_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=monthly_income&sort_order='. ($next_order['monthly_income']) .'\' class=\'sort\' column=\'monthly_income\' sort_order=\''.$sort_order['monthly_income'].'\'>Ежемесячные доход'. $sort_icon['monthly_income'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=amount_savings&sort_order='. ($next_order['amount_savings']) .'\' class=\'sort\' column=\'amount_savings\' sort_order=\''.$sort_order['amount_savings'].'\'>Накопления'. $sort_icon['amount_savings'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=have_a_property&sort_order='. ($next_order['have_a_property']) .'\' class=\'sort\' column=\'have_a_property\' sort_order=\''.$sort_order['have_a_property'].'\'>Недвижимость'. $sort_icon['have_a_property'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="have_a_property_filter">
							'. $have_a_property_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=have_a_hobby&sort_order='. ($next_order['have_a_hobby']) .'\' class=\'sort\' column=\'have_a_hobby\' sort_order=\''.$sort_order['have_a_hobby'].'\'>Хобби'. $sort_icon['have_a_hobby'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="have_a_hobby_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=plans_for_life&sort_order='. ($next_order['plans_for_life']) .'\' class=\'sort\' column=\'plans_for_life\' sort_order=\''.$sort_order['plans_for_life'].'\'>Планы'. $sort_icon['plans_for_life'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="plans_for_life_filter">
							'. $plans_for_life_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=play_sports&sort_order='. ($next_order['play_sports']) .'\' class=\'sort\' column=\'play_sports\' sort_order=\''.$sort_order['play_sports'].'\'>Спорт'. $sort_icon['play_sports'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="play_sports_filter">
							'. $play_sports_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=keep_shabbat&sort_order='. ($next_order['keep_shabbat']) .'\' class=\'sort\' column=\'keep_shabbat\' sort_order=\''.$sort_order['keep_shabbat'].'\'>Соблюдаете шаббат'. $sort_icon['keep_shabbat'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="keep_shabbat_filter">
							'. $keep_shabbat_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=keep_kosher&sort_order='. ($next_order['keep_kosher']) .'\' class=\'sort\' column=\'keep_kosher\' sort_order=\''.$sort_order['keep_kosher'].'\'>Кашрут?'. $sort_icon['keep_kosher'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="keep_kosher_filter">
							'. $keep_kosher_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=go_to_synagogue&sort_order='. ($next_order['go_to_synagogue']) .'\' class=\'sort\' column=\'go_to_synagogue\' sort_order=\''.$sort_order['go_to_synagogue'].'\'>Ходите в синагогу?'. $sort_icon['go_to_synagogue'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="go_to_synagogue_filter">
							'. $go_to_synagogue_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=keep_tsniyut&sort_order='. ($next_order['keep_tsniyut']) .'\' class=\'sort\' column=\'keep_tsniyut\' sort_order=\''.$sort_order['keep_tsniyut'].'\'>Цниют'. $sort_icon['keep_tsniyut'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="keep_tsniyut_filter">
							'. $keep_tsniyut_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=did_brit_mila&sort_order='. ($next_order['did_brit_mila']) .'\' class=\'sort\' column=\'did_brit_mila\' sort_order=\''.$sort_order['did_brit_mila'].'\'>Брит мила'. $sort_icon['did_brit_mila'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="did_brit_mila_filter">
							'. $did_brit_mila_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=apply_tefillin&sort_order='. ($next_order['apply_tefillin']) .'\' class=\'sort\' column=\'apply_tefillin\' sort_order=\''.$sort_order['apply_tefillin'].'\'>Тфилин'. $sort_icon['apply_tefillin'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="apply_tefillin_filter">
							'. $apply_tefillin_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=light_shabbat_candles&sort_order='. ($next_order['light_shabbat_candles']) .'\' class=\'sort\' column=\'light_shabbat_candles\' sort_order=\''.$sort_order['light_shabbat_candles'].'\'>Шаббатние свечи'. $sort_icon['light_shabbat_candles'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="light_shabbat_candles_filter">
							'. $light_shabbat_candles_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=religious_views&sort_order='. ($next_order['religious_views']) .'\' class=\'sort\' column=\'religious_views\' sort_order=\''.$sort_order['religious_views'].'\'>Еврейская "Ориентация"'. $sort_icon['religious_views'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="religious_views_filter">
							'. $religious_views_values_text .'
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=jewish_organizations&sort_order='. ($next_order['jewish_organizations']) .'\' class=\'sort\' column=\'jewish_organizations\' sort_order=\''.$sort_order['jewish_organizations'].'\'>Еврейские организации'. $sort_icon['jewish_organizations'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="jewish_organizations_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=your_three_virtues&sort_order='. ($next_order['your_three_virtues']) .'\' class=\'sort\' column=\'your_three_virtues\' sort_order=\''.$sort_order['your_three_virtues'].'\'>Три достоинства'. $sort_icon['your_three_virtues'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="your_three_virtues_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=your_three_faults&sort_order='. ($next_order['your_three_faults']) .'\' class=\'sort\' column=\'your_three_faults\' sort_order=\''.$sort_order['your_three_faults'].'\'>Три недостатка'. $sort_icon['your_three_faults'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=about_partner&sort_order='. ($next_order['about_partner']) .'\' class=\'sort\' column=\'about_partner\' sort_order=\''.$sort_order['about_partner'].'\'>О партнере'. $sort_icon['about_partner'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="about_partner_filter">
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

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=jewish_name&sort_order='. ($next_order['jewish_name']) .'\' class=\'sort\' column=\'jewish_name\' sort_order=\''.$sort_order['jewish_name'].'\'>Еврейское имя'. $sort_icon['jewish_name'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="jewish_name_filter">
							'. $jewish_name_values_text .'
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
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($coordinator_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='coordinator_id'>".select_mapping($coordinator_id_values, $item['coordinator_id'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($communication_method_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='communication_method'>".select_mapping($communication_method_values, $item['communication_method'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($coordinator_gender_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='coordinator_gender'>".select_mapping($coordinator_gender_values, $item['coordinator_gender'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='social_networks_links'>".htmlspecialchars($item['social_networks_links'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($allow_show_social_networks_links_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='allow_show_social_networks_links'>".select_mapping($allow_show_social_networks_links_values, $item['allow_show_social_networks_links'])."</span></td>
<td><span class='editable '  data-placeholder='' data-inp='date' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='birthday'>".DateTime::createFromFormat('Y-m-d H:i:s', ($item['birthday']?$item['birthday']:"1970-01-01 00:00:00") )->format('Y-m-d H:i')."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='city_born'>".htmlspecialchars($item['city_born'])."</span></td>
<td>".htmlspecialchars($item['city_name'])."</td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($offers_other_cities_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='offers_other_cities'>".select_mapping($offers_other_cities_values, $item['offers_other_cities'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($education_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='education'>".select_mapping($education_values, $item['education'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='education_text'>".htmlspecialchars($item['education_text'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($speak_russian_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='speak_russian'>".select_mapping($speak_russian_values, $item['speak_russian'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($speak_english_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='speak_english'>".select_mapping($speak_english_values, $item['speak_english'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($speak_hebrew_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='speak_hebrew'>".select_mapping($speak_hebrew_values, $item['speak_hebrew'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='other_languages'>".htmlspecialchars($item['other_languages'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($is_working_now_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='is_working_now'>".select_mapping($is_working_now_values, $item['is_working_now'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='about_work'>".htmlspecialchars($item['about_work'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='number' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='monthly_income'>".htmlspecialchars($item['monthly_income'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='number' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='amount_savings'>".htmlspecialchars($item['amount_savings'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($have_a_property_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='have_a_property'>".select_mapping($have_a_property_values, $item['have_a_property'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='have_a_hobby'>".htmlspecialchars($item['have_a_hobby'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($plans_for_life_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='plans_for_life'>".select_mapping($plans_for_life_values, $item['plans_for_life'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($play_sports_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='play_sports'>".select_mapping($play_sports_values, $item['play_sports'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($keep_shabbat_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='keep_shabbat'>".select_mapping($keep_shabbat_values, $item['keep_shabbat'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($keep_kosher_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='keep_kosher'>".select_mapping($keep_kosher_values, $item['keep_kosher'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($go_to_synagogue_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='go_to_synagogue'>".select_mapping($go_to_synagogue_values, $item['go_to_synagogue'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($keep_tsniyut_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='keep_tsniyut'>".select_mapping($keep_tsniyut_values, $item['keep_tsniyut'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($did_brit_mila_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='did_brit_mila'>".select_mapping($did_brit_mila_values, $item['did_brit_mila'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($apply_tefillin_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='apply_tefillin'>".select_mapping($apply_tefillin_values, $item['apply_tefillin'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($light_shabbat_candles_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='light_shabbat_candles'>".select_mapping($light_shabbat_candles_values, $item['light_shabbat_candles'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($religious_views_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='religious_views'>".select_mapping($religious_views_values, $item['religious_views'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='jewish_organizations'>".htmlspecialchars($item['jewish_organizations'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='your_three_virtues'>".htmlspecialchars($item['your_three_virtues'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='your_three_faults'>".htmlspecialchars($item['your_three_faults'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='about_partner'>".htmlspecialchars($item['about_partner'])."</span></td>
<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='not_accept_in_partner'>".htmlspecialchars($item['not_accept_in_partner'])."</span></td>
<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($jewish_name_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=users' data-pk='{$item['id']}' data-name='jewish_name'>".select_mapping($jewish_name_values, $item['jewish_name'])."</span></td>
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
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Анкеты полные".' #'.$id.'</small></h1>
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
$coordinator_id = $_REQUEST['coordinator_id'];
$communication_method = $_REQUEST['communication_method'];
$coordinator_gender = $_REQUEST['coordinator_gender'];
$social_networks_links = $_REQUEST['social_networks_links'];
$allow_show_social_networks_links = $_REQUEST['allow_show_social_networks_links'];
$birthday = $_REQUEST['birthday'];
$city_born = $_REQUEST['city_born'];
$city_id = $_REQUEST['city_id'];
$offers_other_cities = $_REQUEST['offers_other_cities'];
$education = $_REQUEST['education'];
$education_text = $_REQUEST['education_text'];
$speak_russian = $_REQUEST['speak_russian'];
$speak_english = $_REQUEST['speak_english'];
$speak_hebrew = $_REQUEST['speak_hebrew'];
$other_languages = $_REQUEST['other_languages'];
$is_working_now = $_REQUEST['is_working_now'];
$about_work = $_REQUEST['about_work'];
$monthly_income = $_REQUEST['monthly_income'];
$amount_savings = $_REQUEST['amount_savings'];
$have_a_property = $_REQUEST['have_a_property'];
$have_a_hobby = $_REQUEST['have_a_hobby'];
$plans_for_life = $_REQUEST['plans_for_life'];
$play_sports = $_REQUEST['play_sports'];
$keep_shabbat = $_REQUEST['keep_shabbat'];
$keep_kosher = $_REQUEST['keep_kosher'];
$go_to_synagogue = $_REQUEST['go_to_synagogue'];
$keep_tsniyut = $_REQUEST['keep_tsniyut'];
$did_brit_mila = $_REQUEST['did_brit_mila'];
$apply_tefillin = $_REQUEST['apply_tefillin'];
$light_shabbat_candles = $_REQUEST['light_shabbat_candles'];
$religious_views = $_REQUEST['religious_views'];
$jewish_organizations = $_REQUEST['jewish_organizations'];
$your_three_virtues = $_REQUEST['your_three_virtues'];
$your_three_faults = $_REQUEST['your_three_faults'];
$about_partner = $_REQUEST['about_partner'];
$not_accept_in_partner = $_REQUEST['not_accept_in_partner'];
$jewish_name = $_REQUEST['jewish_name'];

		qi("INSERT INTO users (`name`, `lastname`, `phone`, `age`, `sex`, `has_giyur`, `dt`, `status`, `allow_processing_personal_data`, `coordinator_id`, `communication_method`, `coordinator_gender`, `social_networks_links`, `allow_show_social_networks_links`, `birthday`, `city_born`, `city_id`, `offers_other_cities`, `education`, `education_text`, `speak_russian`, `speak_english`, `speak_hebrew`, `other_languages`, `is_working_now`, `about_work`, `monthly_income`, `amount_savings`, `have_a_property`, `have_a_hobby`, `plans_for_life`, `play_sports`, `keep_shabbat`, `keep_kosher`, `go_to_synagogue`, `keep_tsniyut`, `did_brit_mila`, `apply_tefillin`, `light_shabbat_candles`, `religious_views`, `jewish_organizations`, `your_three_virtues`, `your_three_faults`, `about_partner`, `not_accept_in_partner`, `jewish_name`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $lastname, $phone, $age, $sex, $has_giyur, $dt, $status, $allow_processing_personal_data, $coordinator_id, $communication_method, $coordinator_gender, $social_networks_links, $allow_show_social_networks_links, $birthday, $city_born, $city_id, $offers_other_cities, $education, $education_text, $speak_russian, $speak_english, $speak_hebrew, $other_languages, $is_working_now, $about_work, $monthly_income, $amount_savings, $have_a_property, $have_a_hobby, $plans_for_life, $play_sports, $keep_shabbat, $keep_kosher, $go_to_synagogue, $keep_tsniyut, $did_brit_mila, $apply_tefillin, $light_shabbat_candles, $religious_views, $jewish_organizations, $your_three_virtues, $your_three_faults, $about_partner, $not_accept_in_partner, $jewish_name]);
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
				

		if(isset2($_REQUEST['coordinator_id_filter']))
		{
			$filters[] = "`coordinator_id` = '{$_REQUEST['coordinator_id_filter']}'";
		}
				

		if(isset2($_REQUEST['communication_method_filter']))
		{
			$filters[] = "`communication_method` = '{$_REQUEST['communication_method_filter']}'";
		}
				

		if(isset2($_REQUEST['coordinator_gender_filter']))
		{
			$filters[] = "`coordinator_gender` = '{$_REQUEST['coordinator_gender_filter']}'";
		}
				

		if(isset2($_REQUEST['social_networks_links_filter']))
		{
			$filters[] = "`social_networks_links` LIKE '%{$_REQUEST['social_networks_links_filter']}%'";
		}
				

		if(isset2($_REQUEST['allow_show_social_networks_links_filter']))
		{
			$filters[] = "`allow_show_social_networks_links` = '{$_REQUEST['allow_show_social_networks_links_filter']}'";
		}
				

		if(isset2($_REQUEST['birthday_filter_from']) && isset2($_REQUEST['birthday_filter_to']))
		{
			$filters[] = "birthday >= '{$_REQUEST['birthday_filter_from']}' AND birthday <= '{$_REQUEST['birthday_filter_to']}'";
		}

		

		if(isset2($_REQUEST['city_born_filter']))
		{
			$filters[] = "`city_born` LIKE '%{$_REQUEST['city_born_filter']}%'";
		}
				

		if(isset2($_REQUEST['offers_other_cities_filter']))
		{
			$filters[] = "`offers_other_cities` = '{$_REQUEST['offers_other_cities_filter']}'";
		}
				

		if(isset2($_REQUEST['education_filter']))
		{
			$filters[] = "`education` = '{$_REQUEST['education_filter']}'";
		}
				

		if(isset2($_REQUEST['education_text_filter']))
		{
			$filters[] = "`education_text` LIKE '%{$_REQUEST['education_text_filter']}%'";
		}
				

		if(isset2($_REQUEST['speak_russian_filter']))
		{
			$filters[] = "`speak_russian` = '{$_REQUEST['speak_russian_filter']}'";
		}
				

		if(isset2($_REQUEST['speak_english_filter']))
		{
			$filters[] = "`speak_english` = '{$_REQUEST['speak_english_filter']}'";
		}
				

		if(isset2($_REQUEST['speak_hebrew_filter']))
		{
			$filters[] = "`speak_hebrew` = '{$_REQUEST['speak_hebrew_filter']}'";
		}
				

		if(isset2($_REQUEST['other_languages_filter']))
		{
			$filters[] = "`other_languages` LIKE '%{$_REQUEST['other_languages_filter']}%'";
		}
				

		if(isset2($_REQUEST['is_working_now_filter']))
		{
			$filters[] = "`is_working_now` = '{$_REQUEST['is_working_now_filter']}'";
		}
				

		if(isset2($_REQUEST['about_work_filter']))
		{
			$filters[] = "`about_work` LIKE '%{$_REQUEST['about_work_filter']}%'";
		}
				

		if(isset2($_REQUEST['have_a_property_filter']))
		{
			$filters[] = "`have_a_property` = '{$_REQUEST['have_a_property_filter']}'";
		}
				

		if(isset2($_REQUEST['have_a_hobby_filter']))
		{
			$filters[] = "`have_a_hobby` LIKE '%{$_REQUEST['have_a_hobby_filter']}%'";
		}
				

		if(isset2($_REQUEST['plans_for_life_filter']))
		{
			$filters[] = "`plans_for_life` = '{$_REQUEST['plans_for_life_filter']}'";
		}
				

		if(isset2($_REQUEST['play_sports_filter']))
		{
			$filters[] = "`play_sports` = '{$_REQUEST['play_sports_filter']}'";
		}
				

		if(isset2($_REQUEST['keep_shabbat_filter']))
		{
			$filters[] = "`keep_shabbat` = '{$_REQUEST['keep_shabbat_filter']}'";
		}
				

		if(isset2($_REQUEST['keep_kosher_filter']))
		{
			$filters[] = "`keep_kosher` = '{$_REQUEST['keep_kosher_filter']}'";
		}
				

		if(isset2($_REQUEST['go_to_synagogue_filter']))
		{
			$filters[] = "`go_to_synagogue` = '{$_REQUEST['go_to_synagogue_filter']}'";
		}
				

		if(isset2($_REQUEST['keep_tsniyut_filter']))
		{
			$filters[] = "`keep_tsniyut` = '{$_REQUEST['keep_tsniyut_filter']}'";
		}
				

		if(isset2($_REQUEST['did_brit_mila_filter']))
		{
			$filters[] = "`did_brit_mila` = '{$_REQUEST['did_brit_mila_filter']}'";
		}
				

		if(isset2($_REQUEST['apply_tefillin_filter']))
		{
			$filters[] = "`apply_tefillin` = '{$_REQUEST['apply_tefillin_filter']}'";
		}
				

		if(isset2($_REQUEST['light_shabbat_candles_filter']))
		{
			$filters[] = "`light_shabbat_candles` = '{$_REQUEST['light_shabbat_candles_filter']}'";
		}
				

		if(isset2($_REQUEST['religious_views_filter']))
		{
			$filters[] = "`religious_views` = '{$_REQUEST['religious_views_filter']}'";
		}
				

		if(isset2($_REQUEST['jewish_organizations_filter']))
		{
			$filters[] = "`jewish_organizations` LIKE '%{$_REQUEST['jewish_organizations_filter']}%'";
		}
				

		if(isset2($_REQUEST['your_three_virtues_filter']))
		{
			$filters[] = "`your_three_virtues` LIKE '%{$_REQUEST['your_three_virtues_filter']}%'";
		}
				

		if(isset2($_REQUEST['about_partner_filter']))
		{
			$filters[] = "`about_partner` LIKE '%{$_REQUEST['about_partner_filter']}%'";
		}
				

		if(isset2($_REQUEST['jewish_name_filter']))
		{
			$filters[] = "`jewish_name` = '{$_REQUEST['jewish_name_filter']}'";
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

		
$coordinator_id_values = json_encode(q("SELECT name as text, id as value FROM coordinators where role='coordinator'", []));
				  $coordinator_id_values_text = "";
			foreach(json_decode($coordinator_id_values, true) as $opt)
			{
			  $coordinator_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
$communication_method_values = '[ { "text": "email", "value": "email" }, { "text": "Мессенджер", "value": "bot" }, { "text": "Звонок", "value": "phone" }, { "text": "Встреча", "value": "meet" } ]';
		$communication_method_values_text = "";
		foreach(json_decode($communication_method_values, true) as $opt)
		{
			$communication_method_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$coordinator_gender_values = '[ { "text": "Мужской", "value": "male" }, { "text": "Женский", "value": "female" } ]';
		$coordinator_gender_values_text = "";
		foreach(json_decode($coordinator_gender_values, true) as $opt)
		{
			$coordinator_gender_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$allow_show_social_networks_links_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$allow_show_social_networks_links_values_text = "";
		foreach(json_decode($allow_show_social_networks_links_values, true) as $opt)
		{
			$allow_show_social_networks_links_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$offers_other_cities_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$offers_other_cities_values_text = "";
		foreach(json_decode($offers_other_cities_values, true) as $opt)
		{
			$offers_other_cities_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$education_values = '[ { "text": "Среднее", "value": "secondary" }, { "text": "Незаконченное высшее", "value": "unfinished_higher" }, { "text": "Бакалавр", "value": "bachelor" }, { "text": "Магистратура", "value": "master" } ]';
		$education_values_text = "";
		foreach(json_decode($education_values, true) as $opt)
		{
			$education_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$speak_russian_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$speak_russian_values_text = "";
		foreach(json_decode($speak_russian_values, true) as $opt)
		{
			$speak_russian_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$speak_english_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$speak_english_values_text = "";
		foreach(json_decode($speak_english_values, true) as $opt)
		{
			$speak_english_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$speak_hebrew_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$speak_hebrew_values_text = "";
		foreach(json_decode($speak_hebrew_values, true) as $opt)
		{
			$speak_hebrew_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$is_working_now_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$is_working_now_values_text = "";
		foreach(json_decode($is_working_now_values, true) as $opt)
		{
			$is_working_now_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$have_a_property_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$have_a_property_values_text = "";
		foreach(json_decode($have_a_property_values, true) as $opt)
		{
			$have_a_property_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$plans_for_life_values = '[ { "text": "Найти девушку", "value": "find_a_friend" }, { "text": "Создать семейную пару", "value": "get_married" }, { "text": "Завести детей", "value": "have_children" } ]';
		$plans_for_life_values_text = "";
		foreach(json_decode($plans_for_life_values, true) as $opt)
		{
			$plans_for_life_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$play_sports_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$play_sports_values_text = "";
		foreach(json_decode($play_sports_values, true) as $opt)
		{
			$play_sports_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$keep_shabbat_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$keep_shabbat_values_text = "";
		foreach(json_decode($keep_shabbat_values, true) as $opt)
		{
			$keep_shabbat_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$keep_kosher_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$keep_kosher_values_text = "";
		foreach(json_decode($keep_kosher_values, true) as $opt)
		{
			$keep_kosher_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$go_to_synagogue_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$go_to_synagogue_values_text = "";
		foreach(json_decode($go_to_synagogue_values, true) as $opt)
		{
			$go_to_synagogue_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$keep_tsniyut_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$keep_tsniyut_values_text = "";
		foreach(json_decode($keep_tsniyut_values, true) as $opt)
		{
			$keep_tsniyut_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$did_brit_mila_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$did_brit_mila_values_text = "";
		foreach(json_decode($did_brit_mila_values, true) as $opt)
		{
			$did_brit_mila_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$apply_tefillin_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$apply_tefillin_values_text = "";
		foreach(json_decode($apply_tefillin_values, true) as $opt)
		{
			$apply_tefillin_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$light_shabbat_candles_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$light_shabbat_candles_values_text = "";
		foreach(json_decode($light_shabbat_candles_values, true) as $opt)
		{
			$light_shabbat_candles_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$religious_views_values = '[{"text":"Традиционая", "value":"traditional"},{"text":"Ортодоксальная", "value":"orthodox"},{"text":"Реформистская", "value":"reform"},{"text":"Воинствуюший атеист", "value":"militant_atheist"},{"text":"Немного соблюдаю", "value":"i_observe_a_little"},{"text":"Кошер-стайл", "value":"kosher_style"}]';
		$religious_views_values_text = "";
		foreach(json_decode($religious_views_values, true) as $opt)
		{
			$religious_views_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$jewish_name_values = '[{"text":"Есть", "value":"1"},{"text":"Нет", "value":"0"}]';
		$jewish_name_values_text = "";
		foreach(json_decode($jewish_name_values, true) as $opt)
		{
			$jewish_name_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
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
				

		$text_option = array_filter(json_decode($coordinator_gender_values, true), function($i)
		{
			return $i['value']==$_REQUEST['coordinator_gender_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['coordinator_gender_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='coordinator_gender_filter' value='{$_REQUEST['coordinator_gender_filter']}'>
					<span class='fa fa-times remove-tag'></span> Пол координатора: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['social_networks_links_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='social_networks_links_filter' value='{$_REQUEST['social_networks_links_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Ссылки соцсетей: <b>{$_REQUEST['social_networks_links_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($allow_show_social_networks_links_values, true), function($i)
		{
			return $i['value']==$_REQUEST['allow_show_social_networks_links_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['allow_show_social_networks_links_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='allow_show_social_networks_links_filter' value='{$_REQUEST['allow_show_social_networks_links_filter']}'>
					<span class='fa fa-times remove-tag'></span> Разрешить соцсети: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['birthday_filter_from']))
		{
			$from = date('d.m.Y', strtotime($_REQUEST['birthday_filter_from']));
			$to = date('d.m.Y', strtotime($_REQUEST['birthday_filter_to']));
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='birthday_filter_from' value='{$_REQUEST['birthday_filter_from']}'>
					<input type='hidden' class='filter' name='birthday_filter_to' value='{$_REQUEST['birthday_filter_to']}'>
					<span class='fa fa-times remove-tag'></span> Дата рождения: <b>{$from}–{$to}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['city_born_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='city_born_filter' value='{$_REQUEST['city_born_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Город рождения: <b>{$_REQUEST['city_born_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($offers_other_cities_values, true), function($i)
		{
			return $i['value']==$_REQUEST['offers_other_cities_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['offers_other_cities_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='offers_other_cities_filter' value='{$_REQUEST['offers_other_cities_filter']}'>
					<span class='fa fa-times remove-tag'></span> Иногородние: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($education_values, true), function($i)
		{
			return $i['value']==$_REQUEST['education_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['education_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='education_filter' value='{$_REQUEST['education_filter']}'>
					<span class='fa fa-times remove-tag'></span> Образование: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['education_text_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='education_text_filter' value='{$_REQUEST['education_text_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Где учился: <b>{$_REQUEST['education_text_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($speak_russian_values, true), function($i)
		{
			return $i['value']==$_REQUEST['speak_russian_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['speak_russian_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='speak_russian_filter' value='{$_REQUEST['speak_russian_filter']}'>
					<span class='fa fa-times remove-tag'></span> Русский: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($speak_english_values, true), function($i)
		{
			return $i['value']==$_REQUEST['speak_english_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['speak_english_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='speak_english_filter' value='{$_REQUEST['speak_english_filter']}'>
					<span class='fa fa-times remove-tag'></span> Английский: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($speak_hebrew_values, true), function($i)
		{
			return $i['value']==$_REQUEST['speak_hebrew_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['speak_hebrew_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='speak_hebrew_filter' value='{$_REQUEST['speak_hebrew_filter']}'>
					<span class='fa fa-times remove-tag'></span> Иврит: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['other_languages_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='other_languages_filter' value='{$_REQUEST['other_languages_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Другие языки: <b>{$_REQUEST['other_languages_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($is_working_now_values, true), function($i)
		{
			return $i['value']==$_REQUEST['is_working_now_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['is_working_now_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='is_working_now_filter' value='{$_REQUEST['is_working_now_filter']}'>
					<span class='fa fa-times remove-tag'></span> Работает: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['about_work_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='about_work_filter' value='{$_REQUEST['about_work_filter']}'>
				   <span class='fa fa-times remove-tag'></span> О работе: <b>{$_REQUEST['about_work_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($have_a_property_values, true), function($i)
		{
			return $i['value']==$_REQUEST['have_a_property_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['have_a_property_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='have_a_property_filter' value='{$_REQUEST['have_a_property_filter']}'>
					<span class='fa fa-times remove-tag'></span> Недвижимость: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['have_a_hobby_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='have_a_hobby_filter' value='{$_REQUEST['have_a_hobby_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Хобби: <b>{$_REQUEST['have_a_hobby_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($plans_for_life_values, true), function($i)
		{
			return $i['value']==$_REQUEST['plans_for_life_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['plans_for_life_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='plans_for_life_filter' value='{$_REQUEST['plans_for_life_filter']}'>
					<span class='fa fa-times remove-tag'></span> Планы: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($play_sports_values, true), function($i)
		{
			return $i['value']==$_REQUEST['play_sports_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['play_sports_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='play_sports_filter' value='{$_REQUEST['play_sports_filter']}'>
					<span class='fa fa-times remove-tag'></span> Спорт: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($keep_shabbat_values, true), function($i)
		{
			return $i['value']==$_REQUEST['keep_shabbat_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['keep_shabbat_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='keep_shabbat_filter' value='{$_REQUEST['keep_shabbat_filter']}'>
					<span class='fa fa-times remove-tag'></span> Соблюдаете шаббат: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($keep_kosher_values, true), function($i)
		{
			return $i['value']==$_REQUEST['keep_kosher_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['keep_kosher_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='keep_kosher_filter' value='{$_REQUEST['keep_kosher_filter']}'>
					<span class='fa fa-times remove-tag'></span> Кашрут?: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($go_to_synagogue_values, true), function($i)
		{
			return $i['value']==$_REQUEST['go_to_synagogue_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['go_to_synagogue_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='go_to_synagogue_filter' value='{$_REQUEST['go_to_synagogue_filter']}'>
					<span class='fa fa-times remove-tag'></span> Ходите в синагогу?: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($keep_tsniyut_values, true), function($i)
		{
			return $i['value']==$_REQUEST['keep_tsniyut_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['keep_tsniyut_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='keep_tsniyut_filter' value='{$_REQUEST['keep_tsniyut_filter']}'>
					<span class='fa fa-times remove-tag'></span> Цниют: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($did_brit_mila_values, true), function($i)
		{
			return $i['value']==$_REQUEST['did_brit_mila_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['did_brit_mila_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='did_brit_mila_filter' value='{$_REQUEST['did_brit_mila_filter']}'>
					<span class='fa fa-times remove-tag'></span> Брит мила: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($apply_tefillin_values, true), function($i)
		{
			return $i['value']==$_REQUEST['apply_tefillin_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['apply_tefillin_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='apply_tefillin_filter' value='{$_REQUEST['apply_tefillin_filter']}'>
					<span class='fa fa-times remove-tag'></span> Тфилин: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($light_shabbat_candles_values, true), function($i)
		{
			return $i['value']==$_REQUEST['light_shabbat_candles_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['light_shabbat_candles_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='light_shabbat_candles_filter' value='{$_REQUEST['light_shabbat_candles_filter']}'>
					<span class='fa fa-times remove-tag'></span> Шаббатние свечи: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($religious_views_values, true), function($i)
		{
			return $i['value']==$_REQUEST['religious_views_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['religious_views_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='religious_views_filter' value='{$_REQUEST['religious_views_filter']}'>
					<span class='fa fa-times remove-tag'></span> Еврейская \"Ориентация\": <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['jewish_organizations_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='jewish_organizations_filter' value='{$_REQUEST['jewish_organizations_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Еврейские организации: <b>{$_REQUEST['jewish_organizations_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['your_three_virtues_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='your_three_virtues_filter' value='{$_REQUEST['your_three_virtues_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Три достоинства: <b>{$_REQUEST['your_three_virtues_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['about_partner_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='about_partner_filter' value='{$_REQUEST['about_partner_filter']}'>
				   <span class='fa fa-times remove-tag'></span> О партнере: <b>{$_REQUEST['about_partner_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($jewish_name_values, true), function($i)
		{
			return $i['value']==$_REQUEST['jewish_name_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['jewish_name_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='jewish_name_filter' value='{$_REQUEST['jewish_name_filter']}'>
					<span class='fa fa-times remove-tag'></span> Еврейское имя: <b>{$text_option}</b>
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
	echo masterRender("Анкеты полные", $content, 7);
