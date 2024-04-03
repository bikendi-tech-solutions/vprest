<?php
/**
*Plugin Name: VP Reseller
*Plugin URI: https://vtupress.com
*Description: Add Reseller Feature to your VTU business
*Version: 2.5.0
*Author: Akor Victor
*Author URI: https://facebook.com/akor.victor.39
*/

if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH.'wp-admin/includes/plugin.php');
$path = WP_PLUGIN_DIR.'/vtupress/functions.php';
if(file_exists($path) && in_array('vtupress/vtupress.php', apply_filters('active_plugins', get_option('active_plugins')))){
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
}
else{
	if(!function_exists("vp_updateuser")){
function vp_updateuser(){
	
}

function vp_getuser(){
	
}

function vp_adduser(){
	
}

function vp_updateoption(){
	
}

function vp_getoption(){
	
}

function vp_option_array(){
	
}

function vp_user_array(){
	
}

function vp_deleteuser(){
	
}

function vp_addoption(){
	
}

	}

}

require __DIR__.'/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/bikendi-tech-solutions/vprest',
	__FILE__,
	'vprest'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

$myUpdateChecker->getVcsApi()->enableReleaseAssets();


vp_addoption("rb",0);
vp_addoption("resc",10000);







vp_addoption("vp_min_withdrawal",0);
vp_addoption("vp_first_level_bonus", 0);
vp_addoption("vp_second_level_bonus", 0);
vp_addoption("vp_third_level_bonus", 0);
vp_addoption("vp_first_trans_bonus", 0);
vp_addoption("vp_second_trans_bonus", 0);




// User Loop
add_action('init', 'is_user_func');

function is_user_func(){
if(is_user_logged_in()){
$current_user = get_current_user_id();
	
vp_adduser( $current_user, 'vp_who_ref' , 1); //who referred me

vp_adduser( $current_user, 'vp_tot_ref' , 0); //number of my direct referrs
vp_adduser( $current_user, 'vp_tot_in_ref' , 0); //number of my second level referrs
vp_adduser( $current_user, 'vp_tot_in_ref3' , 0); //number of my third level referrers referrs

vp_adduser( $current_user, 'vp_tot_ref_earn' , 0); // total earned from direct referers
vp_adduser( $current_user, 'vp_tot_in_ref_earn' , 0); // total earned from indirect referers
vp_adduser( $current_user, 'vp_tot_in_ref_earn3' , 0); // total earned from third level referers

vp_adduser( $current_user, 'vp_tot_trans' , 0);  // total transactions Attempted
vp_adduser( $current_user, 'vp_tot_suc_trans' , 0);  // total Successful transactions made
vp_adduser( $current_user, 'vp_tot_trans_amt' , 0); //total transactions amount consumed

vp_adduser( $current_user, 'vp_tot_dir_trans' , 0); //total transactions amount earned from direct
vp_adduser( $current_user, 'vp_tot_indir_trans' , 0); //total transactions amount earned from indirect
vp_adduser( $current_user, 'vp_tot_indir_trans3' , 0); //total transactions amount earned from third level

vp_adduser( $current_user, 'vp_tot_trans_bonus' , 0); //total transactions bonus earned
vp_adduser( $current_user, 'vp_tot_withdraws' , 0); // total withdrawals made

}
}






