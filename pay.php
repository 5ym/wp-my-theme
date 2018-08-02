<?php
	require_once(__DIR__.'/../../../wp-load.php' );

	$file = fopen("trans.txt", "r");
  while ($line = fgets($file)) {
    if(strpos($line, json_decode(file_get_contents('php://input'))->resource->parent_payment)) {
			$ar = explode(',',$line);
			$bo = get_user_meta($ar[1], 'bought')[0]; //購入済みデータ取得
			$bo[$ar[0]] = 1;
			$st = update_user_meta($ar[1], 'bought', $bo);
			break;
		}
  }
	fclose($file);
