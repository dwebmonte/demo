<?php
/*
	~~~~~~~~~~~~~~~~~~~~     $params   ~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
  ["total"]=>
  int(11)
  ["iteration"]=>
  int(1)
  ["item_field"]=>
  array(5) {
    ["name"]=>
    string(5) "title"
    ["title"]=>
    string(17) "Название "
    ["html"]=>
    string(5) "input"
    ["col_width"]=>
    int(12)
    ["filter_type"]=>
    string(4) "text"
  }
 */

function smarty_block_win_row_wrap($params, $content, &$smarty) {
	$iteration = $params["iteration"];     $total = $params["total"];     $item_field = $params["item"];
	
	if (!isset($item_field["label_col_width"])) $item_field["label_col_width"] = 2;
	if (!isset($item_field["col_width"])) $item_field["col_width"] = 12 - $item_field["label_col_width"];
	
	
	// Самый первый вызов - создаем глобальные переменные отслеживания
	if (is_null($content) && $iteration == 1) {		
		$GLOBALS["_win_row_wrap"] = array(
			"_temp_form_group_tag_start" => false,	
			"_temp_curr_width" => 0	
		);
	};	
		
	$group_tag_start = $GLOBALS["_win_row_wrap"]["_temp_form_group_tag_start"];    
	$curr_width = $GLOBALS["_win_row_wrap"]["_temp_curr_width"];
	
		
	if (!is_null($content)) {
		$content = str_replace(array("\r\n"), "", $content);
		$start_wrap = $end_wrap = "";
		
		$content = "<div class='col-sm-{$item_field["col_width"]}'>{$content}</div>";
		
		// Конечная обертка
		if ($curr_width + $item_field["col_width"] + $item_field["label_col_width"] > 12) {
			$start_wrap .= "\r\n</div><!-- end 1 for {$iteration} -->";
			if ($iteration != $total) $start_wrap .= "<div class='form-group-separator'></div><!-- end 1 for {$iteration} -->";
			$group_tag_start = false;
			$curr_width = 0;
		};
		
		// Стартовая обертка
		if ($curr_width == 0) {
			$start_wrap = $start_wrap . "<div class='form-group'>\r\n";
			$group_tag_start = true;
		};

		$curr_width = $curr_width + $item_field["col_width"] + $item_field["label_col_width"];
		
		// Конечная обертка
		if ($curr_width >= 12) {
			$end_wrap .= "\r\n</div><!-- end 2  for {$iteration} -->";
			if ($iteration != $total) $end_wrap .= "<div class='form-group-separator'></div><!-- end 2  for {$iteration} -->";
			$group_tag_start = false;
			$curr_width = 0;
		};
	
		if (!isset($params["label"])) $params["label"] = "";
		$content = $start_wrap . "<label class='col-sm-{$item_field["label_col_width"]}'>{$params["label"]}</label>" . $content . $end_wrap;	
		$content = str_replace(array("\t"), "", $content);
	};

	$GLOBALS["_win_row_wrap"]["_temp_form_group_tag_start"] = $group_tag_start;		
	$GLOBALS["_win_row_wrap"]["_temp_curr_width"] = $curr_width;
	
	// Самый последний вызов - удаляем глобальные переменные отслеживания
	if (!is_null($content) && $iteration == $total) unset( $GLOBALS["_win_row_wrap"] );
	
	return $content;
};