add_action("vpaccount", "vpaccoun");
function vpaccoun(){

 extract(vtupress_user_details());
 
$resc = vp_getoption("resc");
$id = get_current_user_id();
$bal = vp_getuser($id, "vp_bal", true);
$rplan = vp_getuser($id, "vr_plan", true);
$ud = vp_getuser($id, "vr_id", true);
$data = get_userdata($id);

?>

<?php
global $wpdb;
$table_name = $wpdb->prefix."vp_levels";
$data = $wpdb->get_results("SELECT * FROM  $table_name");
$my_data = $wpdb->get_results("SELECT * FROM  $table_name WHERE name = '$rplan'");
echo'
<div class="sshadow">
<div class="ccontainer" style="overflow:auto;">

<div class="input-group">
<span class="input-group-text">Plan</span>
<span class="input-group-text">'.$rplan.'</span>
';
if(isset($my_data)){
	if(strtolower($my_data[0]->developer) == "yes"){
echo'
<span class="input-group-text">API KEY</span>
<span class="input-group-text">'.$ud.'</span>
';
}
}
echo'
</div>
';

$id = get_current_user_id();
$bal = vp_getuser($id, "vp_bal", true);
$all_my_plans = vp_getuser($id, "all_my_plans", true);
	

?>
<table class="table table-responsive table-stripped">
<thead>
<tr>
<th>Package Id</th>
<th>Package Name</th>
<th>Upgrade Bonus</th>
<th>Upgrade PV</th>
<?php
if(vp_option_array($option_array,"setairtime") == "checked"){
	?>
<th>Airtime .Max Bonus [%]</th>
<?php
}
if(vp_option_array($option_array,"setdata") == "checked"){
	?>
<th>Data .Max Bonus [%]</th>
<?php
}
if(is_plugin_active("bcmv/bcmv.php") && vp_option_array($option_array,"setcable") == "checked"){
	?>
<th>Cable .Max Bonus [%]</th>
<?php
}
if(is_plugin_active("bcmv/bcmv.php") && vp_option_array($option_array,"setbill") == "checked"){
	?>
<th>Bill .Max Bonus [%]</th>
<?php
}
 if(is_plugin_active("vpcards/vpcards.php") && vp_option_array($option_array,"cardscontrol") == "checked" && vp_option_array($option_array,"resell") == "yes"){
?>
<th>Recharge Card .Max Bonus [%]</th>
<?php
 }
if(is_plugin_active("vpepin/vpepin.php") && vp_option_array($option_array,"epinscontrol") == "checked" && vp_option_array($option_array,"resell") == "yes"){ 
?>
<th>Exam PINs .Max Bonus [%]</th>
<?php
}
?>
<th>API Access</th>
<th>Transfer Access</th>
<th>Upgrade Amount</th>
<th>More Info.</th>
<th>Upgrade</th>
</tr>
</thead>
<tbody>
<?php
foreach($data as $level){

$vtu = max(array(floatval($level->mtn_vtu),floatval($level->glo_vtu),floatval($level->mobile_vtu),floatval($level->airtel_vtu)));
$share = max(array(floatval($level->mtn_share),floatval($level->glo_share),floatval($level->mobile_share),floatval($level->airtel_share)));
$awuf = max(array(floatval($level->mtn_awuf),floatval($level->glo_awuf),floatval($level->mobile_awuf),floatval($level->airtel_awuf)));


$sme = max(array(floatval($level->mtn_sme),floatval($level->glo_sme),floatval($level->mobile_sme),floatval($level->airtel_sme)));
$corporate = max(array(floatval($level->mtn_corporate),floatval($level->glo_corporate),floatval($level->mobile_corporate),floatval($level->airtel_corporate)));
$gifting = max(array(floatval($level->mtn_gifting),floatval($level->glo_gifting),floatval($level->mobile_gifting),floatval($level->airtel_gifting)));


if(is_plugin_active("vpcards/vpcards.php") && vp_option_array($option_array,"cardscontrol") == "checked" && vp_option_array($option_array,"resell") == "yes"){
$card = max(array(floatval($level->card_mtn),floatval($level->card_glo),floatval($level->card_9mobile),floatval($level->card_airtel)));
}
if(is_plugin_active("vpepin/vpepin.php") && vp_option_array($option_array,"epinscontrol") == "checked" && vp_option_array($option_array,"resell") == "yes"){ 
$epin = max(array(floatval($level->epin_waec),floatval($level->epin_neco),floatval($level->epin_nabteb),floatval($level->epin_jamb)));
}

$id= $level->id;
$name = $level->name;
$airtime = max(array($vtu,$share,$awuf));
$data = max(array($sme,$corporate,$gifting));
$cable = floatval($level->cable);
$bill = floatval($level->bill_prepaid);
$upgrade_amount = $level->upgrade;
$api_access = strtoupper($level->developer);
$transfer_access = strtoupper($level->transfer);

$upgrade_bonus = $level->upgrade_bonus;
$upgrade_pv = $level->upgrade_pv;

#BEGINNING OF ROW

if(strtolower($level->status) == "active"){
echo"
<tr>
<td>$id</td>
<td>$name</td>
<td>$upgrade_bonus</td>
<td>$upgrade_pv</td>
";
if(vp_option_array($option_array,"setairtime") == "checked"){
	echo"
<td>$airtime</td>
";
}
if(vp_option_array($option_array,"setdata") == "checked"){
	echo"
<td>$data</td>
";
}
if(is_plugin_active("bcmv/bcmv.php") && vp_option_array($option_array,"setcable") == "checked"){
	echo"
<td>$cable</td>
";
}
if(is_plugin_active("bcmv/bcmv.php")  && vp_option_array($option_array,"setbill") == "checked"){
	echo"
<td>$bill</td>
";
}
if(is_plugin_active("vpcards/vpcards.php") && vp_option_array($option_array,"cardscontrol") == "checked" && vp_option_array($option_array,"resell") == "yes"){
echo"
<td>$card</td>
";
}
if(is_plugin_active("vpepin/vpepin.php") && vp_option_array($option_array,"epinscontrol") == "checked" && vp_option_array($option_array,"resell") == "yes"){ 
echo"
<td>$epin</td>
";
}
echo"
<td>$api_access</td>
<td>$transfer_access</td>
<td>$upgrade_amount</td>
<td><button type=\"button\" class=\"btn btn-sm btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal$id\">
See More
</button></td>
<td>
";
if(strtolower($rplan) != strtolower($name) && floatval($bal) >= floatval($upgrade_amount) && !is_numeric(stripos($all_my_plans,$name))){
	echo"

<button class='btn btn-sm btn-success' onclick='upgrade($id,\"$name\")'> Get This Plan </button>

";
}
elseif(strtolower($rplan) != strtolower($name) && $bal < $upgrade_amount){
  echo"

Insufficient Wallet Balance

";	
}
elseif(is_numeric(stripos($all_my_plans,$name))){
  echo"

You Can't Downgrade

";
}
elseif(strtolower($rplan) == strtolower($name)){
		echo"

On This Plan


";	
}

echo"
</td>
</tr>
";


$monthly_referee = intval($level->monthly_referee);
$monthly_transactions_number = intval($level->monthly_transactions_number);
$monthly_transactions_amount = intval($level->monthly_transactions_amount);
$charge_back_percentage = intval($level->charge_back_percentage);
$monthly_sub = $level->monthly_sub;
if(vp_option_array($option_array,"vtupress_custom_mlmsub") == "yes"){
if($level->enable_extra_service == "enabled"){
  $airtime_bonus_ex1 = $level->airtime_bonus_ex1;
  $data_bonus_ex1 = $level->data_bonus_ex1." - ".strtoupper($level->data_bonus_type_ex1);

$retn = <<<EOD

<p>Monthly Airtime: $airtime_bonus_ex1</p>
<p>Monthly Data: $data_bonus_ex1</p>

EOD;
}
}
echo '
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal'.$id.'" tabindex="-1" aria-labelledby="exampleModalLabel'.$id.'" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel'.$id.'">['.$name.']</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <p>Monthly Subscription: '.$monthly_sub.'</p>
          <p>Funding Commisions From Referees: '.$charge_back_percentage.'% </p>
          '.$retn.'
          <br>
          
          <div class="p-1 border">
          Monthly Membership Rule: (0) means the condition is not applied
            <div class="p-2 border">
              <p>Monthly Referees Expected: '.$monthly_referee.'</p>
              <p>Number Of Transactions: '.$monthly_transactions_number.'</p>
              <p>Total Transactions Amount: #'.$monthly_transactions_amount.'</p>

            </div>
          <code>You will be downgraded to the customer plan if those rules are not met</code>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


';


}
#END OF ROW
	
	
}
?>


</tbody>
</table>
<script>
function upgrade(el,name){
var obj = {};

obj["level_id"] = el;
obj["level_name"] = name;
obj["paywall"] = name;
var text = "You've Been Upgraded To "+name;
var the_name = text.toUpperCase();
jQuery("#cover-spin").show();


jQuery.ajax({
  url: '<?php echo esc_url(plugins_url("vtupress/vend.php"));?>',
  data: obj,
 dataType: 'text',
  'cache': false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery("#cover-spin").hide();
        var msg = "";
        if (jqXHR.status === 0) {
            msg = "No Connection. Verify Network.";
     swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
  
        } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "timeout") {
            msg = "Time out error.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else {
            msg = "Uncaught Error." + jqXHR.responseText;
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        }
    },
  
  success: function(data){
	  jQuery("#cover-spin").hide();
        if(data == "100"){
		  swal({
  title: "Welcome",
  text: the_name,
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else if(data == "101"){
		  swal({
  title: "Error Upgrading You",
  text: "Balance Too Low",
  icon: "error",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
		 jQuery("#cover-spin").hide();
	swal({
  buttons: {
    cancel: "Why?",
    defeat: "Okay",
  },
  title: "Error Upgrading You",
  text: "Click \'Why\' To See reason",
  icon: "error",
})
.then((value) => {
  switch (value) {
 
    case "defeat":
      break;
    default:
      swal(data, {
      icon: "info",
    });
  }
});
	  }
  },
  type: 'POST'
});
	
	
}
</script>
<?php

echo '

</div>
</div>
';
?>


<?php

}


//options
vp_addoption("vrap", "no");
vp_addoption("vr_meta", "no");
vp_addoption("resamt", 10000);


//create API Page
function create_resapi(){
if(vp_getoption("vrap") == "no"){
global $wpdb;
$table_name =$wpdb->prefix.'posts';
$data = array(
'post_title'    => 'API',
'post_name' => 'api',
'post_content'  => '[vpapi]',
'post_status'   => 'publish',
'post_author'   => 1,
'post_type'     => 'page'
);
$wpdb->insert($table_name, $data);
vp_updateoption("vrap","yes");
}else{return;}
}


//shortcode
add_shortcode("vpapi","vpapi");
function vpapi(){
$url = 'https://vtupress.com/wp-content/plugins/vtuadmin?id='.vp_getoption('vpid').'&actkey='.vp_getoption('actkey');
$request_url = $url;

$curl = curl_init($request_url);
$agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";

curl_setopt($curl, CURLOPT_USERAGENT, $agent);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json'
]);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
// Check if initialization had gone wrong*    
    if ($curl === false) {
        throw new Exception('failed to initialize');
    }
$resp = curl_exec($curl);

if($e = curl_error($curl)){
echo'<script>alert("'.$e.'");</script>';
}
elseif($curl === false){
        throw new Exception('failed to initialize');
}
else{
$en = json_decode($resp);
curl_close($curl);
}
if($en->status == "active" && $en->plan == "premium" && $en->actkey == vp_getoption('actkey')){
$rst = urldecode($_SERVER['QUERY_STRING']);
wp_safe_redirect(site_url()."/wp-content/plugins/vprest?".$rst);
exit;
}
elseif($en->status == "active" && $en->plan == "premium-y" && $en->actkey == vp_getoption('actkey')){
	
$rst = urldecode($_SERVER['QUERY_STRING']);
wp_safe_redirect(site_url()."/wp-content/plugins/vprest?".$rst);
exit;	
	
}
elseif($en->status == "active" && $en->plan == "unlimited" && $en->actkey == vp_getoption('actkey')){
	
  $rst = urldecode($_SERVER['QUERY_STRING']);
  wp_safe_redirect(site_url()."/wp-content/plugins/vprest?".$rst);
  exit;	
    
  }
else{
	echo "
	Personal API cant be used error: !-#P or !-#U
	";
	
}

}

//create meta for existing users
add_action('init','create_meta');
function create_meta(){
if(vp_getoption("vr_meta") == "no"){
$args = array("fields" => "ids");
$users = get_users($args);
foreach($users as $user){
vp_updateuser($user,"vr_plan", "customer");
vp_updateuser($user,"vr_id", "null");
}
vp_updateoption("vr_meta", "yes");
}
}
//create meta on reg
add_action( 'user_register', 'resreg');
function resreg($user_id){
vp_updateuser($user_id,"vr_plan", "customer");
vp_updateuser($user_id, "vr_id", "null");
}


register_activation_hook(__FILE__, "create_resapi");
?>