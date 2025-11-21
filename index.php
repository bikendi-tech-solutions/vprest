<?php
header("Content-Security-Policy: https:");
//Script_Transport-Security
header("strict-transport-security: max-age=31536000 ");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
//header("Referrer-Policy: same-origin");
header("X-Xss-Protection: 1");
//header('Permissions-Policy: geolocation=(self ),camera=(self), microphone=(self)');
ob_start();
if (!defined('ABSPATH')) {
	$pagePath = explode('/wp-content/', dirname(__FILE__));
	include_once(str_replace('wp-content/', '', $pagePath[0] . '/wp-load.php'));
}
;
if (WP_DEBUG == false) {
	error_reporting(0);
}

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
$path = WP_PLUGIN_DIR . '/vtupress/functions.php';
if (file_exists($path) && in_array('vtupress/vtupress.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	include_once(ABSPATH . 'wp-content/plugins/vtupress/functions.php');
} else {
	if (!function_exists("vp_updateuser")) {
		function vp_updateuser()
		{

		}

		function vp_getuser()
		{

		}

		function vp_adduser()
		{

		}

		function vp_updateoption()
		{

		}

		function vp_getoption()
		{

		}

		function vp_option_array()
		{

		}

		function vp_user_array()
		{

		}

		function vp_deleteuser()
		{

		}

		function vp_addoption()
		{

		}

	}

}

//
//
global $wpdb, $level, $plan, $amount, $sec, $id, $amountv, $mlm_for;

//global $wpdb, $plan,$level,$amount,$sec;
//extract(vtupress_user_details());
//

//Update The Database

function search_bill_token2($array, $key)
{
	$results = array();

	if (is_array($array)) {
		if (isset($array[strtolower($key)])) {
			$results[] = $array[strtolower($key)];
		}

		foreach ($array as $sub_array) {
			$results = array_merge($results, search_bill_token2($sub_array, $key));
		}
	}
	return $results;
}

//

$option_array = json_decode(get_option("vp_options"), true);


//
function harray_key_first1($arr)
{
	$arg = json_decode($arr);
	if (is_array($arg)) {
		$response = array("him" => "me", "them" => "you");
		foreach ($response as $key => $value) {
			if (!is_array($value)) {
				return $arr[$key];
			} else {
				return "error";
			}
		}

	} else {
		return $arr;
	}

}


function validate_response1($response = "", $key = "", $value = "", $alter = "nothing_to_find")
{
	global $msg;


	if (json_decode($response) == NULL) {
		$dis = new stdclass;
		$dis->str = $response;
		$response = json_encode($dis);
	}

	$array = array_change_key_case(json_decode($response, true), CASE_LOWER);


	function search_Key($array = array(), $key = "")
	{
		$results = array();

		if (is_array($array)) {
			if (isset($array[strtolower($key)])) {
				$results[] = $array[strtolower($key)];
			}

			foreach ($array as $sub_array) {
				$results = array_merge($results, search_Key($sub_array, $key));
			}
		}
		return array_change_key_case($results, CASE_LOWER);
	}

	function search_val($results = "", $the_value = "", $alt = "nothing234")
	{
		$status = "FALSE";

		if (empty($the_value)) {
			$the_value = strtolower($the_value . "emptiness234");
		} else {
			$the_value = strtolower($the_value);
		}


		if (empty($alt)) {
			$alt = strtolower($alt . "emptiness234");
		} else {
			$alt = strtolower($alt);
		}


		foreach ($results as $dvalue) {
			if (!is_array($dvalue)) {

				$mthe_value = strtolower($the_value);
				$mdvalue = strtolower($dvalue);
				$malt = strtolower($alt);


				if ((strtolower($dvalue) === strtolower($the_value) || strtolower($dvalue) === strtolower($alt) || $dvalue == 1 || preg_match("/$mthe_value/", $mdvalue) || preg_match("/$malt/", $mdvalue)) && !preg_match("/not/", $mdvalue)) {
					$status = "TRUE";
				} elseif (is_numeric(stripos($mdvalue, "proce")) || is_numeric(stripos($mdvalue, "pen"))) {
					$status = "MAYBE";
				}

			}
		}
		return $status;
	}


	if (preg_match('/&&/', $key)) {
		$explode = explode("&&", $key);
		$key1 = $explode[0];
		$key2 = $explode[1];

		$first_key_result = search_Key($array, $key1);
		//print_r($result);
		$first_val_result = search_val($first_key_result, $value, $alter);



		$second_key_result = search_Key($array, $key2);
		//print_r($result);
		$second_val_result = search_val($second_key_result, $value, $alter);

		if ($first_val_result == "TRUE" && $second_val_result == "TRUE") {
			$status_from_result_val = "TRUE";
		} elseif ($first_val_result == "MAYBE" || $second_val_result == "MAYBE") {
			$status_from_result_val = "MAYBE";
		} else {
			$status_from_result_val = "FALSE";
		}

		$msg = "FIRST = $first_val_result && SECOND = $second_val_result";

	} elseif (preg_match('/\|\|/', $key)) {
		$explode = explode("||", $key);
		$key1 = $explode[0];
		$key2 = $explode[1];

		$first_key_result = search_Key($array, $key1);
		//print_r($result);
		$first_val_result = search_val($first_key_result, $value, $alter);

		$second_key_result = search_Key($array, $key2);
		//print_r($result);
		$second_val_result = search_val($second_key_result, $value, $alter);

		if ($first_val_result == "TRUE" || $second_val_result == "TRUE") {
			$status_from_result_val = "TRUE";
		} elseif ($first_val_result == "MAYBE" || $second_val_result == "MAYBE") {
			$status_from_result_val = "MAYBE";
		} else {
			$status_from_result_val = "FALSE";
		}

		$msg = "FIRST = $first_val_result && SECOND = $second_val_result";

	} else {
		$result = search_Key($array, $key);
		//print_r($result);
		$status_from_result_val = search_val($result, $value, $alter);
	}



	return $status_from_result_val;


}



if (isset($_SERVER["HTTP_USER_AGENT"])) {
	$agent = $_SERVER["HTTP_USER_AGENT"];
} else {
	$agent = "Undefined";
}
if (preg_match('/MSIE (\d+\.\d+);/', $agent)) {
	// echo "You're using Internet Explorer";
	$browser = "IE";
} else if (preg_match('/Chrome[\/\s](\d+\.\d+)/', $agent)) {
	//  echo "You're using Chrome";
	$browser = "CHROME";
} else if (preg_match('/Edge\/\d+/', $agent)) {
	//  echo "You're using Edge";
	$browser = "EDGE";
} else if (preg_match('/Firefox[\/\s](\d+\.\d+)/', $agent)) {
	//  echo "You're using Firefox";
	$browser = "FIREFOX";
} else if (preg_match('/OPR[\/\s](\d+\.\d+)/', $agent)) {
	//  echo "You're using Opera";
	$browser = "OPERA";
} else if (preg_match('/Safari[\/\s](\d+\.\d+)/', $agent)) {
	//  echo "You're using Safari";
	$browser = "SAFARI";
}


//
$vpdebug = vp_option_array($option_array, "vpdebug");

//Check if reseller
if (vp_option_array($option_array, "resell") === "yes") {
	//Continue
} else {
	$obj = new stdClass;
	$obj->status = "300";
	$obj->message = "Api Service Not Available [Site Plan Has No ACCESS]";

	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
}

//Check if debug is on

if ($vpdebug === "no") {
	//continue
} else {
	$obj = new stdClass;
	$obj->status = "200";
	$obj->message = "Api Service Not Available [Debug Mode On]";

	die(json_encode($obj, JSON_UNESCAPED_SLASHES));

}



if (isset($_REQUEST['q']) && isset($_REQUEST['id']) && isset($_REQUEST['apikey'])) {//if isset q, id, ud
	$q = $_REQUEST['q'];
	$id = $_REQUEST['id'];


	$data = get_userdata($id);
	$ud = $_REQUEST['apikey'];
	$plan = vp_getuser($id, 'vr_plan', true);
	$rplan = vp_getuser($id, 'vr_plan', true);
	$vrid = vp_getuser($id, 'vr_id', true);
	$bal = vp_getuser($id, "vp_bal", true);
	$ref = vp_getuser($id, "vp_ref", true);

	date_default_timezone_set("Africa/Lagos");

	$uniqidvalue = date('Ymd') . date('H') . date("i") . date("s");//.uniqid("vtu-",false);

	//echo $uniqidvalue;
	if (isset($_GET["session"])) {
		$session = "  [ " . $_GET["session"] . " ]";
	} else {
		$session = "";
	}


	if (isset($_GET["via"])) {
		$via = $_GET["via"];
	} else {
		$via = "api";
	}

	$table_name = $wpdb->prefix . "vp_levels";
	$level = $wpdb->get_results("SELECT * FROM $table_name WHERE name = '$plan'");

	if (empty($level)) {
		die('{"status":"200","message":"No Level Found!"}');
	}
	if (isset($level)) {

		$my_level = $level[0]->name;
		if (strtolower($level[0]->developer) == "yes") {

			if ((get_userdata($id) == true && strtolower($ud) == strtolower($vrid) && strtolower($vrid) != "null")) {

				$vp_most_secured_version = vp_getuser($id, 'vp_most_secured_version', true);
				$msv = 1;
				if ($vp_most_secured_version != $msv) {
					$new_pin = rand(1111, 9999);
					vp_updateuser($id, 'vr_id', uniqid($id));
					//vp_updateuser($id,'vp_pin',$new_pin);
					vp_updateuser($id, 'vp_most_secured_version', $msv);

					die('{"status":"200","message":"Your Api Key Has Been Changed. Please Check Your Dashboard For The New Updated ApiKey"}');
				}

				$vc = "custom";

				if ($vc == "custom") {

					$name = get_userdata($id)->user_login;
					$email = get_userdata($id)->user_email;



					//Airtime and Data Choices
					if (isset($_REQUEST['type'])) {
						$datatcode = strtolower($_REQUEST['type']);
						$airtimechoice = strtolower($_REQUEST['type']);
					}


					//CHARGE METHOD
					if (is_plugin_active("vpmlm/vpmlm.php")) {
						$discount_method = vp_option_array($option_array, "discount_method");
					} else {
						$discount_method = "null";
					}


					//END OF CHARGE METHOD	


					$vpdebug = vp_option_array($option_array, "vpdebug");
					$bal = vp_getuser($id, "vp_bal", true);




					switch ($q) {//to be done
						case "user":
							$bal = vp_getuser($id, "vp_bal", true);
							$obj = new stdClass;
							$obj->status = "100";
							$obj->request_id = $uniqidvalue;
							$obj->Successful = "true";
							$obj->Id = $id;
							$obj->Plan = $rplan;
							$obj->Balance = $bal;
							$obj->Referred_By = $ref;
							die(json_encode($obj, JSON_UNESCAPED_SLASHES));

							break;
						case "smile":
							$required = ["type", "plan_id", "recipient"];
							foreach ($required as $key) {
								if (!isset($_REQUEST[$key])) {
									$obj = new stdClass;
									$obj->status = "200";
									$obj->Successful = "false";
									$obj->message = "$key required";
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								}
							}
							$plan_id = $_REQUEST["plan_id"];
							$type = $_REQUEST["type"];
							$recipient = $_REQUEST["recipient"];

							//check type
							if ($type != "phone" && $type != "id") {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "type must be id or phone";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}


							//check plan
							$array_ids = [];
							for ($i = 0; $i <= 20; $i++) {
								$doos = vp_option_array($option_array, "csmiledata" . $i);
								if ($doos != "") {

									$array_ids[$doos] = [
										"name" => vp_option_array($option_array, "csmiledatan" . $i),
										"price" => vp_option_array($option_array, "csmiledatap" . $i)
									];
								}
							}

							if (!isset($array_ids[$plan_id])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "incorrect service id";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$price = $array_ids[$plan_id]["price"];
							$amount = $price;
							$pname = $array_ids[$plan_id]["name"];

							$bal = vp_getuser($id, "vp_bal", true);
							$amountv = $amount;
							$baln = $bal - $amountv;

							if ($bal < $amount) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Insufficient Balance";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}



							$datatype = vp_option_array($option_array, "smile_datatype");
							$datatype_value = $type;
							$phone = $recipient;
							$dplan = $plan_id;
							$network = "smile";


							$url = vp_getoption("smilebaseurl") . vp_getoption("smileendpoint");
							$phone = preg_replace('/^0/', "234", $phone);
							$num = $phone;
							$uniqidvalue = date('Ymd', $current_timestamp) . date('H', $current_timestamp) . date("i", $current_timestamp) . date("s", $current_timestamp);

							$cua = vp_getoption("smilepostdata1");
							$cppa = vp_getoption("smilepostdata2");
							$c1a = vp_getoption("smilepostdata3");
							$c2a = vp_getoption("smilepostdata4");
							$c3a = vp_getoption("smilepostdata5");
							$cna = vp_getoption("smilenetworkattribute");
							$caa = vp_getoption("smileamountattribute");
							$cpa = vp_getoption("smilephoneattribute");
							$cpla = vp_getoption("smilevariationattr");
							$uniqid = vp_getoption("request_id");

							$datass = array(
								$cua => vp_getoption("smilepostvalue1"),
								$cppa => vp_getoption("smilepostvalue2"),
								$c1a => vp_getoption("smilepostvalue3"),
								$c2a => vp_getoption("smilepostvalue4"),
								$c3a => vp_getoption("smilepostvalue5"),
								$uniqid => $uniqidvalue,
								$cna => "smile",
								$cpa => $phone,
								$datatype => $datatype_value,
								$cpla => $dplan
							);
							//edit here smileedit smiledit

							$smile_array = [];

							$the_head = vp_getoption("smile_head");
							if ($the_head == "not_concatenated") {
								$the_auth = vp_getoption("smilevalue1");
								$auto = vp_getoption("smilehead1") . ' ' . $the_auth;
								$smile_array["Authorization"] = $auto;
							} elseif ($the_head == "concatenated") {
								$the_auth_value = vp_getoption("smilevalue1");
								$the_auth = base64_encode($the_auth_value);
								$auto = vp_getoption("smilehead1") . ' ' . $the_auth;
								$smile_array["Authorization"] = $auto;
							} else {
								$smile_array[vp_getoption("smilehead1")] = vp_getoption("smilevalue1");
							}



							$smile_array["Content-Type"] = "application/json";
							$smile_array["cache-control"] = "no-cache";

							for ($smileaddheaders = 1; $smileaddheaders <= 4; $smileaddheaders++) {
								if (!empty(vp_getoption("smileaddheaders$smileaddheaders")) && !empty(vp_getoption("smileaddvalue$smileaddheaders"))) {
									$smile_array[vp_getoption("smileaddheaders$smileaddheaders")] = vp_getoption("smileaddvalue$smileaddheaders");
								}
							}

							$http_args = array(
								'headers' => $smile_array,
								'timeout' => '3000',
								'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
								'sslverify' => false,
								'body' => json_encode($datass)
							);

							$sc = vp_getoption("smilesuccesscode");


							if (vp_getoption("smilequerymethod") != "array") {


								$call = wp_remote_post($url, $http_args);
								$response = wp_remote_retrieve_body($call);
								if (is_wp_error($call)) {
									if (vp_option_array($option_array, "vpdebug") != "yes") {
										$error = $call->get_error_code();
									} else {
										$error = $call->get_error_message();
									}

									die($error);
								}
							} else {

								$response = vp_remote_post_fn($url, $smile_array, $datass);

							}


							if (vp_getoption("smile1_response_format") == "JSON" || vp_getoption("smile1_response_format") == "json") {
								$en = validate_response1($response, $sc, vp_getoption("smilesuccessvalue"), vp_getoption("smilesuccessvalue2"));
							} else {
								$en = $response;
							}

							$smile_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_getoption("smileresponse_id"));

							if (!empty($smile_response)) {
								$smile_token = $smile_response[0];
							} else {
								$smile_token = "Nill";
							}

							if ($en == "TRUE" || $response === vp_getoption("smilesuccessvalue")) {


								$myemail = get_userdata($id)->user_email;
								$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
								wp_mail($myemail, "New Vend SmileData [" . $name . "]", $content);



								global $wpdb;
								$table_name = $wpdb->prefix . 'sdata';
								$added_to_db = $wpdb->insert($table_name, array(
									'run_code' => esc_html($pos),
									'response_id' => $smile_token,
									'name' => $name,
									'email' => $email,
									'phone' => $phone,
									'plan' => $pname,
									'bal_bf' => $bal,
									'bal_nw' => $baln,
									'amount' => $amount,
									'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
									'browser' => $browser,
									'trans_type' => 'smile',
									'trans_method' => 'post',
									'via' => 'site',
									'time_taken' => '1',
									'request_id' => $uniqidvalue,
									'user_id' => $id,
									'status' => 'Successful',
									'the_time' => date('Y-m-d h:i:s A', $current_timestamp)
								));

								$tot = $bal - $amountv;

								if (is_plugin_active("vpmlm/vpmlm.php")) {
									do_action("vp_after_api");
									vp_updateuser($id, 'vp_bal', $tot);
								} else {
									vp_updateuser($id, 'vp_bal', $tot);
								}

								$obj = new stdClass;
								$obj->status = "100";
								$obj->request_id = $uniqidvalue;
								$obj->Successful = "true";
								$obj->message = "Purchase Of $pname Was Successful";
								$obj->Previous_Balance = $bal;
								$obj->Current_Balance = $tot;
								$obj->Amount_Charged = $amountv;
								$obj->Data_Plan = $pname;
								$obj->Plan_Code = $dplan;
								$obj->Data_Type = "Smile";
								$obj->Network = $network;
								$obj->Receiver = $phone;
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));


							} else {


								global $wpdb;
								$table_name = $wpdb->prefix . 'sdata';
								$added_to_db = $wpdb->insert($table_name, array(
									'run_code' => esc_html($pos),
									'response_id' => $smile_token,
									'name' => $name,
									'email' => $email,
									'phone' => $phone,
									'plan' => $pname,
									'bal_bf' => $bal,
									'bal_nw' => $bal,
									'amount' => $amount,
									'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
									'browser' => $browser,
									'trans_type' => 'smile',
									'trans_method' => 'post',
									'via' => 'site',
									'time_taken' => '1',
									'request_id' => $uniqidvalue,
									'user_id' => $id,
									'status' => 'Failed',
									'the_time' => date('Y-m-d h:i:s A', $current_timestamp)
								));




								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Purchase Of $pname Was Not Successful";
								$obj->Previous_Balance = $bal;
								$obj->Data_Plan = $pname;
								$obj->Plan_Code = $dplan;
								$obj->Data_Type = "Smile";
								$obj->Network = $network;
								$obj->Receiver = $phone;
								$obj->Response = harray_key_first1($response);
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));


							}


							break;
						case "airtime":
							$mlm_for = "";
							if (isset($_REQUEST["phone"])) {
								if (isset($_REQUEST["network"])) {
									if (isset($_REQUEST["amount"])) {
										if (isset($_REQUEST["type"])) {

											if (strtolower($level[0]->developer) == "yes") {

												if (isset($_REQUEST['network'])) {
													$disnetwork = strtoupper($_REQUEST['network']);
													$datnetwork = strtoupper($_REQUEST['network']);
												}



												switch ($q) {
													case "airtime":
														if ($airtimechoice == "vtu") {
															switch ($disnetwork) {
																case "MTN":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->mtn_vtu);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "GLO":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->glo_vtu);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "9MOBILE":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->mobile_vtu);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "AIRTEL":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->airtel_vtu);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																default:
																	$obj = new stdClass;
																	$obj->status = "200";
																	$obj->Successful = "false";
																	$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~ For VTU";
																	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																	;
															}
															;
														} elseif ($airtimechoice == "share") {
															switch ($disnetwork) {
																case "MTN":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->mtn_share);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "GLO":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->glo_share);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "9MOBILE":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->mobile_share);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "AIRTEL":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->airtel_share);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																default:
																	$obj = new stdClass;
																	$obj->status = "200";
																	$obj->Successful = "false";
																	$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~ For Share & Sell";
																	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																	;
															}
															;

														} elseif ($airtimechoice == "awuf") {
															switch ($disnetwork) {
																case "MTN":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->mtn_awuf);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "GLO":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->glo_awuf);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "9MOBILE":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->mobile_awuf);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																case "AIRTEL":
																	$fir = $_REQUEST['amount'] * floatval($level[0]->airtel_awuf);
																	$sec = $fir / 100;
																	$amountv = $_REQUEST['amount'] - $sec;
																	$baln = $bal - $_REQUEST['amount'];
																	break;
																default:
																	$obj = new stdClass;
																	$obj->status = "200";
																	$obj->Successful = "false";
																	$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~ For Awuf";
																	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																	;
															}
															;

														} else {

															$obj = new stdClass;
															$obj->status = "200";
															$obj->Successful = "false";
															$obj->message = "AIRTIME SERVICE TYPE INVALID";
															die(json_encode($obj, JSON_UNESCAPED_SLASHES));

														}
														if ($discount_method == "direct") {
															$amountv = $amountv;
															$amount = $amountv;
														} else {
															$amountv = $_REQUEST["amount"];
															$amount = $_REQUEST["amount"];
														}
														break;
												}

											} else {

												if ($q == "airtime") {
													$baln = $bal - $_REQUEST['amount'];
													$amountv = $_REQUEST['amount'];
													if ($discount_method == "direct") {
														$baln = $bal - $amountv;
														$amountv = $amountv;
														$amount = $_REQUEST['amount'];
													} else {
														$amountv = $_REQUEST["amount"];
														$amount = $_REQUEST["amount"];
													}
												} else {
													$obj = new stdClass;
													$obj->status = "200";
													$obj->Successful = "false";
													$obj->message = "Query Not Airtime or Data";
													die(json_encode($obj, JSON_UNESCAPED_SLASHES));
												}

											}

											if (isset($_REQUEST["type"]) && ($_REQUEST["type"] == "vtu" || $_REQUEST["type"] == "share" || $_REQUEST["type"] == "awuf")) {
												$id = $_REQUEST['id'];
												$dnetwork = $_REQUEST['network'];
												$phone = $_REQUEST['phone'];
												$amount = $_REQUEST['amount'];

												if (isset($_REQUEST["network"])) {

													if (isset($_REQUEST["phone"])) {
														//AIRTIME START
														if (isset($_REQUEST["amount"])) {
															if ($bal >= $amountv) {
																$airtimechoice = $_REQUEST["type"];

																if ($airtimechoice == "vtu") {

																	if (vp_option_array($option_array, "setairtime") == "checked" && !empty(vp_option_array($option_array, "airtimebaseurl")) && !empty(vp_option_array($option_array, "airtimeendpoint")) && vp_option_array($option_array, "vtucontrol") == "checked") {

																	} else {
																		$obj = new stdClass;
																		$obj->status = "200";
																		$obj->Successful = "false";
																		$obj->message = "VTU Airtime Not Available";
																		die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																	}

																	switch ($dnetwork) {
																		case "mtn":
																			$network = vp_option_array($option_array, "airtimemtn");
																			break;
																		case "glo":
																			$network = vp_option_array($option_array, "airtimeglo");
																			break;
																		case "airtel":
																			$network = vp_option_array($option_array, "airtimeairtel");
																			break;
																		case "9mobile":
																			$network = vp_option_array($option_array, "airtime9mobile");
																			break;
																		default:
																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~";
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																			;
																	}


																	//echo "<br>Network call =".$dnetwork." Main = $network </br>";

																	$vpdebug = vp_option_array($option_array, "vpdebug");
																	if (vp_option_array($option_array, "airtimerequest") == "get") {
																		//$ch = curl_init($url);
																		$url = vp_option_array($option_array, "airtimebaseurl") . vp_option_array($option_array, "airtimeendpoint") . vp_option_array($option_array, "airtimepostdata1") . "=" . vp_option_array($option_array, "airtimepostvalue1") . "&" . vp_option_array($option_array, "arequest_id") . "=" . $uniqidvalue . "&" . vp_option_array($option_array, "airtimepostdata2") . "=" . vp_option_array($option_array, "airtimepostvalue2") . "&" . vp_option_array($option_array, "airtimepostdata3") . "=" . vp_option_array($option_array, "airtimepostvalue3") . "&" . vp_option_array($option_array, "airtimepostdata4") . "=" . vp_option_array($option_array, "airtimepostvalue4") . "&" . vp_option_array($option_array, "airtimepostdata5") . "=" . vp_option_array($option_array, "airtimepostvalue5") . "&" . vp_option_array($option_array, "airtimenetworkattribute") . "=" . $network . "&" . vp_option_array($option_array, "airtimeamountattribute") . "=" . $amount . "&" . vp_option_array($option_array, "airtimephoneattribute") . "=" . $phone;
																		$sc = vp_option_array($option_array, "airtimesuccesscode");
																		//echo "<script>alert('url1".$url."');</script>";

																		$http_args = array(
																			'headers' => array(
																				'cache-control' => 'no-cache',
																				'Content-Type' => 'application/json'
																			),
																			'timeout' => '300',
																			'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																			'sslverify' => false
																		);


																		$call = wp_remote_get($url, $http_args);
																		$response = wp_remote_retrieve_body($call);

																		if (is_wp_error($call)) {
																			if (vp_option_array($option_array, "vpdebug") != "yes") {
																				$error = $call->get_error_code();
																			} else {
																				$error = $call->get_error_message();
																			}

																			die($error);
																		}


																		if (vp_option_array($option_array, "airtime1_response_format") == "json") {
																			$en = validate_response1($response, $sc, vp_option_array($option_array, "airtimesuccessvalue"), vp_option_array($option_array, "airtimesuccessvalue2"));
																		} else {
																			$en = $response;
																		}

																		$vpdebug = vp_option_array($option_array, "vpdebug");

																		$vtu_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "vturesponse_id"));

																		if (!empty($vtu_response)) {
																			$vtu_token = $vtu_response[0];
																		} else {
																			$vtu_token = "Nill";
																		}

																		if ($en == "TRUE" || $response === vp_option_array($option_array, "airtimesuccessvalue")) {
																			$vpdebug = vp_option_array($option_array, "vpdebug");
																			include_once(ABSPATH . "wp-load.php");
																			$myemail = get_userdata($id)->user_email;
																			$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																			wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'response_id' => $vtu_token,
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'vtu',
																				'trans_method' => 'get',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Successful",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			if (is_plugin_active("vpmlm/vpmlm.php")) {
																				do_action("vp_after_api");
																				vp_updateuser($id, 'vp_bal', $tot);
																			} else {
																				vp_updateuser($id, 'vp_bal', $tot);
																			}

																			//VTU AIRTIME SUCCESS

																			$obj = new stdClass;
																			$obj->status = "100";
																			$obj->request_id = $uniqidvalue;
																			$obj->Successful = "true";
																			$obj->message = "Purchase Was Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Current_Balance = $tot;
																			$obj->Amount_Charged = $amountv;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																		} else {

																			include_once(ABSPATH . "wp-load.php");
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'response_id' => $vtu_token,
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'vtu',
																				'trans_method' => 'get',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Failed",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			//vp_updateuser($id, 'vp_bal', $tot);


																			//VTU AIRTIME FAILED
																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Purchase Was Not Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			$obj->Response = harray_key_first1($response);
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																		}
																	} else {
																		$url = vp_option_array($option_array, "airtimebaseurl") . vp_option_array($option_array, "airtimeendpoint");
																		$num = $phone;
																		$cua = vp_option_array($option_array, "airtimepostdata1");
																		$cppa = vp_option_array($option_array, "airtimepostdata2");
																		$c1a = vp_option_array($option_array, "airtimepostdata3");
																		$c2a = vp_option_array($option_array, "airtimepostdata4");
																		$c3a = vp_option_array($option_array, "airtimepostdata5");
																		$cna = vp_option_array($option_array, "airtimenetworkattribute");
																		$caa = vp_option_array($option_array, "airtimeamountattribute");
																		$cpa = vp_option_array($option_array, "airtimephoneattribute");
																		$uniqid = vp_option_array($option_array, "arequest_id");

																		$datass = array(
																			$cua => vp_option_array($option_array, "airtimepostvalue1"),
																			$cppa => vp_option_array($option_array, "airtimepostvalue2"),
																			$c1a => vp_option_array($option_array, "airtimepostvalue3"),
																			$c2a => vp_option_array($option_array, "airtimepostvalue4"),
																			$c3a => vp_option_array($option_array, "airtimepostvalue5"),
																			$uniqid => $uniqidvalue,
																			$cna => $network,
																			$caa => $amount,
																			$cpa => $phone
																		);

																		$the_head = vp_option_array($option_array, "airtime_head");
																		if ($the_head == "not_concatenated") {
																			$the_auth = vp_option_array($option_array, "airtimevalue1");
																		} else {
																			$the_auth_value = vp_option_array($option_array, "airtimevalue1");
																			$the_auth = base64_encode($the_auth_value);
																		}
																		$sc = vp_option_array($option_array, "airtimesuccesscode");
																		//echo "<script>alert('url1".$url."');</script>";
																		$agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";


																		$the_head = vp_option_array($option_array, "airtime_head");
																		if ($the_head == "not_concatenated") {
																			$the_auth = vp_option_array($option_array, "airtimevalue1");
																		} else {
																			$the_auth_value = vp_option_array($option_array, "airtimevalue1");
																			$the_auth = base64_encode($the_auth_value);
																		}
																		$sc = vp_option_array($option_array, "airtimesuccesscode");
																		//echo "<script>alert('url1".$url."');</script>";

																		$token = vp_option_array($option_array, "airtimehead1");
																		$auto = "$token $the_auth";


																		if (vp_option_array($option_array, "vtuquerymethod") != "array") {

																			$vtuairtime_array = [];

																			$the_head = vp_getoption("airtime_head");
																			if ($the_head == "not_concatenated") {
																				$the_auth = vp_getoption("airtimevalue1");
																				$auto = vp_getoption("airtimehead1") . ' ' . $the_auth;
																				$vtuairtime_array["Authorization"] = $auto;
																			} elseif ($the_head == "concatenated") {
																				$the_auth_value = vp_getoption("airtimevalue1");
																				$the_auth = base64_encode($the_auth_value);
																				$auto = vp_getoption("airtimehead1") . ' ' . $the_auth;
																				$vtuairtime_array["Authorization"] = $auto;
																			} else {
																				$vtuairtime_array[vp_getoption("airtimehead1")] = vp_getoption("airtimevalue1");
																			}

																			$sc = vp_getoption("airtimesuccesscode");
																			//echo "<script>alert('url1".$url."');</script>";

																			$token = vp_getoption("airtimehead1");
																			$auto = "$token $the_auth";


																			$vtuairtime_array["cache-control"] = "no-cache";
																			$vtuairtime_array["content-type"] = "application/json";


																			for ($vtuaddheaders = 1; $vtuaddheaders <= 4; $vtuaddheaders++) {
																				if (!empty(vp_getoption("vtuaddheaders$vtuaddheaders")) && !empty(vp_getoption("vtuaddvalue$vtuaddheaders"))) {
																					$vtuairtime_array[vp_getoption("vtuaddheaders$vtuaddheaders")] = vp_getoption("vtuaddvalue$vtuaddheaders");
																				}
																			}



																			$http_args = array(
																				'headers' => $vtuairtime_array,
																				'timeout' => '300',
																				'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																				'blocking' => true,
																				'body' => json_encode($datass)
																			);


																			$call = wp_remote_post($url, $http_args);
																			$response = wp_remote_retrieve_body($call);



																		} else {


																			$vtuairtime_array = [];

																			$the_head = vp_getoption("airtime_head");
																			if ($the_head == "not_concatenated") {
																				$the_auth = vp_getoption("airtimevalue1");
																				$auto = vp_getoption("airtimehead1") . ' ' . $the_auth;
																				$vtuairtime_array["Authorization"] = $auto;
																			} elseif ($the_head == "concatenated") {
																				$the_auth_value = vp_getoption("airtimevalue1");
																				$the_auth = base64_encode($the_auth_value);
																				$auto = vp_getoption("airtimehead1") . ' ' . $the_auth;
																				$vtuairtime_array["Authorization"] = $auto;
																			} else {
																				$vtuairtime_array[vp_getoption("airtimehead1")] = vp_getoption("airtimevalue1");
																			}

																			$sc = vp_getoption("airtimesuccesscode");
																			//echo "<script>alert('url1".$url."');</script>";

																			$token = vp_getoption("airtimehead1");
																			$auto = "$token $the_auth";


																			$vtuairtime_array["cache-control"] = "no-cache";
																			$vtuairtime_array["content-type"] = "application/json";


																			for ($vtuaddheaders = 1; $vtuaddheaders <= 4; $vtuaddheaders++) {
																				if (!empty(vp_getoption("vtuaddheaders$vtuaddheaders")) && !empty(vp_getoption("vtuaddvalue$vtuaddheaders"))) {
																					$vtuairtime_array[vp_getoption("vtuaddheaders$vtuaddheaders")] = vp_getoption("vtuaddvalue$vtuaddheaders");
																				}
																			}


																			$response = vp_remote_post_fn($url, $vtuairtime_array, $datass);

																		}

																		/*
																		echo "<pre>";
																		print_r(curl_getinfo($ch));
																		echo "<br></pre></br>";
																		*/

																		if (vp_option_array($option_array, "airtime1_response_format") == "json") {
																			$en = validate_response1($response, $sc, vp_option_array($option_array, "airtimesuccessvalue"), vp_option_array($option_array, "airtimesuccessvalue2"));
																		} else {
																			$en = $response;
																		}



																		$vtu_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "vturesponse_id"));

																		if (!empty($vtu_response)) {
																			$vtu_token = $vtu_response[0];
																		} else {
																			$vtu_token = "Nill";
																		}


																		if ($en == "TRUE" || $response === vp_option_array($option_array, "airtimesuccessvalue")) {
																			$myemail = get_userdata($id)->user_email;
																			$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																			wp_mail($myemail, "New Vend Data [" . $name . "]", $content);


																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'response_id' => $vtu_token,
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'vtu',
																				'trans_method' => 'post',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Successful",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			if (is_plugin_active("vpmlm/vpmlm.php")) {
																				do_action("vp_after_api");
																				vp_updateuser($id, 'vp_bal', $tot);
																			} else {
																				vp_updateuser($id, 'vp_bal', $tot);
																			}
																			//POST VTU AIRTIME SUCCESS
																			$obj = new stdClass;
																			$obj->status = "100";
																			$obj->request_id = $uniqidvalue;

																			$obj->Successful = "true";
																			$obj->message = "Purchase Was Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Current_Balance = $tot;
																			$obj->Amount_Charged = $amountv;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																		} else {

																			include_once(ABSPATH . "wp-load.php");
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'response_id' => $vtu_token,
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'vtu',
																				'trans_method' => 'post',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Failed",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			//vp_updateuser($id, 'vp_bal', $tot);


																			//POST VTU AIRTIME FAILED
																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Purchase Was Not Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			$obj->Response = harray_key_first1($response);
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));


																		}
																	}

																} elseif ($airtimechoice == "share") {

																	if (vp_option_array($option_array, "setairtime") == "checked" && !empty(vp_option_array($option_array, "sairtimebaseurl")) && !empty(vp_option_array($option_array, "sairtimeendpoint")) && vp_option_array($option_array, "sharecontrol") == "checked") {

																	} else {
																		$obj = new stdClass;
																		$obj->status = "200";
																		$obj->Successful = "false";
																		$obj->message = "Shared Airtime Not Available";
																		die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																	}



																	switch ($dnetwork) {
																		case "mtn":
																			$network = vp_option_array($option_array, "sairtimemtn");
																			break;
																		case "glo":
																			$network = vp_option_array($option_array, "sairtimeglo");
																			break;
																		case "airtel":
																			$network = vp_option_array($option_array, "sairtimeairtel");
																			break;
																		case "9mobile":
																			$network = vp_option_array($option_array, "sairtime9mobile");
																			break;
																		default:
																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~";
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																			;
																	}
																	$vpdebug = vp_option_array($option_array, "vpdebug");
																	if (vp_option_array($option_array, "sairtimerequest") == "get") {
																		//$ch = curl_init($url);
																		$url = vp_option_array($option_array, "sairtimebaseurl") . vp_option_array($option_array, "sairtimeendpoint") . vp_option_array($option_array, "sairtimepostdata1") . "=" . vp_option_array($option_array, "sairtimepostvalue1") . "&" . vp_option_array($option_array, "sarequest_id") . "=" . $uniqidvalue . "&" . vp_option_array($option_array, "sairtimepostdata2") . "=" . vp_option_array($option_array, "sairtimepostvalue2") . "&" . vp_option_array($option_array, "sairtimepostdata3") . "=" . vp_option_array($option_array, "sairtimepostvalue3") . "&" . vp_option_array($option_array, "sairtimepostdata4") . "=" . vp_option_array($option_array, "sairtimepostvalue4") . "&" . vp_option_array($option_array, "sairtimepostdata5") . "=" . vp_option_array($option_array, "sairtimepostvalue5") . "&" . vp_option_array($option_array, "sairtimenetworkattribute") . "=" . $network . "&" . vp_option_array($option_array, "sairtimeamountattribute") . "=" . $amount . "&" . vp_option_array($option_array, "sairtimephoneattribute") . "=" . $phone;

																		$sc = vp_option_array($option_array, "sairtimesuccesscode");
																		//echo "<script>alert('url1".$url."');</script>";
																		$http_args = array(
																			'headers' => array(
																				'cache-control' => 'no-cache',
																				'Content-Type' => 'application/json'
																			),
																			'timeout' => '300',
																			'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																			'sslverify' => false
																		);


																		$call = wp_remote_post($url, $http_args);
																		$response = wp_remote_retrieve_body($call);


																		if (is_wp_error($call)) {
																			if (vp_option_array($option_array, "vpdebug") != "yes") {
																				$error = $call->get_error_code();
																			} else {
																				$error = $call->get_error_message();
																			}

																			die($error);
																		}

																		if (vp_option_array($option_array, "airtime2_response_format") == "json") {
																			$en = validate_response1($response, $sc, vp_option_array($option_array, "sairtimesuccessvalue"), vp_option_array($option_array, "sairtimesuccessvalue2"));
																		} else {
																			$en = $response;
																		}



																		$share_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "shareresponse_id"));

																		if (!empty($share_response)) {
																			$share_token = $share_response[0];
																		} else {
																			$share_token = "Nill";
																		}

																		$vpdebug = vp_option_array($option_array, "vpdebug");
																		if ($en == "TRUE" || $response === vp_option_array($option_array, "sairtimesuccessvalue")) {
																			$vpdebug = vp_option_array($option_array, "vpdebug");
																			include_once(ABSPATH . "wp-load.php");
																			$myemail = get_userdata($id)->user_email;
																			$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																			wp_mail($myemail, "New Vend Data [" . $name . "]", $content);
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'response_id' => $share_token,
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'share',
																				'trans_method' => 'get',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Successful",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			if (is_plugin_active("vpmlm/vpmlm.php")) {
																				do_action("vp_after_api");
																				vp_updateuser($id, 'vp_bal', $tot);
																			} else {
																				vp_updateuser($id, 'vp_bal', $tot);
																			}

																			$obj = new stdClass;
																			$obj->status = "100";
																			$obj->request_id = $uniqidvalue;

																			$obj->Successful = "true";
																			$obj->message = "Purchase Was Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Current_Balance = $tot;
																			$obj->Amount_Charged = $amountv;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																		} else {

																			include_once(ABSPATH . "wp-load.php");
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'response_id' => $share_token,
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'share',
																				'trans_method' => 'get',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Failed",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			//vp_updateuser($id, 'vp_bal', $tot);


																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Purchase Was Not Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			$obj->Response = harray_key_first1($response);
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																		}
																	} else {

																		$url = vp_option_array($option_array, "sairtimebaseurl") . vp_option_array($option_array, "sairtimeendpoint");
																		$num = $phone;
																		$cua = vp_option_array($option_array, "sairtimepostdata1");
																		$cppa = vp_option_array($option_array, "sairtimepostdata2");
																		$c1a = vp_option_array($option_array, "sairtimepostdata3");
																		$c2a = vp_option_array($option_array, "sairtimepostdata4");
																		$c3a = vp_option_array($option_array, "sairtimepostdata5");
																		$cna = vp_option_array($option_array, "sairtimenetworkattribute");
																		$caa = vp_option_array($option_array, "sairtimeamountattribute");
																		$cpa = vp_option_array($option_array, "sairtimephoneattribute");
																		$uniqid = vp_option_array($option_array, "sarequest_id");

																		$datass = array(
																			$cua => vp_option_array($option_array, "sairtimepostvalue1"),
																			$cppa => vp_option_array($option_array, "sairtimepostvalue2"),
																			$c1a => vp_option_array($option_array, "sairtimepostvalue3"),
																			$c2a => vp_option_array($option_array, "sairtimepostvalue4"),
																			$c3a => vp_option_array($option_array, "sairtimepostvalue5"),
																			$uniqid => $uniqidvalue,
																			$cna => $network,
																			$caa => $amount,
																			$cpa => $phone
																		);


																		$the_head = vp_option_array($option_array, "airtime_head2");
																		if ($the_head == "not_concatenated") {
																			$the_auth = vp_option_array($option_array, "sairtimevalue1");
																		} else {
																			$the_auth_value = vp_option_array($option_array, "sairtimevalue1");
																			$the_auth = base64_encode($the_auth_value);
																		}

																		$auto = vp_option_array($option_array, "sairtimehead1") . ' ' . $the_auth;
																		$sc = vp_option_array($option_array, "sairtimesuccesscode");
																		if (vp_option_array($option_array, "sharequerymethod") != "array") {


																			$shareairtime_array = [];

																			$the_head = vp_getoption("airtime_head2");
																			if ($the_head == "not_concatenated") {
																				$the_auth = vp_getoption("sairtimevalue1");
																				$auto = vp_getoption("sairtimehead1") . ' ' . $the_auth;
																				$shareairtime_array["Authorization"] = $auto;
																			} elseif ($the_head == "concatenated") {
																				$the_auth_value = vp_getoption("sairtimevalue1");
																				$the_auth = base64_encode($the_auth_value);
																				$auto = vp_getoption("sairtimehead1") . ' ' . $the_auth;
																				$shareairtime_array["Authorization"] = $auto;
																			} else {
																				$shareairtime_array[vp_getoption("sairtimehead1")] = vp_getoption("sairtimevalue1");
																			}

																			$shareairtime_array = [];
																			$shareairtime_array["Content-Type"] = "application/json";
																			$shareairtime_array["cache-control"] = "no-cache";

																			for ($shareaddheaders = 1; $shareaddheaders <= 4; $shareaddheaders++) {
																				if (!empty(vp_getoption("shareaddheaders$shareaddheaders")) && !empty(vp_getoption("shareaddvalue$shareaddheaders"))) {
																					$shareairtime_array[vp_getoption("shareaddheaders$shareaddheaders")] = vp_getoption("shareaddvalue$shareaddheaders");
																				}
																			}



																			//echo "<script>alert('url1".$url."');</script>";
																			$http_args = array(
																				'headers' => $shareairtime_array,
																				'timeout' => '300',
																				'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																				'sslverify' => false,
																				'body' => json_encode($datass)
																			);


																			$call = wp_remote_post($url, $http_args);
																			$response = wp_remote_retrieve_body($call);

																			if (is_wp_error($call)) {
																				if (vp_option_array($option_array, "vpdebug") != "yes") {
																					$error = $call->get_error_code();
																				} else {
																					$error = $call->get_error_message();
																				}

																				die($error);
																			}


																		} else {


																			$shareairtime_array = [];

																			$the_head = vp_getoption("airtime_head2");
																			if ($the_head == "not_concatenated") {
																				$the_auth = vp_getoption("sairtimevalue1");
																				$auto = vp_getoption("sairtimehead1") . ' ' . $the_auth;
																				$shareairtime_array["Authorization"] = $auto;
																			} elseif ($the_head == "concatenated") {
																				$the_auth_value = vp_getoption("sairtimevalue1");
																				$the_auth = base64_encode($the_auth_value);
																				$auto = vp_getoption("sairtimehead1") . ' ' . $the_auth;
																				$shareairtime_array["Authorization"] = $auto;
																			} else {
																				$shareairtime_array[vp_getoption("sairtimehead1")] = vp_getoption("sairtimevalue1");
																			}

																			$shareairtime_array = [];
																			$shareairtime_array["Content-Type"] = "application/json";
																			$shareairtime_array["cache-control"] = "no-cache";

																			for ($shareaddheaders = 1; $shareaddheaders <= 4; $shareaddheaders++) {
																				if (!empty(vp_getoption("shareaddheaders$shareaddheaders")) && !empty(vp_getoption("shareaddvalue$shareaddheaders"))) {
																					$shareairtime_array[vp_getoption("shareaddheaders$shareaddheaders")] = vp_getoption("shareaddvalue$shareaddheaders");
																				}
																			}

																			$response = vp_remote_post_fn($url, $shareairtime_array, $datass);

																		}




																		if (vp_option_array($option_array, "airtime2_response_format") == "json") {
																			$en = validate_response1($response, $sc, vp_option_array($option_array, "sairtimesuccessvalue"), vp_option_array($option_array, "sairtimesuccessvalue2"));
																		} else {
																			$en = $response;
																		}


																		$share_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "shareresponse_id"));

																		if (!empty($share_response)) {
																			$share_token = $share_response[0];
																		} else {
																			$share_token = "Nill";
																		}

																		if ($en == "TRUE" || $response === vp_option_array($option_array, "sairtimesuccessvalue")) {
																			$myemail = get_userdata($id)->user_email;
																			$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																			wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'share',
																				'trans_method' => 'post',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'response_id' => $share_token,
																				'status' => "Successful",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			if (is_plugin_active("vpmlm/vpmlm.php")) {
																				do_action("vp_after_api");
																				vp_updateuser($id, 'vp_bal', $tot);
																			} else {
																				vp_updateuser($id, 'vp_bal', $tot);
																			}

																			$obj = new stdClass;
																			$obj->status = "100";
																			$obj->request_id = $uniqidvalue;

																			$obj->Successful = "true";
																			$obj->message = "Purchase Was Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Current_Balance = $tot;
																			$obj->Amount_Charged = $amountv;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																		} else {

																			include_once(ABSPATH . "wp-load.php");
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'share',
																				'trans_method' => 'post',
																				'via' => $via,
																				'time_taken' => '2',
																				'request_id' => $uniqidvalue . $session,
																				'response_id' => $share_token,
																				'status' => "Failed",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			// vp_updateuser($id, 'vp_bal', $tot);


																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Purchase Was Not Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			$obj->Response = harray_key_first1($response);
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																		}
																	}



																} else {


																	if (vp_option_array($option_array, "setairtime") == "checked" && !empty(vp_option_array($option_array, "wairtimebaseurl")) && !empty(vp_option_array($option_array, "wairtimeendpoint")) && vp_option_array($option_array, "awufcontrol") == "checked") {

																	} else {
																		$obj = new stdClass;
																		$obj->status = "200";
																		$obj->Successful = "false";
																		$obj->message = "Awuf Airtime Not Available";
																		die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																	}


																	switch ($dnetwork) {
																		case "mtn":
																			$network = vp_option_array($option_array, "wairtimemtn");
																			break;
																		case "glo":
																			$network = vp_option_array($option_array, "wairtimeglo");
																			break;
																		case "airtel":
																			$network = vp_option_array($option_array, "wairtimeairtel");
																			break;
																		case "9mobile":
																			$network = vp_option_array($option_array, "wairtime9mobile");
																			break;
																		default:
																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~";
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																			;
																	}
																	$vpdebug = vp_option_array($option_array, "vpdebug");
																	if (vp_option_array($option_array, "wairtimerequest") == "get") {
																		//$ch = curl_init($url);

																		$url = vp_option_array($option_array, "wairtimebaseurl") . vp_option_array($option_array, "wairtimeendpoint") . vp_option_array($option_array, "wairtimepostdata1") . "=" . vp_option_array($option_array, "wairtimepostvalue1") . "&" . vp_option_array($option_array, "warequest_id") . "=" . $uniqidvalue . "&" . vp_option_array($option_array, "wairtimepostdata2") . "=" . vp_option_array($option_array, "wairtimepostvalue2") . "&" . vp_option_array($option_array, "wairtimepostdata3") . "=" . vp_option_array($option_array, "wairtimepostvalue3") . "&" . vp_option_array($option_array, "wairtimepostdata4") . "=" . vp_option_array($option_array, "wairtimepostvalue4") . "&" . vp_option_array($option_array, "wairtimepostdata5") . "=" . vp_option_array($option_array, "wairtimepostvalue5") . "&" . vp_option_array($option_array, "wairtimenetworkattribute") . "=" . $network . "&" . vp_option_array($option_array, "wairtimeamountattribute") . "=" . $amount . "&" . vp_option_array($option_array, "wairtimephoneattribute") . "=" . $phone;


																		$sc = vp_option_array($option_array, "wairtimesuccesscode");
																		//echo "<script>alert('url1".$url."');</script>";
																		$http_args = array(
																			'headers' => array(
																				'cache-control' => 'no-cache',
																				'Content-Type' => 'application/json'
																			),
																			'timeout' => '300',
																			'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																			'sslverify' => false
																		);

																		$call = wp_remote_post($url, $http_args);
																		$response = wp_remote_retrieve_body($call);


																		if (is_wp_error($call)) {
																			if (vp_option_array($option_array, "vpdebug") != "yes") {
																				$error = $call->get_error_code();
																			} else {
																				$error = $call->get_error_message();
																			}

																			die($error);
																		}

																		if (vp_option_array($option_array, "airtime3_response_format") == "json") {
																			$en = validate_response1($response, $sc, vp_option_array($option_array, "wairtimesuccessvalue"), vp_option_array($option_array, "wairtimesuccessvalue2"));
																		} else {
																			$en = $response;
																		}


																		$vpdebug = vp_option_array($option_array, "vpdebug");

																		$awuf_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "awufresponse_id"));

																		if (!empty($awuf_response)) {
																			$awuf_token = $awuf_response[0];
																		} else {
																			$awuf_token = "Nill";
																		}

																		if ($en == "TRUE" || $response === vp_option_array($option_array, "wairtimesuccessvalue")) {
																			$vpdebug = vp_option_array($option_array, "vpdebug");
																			include_once(ABSPATH . "wp-load.php");
																			$myemail = get_userdata($id)->user_email;
																			$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																			wp_mail($myemail, "New Vend Data [" . $name . "]", $content);
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'awuf',
																				'trans_method' => 'get',
																				'via' => $via,
																				'time_taken' => '2',
																				'response_id' => $awuf_token,
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Successful",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			if (is_plugin_active("vpmlm/vpmlm.php")) {
																				do_action("vp_after_api");
																				vp_updateuser($id, 'vp_bal', $tot);
																			} else {
																				vp_updateuser($id, 'vp_bal', $tot);
																			}

																			$obj = new stdClass;
																			$obj->status = "100";
																			$obj->request_id = $uniqidvalue;

																			$obj->Successful = "true";
																			$obj->message = "Purchase Was Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Current_Balance = $tot;
																			$obj->Amount_Charged = $amountv;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																		} else {

																			include_once(ABSPATH . "wp-load.php");
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'awuf',
																				'trans_method' => 'get',
																				'via' => $via,
																				'time_taken' => '2',
																				'response_id' => $awuf_token,
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Failed",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			// vp_updateuser($id, 'vp_bal', $tot);


																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Purchase Was Not Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			$obj->Response = harray_key_first1($response);
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));


																		}
																	} else {

																		$url = vp_option_array($option_array, "wairtimebaseurl") . vp_option_array($option_array, "wairtimeendpoint");
																		$num = $phone;
																		$cua = vp_option_array($option_array, "wairtimepostdata1");
																		$cppa = vp_option_array($option_array, "wairtimepostdata2");
																		$c1a = vp_option_array($option_array, "wairtimepostdata3");
																		$c2a = vp_option_array($option_array, "wairtimepostdata4");
																		$c3a = vp_option_array($option_array, "wairtimepostdata5");
																		$cna = vp_option_array($option_array, "wairtimenetworkattribute");
																		$caa = vp_option_array($option_array, "wairtimeamountattribute");
																		$cpa = vp_option_array($option_array, "wairtimephoneattribute");
																		$uniqid = vp_option_array($option_array, "warequest_id");

																		$datass = array(
																			$cua => vp_option_array($option_array, "wairtimepostvalue1"),
																			$cppa => vp_option_array($option_array, "wairtimepostvalue2"),
																			$c1a => vp_option_array($option_array, "wairtimepostvalue3"),
																			$c2a => vp_option_array($option_array, "wairtimepostvalue4"),
																			$c3a => vp_option_array($option_array, "wairtimepostvalue5"),
																			$uniqid => $uniqidvalue,
																			$cna => $network,
																			$caa => $amount,
																			$cpa => $phone
																		);

																		$the_head = vp_option_array($option_array, "airtime_head3");
																		if ($the_head == "not_concatenated") {
																			$the_auth = vp_option_array($option_array, "wairtimevalue1");
																		} else {
																			$the_auth_value = vp_option_array($option_array, "wairtimevalue1");
																			$the_auth = base64_encode($the_auth_value);
																		}

																		$sc = vp_option_array($option_array, "wairtimesuccesscode");
																		$auto = vp_option_array($option_array, "wairtimehead1") . ' ' . $the_auth;

																		if (vp_option_array($option_array, "awufquerymethod") != "array") {


																			$awufairtime_array = [];

																			$the_head = vp_getoption("airtime_head2");
																			if ($the_head == "not_concatenated") {
																				$the_auth = vp_getoption("wairtimevalue1");
																				$auto = vp_getoption("wairtimehead1") . ' ' . $the_auth;
																				$awufairtime_array["Authorization"] = $auto;
																			} elseif ($the_head == "concatenated") {
																				$the_auth_value = vp_getoption("wairtimevalue1");
																				$the_auth = base64_encode($the_auth_value);
																				$auto = vp_getoption("wairtimehead1") . ' ' . $the_auth;
																				$awufairtime_array["Authorization"] = $auto;
																			} else {
																				$awufairtime_array[vp_getoption("wairtimehead1")] = vp_getoption("wairtimevalue1");
																			}

																			$sc = vp_getoption("wairtimesuccesscode");
																			$auto = vp_getoption("wairtimehead1") . ' ' . $the_auth;


																			$awufairtime_array["Content-Type"] = "application/json";
																			$awufairtime_array["cache-control"] = "no-cache";

																			for ($awufaddheaders = 1; $awufaddheaders <= 4; $awufaddheaders++) {
																				if (!empty(vp_getoption("awufaddheaders$awufaddheaders")) && !empty(vp_getoption("awufaddvalue$awufaddheaders"))) {
																					$awufairtime_array[vp_getoption("awufaddheaders$awufaddheaders")] = vp_getoption("awufaddvalue$awufaddheaders");
																				}
																			}

																			//echo "<script>alert('url1".$url."');</script>";
																			$call = wp_remote_post($url, $http_args);
																			$response = wp_remote_retrieve_body($call);

																			if (is_wp_error($call)) {
																				if (vp_option_array($option_array, "vpdebug") != "yes") {
																					$error = $call->get_error_code();
																				} else {
																					$error = $call->get_error_message();
																				}

																				die($error);
																			}

																		} else {

																			$awufairtime_array = [];

																			$the_head = vp_getoption("airtime_head2");
																			if ($the_head == "not_concatenated") {
																				$the_auth = vp_getoption("wairtimevalue1");
																				$auto = vp_getoption("wairtimehead1") . ' ' . $the_auth;
																				$awufairtime_array["Authorization"] = $auto;
																			} elseif ($the_head == "concatenated") {
																				$the_auth_value = vp_getoption("wairtimevalue1");
																				$the_auth = base64_encode($the_auth_value);
																				$auto = vp_getoption("wairtimehead1") . ' ' . $the_auth;
																				$awufairtime_array["Authorization"] = $auto;
																			} else {
																				$awufairtime_array[vp_getoption("wairtimehead1")] = vp_getoption("wairtimevalue1");
																			}

																			$sc = vp_getoption("wairtimesuccesscode");
																			$auto = vp_getoption("wairtimehead1") . ' ' . $the_auth;


																			$awufairtime_array["Content-Type"] = "application/json";
																			$awufairtime_array["cache-control"] = "no-cache";

																			for ($awufaddheaders = 1; $awufaddheaders <= 4; $awufaddheaders++) {
																				if (!empty(vp_getoption("awufaddheaders$awufaddheaders")) && !empty(vp_getoption("awufaddvalue$awufaddheaders"))) {
																					$awufairtime_array[vp_getoption("awufaddheaders$awufaddheaders")] = vp_getoption("awufaddvalue$awufaddheaders");
																				}
																			}

																			$response = vp_remote_post_fn($url, $awufairtime_array, $datass);
																		}



																		if (vp_option_array($option_array, "airtime3_response_format") == "json") {
																			$en = validate_response1($response, $sc, vp_option_array($option_array, "wairtimesuccessvalue"), vp_option_array($option_array, "wairtimesuccessvalue2"));
																		} else {
																			$en = $response;
																		}


																		$awuf_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "awufresponse_id"));

																		if (!empty($awuf_response)) {
																			$awuf_token = $awuf_response[0];
																		} else {
																			$awuf_token = "Nill";
																		}



																		if ($en == "TRUE" || $response === vp_option_array($option_array, "wairtimesuccessvalue")) {
																			$myemail = get_userdata($id)->user_email;
																			$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																			wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'awuf',
																				'trans_method' => 'post',
																				'via' => $via,
																				'time_taken' => '2',
																				'response_id' => $awuf_token,
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Successful",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			if (is_plugin_active("vpmlm/vpmlm.php")) {
																				do_action("vp_after_api");
																				vp_updateuser($id, 'vp_bal', $tot);
																			} else {
																				vp_updateuser($id, 'vp_bal', $tot);
																			}

																			$obj = new stdClass;
																			$obj->status = "100";
																			$obj->request_id = $uniqidvalue;

																			$obj->Successful = "true";
																			$obj->message = "Purchase Was Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Current_Balance = $tot;
																			$obj->Amount_Charged = $amountv;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																		} else {

																			include_once(ABSPATH . "wp-load.php");
																			global $wpdb;
																			$table_name = $wpdb->prefix . 'sairtime';
																			$wpdb->insert($table_name, array(
																				'name' => $name,
																				'email' => $email,
																				'network' => $dnetwork,
																				'phone' => $phone,
																				'bal_bf' => $bal,
																				'bal_nw' => $baln,
																				'amount' => $amountv,
																				'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																				'user_id' => $id,
																				'browser' => $browser,
																				'trans_type' => 'awuf',
																				'trans_method' => 'post',
																				'via' => $via,
																				'time_taken' => '2',
																				'response_id' => $awuf_token,
																				'request_id' => $uniqidvalue . $session,
																				'status' => "Failed",
																				'the_time' => date('Y-m-d h-i-s')
																			));

																			$tot = $bal - $amountv;

																			// vp_updateuser($id, 'vp_bal', $tot);


																			$obj = new stdClass;
																			$obj->status = "200";
																			$obj->Successful = "false";
																			$obj->message = "Purchase Was Not Successful";
																			$obj->Previous_Balance = $bal;
																			$obj->Type = $_REQUEST["type"];
																			$obj->Receiver = $phone;
																			$obj->Network = $network;
																			$obj->Response = harray_key_first1($response);
																			die(json_encode($obj, JSON_UNESCAPED_SLASHES));


																		}
																	}

																}
															} else {
																//Balance too low airtime
																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Balance Too Low";
																$obj->Balance = $bal;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));
															}

														} else {
															$obj = new stdClass;
															$obj->status = "200";
															$obj->Successful = "false";
															$obj->message = "Amount Not Specified";
															die(json_encode($obj, JSON_UNESCAPED_SLASHES));

														}
													} else {
														$obj = new stdClass;
														$obj->status = "200";
														$obj->Successful = "false";
														$obj->message = "Receipient Not Specified";
														die(json_encode($obj, JSON_UNESCAPED_SLASHES));

													}

												} else {
													$obj = new stdClass;
													$obj->status = "200";
													$obj->Successful = "false";
													$obj->message = "Network Not Specified";
													die(json_encode($obj, JSON_UNESCAPED_SLASHES));

												}






											} else {
												die('{"status":"200","message":"type error"}');
											}
											//AIRTIME END
										} else {
											$obj = new stdClass;
											$obj->status = "200";
											$obj->Sucessful = "false";
											$obj->message = "AIRTIME TYPE NOT ENTERED";

											die(json_encode($obj, JSON_UNESCAPED_SLASHES));
										}

									} else {
										$obj = new stdClass;
										$obj->status = "200";
										$obj->Sucessful = "false";
										$obj->message = "AMOUNT NOT SPECIFIED";

										die(json_encode($obj, JSON_UNESCAPED_SLASHES));
									}
								} else {
									$obj = new stdClass;
									$obj->status = "200";
									$obj->Sucessful = "false";
									$obj->message = "NETWORK NOT SPECIFIED";

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								}

							} else {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Sucessful = "false";
								$obj->message = "RECIPIENT NOT SPECIFIED";

								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							break;
						case "data":
							$mlm_for = "_data";
							if (isset($_REQUEST["type"])) {

								if (isset($_REQUEST["network"])) {

									if (isset($_REQUEST["dataplan"])) {

										if (isset($_REQUEST["phone"])) {
											if (isset($_REQUEST["type"]) && ($_REQUEST["type"] == "sme" || $_REQUEST["type"] == "direct" || $_REQUEST["type"] == "corporate")) {
												$vpdebug = vp_option_array($option_array, "vpdebug");
												$phone = $_REQUEST['phone'];
												$dnetwork = $_REQUEST['network'];
												$datatcode = $_REQUEST["type"];

												if (strtolower($level[0]->developer) == "yes") {

													if (isset($_REQUEST['network'])) {
														$disnetwork = strtoupper($_REQUEST['network']);
														$datnetwork = strtoupper($_REQUEST['network']);
													}



													switch ($q) {
														case "data":
															$mlm_for = "_data";
															$valid_dataplan = "no";
															for ($i = 0; $i <= 10; $i++) {
																switch ($_REQUEST["dataplan"]) {
																	case vp_option_array($option_array, "api$i"):
																		$plan = vp_option_array($option_array, "cdata$i");
																		$disamount = vp_option_array($option_array, "cdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "mtn";
																		$plan_type = "sme";
																		$plan_name = vp_option_array($option_array, "cdatan$i");
																		break;
																	case vp_option_array($option_array, "aapi$i"):
																		$plan = vp_option_array($option_array, "acdata$i");
																		$disamount = vp_option_array($option_array, "acdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "airtel";
																		$plan_type = "sme";
																		$plan_name = vp_option_array($option_array, "acdatan$i");
																		break;
																	case vp_option_array($option_array, "9api$i"):
																		$plan = vp_option_array($option_array, "9cdata$i");
																		$disamount = vp_option_array($option_array, "9cdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "9mobile";
																		$plan_type = "sme";
																		$plan_name = vp_option_array($option_array, "9cdatan$i");
																		break;
																	case vp_option_array($option_array, "gapi$i"):
																		$plan = vp_option_array($option_array, "gcdata$i");
																		$disamount = vp_option_array($option_array, "gcdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "glo";
																		$plan_type = "sme";
																		$plan_name = vp_option_array($option_array, "gcdatan$i");
																		break;
																	case vp_option_array($option_array, "api2$i"):
																		$plan = vp_option_array($option_array, "rcdata$i");
																		$disamount = vp_option_array($option_array, "rcdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "mtn";
																		$plan_type = "direct";
																		$plan_name = vp_option_array($option_array, "rcdatan$i");
																		break;
																	case vp_option_array($option_array, "aapi2$i"):
																		$plan = vp_option_array($option_array, "racdata$i");
																		$disamount = vp_option_array($option_array, "racdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "airtel";
																		$plan_type = "direct";
																		$plan_name = vp_option_array($option_array, "racdatan$i");
																		break;
																	case vp_option_array($option_array, "9api2$i"):
																		$plan = vp_option_array($option_array, "r9cdata$i");
																		$disamount = vp_option_array($option_array, "r9cdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "9mobile";
																		$plan_type = "direct";
																		$plan_name = vp_option_array($option_array, "r9cdatan$i");
																		break;
																	case vp_option_array($option_array, "gapi2$i"):
																		$plan = vp_option_array($option_array, "rgcdata$i");
																		$disamount = vp_option_array($option_array, "rgcdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "glo";
																		$plan_type = "direct";
																		$plan_name = vp_option_array($option_array, "rgcdatan$i");
																		break;
																	case vp_option_array($option_array, "api3$i"):
																		$plan = vp_option_array($option_array, "r2cdata$i");
																		$disamount = vp_option_array($option_array, "r2cdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "mtn";
																		$plan_type = "corporate";
																		$plan_name = vp_option_array($option_array, "r2cdatan$i");
																		break;
																	case vp_option_array($option_array, "aapi3$i"):
																		$plan = vp_option_array($option_array, "r2acdata$i");
																		$disamount = vp_option_array($option_array, "r2acdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "airtel";
																		$plan_type = "corporate";
																		$plan_name = vp_option_array($option_array, "r2acdatan$i");
																		break;
																	case vp_option_array($option_array, "9api3$i"):
																		$plan = vp_option_array($option_array, "r29cdata$i");
																		$disamount = vp_option_array($option_array, "r29cdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "9mobile";
																		$plan_type = "corporate";
																		$plan_name = vp_option_array($option_array, "r29cdatan$i");
																		break;
																	case vp_option_array($option_array, "gloapi3$i"):
																		$plan = vp_option_array($option_array, "r2gcdata$i");
																		$disamount = vp_option_array($option_array, "r2gcdatap$i");
																		$valid_dataplan = "yes";
																		$plan_network = "glo";
																		$plan_type = "corporate";
																		$plan_name = vp_option_array($option_array, "r2gcdatan$i");
																		break;
																}
															}

															if ($valid_dataplan == "yes") {

																if ($plan_type == $datatcode) {

																	if ($plan_network == $_REQUEST["network"]) {
																		if ($datatcode == "sme") {
																			switch ($datnetwork) {
																				case "MTN":
																					$fir = intval($disamount) * floatval($level[0]->mtn_sme);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "GLO":
																					$fir = $disamount * floatval($level[0]->glo_sme);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "9MOBILE":
																					$fir = $disamount * floatval($level[0]->mobile_sme);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "AIRTEL":
																					$fir = $disamount * floatval($level[0]->airtel_sme);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				default:
																					$obj = new stdClass;
																					$obj->status = "200";
																					$obj->Successful = "false";
																					$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~ For SME (p-$plan a-$disamount)";
																					die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																					;
																			}
																			;

																		} elseif ($datatcode == "direct") {
																			switch ($datnetwork) {
																				case "MTN":
																					$fir = $disamount * floatval($level[0]->mtn_gifting);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "GLO":
																					$fir = $disamount * floatval($level[0]->glo_gifting);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "9MOBILE":
																					$fir = $disamount * floatval($level[0]->mobile_gifting);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "AIRTEL":
																					$fir = $disamount * floatval($level[0]->airtel_gifting);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				default:
																					$obj = new stdClass;
																					$obj->status = "200";
																					$obj->Successful = "false";
																					$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~ For Gifting (p-$plan a-$disamount)";
																					die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																					;
																			}
																			;

																		} elseif ($datatcode == "corporate") {
																			switch ($datnetwork) {
																				case "MTN":
																					$fir = $disamount * floatval($level[0]->mtn_corporate);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "GLO":
																					$fir = $disamount * floatval($level[0]->glo_corporate);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "9MOBILE":
																					$fir = $disamount * floatval($level[0]->mobile_corporate);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				case "AIRTEL":
																					$fir = $disamount * floatval($level[0]->airtel_corporate);
																					$sec = $fir / 100;
																					$amountv = $disamount - $sec;
																					$baln = $bal - $disamount;
																					break;
																				default:
																					$obj = new stdClass;
																					$obj->status = "200";
																					$obj->Successful = "false";
																					$obj->message = "Network Invalid ~MTN - GLO - 9MOBILE - AIRTEL~ For Corporate (p-$plan a-$disamount)";
																					die(json_encode($obj, JSON_UNESCAPED_SLASHES));
																					;
																			}
																			;

																		}

																	} else {
																		$obj = new stdClass;
																		$obj->status = "200";
																		$obj->Successful = "false";
																		$obj->message = "DATA PLAN AND DATA NETWORK DOESN'T MATCH";
																		die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																	}

																} else {
																	$obj = new stdClass;
																	$obj->status = "200";
																	$obj->Successful = "false";
																	$obj->message = "DATA TYPE AND DATA PLAN DOESN'T MATCH";
																	die(json_encode($obj, JSON_UNESCAPED_SLASHES));

																}


															} else {
																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "DATAPLAN INVALID";
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));
															}


															if ($discount_method == "direct") {
																$amountv = $amountv;
																$amount = $amountv;
															} else {
																$amountv = $disamount;
																$amount = $disamount;
															}

															break;

													}

												}

												if ($bal >= $amountv) {
													if ($datatcode == "sme") {

														if (vp_option_array($option_array, "setdata") == "checked" && !empty(vp_option_array($option_array, "databaseurl")) && !empty(vp_option_array($option_array, "dataendpoint")) && vp_option_array($option_array, "smecontrol") == "checked") {

														} else {
															$obj = new stdClass;
															$obj->status = "200";
															$obj->Successful = "false";
															$obj->message = "SME Data Plan not Available";
															die(json_encode($obj, JSON_UNESCAPED_SLASHES));
														}

														switch ($dnetwork) {
															case "mtn":
																$network = vp_option_array($option_array, "datamtn");
																break;
															case "glo":
																$network = vp_option_array($option_array, "dataglo");
																break;
															case "airtel":
																$network = vp_option_array($option_array, "dataairtel");
																break;
															case "9mobile":
																$network = vp_option_array($option_array, "data9mobile");
																break;
														}




														$vpdebug = vp_option_array($option_array, "vpdebug");
														if (vp_option_array($option_array, "datarequest") == "get") {
															//$ch = curl_init();
															$url = vp_option_array($option_array, "databaseurl") . vp_option_array($option_array, "dataendpoint") . vp_option_array($option_array, "datapostdata1") . '=' . vp_option_array($option_array, "datapostvalue1") . '&' . vp_option_array($option_array, "request_id") . '=' . $uniqidvalue . '&' . vp_option_array($option_array, "datapostdata2") . '=' . vp_option_array($option_array, "datapostvalue2") . '&' . vp_option_array($option_array, "datapostdata3") . '=' . vp_option_array($option_array, "datapostvalue3") . '&' . vp_option_array($option_array, "datapostdata4") . '=' . vp_option_array($option_array, "datapostvalue4") . '&' . vp_option_array($option_array, "datapostdata5") . '=' . vp_option_array($option_array, "datapostvalue5") . '&' . vp_option_array($option_array, "datanetworkattribute") . '=' . $network . '&' . vp_option_array($option_array, "dataamountattribute") . '=' . $amount . '&' . vp_option_array($option_array, "dataphoneattribute") . '=' . $phone . '&' . vp_option_array($option_array, "cvariationattr") . '=' . $plan;

															$sc = vp_option_array($option_array, "datasuccesscode");
															//echo "<script>alert('url1".$url."');</script>";

															$http_args = array(
																'headers' => array(
																	'cache-control' => 'no-cache',
																	'Content-Type' => 'application/json'
																),
																'timeout' => '300',
																'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																'sslverify' => false
															);

															$call = wp_remote_get($url, $http_args);
															$response = wp_remote_retrieve_body($call);

															if (is_wp_error($call)) {
																if (vp_option_array($option_array, "vpdebug") != "yes") {
																	$error = $call->get_error_code();
																} else {
																	$error = $call->get_error_message();
																}

																die($error);
															}


															if (vp_option_array($option_array, "data1_response_format") == "json") {
																$en = validate_response1($response, $sc, vp_option_array($option_array, "datasuccessvalue"), vp_option_array($option_array, "datasuccessvalue2"));
															} else {
																$en = $response;
															}


															$vpdebug = vp_option_array($option_array, "vpdebug");

															$sme_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "smeresponse_id"));

															if (!empty($sme_response)) {
																$sme_token = $sme_response[0];
															} else {
																$sme_token = "Nill";
															}

															if ($en == "TRUE" || $response === vp_option_array($option_array, "datasuccessvalue")) {
																include_once(ABSPATH . "wp-load.php");
																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'sme',
																	'trans_method' => 'get',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $sme_token,
																	'status' => "Successful",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																if (is_plugin_active("vpmlm/vpmlm.php")) {
																	do_action("vp_after_api");
																	vp_updateuser($id, 'vp_bal', $tot);
																} else {
																	vp_updateuser($id, 'vp_bal', $tot);
																}


																$myemail = get_userdata($id)->user_email;
																$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Plan = " . $plan . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																$obj = new stdClass;
																$obj->status = "100";
																$obj->request_id = $uniqidvalue;

																$obj->Successful = "true";
																$obj->message = "Purchase Of $plan_name Was Successful";
																$obj->Previous_Balance = $bal;
																$obj->Current_Balance = $tot;
																$obj->Amount_Charged = $amountv;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															} else {
																$vpdebug = vp_option_array($option_array, "vpdebug");

																$_SESSION["details"] = $response;
																include_once(ABSPATH . "wp-load.php");

																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'sme',
																	'trans_method' => 'get',
																	'via' => $via,
																	'time_taken' => '2',
																	'response_id' => $sme_token,
																	'request_id' => $uniqidvalue . $session,
																	'status' => "Failed",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																// vp_updateuser($id, 'vp_bal', $tot);



																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Purchase Of $plan_name Was Not Successful";
																$obj->Previous_Balance = $bal;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																$obj->Response = harray_key_first1($response);
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));


															}
														} else {
															$url = vp_option_array($option_array, "databaseurl") . vp_option_array($option_array, "dataendpoint");
															$num = $phone;
															$cua = vp_option_array($option_array, "datapostdata1");
															$cppa = vp_option_array($option_array, "datapostdata2");
															$c1a = vp_option_array($option_array, "datapostdata3");
															$c2a = vp_option_array($option_array, "datapostdata4");
															$c3a = vp_option_array($option_array, "datapostdata5");
															$cna = vp_option_array($option_array, "datanetworkattribute");
															$caa = vp_option_array($option_array, "dataamountattribute");
															$cpa = vp_option_array($option_array, "dataphoneattribute");
															$cpla = vp_option_array($option_array, "cvariationattr");
															$uniqid = vp_option_array($option_array, "request_id");

															$datass = array(
																$cua => vp_option_array($option_array, "datapostvalue1"),
																$cppa => vp_option_array($option_array, "datapostvalue2"),
																$c1a => vp_option_array($option_array, "datapostvalue3"),
																$c2a => vp_option_array($option_array, "datapostvalue4"),
																$c3a => vp_option_array($option_array, "datapostvalue5"),
																$uniqid => $uniqidvalue,
																$cna => $network,
																$cpa => $phone,
																$cpla => $plan
															);

															$the_head = vp_option_array($option_array, "data_head");
															if ($the_head == "not_concatenated") {
																$the_auth = vp_option_array($option_array, "datavalue1");
															} else {
																$the_auth_value = vp_option_array($option_array, "datavalue1");
																$the_auth = base64_encode($the_auth_value);
															}

															$auto = vp_option_array($option_array, "datahead1") . ' ' . $the_auth;
															$sc = vp_option_array($option_array, "datasuccesscode");
															if (vp_option_array($option_array, "smequerymethod") != "array") {

																$sme_array = [];

																$the_head = vp_getoption("data_head");
																if ($the_head == "not_concatenated") {
																	$the_auth = vp_getoption("datavalue1");
																	$auto = vp_getoption("datahead1") . ' ' . $the_auth;
																	$sme_array["Authorization"] = $auto;
																} elseif ($the_head == "concatenated") {
																	$the_auth_value = vp_getoption("datavalue1");
																	$the_auth = base64_encode($the_auth_value);
																	$auto = vp_getoption("datahead1") . ' ' . $the_auth;
																	$sme_array["Authorization"] = $auto;
																} else {
																	$sme_array[vp_getoption("datahead1")] = vp_getoption("datavalue1");
																}



																$sme_array["Content-Type"] = "application/json";
																$sme_array["cache-control"] = "no-cache";

																for ($smeaddheaders = 1; $smeaddheaders <= 4; $smeaddheaders++) {
																	if (!empty(vp_getoption("smeaddheaders$smeaddheaders")) && !empty(vp_getoption("smeaddvalue$smeaddheaders"))) {
																		$sme_array[vp_getoption("smeaddheaders$smeaddheaders")] = vp_getoption("smeaddvalue$smeaddheaders");
																	}
																}


																$http_args = array(
																	'headers' => $sme_array,
																	'timeout' => '300',
																	'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																	'sslverify' => false,
																	'body' => json_encode($datass)
																);
																//echo "<script>alert('url1".$url."');</script>";
																$call = wp_remote_post($url, $http_args);
																$response = wp_remote_retrieve_body($call);

																if (is_wp_error($call)) {
																	if (vp_option_array($option_array, "vpdebug") != "yes") {
																		$error = $call->get_error_code();
																	} else {
																		$error = $call->get_error_message();
																	}

																	die($error);
																}


															} else {

																$sme_array = [];

																$the_head = vp_getoption("data_head");
																if ($the_head == "not_concatenated") {
																	$the_auth = vp_getoption("datavalue1");
																	$auto = vp_getoption("datahead1") . ' ' . $the_auth;
																	$sme_array["Authorization"] = $auto;
																} elseif ($the_head == "concatenated") {
																	$the_auth_value = vp_getoption("datavalue1");
																	$the_auth = base64_encode($the_auth_value);
																	$auto = vp_getoption("datahead1") . ' ' . $the_auth;
																	$sme_array["Authorization"] = $auto;
																} else {
																	$sme_array[vp_getoption("datahead1")] = vp_getoption("datavalue1");
																}



																$sme_array["Content-Type"] = "application/json";
																$sme_array["cache-control"] = "no-cache";

																for ($smeaddheaders = 1; $smeaddheaders <= 4; $smeaddheaders++) {
																	if (!empty(vp_getoption("smeaddheaders$smeaddheaders")) && !empty(vp_getoption("smeaddvalue$smeaddheaders"))) {
																		$sme_array[vp_getoption("smeaddheaders$smeaddheaders")] = vp_getoption("smeaddvalue$smeaddheaders");
																	}
																}

																$response = vp_remote_post_fn($url, $sme_array, $datass);
															}


															if (vp_option_array($option_array, "data1_response_format") == "json") {
																$en = validate_response1($response, $sc, vp_option_array($option_array, "datasuccessvalue"), vp_option_array($option_array, "datasuccessvalue2"));
															} else {
																$en = $response;
															}



															$sme_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "smeresponse_id"));

															if (!empty($sme_response)) {
																$sme_token = $sme_response[0];
															} else {
																$sme_token = "Nill";
															}


															if ($en == "TRUE" || $response === vp_option_array($option_array, "datasuccessvalue")) {
																$myemail = get_userdata($id)->user_email;
																$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'sme',
																	'trans_method' => 'post',
																	'via' => $via,
																	'time_taken' => '2',
																	'response_id' => $sme_token,
																	'request_id' => $uniqidvalue . $session,
																	'status' => "Successful",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																if (is_plugin_active("vpmlm/vpmlm.php")) {
																	do_action("vp_after_api");
																	vp_updateuser($id, 'vp_bal', $tot);
																} else {
																	vp_updateuser($id, 'vp_bal', $tot);
																}



																$obj = new stdClass;
																$obj->status = "100";
																$obj->request_id = $uniqidvalue;

																$obj->Successful = "true";
																$obj->message = "Purchase Of $plan_name Was Successful";
																$obj->Previous_Balance = $bal;
																$obj->Current_Balance = $tot;
																$obj->Amount_Charged = $amountv;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));
															} else {

																$_SESSION["details"] = $response;
																include_once(ABSPATH . "wp-load.php");

																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'sme',
																	'trans_method' => 'post',
																	'via' => $via,
																	'time_taken' => '2',
																	'response_id' => $sme_token,
																	'request_id' => $uniqidvalue . $session,
																	'status' => "Failed",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;
																// vp_updateuser($id, 'vp_bal', $tot);



																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Purchase Of $plan_name Was Not Successful";
																$obj->Previous_Balance = $bal;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																$obj->Response = harray_key_first1($response);
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));


															}



														}
													} elseif ($datatcode == "direct") {


														if (vp_option_array($option_array, "setdata") == "checked" && !empty(vp_option_array($option_array, "rdatabaseurl")) && !empty(vp_option_array($option_array, "rdataendpoint")) && vp_option_array($option_array, "directcontrol") == "checked") {

														} else {
															$obj = new stdClass;
															$obj->status = "200";
															$obj->Successful = "false";
															$obj->message = "Gifting/Direct Data Plan not Available";
															die(json_encode($obj, JSON_UNESCAPED_SLASHES));
														}


														switch ($dnetwork) {
															case "mtn":
																$network = vp_option_array($option_array, "rdatamtn");
																break;
															case "glo":
																$network = vp_option_array($option_array, "rdataglo");
																break;
															case "airtel":
																$network = vp_option_array($option_array, "rdataairtel");
																break;
															case "9mobile":
																$network = vp_option_array($option_array, "rdata9mobile");
																break;
														}

														$vpdebug = vp_option_array($option_array, "vpdebug");
														if (vp_option_array($option_array, "rdatarequest") == "get") {
															//$ch = curl_init();
															$url = vp_option_array($option_array, "rdatabaseurl") . vp_option_array($option_array, "rdataendpoint") . vp_option_array($option_array, "rdatapostrdata1") . '=' . vp_option_array($option_array, "rdatapostvalue1") . '&' . vp_option_array($option_array, "rrequest_id") . '=' . $uniqidvalue . '&' . vp_option_array($option_array, "rdatapostrdata2") . '=' . vp_option_array($option_array, "rdatapostvalue2") . '&' . vp_option_array($option_array, "rdatapostrdata3") . '=' . vp_option_array($option_array, "rdatapostvalue3") . '&' . vp_option_array($option_array, "rdatapostrdata4") . '=' . vp_option_array($option_array, "rdatapostvalue4") . '&' . vp_option_array($option_array, "rdatapostrdata5") . '=' . vp_option_array($option_array, "rdatapostvalue5") . '&' . vp_option_array($option_array, "rdatanetworkattribute") . '=' . $network . '&' . vp_option_array($option_array, "rdataamountattribute") . '=' . $amount . '&' . vp_option_array($option_array, "rdataphoneattribute") . '=' . $phone . '&' . vp_option_array($option_array, "rcvariationattr") . '=' . $plan;

															$sc = vp_option_array($option_array, "rdatasuccesscode");
															//echo "<script>alert('url1".$url."');</script>";
															$http_args = array(
																'headers' => array(
																	'cache-control' => 'no-cache',
																	'Content-Type' => 'application/json'
																),
																'timeout' => '300',
																'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																'sslverify' => false
															);

															$call = wp_remote_get($url, $http_args);
															$response = wp_remote_retrieve_body($call);

															if (is_wp_error($call)) {
																if (vp_option_array($option_array, "vpdebug") != "yes") {
																	$error = $call->get_error_code();
																} else {
																	$error = $call->get_error_message();
																}

																die($error);
															}


															if (vp_option_array($option_array, "data2_response_format") == "json") {
																$en = validate_response1($response, $sc, vp_option_array($option_array, "rdatasuccessvalue"), vp_option_array($option_array, "rdatasuccessvalue2"));
															} else {
																$en = $response;
															}

															$vpdebug = vp_option_array($option_array, "vpdebug");

															$direct_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "directresponse_id"));

															if (!empty($direct_response)) {
																$direct_token = $direct_response[0];
															} else {
																$direct_token = "Nill";
															}


															if ($en == "TRUE" || $response === vp_option_array($option_array, "rdatasuccessvalue")) {
																include_once(ABSPATH . "wp-load.php");

																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'direct',
																	'trans_method' => 'get',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $direct_token,
																	'status' => "Successful",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																if (is_plugin_active("vpmlm/vpmlm.php")) {
																	do_action("vp_after_api");
																	vp_updateuser($id, 'vp_bal', $tot);
																} else {
																	vp_updateuser($id, 'vp_bal', $tot);
																}



																$myemail = get_userdata($id)->user_email;
																$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Plan = " . $plan . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																wp_mail($myemail, "New Vend Data [" . $name . "]", $content);
																$tot = $bal - $amountv;


																$obj = new stdClass;
																$obj->status = "100";
																$obj->request_id = $uniqidvalue;

																$obj->Successful = "true";
																$obj->message = "Purchase Of $plan_name Was Successful";
																$obj->Previous_Balance = $bal;
																$obj->Current_Balance = $tot;
																$obj->Amount_Charged = $amountv;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															} else {
																$vpdebug = vp_option_array($option_array, "vpdebug");

																$_SESSION["details"] = $response;

																include_once(ABSPATH . "wp-load.php");

																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'direct',
																	'trans_method' => 'get',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $direct_token,
																	'status' => "Failed",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																// vp_updateuser($id, 'vp_bal', $tot);



																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Purchase Of $plan_name Was Not Successful";
																$obj->Previous_Balance = $bal;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																$obj->Response = harray_key_first1($response);
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															}
														} else {
															$url = vp_option_array($option_array, "rdatabaseurl") . vp_option_array($option_array, "rdataendpoint");
															$num = $phone;
															$cua = vp_option_array($option_array, "rdatapostdata1");
															$cppa = vp_option_array($option_array, "rdatapostdata2");
															$c1a = vp_option_array($option_array, "rdatapostdata3");
															$c2a = vp_option_array($option_array, "rdatapostdata4");
															$c3a = vp_option_array($option_array, "rdatapostdata5");
															$cna = vp_option_array($option_array, "rdatanetworkattribute");
															$caa = vp_option_array($option_array, "rdataamountattribute");
															$cpa = vp_option_array($option_array, "rdataphoneattribute");
															$cpla = vp_option_array($option_array, "rcvariationattr");
															$uniqid = vp_option_array($option_array, "rrequest_id");

															$datass = array(
																$cua => vp_option_array($option_array, "rdatapostvalue1"),
																$cppa => vp_option_array($option_array, "rdatapostvalue2"),
																$c1a => vp_option_array($option_array, "rdatapostvalue3"),
																$c2a => vp_option_array($option_array, "rdatapostvalue4"),
																$c3a => vp_option_array($option_array, "rdatapostvalue5"),
																$uniqid => $uniqidvalue,
																$cna => $network,
																$cpa => $phone,
																$cpla => $plan
															);


															$the_head = vp_option_array($option_array, "data_head2");
															if ($the_head == "not_concatenated") {
																$the_auth = vp_option_array($option_array, "rdatavalue1");
															} else {
																$the_auth_value = vp_option_array($option_array, "rdatavalue1");
																$the_auth = base64_encode($the_auth_value);
															}

															$auto = vp_option_array($option_array, "rdatahead1") . ' ' . $the_auth;
															$sc = vp_option_array($option_array, "rdatasuccesscode");

															if (vp_option_array($option_array, "directquerymethod") != "array") {

																$direct_array = [];

																$the_head = vp_getoption("data_head2");
																if ($the_head == "not_concatenated") {
																	$the_auth = vp_getoption("rdatavalue1");
																	$auto = vp_getoption("rdatahead1") . ' ' . $the_auth;
																	$direct_array["Authorization"] = $auto;
																} elseif ($the_head == "concatenated") {
																	$the_auth_value = vp_getoption("rdatavalue1");
																	$the_auth = base64_encode($the_auth_value);
																	$auto = vp_getoption("rdatahead1") . ' ' . $the_auth;
																	$direct_array["Authorization"] = $auto;
																} else {
																	$direct_array[vp_getoption("rdatahead1")] = vp_getoption("rdatavalue1");
																}

																$direct_array["Content-Type"] = "application/json";
																$direct_array["cache-control"] = "no-cache";

																for ($directaddheaders = 1; $directaddheaders <= 4; $directaddheaders++) {
																	if (!empty(vp_getoption("directaddheaders$directaddheaders")) && !empty(vp_getoption("directaddvalue$directaddheaders"))) {
																		$direct_array[vp_getoption("directaddheaders$directaddheaders")] = vp_getoption("directaddvalue$directaddheaders");
																	}
																}


																$http_args = array(
																	'headers' => $direct_array,
																	'timeout' => '300',
																	'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																	'sslverify' => false,
																	'body' => json_encode($datass)
																);


																//echo "<script>alert('url1".$url."');</script>";
																$call = wp_remote_post($url, $http_args);
																$response = wp_remote_retrieve_body($call);

																if (is_wp_error($call)) {
																	if (vp_option_array($option_array, "vpdebug") != "yes") {
																		$error = $call->get_error_code();
																	} else {
																		$error = $call->get_error_message();
																	}

																	die($error);
																}

															} else {
																$direct_array = [];

																$the_head = vp_getoption("data_head2");
																if ($the_head == "not_concatenated") {
																	$the_auth = vp_getoption("rdatavalue1");
																	$auto = vp_getoption("rdatahead1") . ' ' . $the_auth;
																	$direct_array["Authorization"] = $auto;
																} elseif ($the_head == "concatenated") {
																	$the_auth_value = vp_getoption("rdatavalue1");
																	$the_auth = base64_encode($the_auth_value);
																	$auto = vp_getoption("rdatahead1") . ' ' . $the_auth;
																	$direct_array["Authorization"] = $auto;
																} else {
																	$direct_array[vp_getoption("rdatahead1")] = vp_getoption("rdatavalue1");
																}

																$direct_array["Content-Type"] = "application/json";
																$direct_array["cache-control"] = "no-cache";

																for ($directaddheaders = 1; $directaddheaders <= 4; $directaddheaders++) {
																	if (!empty(vp_getoption("directaddheaders$directaddheaders")) && !empty(vp_getoption("directaddvalue$directaddheaders"))) {
																		$direct_array[vp_getoption("directaddheaders$directaddheaders")] = vp_getoption("directaddvalue$directaddheaders");
																	}
																}

																$response = vp_remote_post_fn($url, $direct_array, $datass);
															}

															if (vp_option_array($option_array, "data2_response_format") == "json") {
																$en = validate_response1($response, $sc, vp_option_array($option_array, "rdatasuccessvalue"), vp_option_array($option_array, "rdatasuccessvalue2"));
															} else {
																$en = $response;
															}


															$direct_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "directresponse_id"));

															if (!empty($direct_response)) {
																$direct_token = $direct_response[0];
															} else {
																$direct_token = "Nill";
															}


															if ($en == "TRUE" || $response === vp_option_array($option_array, "rdatasuccessvalue")) {
																$myemail = get_userdata($id)->user_email;
																$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'direct',
																	'trans_method' => 'post',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $direct_token,
																	'status' => "Successful",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																if (is_plugin_active("vpmlm/vpmlm.php")) {
																	do_action("vp_after_api");
																	vp_updateuser($id, 'vp_bal', $tot);
																} else {
																	vp_updateuser($id, 'vp_bal', $tot);
																}


																$obj = new stdClass;
																$obj->status = "100";
																$obj->request_id = $uniqidvalue;

																$obj->Successful = "true";
																$obj->message = "Purchase Of $plan_name Was Successful";
																$obj->Previous_Balance = $bal;
																$obj->Current_Balance = $tot;
																$obj->Amount_Charged = $amountv;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															} else {

																$_SESSION["details"] = $response;

																include_once(ABSPATH . "wp-load.php");
																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'direct',
																	'trans_method' => 'post',
																	'via' => $via,
																	'time_taken' => '2',
																	'response_id' => $direct_token,
																	'request_id' => $uniqidvalue . $session,
																	'status' => "Failed",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																// vp_updateuser($id, 'vp_bal', $tot);





																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Purchase Of $plan_name Was Not Successful";
																$obj->Previous_Balance = $bal;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																$obj->Response = harray_key_first1($response);
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));


															}



														}

													} else {


														if (vp_option_array($option_array, "setdata") == "checked" && !empty(vp_option_array($option_array, "r2databaseurl")) && !empty(vp_option_array($option_array, "r2dataendpoint")) && vp_option_array($option_array, "corporatecontrol") == "checked") {

														} else {
															$obj = new stdClass;
															$obj->status = "200";
															$obj->Successful = "false";
															$obj->message = "Corporate Data Plan not Available";
															die(json_encode($obj, JSON_UNESCAPED_SLASHES));
														}

														switch ($dnetwork) {
															case "mtn":
																$network = vp_option_array($option_array, "r2datamtn");
																break;
															case "glo":
																$network = vp_option_array($option_array, "r2dataglo");
																break;
															case "airtel":
																$network = vp_option_array($option_array, "r2dataairtel");
																break;
															case "9mobile":
																$network = vp_option_array($option_array, "r2data9mobile");
																break;
														}



														$vpdebug = vp_option_array($option_array, "vpdebug");
														if (vp_option_array($option_array, "r2datarequest") == "get") {
															//$ch = curl_init();
															$url = vp_option_array($option_array, "r2databaseurl") . vp_option_array($option_array, "r2dataendpoint") . vp_option_array($option_array, "r2datapostr2data1") . '=' . vp_option_array($option_array, "r2datapostvalue1") . '&' . vp_option_array($option_array, "r2request_id") . '=' . $uniqidvalue . '&' . vp_option_array($option_array, "r2datapostr2data2") . '=' . vp_option_array($option_array, "r2datapostvalue2") . '&' . vp_option_array($option_array, "r2datapostr2data3") . '=' . vp_option_array($option_array, "r2datapostvalue3") . '&' . vp_option_array($option_array, "r2datapostr2data4") . '=' . vp_option_array($option_array, "r2datapostvalue4") . '&' . vp_option_array($option_array, "r2datapostr2data5") . '=' . vp_option_array($option_array, "r2datapostvalue5") . '&' . vp_option_array($option_array, "r2datanetworkattribute") . '=' . $network . '&' . vp_option_array($option_array, "r2dataamountattribute") . '=' . $amount . '&' . vp_option_array($option_array, "r2dataphoneattribute") . '=' . $phone . '&' . vp_option_array($option_array, "r2cvariationattr") . '=' . $plan;

															$sc = vp_option_array($option_array, "r2datasuccesscode");


															$http_args = array(
																'headers' => array(
																	'cache-control' => 'no-cache',
																	'Content-Type' => 'application/json'
																),
																'timeout' => '300',
																'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																'sslverify' => false
															);


															//echo "<script>alert('url1".$url."');</script>";
															$call = wp_remote_get($url, $http_args);
															$response = wp_remote_retrieve_body($call);

															if (is_wp_error($call)) {
																if (vp_option_array($option_array, "vpdebug") != "yes") {
																	$error = $call->get_error_code();
																} else {
																	$error = $call->get_error_message();
																}

																die($error);
															}



															if (vp_option_array($option_array, "data3_response_format") == "json") {
																$en = validate_response1($response, $sc, vp_option_array($option_array, "r2datasuccessvalue"), vp_option_array($option_array, "r2datasuccessvalue2"));
															} else {
																$en = $response;
															}



															$vpdebug = vp_option_array($option_array, "vpdebug");

															$corporate_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "corporateresponse_id"));

															if (!empty($corporate_response)) {
																$corporate_token = $corporate_response[0];
															} else {
																$corporate_token = "Nill";
															}


															if ($en == "TRUE" || $response === vp_option_array($option_array, "r2datasuccessvalue")) {
																//echo"<script>alert('sta 1 ma');</script>";
																include_once(ABSPATH . "wp-load.php");
																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'corporate',
																	'trans_method' => 'get',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $corporate_token,
																	'status' => "Successful",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																if (is_plugin_active("vpmlm/vpmlm.php")) {
																	do_action("vp_after_api");
																	vp_updateuser($id, 'vp_bal', $tot);
																} else {
																	vp_updateuser($id, 'vp_bal', $tot);
																}



																$myemail = get_userdata($id)->user_email;
																$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Plan = " . $plan . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																wp_mail($myemail, "New Vend Data [" . $name . "]", $content);



																$obj = new stdClass;
																$obj->status = "100";
																$obj->request_id = $uniqidvalue;

																$obj->Successful = "true";
																$obj->message = "Purchase Of $plan_name Was Successful";
																$obj->Previous_Balance = $bal;
																$obj->Current_Balance = $tot;
																$obj->Amount_Charged = $amountv;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															} else {
																$vpdebug = vp_option_array($option_array, "vpdebug");

																$_SESSION["details"] = $response;

																include_once(ABSPATH . "wp-load.php");
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'corporate',
																	'trans_method' => 'get',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $corporate_token,
																	'status' => "Failed",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																// vp_updateuser($id, 'vp_bal', $tot);




																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Purchase Of $plan_name Was Not Successful";
																$obj->Previous_Balance = $bal;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																$obj->Response = harray_key_first1($response);
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															}
														} else {
															$url = vp_option_array($option_array, "r2databaseurl") . vp_option_array($option_array, "r2dataendpoint");
															$num = $phone;
															$cua = vp_option_array($option_array, "r2datapostdata1");
															$cppa = vp_option_array($option_array, "r2datapostdata2");
															$c1a = vp_option_array($option_array, "r2datapostdata3");
															$c2a = vp_option_array($option_array, "r2datapostdata4");
															$c3a = vp_option_array($option_array, "r2datapostdata5");
															$cna = vp_option_array($option_array, "r2datanetworkattribute");
															$caa = vp_option_array($option_array, "r2dataamountattribute");
															$cpa = vp_option_array($option_array, "r2dataphoneattribute");
															$cpla = vp_option_array($option_array, "r2cvariationattr");
															$uniqid = vp_option_array($option_array, "r2request_id");

															$datass = array(
																$cua => vp_option_array($option_array, "r2datapostvalue1"),
																$cppa => vp_option_array($option_array, "r2datapostvalue2"),
																$c1a => vp_option_array($option_array, "r2datapostvalue3"),
																$c2a => vp_option_array($option_array, "r2datapostvalue4"),
																$c3a => vp_option_array($option_array, "r2datapostvalue5"),
																$uniqid => $uniqidvalue,
																$cna => $network,
																$cpa => $phone,
																$cpla => $plan
															);


															$the_head = vp_option_array($option_array, "data_head3");
															if ($the_head == "not_concatenated") {
																$the_auth = vp_option_array($option_array, "r2datavalue1");
															} else {
																$the_auth_value = vp_option_array($option_array, "r2datavalue1");
																$the_auth = base64_encode($the_auth_value);
															}

															$auto = vp_option_array($option_array, "r2datahead1") . ' ' . $the_auth;
															$sc = vp_option_array($option_array, "r2datasuccesscode");
															if (vp_option_array($option_array, "corporatequerymethod") != "array") {





																//echo "<script>alert('url1".$url."');</script>";
																$corporate_array = [];

																$the_head = vp_getoption("data_head3");
																if ($the_head == "not_concatenated") {
																	$the_auth = vp_getoption("r2datavalue1");
																	$auto = vp_getoption("r2datahead1") . ' ' . $the_auth;
																	$corporate_array["Authorization"] = $auto;
																} elseif ($the_head == "concatenated") {
																	$the_auth_value = vp_getoption("r2datavalue1");
																	$the_auth = base64_encode($the_auth_value);
																	$auto = vp_getoption("r2datahead1") . ' ' . $the_auth;
																	$corporate_array["Authorization"] = $auto;
																} else {
																	$corporate_array[vp_getoption("r2datahead1")] = vp_getoption("r2datavalue1");
																}
																$corporate_array["Content-Type"] = "application/json";
																$corporate_array["cache-control"] = "no-cache";

																for ($corporateaddheaders = 1; $corporateaddheaders <= 4; $corporateaddheaders++) {
																	if (!empty(vp_getoption("corporateaddheaders$corporateaddheaders")) && !empty(vp_getoption("corporateaddvalue$corporateaddheaders"))) {
																		$corporate_array[vp_getoption("corporateaddheaders$corporateaddheaders")] = vp_getoption("corporateaddvalue$corporateaddheaders");
																	}
																}


																$http_args = array(
																	'headers' => $corporate_array,
																	'timeout' => '300',
																	'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
																	'sslverify' => false,
																	'body' => json_encode($datass)
																);


																$call = wp_remote_post($url, $http_args);
																$response = wp_remote_retrieve_body($call);

																if (is_wp_error($call)) {
																	if (vp_option_array($option_array, "vpdebug") != "yes") {
																		$error = $call->get_error_code();
																	} else {
																		$error = $call->get_error_message();
																	}

																	die($error);
																}


															} else {

																$corporate_array = [];

																$the_head = vp_getoption("data_head3");
																if ($the_head == "not_concatenated") {
																	$the_auth = vp_getoption("r2datavalue1");
																	$auto = vp_getoption("r2datahead1") . ' ' . $the_auth;
																	$corporate_array["Authorization"] = $auto;
																} elseif ($the_head == "concatenated") {
																	$the_auth_value = vp_getoption("r2datavalue1");
																	$the_auth = base64_encode($the_auth_value);
																	$auto = vp_getoption("r2datahead1") . ' ' . $the_auth;
																	$corporate_array["Authorization"] = $auto;
																} else {
																	$corporate_array[vp_getoption("r2datahead1")] = vp_getoption("r2datavalue1");
																}
																$corporate_array["Content-Type"] = "application/json";
																$corporate_array["cache-control"] = "no-cache";

																for ($corporateaddheaders = 1; $corporateaddheaders <= 4; $corporateaddheaders++) {
																	if (!empty(vp_getoption("corporateaddheaders$corporateaddheaders")) && !empty(vp_getoption("corporateaddvalue$corporateaddheaders"))) {
																		$corporate_array[vp_getoption("corporateaddheaders$corporateaddheaders")] = vp_getoption("corporateaddvalue$corporateaddheaders");
																	}
																}

																$response = vp_remote_post_fn($url, $corporate_array, $datass);

															}



															if (vp_option_array($option_array, "data3_response_format") == "json") {
																$en = validate_response1($response, $sc, vp_option_array($option_array, "r2datasuccessvalue"), vp_option_array($option_array, "r2datasuccessvalue2"));
															} else {
																$en = $response;
															}


															$corporate_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "corporateresponse_id"));

															if (!empty($corporate_response)) {
																$corporate_token = $corporate_response[0];
															} else {
																$corporate_token = "Nill";
															}



															if ($en == "TRUE" || $response === vp_option_array($option_array, "r2datasuccessvalue")) {
																$myemail = get_userdata($id)->user_email;
																$content = "Hello!,<br><b> A new user just vended from you</b><br> Name = " . $name . "<br> Network = " . $network . " <br> Phone = " . $phone . "<br> Amount = " . $amount . "<br>";
																wp_mail($myemail, "New Vend Data [" . $name . "]", $content);

																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'corporate',
																	'trans_method' => 'post',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $corporate_token,
																	'status' => "Successful",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																if (is_plugin_active("vpmlm/vpmlm.php")) {
																	do_action("vp_after_api");
																	vp_updateuser($id, 'vp_bal', $tot);
																} else {
																	vp_updateuser($id, 'vp_bal', $tot);
																}



																$obj = new stdClass;
																$obj->status = "100";
																$obj->request_id = $uniqidvalue;

																$obj->Successful = "true";
																$obj->message = "Purchase Of $plan_name Was Successful";
																$obj->Previous_Balance = $bal;
																$obj->Current_Balance = $tot;
																$obj->Amount_Charged = $amountv;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));

															} else {

																$_SESSION["details"] = $response;

																include_once(ABSPATH . "wp-load.php");
																global $wpdb;
																$table_name = $wpdb->prefix . 'sdata';
																$wpdb->insert($table_name, array(
																	'plan' => $_REQUEST["dataplan"],
																	'name' => $name,
																	'email' => $email,
																	'phone' => $phone,
																	'bal_bf' => $bal,
																	'bal_nw' => $baln,
																	'amount' => $amountv,
																	'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
																	'user_id' => $id,
																	'browser' => $browser,
																	'trans_type' => 'corporate',
																	'trans_method' => 'post',
																	'via' => $via,
																	'time_taken' => '2',
																	'request_id' => $uniqidvalue . $session,
																	'response_id' => $corporate_token,
																	'status' => "Failed",
																	'the_time' => date('Y-m-d h-i-s')
																));

																$tot = $bal - $amountv;

																// vp_updateuser($id, 'vp_bal', $tot);




																$obj = new stdClass;
																$obj->status = "200";
																$obj->Successful = "false";
																$obj->message = "Purchase Of $plan_name Was Not Successful";
																$obj->Previous_Balance = $bal;
																$obj->Data_Plan = $plan_name;
																$obj->Plan_Code = $_REQUEST["dataplan"];
																$obj->Data_Type = $datatcode;
																$obj->Network = $network;
																$obj->Receiver = $phone;
																$obj->Response = harray_key_first1($response);
																die(json_encode($obj, JSON_UNESCAPED_SLASHES));


															}

														}

													}
												} else {
													// Balance too low data
													$obj = new stdClass;
													$obj->status = "200";
													$obj->Successful = "false";
													$obj->message = "Balance Too Low";
													$obj->Balance = $bal;
													die(json_encode($obj, JSON_UNESCAPED_SLASHES));
												}
											} else {
												die('{"status":"200","message":"type error"}');
											}

										} else {
											$obj = new stdClass;
											$obj->status = "200";
											$obj->Sucessful = "false";
											$obj->message = "RECIPIENT NOT SPECIFIED";

											die(json_encode($obj, JSON_UNESCAPED_SLASHES));

										}
									} else {

										$obj = new stdClass;
										$obj->status = "200";
										$obj->Sucessful = "false";
										$obj->message = "DATAPLAN NOT SPECIFIED";

										die(json_encode($obj, JSON_UNESCAPED_SLASHES));
									}



								} else {
									$obj = new stdClass;
									$obj->status = "200";
									$obj->Sucessful = "false";
									$obj->message = "NETWORK NOT SPECIFIED";

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								}




							} else {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Sucessful = "false";
								$obj->message = "DATA TYPE NOT ENTERED";

								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							break;
						case "debug":

							if ($_REQUEST['debug'] == 1) {
								$id = $_REQUEST['id'];
								$api->id = $id;
								$api->status = 1;
								$api->message = "debug mode is activated and it's working fine as supposed \n";
								$api->message_status = "Successful";
								die(json_encode($api));
							} else {
								$id = $_REQUEST['id'];
								$api->id = $id;
								$api->status = 2;
								$api->message = "debug mode is activated and it's working fine as supposed \n";
								$api->message_status = "failed";
								die(json_encode($api));
							}
							break;
						case "recharge_card":
							if (is_plugin_active("vpcards/vpcards.php") && vp_option_array($option_array, "cardscontrol") == "checked" && vp_option_array($option_array, "resell") == "yes") {
								//Continue
							} else {
								die('{"status":"200","message":"Recharge Card Is Not Active"}');
							}

							//Required Parameters
							#1. network
							#2. Quantity
							#3. Denomination
							if (!isset($_REQUEST["network"])) {
								die('{"status":"200","message":"Network Is Not Defined"}');
							} elseif (!isset($_REQUEST["quantity"])) {
								die('{"status":"200","message":"Quantity Is Not Defined"}');
							} elseif (!isset($_REQUEST["denomination"])) {
								die('{"status":"200","message":"Denomination Is Not Defined"}');
							}

							$network = strtolower($_REQUEST["network"]);
							$denomination = $_REQUEST["denomination"];
							$quantity = $_REQUEST["quantity"];

							if (empty($network)) {
								die('{"status":"200","message":"Network cannot be empty"}');
							} elseif (empty($denomination)) {
								die('{"status":"200","message":"Denomination cannot be empty"}');
							} elseif (empty($quantity)) {
								die('{"status":"200","message":"Quantity cannot be empty"}');
							}


							if ($network != "mtn" && $network != "glo" && $network != "9mobile" && $network != "airtel") {
								die('{"status":"200","message":"Invalid Network"}');
							}

							$dtype = $network;
							$domination = $denomination;

							//	$amount = $domination*$quantity;
							$id = $_REQUEST["id"];
							$bal = vp_getuser($id, "vp_bal", true);

							//Discount Set

							$amount = floatval($domination - ((floatval($level[0]->{"card_$network"}) * $domination) / 100)) * $quantity;



							if ($bal >= $amount || current_user_can('manage_options')) {
								//Continue
							} else {
								$remtot = $amount - $bal;
								die('{"status":"200","message":"' . $remtot . ' Needed To Complete Transaction"}');
							}



							if (is_plugin_active("vpmlm/vpmlm.php")) {
								do_action("vp_mlm");
							}

							$ans = "true";
							global $wpdb;
							$table_name = $wpdb->prefix . 'vpcards';
							$resultfad = $wpdb->get_results("SELECT * FROM  $table_name WHERE network='$dtype' AND value='$domination' AND status='unused' LIMIT $quantity");

							$total = 0;
							$amt = 0;

							if (!empty($resultfad) && $resultfad != NULL) {
								//Continue

								$available = count($resultfad);

								if ($available < $quantity) {

									$obj = new stdClass;
									$obj->status = "200";
									$obj->message = "Contact Us Right Now For A Reload";

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								} else {
								}

							} else {



								global $wpdb;
								$name = get_userdata($id)->user_login;
								$email = get_userdata($id)->user_email;
								$type = strtoupper($_REQUEST["network"]);
								$tid = $id;
								$table_name = $wpdb->prefix . 'scards';
								$wpdb->insert($table_name, array(
									'name' => $name,
									'email' => $email,
									'type' => $type,
									'value' => $domination,
									'quantity' => $quantity,
									'user_id' => $tid,
									'via' => "API",
									'status' => 'Failed',
									'the_time' => current_time('mysql', 1)
								));

								$obj = new stdClass;
								$obj->status = "200";
								$obj->message = "$type Pin In $quantity Pieces @ NGN$amount Is Currently Not Available";

								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$added_pin = "";

							foreach ($resultfad as $result) {
								$pinow = $result->pin;
								$red = $result->id;
								if (!empty($pinow)) {
									$added_pin .= ",$pinow";
									$ans = "true";
									$pinow = $result->pin;
									$balg = vp_getuser($id, "vp_bal", true);
									$balnowg = $balg - floatval($amount / $quantity);
									global $wpdb;
									$name = get_userdata($id)->user_login;
									$email = get_userdata($id)->user_email;
									$type = strtoupper($_REQUEST["network"]);
									$bal_bf = $balg;
									$bal_nw = $balnowg;
									$tid = $id;
									$table_name = $wpdb->prefix . 'scards';
									$wpdb->insert($table_name, array(
										'name' => $name,
										'email' => $email,
										'type' => $type,
										'value' => $domination,
										'pin' => $pinow,
										'quantity' => "1",
										'bal_bf' => $bal_bf,
										'bal_nw' => $bal_nw,
										'amount' => ($amount / $quantity),
										'user_id' => $tid,
										'via' => "API",
										'status' => 'Successful',
										'the_time' => current_time('mysql', 1)
									));
									global $wpdb;
									$table_name = $wpdb->prefix . 'vpcards';
									$wpdb->update($table_name, array('status' => 'used', 'the_time' => current_time('mysql', 1)), array('id' => $red));

									$total += 1;


									vp_updateuser($id, 'vp_bal', $balnowg);

									$amt += $amount;

								} else {


									global $wpdb;
									$name = get_userdata($id)->user_login;
									$email = get_userdata($id)->user_email;
									$type = strtoupper($_REQUEST["network"]);
									$tid = $id;
									$table_name = $wpdb->prefix . 'scards';
									$wpdb->insert($table_name, array(
										'name' => $name,
										'email' => $email,
										'type' => $type,
										'value' => $domination,
										'quantity' => $quantity,
										'user_id' => $tid,
										'via' => "API",
										'status' => 'Failed',
										'the_time' => current_time('mysql', 1)
									));

									$obj = new stdClass;
									$obj->status = "200";
									$obj->message = "$type Pin Of NGN$amount Currently Not Available";

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								}

							}




							if ($quantity == 1 && !empty($pinow)) {

								$obj = new stdClass;
								$obj->status = "100";
								$obj->pin = "$pinow";
								$obj->message = "Recharge Card Pin Generated.";

								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} else if ($quantity > 1 && !empty($pinow)) {

								$obj = new stdClass;
								$obj->status = "100";
								$obj->message = "$total Recharge Card Pins Generated.";
								$obj->pin = $added_pin;
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));

							} else {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->message = "No Pin Available";

								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}




							break;
						case "data_card":

							if (is_plugin_active("vpdatas/vpdatas.php") && vp_option_array($option_array, "resell") == "yes" && vp_option_array($option_array, "datascontrol") == "checked") {
								//Continue
							} else {
								die('{"status":"200","message":"DataCard Is Currently Not Available"}');
							}

							if (!isset($_REQUEST["dataplan"])) {
								die('{"status":"200","message":"Plan Is Required"}');
							} elseif (!isset($_REQUEST["quantity"])) {
								die('{"status":"200","message":"Quantity Is Required"}');
							}
							if (empty($_REQUEST["dataplan"])) {
								die('{"status":"200","message":"Plan Is Empty"}');
							} elseif (empty($_REQUEST["quantity"])) {
								die('{"status":"200","message":"Quantity Is Empty"}');
							}
							$dataplan = $_REQUEST["dataplan"];

							switch ($dataplan) {
								case "1":
									$network = "MTN";
									$plan = "500";
									$volume = "MB";
									$value = $network . " " . $plan . $volume;
									break;
								case "2":
									$network = "MTN";
									$plan = "1";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "3":
									$network = "MTN";
									$plan = "1.5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "4":
									$network = "MTN";
									$plan = "2";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "5":
									$network = "MTN";
									$plan = "3";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "6":
									$network = "MTN";
									$plan = "5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "7":
									$network = "MTN";
									$plan = "10";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "8":
									////////////////////////////////////  GLO    /////////////////////////////////
									$network = "GLO";
									$plan = "500";
									$volume = "MB";
									$value = $network . " " . $plan . $volume;
									break;
								case "9":
									$network = "GLO";
									$plan = "1";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "10":
									$network = "GLO";
									$plan = "1.5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "11":
									$network = "GLO";
									$plan = "2";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "12":
									$network = "GLO";
									$plan = "3";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "13":
									$network = "GLO";
									$plan = "5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "14":
									$network = "GLO";
									$plan = "10";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "15":
									////////////////////////////////////  AIRTEL    /////////////////////////////////
									$network = "AIRTEL";
									$plan = "500";
									$volume = "MB";
									$value = $network . " " . $plan . $volume;
									break;
								case "16":
									$network = "AIRTEL";
									$plan = "1";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "17":
									$network = "AIRTEL";
									$plan = "1.5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "18":
									$network = "AIRTEL";
									$plan = "2";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "19":
									$network = "AIRTEL";
									$plan = "3";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "20":
									$network = "AIRTEL";
									$plan = "5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "21":
									$network = "AIRTEL";
									$plan = "10";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "22":
									////////////////////////////////////  9MOBILE    /////////////////////////////////
									$network = "9MOBILE";
									$plan = "500";
									$volume = "MB";
									$value = $network . " " . $plan . $volume;
									break;
								case "23":
									$network = "9MOBILE";
									$plan = "1";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "24":
									$network = "9MOBILE";
									$plan = "1.5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "25":
									$network = "9MOBILE";
									$plan = "2";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "26":
									$network = "9MOBILE";
									$plan = "3";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "27":
									$network = "9MOBILE";
									$plan = "5";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								case "28":
									$network = "9MOBILE";
									$plan = "10";
									$volume = "GB";
									$value = $network . " " . $plan . $volume;
									break;
								default:
									die('{"status":"200","message":"DATAPLAN ID NOT VALID"}');
							}

							$quantity = $_REQUEST["quantity"]; //1,2,3,4

							global $wpdb;
							$table_name = $wpdb->prefix . 'vpdatas';
							$resultfad = $wpdb->get_results("SELECT * FROM  $table_name WHERE network='$network' AND plan='$plan' AND volume='$volume' AND status='unused' LIMIT $quantity");

							if ($resultfad == NULL || empty($resultfad)) {

								global $wpdb;
								$name = get_userdata($id)->user_login;
								$email = get_userdata($id)->user_email;
								$type = strtoupper($network);
								$tid = $id;
								$table_name = $wpdb->prefix . 'sdatacard';
								$wpdb->insert($table_name, array(
									'name' => $name,
									'email' => $email,
									'type' => $type,
									'plan' => $plan,
									'volume' => $volume,
									'quantity' => $quantity,
									'user_id' => $tid,
									'via' => "API",
									'value' => $value,
									'status' => 'Failed',
									'the_time' => current_time('mysql', 1)
								));

								$obj = new stdClass;
								$obj->status = "200";
								$obj->message = "$type Pin Of $plan.$volume Currently Not Available";

								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} else {
								//$amount = floatval($resultfad[0]->value)*$quantity;
								$dnetwork = strtolower($network);
								$amount = floatval($resultfad[0]->value - ((floatval($level[0]->{"data_$dnetwork"}) * $resultfad[0]->value) / 100)) * $quantity;
							}


							$bal = vp_getuser($id, "vp_bal", true);



							if ($bal >= $amount || current_user_can('manage_options')) {


								if (is_plugin_active("vpmlm/vpmlm.php")) {
									do_action("vp_mlm");
								}

								$ans = "true";
								global $wpdb;
								$table_name = $wpdb->prefix . 'vpdatas';
								$resultfad = $wpdb->get_results("SELECT * FROM  $table_name WHERE network='$network' AND plan='$plan' AND volume='$volume' AND status='unused' LIMIT $quantity");


								$available = count($resultfad);

								if ($available < $quantity) {

									$obj = new stdClass;
									$obj->status = "200";
									$obj->message = "Contact Us Right Now For A Reload";

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								} else {
								}

								$total = 0;
								$amt = 0;

								$added_pin = "";
								foreach ($resultfad as $result) {
									$pinow = $result->pin;
									$red = $result->id;
									$type = $result->type;
									$check_ussd = $result->check_ussd;
									$load_ussd = $result->load_ussd;
									//$amount = floatval($result->value)*$quantity;
									if (!empty($pinow)) {
										$ans = "true";
										$pinow = $result->pin;
										$added_pin .= ",$pinow";

										$balg = vp_getuser($id, "vp_bal", true);
										$balnowg = $balg - floatval($amount / $quantity);
										global $wpdb;
										$name = get_userdata($id)->user_login;
										$email = get_userdata($id)->user_email;
										$bal_bf = $balg;
										$bal_nw = $balnowg;
										$tid = $id;
										$table_name = $wpdb->prefix . 'sdatacard';
										$wpdb->insert($table_name, array(
											'name' => $name,
											'email' => $email,
											'type' => $type,
											'value' => strtoupper($value),
											'check_ussd' => $check_ussd,
											'load_ussd' => $load_ussd,
											'pin' => $pinow,
											'quantity' => "1",
											'network' => strtoupper($network),
											'bal_bf' => $bal_bf,
											'bal_nw' => $bal_nw,
											'amount' => ($amount / $quantity),
											'user_id' => $tid,
											'via' => "API",
											'status' => 'Successful',
											'the_time' => current_time('mysql', 1)
										));

										$table_name = $wpdb->prefix . 'vpdatas';
										$wpdb->update($table_name, array('status' => 'used', 'the_time' => current_time('mysql', 1), 'used_by' => $tid), array('id' => $red));

										$total += 1;


										vp_updateuser($id, 'vp_bal', $balnowg);

										$amt += $amount;

									} else {


										global $wpdb;
										$name = get_userdata($id)->user_login;
										$email = get_userdata($id)->user_email;
										$tid = $id;
										$table_name = $wpdb->prefix . 'sdatacard';
										$wpdb->insert($table_name, array(
											'name' => $name,
											'email' => $email,
											'type' => "",
											'volume' => $volume,
											'value' => $value,
											'plan' => $plan,
											'quantity' => $quantity,
											'user_id' => $tid,
											'via' => "API",
											'network' => strtoupper($network),
											'status' => 'Failed',
											'the_time' => current_time('mysql', 1)
										));

										$obj = new stdClass;
										$obj->status = "200";
										$obj->message = "$value PIN @ NGN$amount Currently Not Available";

										die(json_encode($obj, JSON_UNESCAPED_SLASHES));

									}

								}





								if ($quantity == 1 && !empty($pinow)) {

									$obj = new stdClass;
									$obj->status = "100";
									$obj->pin = $added_pin;

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								} else if ($quantity > 1 && !empty($pinow)) {

									$obj = new stdClass;
									$obj->status = "100";
									$obj->amount = "$total Number Of Data Cards Have Been Printed. Check History For Lists";
									$obj->pin = $added_pin;
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} else {
									$obj = new stdClass;
									$obj->status = "200";
									$obj->message = "Error Fetching Database";

									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								}








							} else {
								$remtot = $amount - $bal;
								die('{"status":"200","message":"' . $remtot . ' Needed To Complete Transaction"}');
							}



							break;
						case "cable":
							if (is_plugin_active("vprest/vprest.php") && vp_getoption("setcable") == "checked" && is_plugin_active("bcmv/bcmv.php")) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Cable Currently Not Available";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							if (!isset($_REQUEST["iuc"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "IUC required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!isset($_REQUEST["type"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "TYPE is required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (strtolower($_REQUEST["type"]) != "dstv" && strtolower($_REQUEST["type"]) != "gotv" && strtolower($_REQUEST["type"]) != "startimes") {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Type must be dstv, gotv, startimes";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!isset($_REQUEST["plan"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!is_numeric($_REQUEST["plan"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN Must Be Numeric";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}
							$iuc = $_REQUEST["iuc"];// iuc number
							$type = strtolower($_REQUEST["type"]);// prepaid / postpaid
							//$tv = $_REQUEST["tv"];// gotv, dstv
							$plan = $_REQUEST["plan"];// gotv-jolli and so on

							//List The ID Of Cables
							if ($plan < 1 || $plan > 20) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN ID DOES NOT EXIST";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$return_plan_code = vp_option_array($option_array, "ccable" . ($plan - 1));

							if (strtolower($return_plan_code) == "false" || empty($return_plan_code)) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN ID EXISTS BUT NOT ASSIGNED";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							//USER DETAILS
							$name = get_userdata($id)->user_login;
							$hname = get_userdata($id)->user_login;
							$email = get_userdata($id)->user_email;
							$phone = "000";
							$actual_price = vp_option_array($option_array, "ccablep" . ($plan - 1));
							$actual_plan = vp_option_array($option_array, "ccable" . ($plan - 1));
							$actual_name = vp_option_array($option_array, "ccablen" . ($plan - 1));

							$ccable = $actual_plan;
							$cabtype = $type;
							$cable = strtoupper($cabtype);
							$recipient = $iuc;

							$amount = $actual_price;



							if ($level[0]->developer == "yes") {
								$fir = $actual_price * floatval($level[0]->cable);
								$sec = $fir / 100;
								$amountv = $actual_price - $sec;
								$baln = $actual_price;
							}

							if ($discount_method == "direct") {
								$amountv = $amountv;
								$amount = $amountv;
							} else {
								$amountv = $actual_price;
								$amount = $actual_price;
							}


							if ($bal < $amount) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Insufficient Balance";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$baln = $bal - $amount;

							if (vp_option_array($option_array, "cablerequest") == "get") {
								$urlraw = htmlspecialchars_decode($_POST["url"]);



								$url = vp_option_array($option_array, "cablebaseurl") . vp_option_array($option_array, "cableendpoint") . vp_option_array($option_array, "cablepostdata1") . '=' . vp_option_array($option_array, "cablepostvalue1") . '&' . vp_option_array($option_array, "crequest_id") . '=' . $uniqidvalue . '&' . vp_option_array($option_array, "cablepostdata2") . '=' . vp_option_array($option_array, "cablepostvalue2") . '&' . vp_option_array($option_array, "cablepostdata3") . '=' . vp_option_array($option_array, "cablepostvalue3") . '&' . vp_option_array($option_array, "cablepostdata4") . '=' . vp_option_array($option_array, "cablepostvalue4") . '&' . vp_option_array($option_array, "cablepostdata5") . '=' . vp_option_array($option_array, "cablepostvalue5") . '&' . vp_option_array($option_array, "ctypeattr") . '=' . $type . '&' . vp_option_array($option_array, "cableamountattribute") . '=' . $amount . '&' . vp_option_array($option_array, "ccvariationattr") . '=' . $ccable . '&' . vp_option_array($option_array, "ciucattr") . '=' . $iuc;


								$sc = vp_option_array($option_array, "cablesuccesscode");


								$tot = $bal - $amount; ###########################
								vp_updateuser($id, 'vp_bal', $tot);

								$http_args = array(
									'headers' => array(
										'cache-control' => 'no-cache',
										'Content-Type' => 'application/json'
									),
									'timeout' => '300',
									'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
									'sslverify' => false
								);

								$call = wp_remote_get($url, $http_args);
								$response = wp_remote_retrieve_body($call);



								if (is_wp_error($call)) {
									if (vp_option_array($option_array, "vpdebug") != "yes") {
										$error = $call->get_error_code();
									} else {
										$error = $call->get_error_message();
									}


									$cable_token = "no_response";
									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $bal,
										'amount' => $amount,
										'resp_log' => " " . esc_html($call->get_error_message()) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'status' => "Failed",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));

									vp_updateuser($id, "vp_bal", $bal);





									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Not Successful";
									$obj->Previous_Balance = $bal;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									$obj->Response = harray_key_first1($error);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} else {
									if (vp_option_array($option_array, "cable_response_format") == "JSON" || vp_option_array($option_array, "cable_response_format") == "json") {
										$en = validate_response1($response, $sc, vp_option_array($option_array, "cablesuccessvalue"), vp_option_array($option_array, "cablesuccessvalue2"));
									} else {
										$en = $response;
									}
								}


								$cable_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "cableresponse_id"));

								if (!empty($cable_response)) {
									$cable_token = $cable_response[0];
								} else {
									$cable_token = "Nill";
								}

								if ($en == "TRUE" || $response === vp_option_array($option_array, "cablesuccessvalue")) {





									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'status' => "Successful",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));


									$obj = new stdClass;
									$obj->Status = "100";
									$obj->Successful = "true";
									$obj->request_id = $uniqidvalue;

									$obj->Message = "Purchase Of $actual_name Plan Was Successful";
									$obj->Previous_Balance = $bal;
									$obj->Current_Balance = $baln;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									//$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} elseif ($en == "MAYBE") {


									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Pending",
										'time' => date("Y-m-d h:i:s A")
									));


									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Pending";
									$obj->Previous_Balance = $bal;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									//$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));


								} else {


									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Failed",
										'time' => date("Y-m-d h:i:s A")
									));


									vp_updateuser($id, "vp_bal", $bal);

									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Pending";
									$obj->Previous_Balance = $bal;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									//$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								}


							} else {
								$url = vp_option_array($option_array, "cablebaseurl") . vp_option_array($option_array, "cableendpoint");
								$num = $phone;
								$cua = vp_option_array($option_array, "cablepostdata1");
								$cppa = vp_option_array($option_array, "cablepostdata2");
								$c1a = vp_option_array($option_array, "cablepostdata3");
								$c2a = vp_option_array($option_array, "cablepostdata4");
								$c3a = vp_option_array($option_array, "cablepostdata5");
								$ctypa = vp_option_array($option_array, "ctypeattr");
								$caa = vp_option_array($option_array, "cableamountattribute");
								$ccvaa = vp_option_array($option_array, "ccvariationattr");
								$ciuc = vp_option_array($option_array, "ciucattr");
								$uniqid = vp_option_array($option_array, "crequest_id");

								$datass = array(
									$cua => vp_option_array($option_array, "cablepostvalue1"),
									$cppa => vp_option_array($option_array, "cablepostvalue2"),
									$c1a => vp_option_array($option_array, "cablepostvalue3"),
									$c2a => vp_option_array($option_array, "cablepostvalue4"),
									$c3a => vp_option_array($option_array, "cablepostvalue5"),
									$uniqid => $uniqidvalue,
									$ctypa => $cabtype,
									$ccvaa => $ccable,
									$ciuc => $iuc
								);
								//	echo "<pre>";
								//	print_r($datass);
								//	echo "\n";

								$cable_array = [];

								$the_head = vp_option_array($option_array, "cable_head");
								if ($the_head == "not_concatenated") {
									$the_auth = vp_option_array($option_array, "cablevalue1");
									$auto = vp_option_array($option_array, "cablehead1") . ' ' . $the_auth;
									$cable_array["Authorization"] = $auto;
								} elseif ($the_head == "concatenated") {
									$the_auth_value = vp_option_array($option_array, "cablevalue1");
									$the_auth = base64_encode($the_auth_value);
									$auto = vp_option_array($option_array, "cablehead1") . ' ' . $the_auth;
									$cable_array["Authorization"] = $auto;
								} else {
									$cable_array[vp_option_array($option_array, "cablehead1")] = vp_option_array($option_array, "cablevalue1");
								}

								$sc = vp_option_array($option_array, "cablesuccesscode");


								$cable_array["Content-Type"] = "application/json";
								$cable_array["cache-control"] = "no-cache";

								for ($cableaddheaders = 1; $cableaddheaders <= 4; $cableaddheaders++) {
									if (!empty(vp_option_array($option_array, "cableaddheaders$cableaddheaders")) && !empty(vp_option_array($option_array, "cableaddvalue$cableaddheaders"))) {
										$cable_array[vp_option_array($option_array, "cableaddheaders$cableaddheaders")] = vp_option_array($option_array, "cableaddvalue$cableaddheaders");
									}
								}

								$http_args = array(
									'headers' => $cable_array,
									'timeout' => '300',
									'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
									'sslverify' => false,
									'body' => json_encode($datass)
								);



								if (vp_option_array($option_array, "cablequerymethod") != "array") {

									$tot = $bal - $amount;
									vp_updateuser($id, 'vp_bal', $tot);

									$call = wp_remote_post($url, $http_args);
									$response = wp_remote_retrieve_body($call);

								} else {

									$tot = $bal - $amount;
									vp_updateuser($id, 'vp_bal', $tot);
									$call = "";
									$response = vp_remote_post_fn($url, $cable_array, $datass);
									if ($response == "error") {
										global $return_message;

										$obj = new stdClass;
										$obj->Status = "200";
										$obj->Successful = "false";
										$obj->Message = "Purchase Of $actual_name Plan Was Not Successful";
										$obj->Previous_Balance = $bal;
										$obj->Cable_Plan = $actual_name;
										$obj->Plan_Code = $ccable;
										$obj->Type = $type;
										$obj->Receiver = $iuc;
										$obj->Response = harray_key_first1($return_message);
										die(json_encode($obj, JSON_UNESCAPED_SLASHES));
									} else {
										//do nothing
									}
								}



								if (is_wp_error($call)) {
									if (vp_option_array($option_array, "vpdebug") != "yes") {
										$error = $call->get_error_code();
									} else {
										$error = $call->get_error_message();
									}




									$cable_token = "no_response";
									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $bal,
										'amount' => $amount,
										'resp_log' => " " . esc_html($call->get_error_message()) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'status' => "Failed",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));

									vp_updateuser($id, "vp_bal", $bal);



									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Not Successful";
									$obj->Previous_Balance = $bal;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								} else {
									if (vp_option_array($option_array, "cable_response_format") == "JSON" || vp_option_array($option_array, "cable_response_format") == "json") {
										$en = validate_response1($response, $sc, vp_option_array($option_array, "cablesuccessvalue"), vp_option_array($option_array, "cablesuccessvalue2"));
									} else {
										$en = $response;
									}
								}

								$cable_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "cableresponse_id"));

								if (!empty($cable_response)) {
									$cable_token = $cable_response[0];
								} else {
									$cable_token = "Nill";
								}

								if ($en == "TRUE" || $response === vp_option_array($option_array, "cablesuccessvalue")) {

									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'status' => "Successful",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));

									$obj = new stdClass;
									$obj->Status = "100";
									$obj->Successful = "true";
									$obj->request_id = $uniqidvalue;

									$obj->Message = "Purchase Of $actual_name Plan Was  Successful";
									$obj->Previous_Balance = $bal;
									$obj->Current_Balance = $baln;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} elseif ($en == "MAYBE") {

									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Pending",
										'time' => date("Y-m-d h:i:s A")
									));

									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan is Pending";
									$obj->Previous_Balance = $bal;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} else {


									global $wpdb;
									$table_name = $wpdb->prefix . 'scable';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $cable_token,
										'name' => $name,
										'email' => $email,
										'iucno' => $iuc,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'cable',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $ccable,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Failed",
										'time' => date("Y-m-d h:i:s A")
									));



									vp_updateuser($id, "vp_bal", $bal);


									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Failed";
									$obj->Previous_Balance = $bal;
									$obj->Cable_Plan = $actual_name;
									$obj->Plan_Code = $ccable;
									$obj->Type = $type;
									$obj->Receiver = $iuc;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								}


							}

							break;
						case "bill":

							if (is_plugin_active("vprest/vprest.php") && vp_getoption("setbill") == "checked" && is_plugin_active("bcmv/bcmv.php")) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Bill Currently Not Available";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							if (!isset($_REQUEST["meter_number"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Meter_Number required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!isset($_REQUEST["type"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "TYPE required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (strtolower($_REQUEST["type"]) != "prepaid" && strtolower($_REQUEST["type"]) != "postpaid") {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Type must be prepaid or postpaid";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!isset($_REQUEST["plan"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!isset($_REQUEST["amount"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Amount required";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							} elseif (!is_numeric($_REQUEST["amount"])) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Amount is Invalid";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$meter_number = $_REQUEST["meter_number"];// meter_number number
							$type = strtolower($_REQUEST["type"]);// prepaid / postpaid
							//$disco = strtolower($_REQUEST["disco"]);// ikeja and so on
							$amount = $_REQUEST["amount"];// gotv, dstv
							$plan = $_REQUEST["plan"];// ikeja-etc

							//List The ID Of bills
							if ($plan < 1 || $plan > 15) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN ID DOES NOT EXIST";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$return_plan_code = vp_option_array($option_array, "cbill" . ($plan - 1));

							if (strtolower($return_plan_code) == "false" || empty($return_plan_code)) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "PLAN ID EXISTS BUT NOT ASSIGNED";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							//USER DETAILS
							$name = get_userdata($id)->user_login;
							$hname = get_userdata($id)->user_login;
							$email = get_userdata($id)->user_email;
							$phone = "000";
							$actual_price = $amount;
							$actual_plan = vp_option_array($option_array, "cbill" . ($plan - 1));
							$actual_name = vp_option_array($option_array, "cbilln" . ($plan - 1));

							$cbill = $actual_plan;
							$cabtype = $type;
							$bill = strtoupper($cabtype);
							$recipient = $meter_number;

							$amount = $actual_price;



							if ($level[0]->developer == "yes") {
								$fir = $actual_price * floatval($level[0]->bill_prepaid);
								$sec = $fir / 100;
								$amountv = $actual_price - $sec;
								$baln = $actual_price;
							}

							if ($discount_method == "direct") {
								$amountv = $amountv;
								$amount = $amountv;
							} else {
								$amountv = $actual_price;
								$amount = $actual_price;
							}


							if ($bal < $amount) {
								$obj = new stdClass;
								$obj->status = "200";
								$obj->Successful = "false";
								$obj->message = "Insufficient Balance";
								die(json_encode($obj, JSON_UNESCAPED_SLASHES));
							}

							$baln = $bal - $amount;

							if (vp_option_array($option_array, "billrequest") == "get") {
								$urlraw = htmlspecialchars_decode($_POST["url"]);



								$url = vp_option_array($option_array, "billbaseurl") . vp_option_array($option_array, "billendpoint") . vp_option_array($option_array, "billpostdata1") . '=' . vp_option_array($option_array, "billpostvalue1") . '&' . vp_option_array($option_array, "brequest_id") . '=' . $uniqidvalue . '&' . vp_option_array($option_array, "billpostdata2") . '=' . vp_option_array($option_array, "billpostvalue2") . '&' . vp_option_array($option_array, "billpostdata3") . '=' . vp_option_array($option_array, "billpostvalue3") . '&' . vp_option_array($option_array, "billpostdata4") . '=' . vp_option_array($option_array, "billpostvalue4") . '&' . vp_option_array($option_array, "billpostdata5") . '=' . vp_option_array($option_array, "billpostvalue5") . '&' . vp_option_array($option_array, "btypeattr") . '=' . $type . '&' . vp_option_array($option_array, "billamountattribute") . '=' . $amount . '&' . vp_option_array($option_array, "cbvariationattr") . '=' . $cbill . '&' . vp_option_array($option_array, "cmeterattr") . '=' . $meter_number;


								$sc = vp_option_array($option_array, "billsuccesscode");


								$tot = $bal - $amount; ###########################
								vp_updateuser($id, 'vp_bal', $tot);

								$http_args = array(
									'headers' => array(
										'cache-control' => 'no-cache',
										'Content-Type' => 'application/json'
									),
									'timeout' => '300',
									'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
									'sslverify' => false
								);

								$call = wp_remote_get($url, $http_args);
								$response = wp_remote_retrieve_body($call);



								if (is_wp_error($call)) {
									if (vp_option_array($option_array, "vpdebug") != "yes") {
										$error = $call->get_error_code();
									} else {
										$error = $call->get_error_message();
									}


									$bill_token = "no_response";
									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $bal,
										'amount' => $amount,
										'resp_log' => " " . esc_html($call->get_error_message()) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'status' => "Failed",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));

									vp_updateuser($id, "vp_bal", $bal);





									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Not Successful";
									$obj->Previous_Balance = $bal;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									$obj->Response = harray_key_first1($error);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} else {
									if (vp_option_array($option_array, "bill_response_format") == "JSON" || vp_option_array($option_array, "bill_response_format") == "json") {
										$en = validate_response1($response, $sc, vp_option_array($option_array, "billsuccessvalue"), vp_option_array($option_array, "billsuccessvalue2"));
									} else {
										$en = $response;
									}
								}


								$bill_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "billresponse_id"));

								if (!empty($bill_response)) {
									$bill_token = $bill_response[0];
								} else {
									$bill_token = "Nill";
								}

								if ($en == "TRUE" || $response === vp_option_array($option_array, "billsuccessvalue")) {





									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'status' => "Successful",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));


									$obj = new stdClass;
									$obj->Status = "100";
									$obj->Successful = "true";
									$obj->request_id = $uniqidvalue;

									$obj->Message = "Purchase Of $actual_name Plan Was Successful";
									$obj->Previous_Balance = $bal;
									$obj->Current_Balance = $baln;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									//$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} elseif ($en == "MAYBE") {


									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Pending",
										'time' => date("Y-m-d h:i:s A")
									));


									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Pending";
									$obj->Previous_Balance = $bal;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									//$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));


								} else {


									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'get',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Failed",
										'time' => date("Y-m-d h:i:s A")
									));


									vp_updateuser($id, "vp_bal", $bal);

									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Pending";
									$obj->Previous_Balance = $bal;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									//$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								}


							} else {

								$url = vp_getoption("billbaseurl") . vp_getoption("billendpoint");
								$num = $phone;
								$cua = vp_getoption("billpostdata1");
								$cppa = vp_getoption("billpostdata2");
								$c1a = vp_getoption("billpostdata3");
								$c2a = vp_getoption("billpostdata4");
								$c3a = vp_getoption("billpostdata5");
								$btypa = vp_getoption("btypeattr");
								$caa = vp_getoption("billamountattribute");
								$cbvaa = vp_getoption("cbvariationattr");
								$cmeter = vp_getoption("cmeterattr");
								$uniqid = vp_getoption("brequest_id");

								$datass = array(
									$cua => vp_getoption("billpostvalue1"),
									$cppa => vp_getoption("billpostvalue2"),
									$c1a => vp_getoption("billpostvalue3"),
									$c2a => vp_getoption("billpostvalue4"),
									$c3a => vp_getoption("billpostvalue5"),
									$uniqid => $uniqidvalue,
									$btypa => $type,
									$cbvaa => $cbill,
									$cmeter => $meter_number,
									$caa => floatval($amount)
								);
								//	echo "<pre>";
								//	print_r($datass);
								//	echo "\n";

								$bill_array = [];

								$the_head = vp_option_array($option_array, "bill_head");
								if ($the_head == "not_concatenated") {
									$the_auth = vp_option_array($option_array, "billvalue1");
									$auto = vp_option_array($option_array, "billhead1") . ' ' . $the_auth;
									$bill_array["Authorization"] = $auto;
								} elseif ($the_head == "concatenated") {
									$the_auth_value = vp_option_array($option_array, "billvalue1");
									$the_auth = base64_encode($the_auth_value);
									$auto = vp_option_array($option_array, "billhead1") . ' ' . $the_auth;
									$bill_array["Authorization"] = $auto;
								} else {
									$bill_array[vp_option_array($option_array, "billhead1")] = vp_option_array($option_array, "billvalue1");
								}

								$sc = vp_option_array($option_array, "billsuccesscode");


								$bill_array["Content-Type"] = "application/json";
								$bill_array["cache-control"] = "no-cache";

								for ($billaddheaders = 1; $billaddheaders <= 4; $billaddheaders++) {
									if (!empty(vp_option_array($option_array, "billaddheaders$billaddheaders")) && !empty(vp_option_array($option_array, "billaddvalue$billaddheaders"))) {
										$bill_array[vp_option_array($option_array, "billaddheaders$billaddheaders")] = vp_option_array($option_array, "billaddvalue$billaddheaders");
									}
								}

								$http_args = array(
									'headers' => $bill_array,
									'timeout' => '300',
									'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
									'sslverify' => false,
									'body' => json_encode($datass)
								);



								if (vp_option_array($option_array, "billquerymethod") != "array") {

									$tot = $bal - $amount;
									vp_updateuser($id, 'vp_bal', $tot);

									$call = wp_remote_post($url, $http_args);
									$response = wp_remote_retrieve_body($call);

								} else {

									$tot = $bal - $amount;
									vp_updateuser($id, 'vp_bal', $tot);
									$call = "";
									$response = vp_remote_post_fn($url, $bill_array, $datass);
									if ($response == "error") {
										global $return_message;

										$obj = new stdClass;
										$obj->Status = "200";
										$obj->Successful = "false";
										$obj->Message = "Purchase Of $actual_name Plan Was Not Successful";
										$obj->Previous_Balance = $bal;
										$obj->bill_Plan = $actual_name;
										$obj->Plan_Code = $cbill;
										$obj->Type = $type;
										$obj->Receiver = $meter_number;
										$obj->Response = harray_key_first1($return_message);
										die(json_encode($obj, JSON_UNESCAPED_SLASHES));
									} else {
										//do nothing
									}
								}



								if (is_wp_error($call)) {
									if (vp_option_array($option_array, "vpdebug") != "yes") {
										$error = $call->get_error_code();
									} else {
										$error = $call->get_error_message();
									}




									$bill_token = "no_response";
									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $bal,
										'amount' => $amount,
										'resp_log' => " " . esc_html($call->get_error_message()) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $type,
										'status' => "Failed",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));

									vp_updateuser($id, "vp_bal", $bal);



									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Was Not Successful";
									$obj->Previous_Balance = $bal;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								} else {
									if (vp_option_array($option_array, "bill_response_format") == "JSON" || vp_option_array($option_array, "bill_response_format") == "json") {
										$en = validate_response1($response, $sc, vp_option_array($option_array, "billsuccessvalue"), vp_option_array($option_array, "billsuccessvalue2"));
									} else {
										$en = $response;
									}
								}

								$bill_response = search_bill_token2(array_change_key_case(json_decode($response, true), CASE_LOWER), vp_option_array($option_array, "billresponse_id"));

								if (!empty($bill_response)) {
									$bill_token = $bill_response[0];
								} else {
									$bill_token = "Nill";
								}

								if ($en == "TRUE" || $response === vp_option_array($option_array, "billsuccessvalue")) {

									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'status' => "Successful",
										'user_id' => $id,
										'time' => date("Y-m-d h:i:s A")
									));

									$obj = new stdClass;
									$obj->Status = "100";
									$obj->Successful = "true";
									$obj->request_id = $uniqidvalue;

									$obj->Message = "Purchase Of $actual_name Plan Was  Successful";
									$obj->Previous_Balance = $bal;
									$obj->Current_Balance = $baln;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} elseif ($en == "MAYBE") {

									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Pending",
										'time' => date("Y-m-d h:i:s A")
									));

									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan is Pending";
									$obj->Previous_Balance = $bal;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));

								} else {


									global $wpdb;
									$table_name = $wpdb->prefix . 'sbill';
									$added_to_db = $wpdb->insert($table_name, array(
										'run_code' => esc_html($uniqidvalue),
										'response_id' => $bill_token,
										'name' => $name,
										'email' => $email,
										'meterno' => $meter_number,
										'phone' => $phone,
										'bal_bf' => $bal,
										'bal_nw' => $baln,
										'amount' => $amount,
										'resp_log' => " " . esc_html(harray_key_first1($response)) . "",
										'browser' => $browser,
										'trans_type' => 'bill',
										'trans_method' => 'post',
										'via' => 'API',
										'time_taken' => '1',
										'request_id' => $uniqidvalue,
										'product_id' => $cbill,
										'type' => $cabtype,
										'user_id' => $id,
										'status' => "Failed",
										'time' => date("Y-m-d h:i:s A")
									));



									vp_updateuser($id, "vp_bal", $bal);


									$obj = new stdClass;
									$obj->Status = "200";
									$obj->Successful = "false";
									$obj->Message = "Purchase Of $actual_name Plan Failed";
									$obj->Previous_Balance = $bal;
									$obj->bill_Plan = $actual_name;
									$obj->Plan_Code = $cbill;
									$obj->Type = $type;
									$obj->Receiver = $meter_number;
									$obj->Response = harray_key_first1($response);
									die(json_encode($obj, JSON_UNESCAPED_SLASHES));
								}


							}

							break;
						default:
							die('{"status":"200","message":"[' . $q . '] Is not a valid service name"}');
					}
				}//end of if MOBILE, VTUNG, CUSTOM
// END OF ELSE IF NOT M, V, C
			}// END OF IF GET USERDATA IS TRUE
			elseif (get_userdata($id) == false) {//ELSE IF GET USERDATA IS FALSE
				die('{"status":"200","message":"ID INCORRECT"}');
			} elseif (get_userdata($id) == true && strtolower($level[0]->developer) == "yes" && $ud == $vrid && $vrid != "null") {// IF USER NOT RESELLER
				die('{"status":"200","message":"YOU ARE NOT ON AN API ENABLED PLAN"}');
			} elseif (get_userdata($id) == true && strtolower($level[0]->developer) == "yes" && $ud != $vrid && $vrid != "null") {// IF USER IS RESELLER BUT UD NOT CORRECT
				die('{"status":"200","message":"API KEY INCORRECT"}');
			} else {
				die('{"status":"200","message":"ACCESS NOT GRANTED"}');
			}

		} else {
			if (isset($my_level)) {
				die('{"status":"200","message":"Your Level {' . $my_level . '} Has No API ACCESS"}');
			} else {
				die('{"status":"200","message":" User Credentials Not Valid [ID] "}');
			}
		}


	} else {
		die('{"status":"200","message":"NO LEVEL"}');
	}




}// END OF IF ISSET Q, ID, UD
elseif (isset($_REQUEST['id']) && !isset($_REQUEST['apikey'])) {//IF ISSET ID BUT NO UD
	$obj = new stdClass;
	$obj->status = "200";
	$obj->Successful = "false";
	$obj->message = "API KEY EXPECTED";
	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
} elseif (isset($_REQUEST['apikey']) && !isset($_REQUEST['id'])) {// IF ISSET UD BUT NO ID

	$obj = new stdClass;
	$obj->status = "200";
	$obj->Successful = "false";
	$obj->message = "ID EXPECTED";
	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
} else {// IF NONE
	$obj = new stdClass;
	$obj->status = "200";
	$obj->Successful = "false";
	$obj->message = "NO VALID CREDENTIALS PROVIDED";
	die(json_encode($obj, JSON_UNESCAPED_SLASHES));
}



?>