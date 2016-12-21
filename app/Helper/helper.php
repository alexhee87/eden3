<?php
function delete_form($value,$param = array()){
    $name = (array_key_exists('name', $param)) ? $param['name'] : randomString(10);
    $form_option = ['method' => 'DELETE',
        'route' => $value,
        'class' => 'form-inline',
        'id' => $name.'_'.$value[1]
        ];

    $label = (array_key_exists('label', $param)) ? $param['label'] : '';
    if(array_key_exists('refresh', $param))
        $form_option['data-refresh'] = $param['refresh'];
    if(array_key_exists('ajax', $param))
        $form_option['data-submit'] = $param['ajax'];

    $form = Form::open($form_option);
    $form .= Html::decode(Form::button('<i class="fa fa-trash-o"></i> '.$label,['data-toggle' => 'tooltip', 'title' => trans('messages.delete'), 'class' => 'btn btn-danger btn-xs', 'data-submit-confirm-text' => 'Yes', 'type' => 'submit']));
    return $form .= Form::close();
}

function getMode(){
	return config('code.mode');
}

function setEncryptionKey(){
    if(!config('code.encryption_key')){
        $config = config('code');
        $config['encryption_key'] = randomString(32);
        write2Config($config,'code');
    }
    config(['app.key' => config('code.encryption_key')]);
}

function backupDatabase(){
    try {
        $db_export = \App\Classes\Shuttle_Dumper::create(array(
            'host' => config('database.connections.primary.host'),
            'username' => config('database.connections.primary.username'),
            'password' => config('database.connections.primary.password'),
            'db_name' => config('database.connections.primary.database'),
        ));
        $filename = 'backup_'.date('Y_m_d_H_i_s').'.sql.gz';
        $db_export->dump($filename);
        return ['status' => 'success','filename' => $filename];
    } catch(\App\Classes\Shuttle_Exception $e) {
        $message = $e->getMessage(); 
        return ['status' => 'error'];
    }
}

function showDateTime($time = ''){
	if($time == '')
		return;

    $format = config('config.date_format') ? : 'd-m-Y';
	if(config('config.time_format'))
        return date($format.',h:i a',strtotime($time));
	else
        return date($format.',H:i',strtotime($time));
}

function showDate($date = ''){
    if($date == '' || $date == null)
        return;

    $format = config('config.date_format') ? : 'd-m-Y';
    return date($format,strtotime($date));
}

function ipRange($network, $ip) {
    $network=trim($network);
    $orig_network = $network;
    $ip = trim($ip);
    if ($ip == $network) {
        return TRUE;
    }
    $network = str_replace(' ', '', $network);
    if (strpos($network, '*') !== FALSE) {
        if (strpos($network, '/') !== FALSE) {
            $asParts = explode('/', $network);
            $network = @ $asParts[0];
        }
        $nCount = substr_count($network, '*');
        $network = str_replace('*', '0', $network);
        if ($nCount == 1) {
            $network .= '/24';
        } else if ($nCount == 2) {
            $network .= '/16';
        } else if ($nCount == 3) {
            $network .= '/8';
        } else if ($nCount > 3) {
            return TRUE;
        }
    }

    $d = strpos($network, '-');
    if ($d === FALSE) {
        $ip_arr = explode('/', $network);
        if (!preg_match("@\d*\.\d*\.\d*\.\d*@", $ip_arr[0], $matches)){
            $ip_arr[0].=".0"; 
        }
        $network_long = ip2long($ip_arr[0]);
        $x = ip2long($ip_arr[1]);
        $mask = long2ip($x) == $ip_arr[1] ? $x : (0xffffffff << (32 - $ip_arr[1]));
        $ip_long = ip2long($ip);
        return ($ip_long & $mask) == ($network_long & $mask);
    } else {
        $from = trim(ip2long(substr($network, 0, $d)));
        $to = trim(ip2long(substr($network, $d+1)));
        $ip = ip2long($ip);
        return ($ip>=$from and $ip<=$to);
    }
}

function defaultDB(){
    config([
    'database.connections.primary.host' => config('db.hostname'),
    'database.connections.primary.username' => config('db.username'),
    'database.connections.primary.password' => config('db.password'),
    'database.connections.primary.database' => config('db.database')
    ]);
}

function checkDBConnection(){
    $link = @mysqli_connect(config('database.connections.primary.host'), 
        config('database.connections.primary.username'), 
        config('database.connections.primary.password'));

    if($link)
        return mysqli_select_db($link,config('database.connections.primary.database'));
    else
        return false;
}

function setConfig($config_vars){

    foreach($config_vars as $config_var){
        config(['config.'.$config_var->name => (isset($config_var->value) && $config_var->value != '' && $config_var->value != null) ? $config_var->value : config('config.'.$config_var->name)]);
    }

    config([
    'mail.driver' => ($config_vars->where('name','driver')->first()) ? $config_vars->where('name','driver')->first()->value : config('constant.mail_default.driver'),
    'mail.from.address' => ($config_vars->where('name','from_address')->first()) ? $config_vars->where('name','from_address')->first()->value : config('constant.mail_default.from_address'),
    'mail.from.name' => ($config_vars->where('name','from_name')->first()) ? $config_vars->where('name','from_name')->first()->value : config('constant.mail_default.from_name'),
    'mail.encryption' => ($config_vars->where('name','encryption')->first()) ? $config_vars->where('name','encryption')->first()->value : ''
    ]);

    if(config('mail.driver') == 'smtp'){
        config([
        'mail.host' => ($config_vars->where('name','host')->first()) ? $config_vars->where('name','host')->first()->value : '',
        'mail.port' => ($config_vars->where('name','port')->first()) ? $config_vars->where('name','port')->first()->value : '',
        'mail.username' => ($config_vars->where('name','username')->first()) ? $config_vars->where('name','username')->first()->value : '',
        'mail.password' => ($config_vars->where('name','password')->first()) ? $config_vars->where('name','password')->first()->value : ''
        ]);
    }

    if(config('mail.driver') == 'mailgun'){
        config([
        'mail.host' => ($config_vars->where('name','mailgun_host')->first()) ? $config_vars->where('name','mailgun_host')->first()->value : '',
        'mail.port' => ($config_vars->where('name','mailgun_port')->first()) ? $config_vars->where('name','mailgun_port')->first()->value : '',
        'mail.username' => ($config_vars->where('name','mailgun_username')->first()) ? $config_vars->where('name','mailgun_username')->first()->value : '',
        'mail.password' => ($config_vars->where('name','mailgun_password')->first()) ? $config_vars->where('name','mailgun_password')->first()->value : '',
        'services.mailgun.domain' => ($config_vars->where('name','mailgun_domain')->first()) ? $config_vars->where('name','mailgun_domain')->first()->value : '',
        'services.mailgun.secret' => ($config_vars->where('name','mailgun_secret')->first()) ? $config_vars->where('name','mailgun_secret')->first()->value : '',
        ]);
    }

    if(config('mail.driver') == 'mandrill'){
        config([
            'services.mandrill.secret' => ($config_vars->where('name','mandrill_secret')->first()) ? $config_vars->where('name','mandrill_secret')->first()->value : ''
        ]);
    }           
}

function createSlug($string){
   if(checkUnicode($string))
        $slug = str_replace(' ', '-', $string);
   else
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
   return $slug;
}

function checkUnicode($string)
{
    if(strlen($string) != strlen(utf8_decode($string)))
    return true;
    else
    return false;
}

function toWord($word){
    $word = str_replace('_', ' ', $word);
    $word = str_replace('-', ' ', $word);
    $word = ucwords($word);
    return $word;
}

function getCustomFields($form, $custom_field_values = array()){
    
    $custom_fields = \App\CustomField::whereForm($form)->get();

    foreach($custom_fields as $custom_field){
      
      $c_values = (array_key_exists($custom_field->name, $custom_field_values)) ? $custom_field_values[$custom_field->name] : '';
      $options = explode(',',$custom_field->options);

      $required = '';
      
      echo '<div class="form-group">';
      echo '<label for="'.$custom_field->name.'">'.$custom_field->title.'</label>';
      
      if($custom_field->type == 'select'){
        echo '<select class="form-control input-xlarge chosen-select" placeholder="'.trans('messages.select_one').'" id="'.$custom_field->name.'" name="'.$custom_field->name.'"'.$required.'>
        <option value="">'.trans('messages.select_one').'</option>';
        foreach($options as $option){
            if($option == $c_values)
                echo '<option value="'.$option.'" selected>'.ucfirst($option).'</option>';
            else
                echo '<option value="'.$option.'">'.ucfirst($option).'</option>';
        }
        echo '</select>';
      }
      elseif($custom_field->type == 'radio'){
        echo '<div>
            <div class="radio">';
            foreach($options as $option){
                if($option == $c_values)
                    $checked = "checked";
                else
                    $checked = "";
                echo '<label><input type="radio" name="'.$custom_field->name.'" id="'.$custom_field->name.'" value="'.$option.'" '.$required.' '.$checked.' class="icheck"> '.ucfirst($option).'</label> ';
            }
        echo '</div>
        </div>';
      }
      elseif($custom_field->type == 'checkbox'){
        echo '<div>
            <div class="checkbox">';
            foreach($options as $option){
                if(in_array($option,explode(',',$c_values)))
                    $checked = "checked";
                else
                    $checked = "";
                echo '<label><input type="checkbox" name="'.$custom_field->name.'[]" id="'.$custom_field->name.'" value="'.$option.'" '.$checked.' '.$required.' class="icheck"> '.ucfirst($option).'</label> ';
            }
        echo '</div>
        </div>';
      }
      elseif($custom_field->type == 'textarea')
       echo '<textarea class="form-control" data-limit="'.config('config.textarea_limit').'" placeholder="'.$custom_field->title.'" name="'.$custom_field->name.'" cols="30" rows="3" id="'.$custom_field->name.'"'.$required.' data-show-counter=1 data-autoresize=1>'.$c_values.'</textarea><span class="countdown"></span>';
      else
        echo '<input class="form-control '.(($custom_field->type == 'date') ? 'datepicker' : '').'" value="'.$c_values.'" placeholder="'.$custom_field->title.'" name="'.$custom_field->name.'" type="text" value="" id="'.$custom_field->name.'"'.$required.' '.(($custom_field->type == 'date') ? 'readonly' : '').'>';
      echo '</div>';
    }
}

function putCustomHeads($form, $col_heads){
    $custom_fields = \App\CustomField::whereForm($form)->get();
    foreach($custom_fields as $custom_field)
        array_push($col_heads, $custom_field->title);
    return $col_heads;
}

function validateCustomField($form,$request){
    $custom_validation = array();
    $custom_fields = \App\CustomField::whereForm($form)->get();
    $friendly_names = array();
    foreach($custom_fields as $custom_field){
        if($custom_field->is_required){
            $custom_validation[$custom_field->name] = 'required'.(($custom_field->type == 'date') ? '|date' : '').(($custom_field->type == 'number') ? '|numeric' : '').(($custom_field->type == 'email') ? '|email' : '').(($custom_field->type == 'url') ? '|url' : '');
            $friendly_names[$custom_field->name] = $custom_field->title;
        }
   }

   $validation = \Validator::make($request->all(),$custom_validation);
   $validation->setAttributeNames($friendly_names);
   return $validation;
}

function fetchCustomValues($form){
    $rows = \DB::table('custom_fields')
    ->join('custom_field_values','custom_field_values.field_id','=','custom_fields.id')
    ->where('form','=',$form)
    ->select(\DB::raw('unique_id,field_id,value,type'))
    ->get();
    $values = array();
    foreach($rows as $row){
        $field_values = [];
        $value = '';
        if($row->type == 'checkbox'){
            $field_values = explode(',',$row->value);
            $value .= '<ol>';
            foreach($field_values as $fv)
                $value .= '<li>'.toWord($fv).'</li>';
            $value .= '</ol>';
        } else
        $value = toWord($row->value);

        $values[$row->unique_id][$row->field_id] = $value;
    }
    return $values;
}

function getCustomFieldValues($form,$id){
    return \DB::table('custom_fields')
    ->join('custom_field_values','custom_field_values.field_id','=','custom_fields.id')
    ->where('form','=',$form)
    ->where('unique_id','=',$id)
    ->pluck('value','name')->all();
}

function getCustomColId($form){
    return \App\CustomField::whereForm($form)->pluck('id')->all();
}

function storeCustomField($form, $id, $request){
    $custom_fields = \App\CustomField::whereForm($form)->get();
    foreach($custom_fields as $custom_field){
        $custom_field_value = new \App\CustomFieldValue;
        $value = $request[$custom_field->name];
        if(is_array($value))
            $value = implode(',',$value);
        $custom_field_value->value = $value;
        $custom_field_value->field_id = $custom_field->id;
        $custom_field_value->unique_id = $id;
        $custom_field_value->save();
    }
}

function updateCustomField($form, $id, $request){
    $custom_fields = \App\CustomField::whereForm($form)->get();
    foreach($custom_fields as $custom_field){
        $value = array_key_exists($custom_field->name, $request) ? $request[$custom_field->name] : '';

        if(is_array($value))
            $value = implode(',',$value);

        $custom = \DB::table('custom_fields')
            ->join('custom_field_values','custom_field_values.field_id','=','custom_fields.id')
            ->where('form','=',$form)
            ->where('name','=',$custom_field->name)
            ->where('unique_id','=',$id)
            ->select(\DB::raw('custom_field_values.id'))
            ->first();

        if($custom)
            $custom_field_value = \App\CustomFieldValue::find($custom->id);
        else
            $custom_field_value = new \App\CustomFieldValue;
        $custom_field_value->value = $value;
        $custom_field_value->field_id = $custom_field->id;
        $custom_field_value->unique_id = $id;
        $custom_field_value->save();
    }
}

function deleteCustomField($form, $id){
    $data = \DB::table('custom_field_values')
        ->join('custom_fields','custom_fields.id','=','custom_field_values.field_id')
        ->where('form','=',$form)
        ->where('unique_id','=',$id)
        ->delete();
}

function randomString($length,$type = 'token'){
    if($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
         $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr( str_shuffle( $chars ), 0, $length );
    return $token;
}

function defaultRole(){
    if(\Entrust::hasRole(DEFAULT_ROLE))
        return 1;
    else
        return 0;
}

function getAvatar($id, $size = 60){
    $user = \App\User::find($id);
    $profile = $user->Profile;
    $name = $user->full_name;
    $tooltip = $name;
    if(isset($profile->avatar))
        return '<img src="'.url(config('constant.upload_path.avatar').$profile->avatar).'" class="img-circle" style="width:'.$size.'px";" alt="User avatar" data-toggle="tooltip" title="'.$tooltip.'">';
    else
        return '<img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=Image=150&h=150" class="img-circle" style="width:'.$size.'px";" alt="User avatar" data-toggle="tooltip" title="'.$tooltip.'">';}

function timeAgo($time_ago){
    $time_ago = strtotime($time_ago);
    $cur_time = strtotime(date('Y-m-d H:i:s'));
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    if($seconds <= 60){
        echo "$seconds seconds ago";
    }
    else if($minutes <=60){
        if($minutes==1){
            echo "one minute ago";
        }
        else{
            echo "$minutes minutes ago";
        }
    }
    else if($hours <=24){
        if($hours==1){
            echo "an hour ago";
        }else{
            echo "$hours hours ago";
        }
    }
    else if($days <= 7){
        if($days==1){
            echo "yesterday";
        }else{
            echo "$days days ago";
        }
    }
    else if($weeks <= 4.3){
        if($weeks==1){
            echo "a week ago";
        }else{
            echo "$weeks weeks ago";
        }
    }
    else if($months <=12){
        if($months==1){
            echo "a month ago";
        }else{
            echo "$months months ago";
        }
    }
    else{
        if($years==1){
            echo "one year ago";
        }else{
            echo "$years years ago";
        }
    }
}

function getDateDiff($date){
    $difference = date('z',strtotime($date)) - date('z') + 1;
    if($difference == 0)
        return trans('messages.today');
    elseif($difference == 1)
        return trans('messages.tomorrow');
    elseif($difference == -1)
        return trans('messages.yesterday');
    else
        return 0;
}

function daySuffix($num){
    $num = $num % 100;
    if($num < 11 || $num > 13){
         switch($num % 10){
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}

function verifyPurchase($purchase_code = ''){
    $purchase_code = ($purchase_code != '') ? $purchase_code : config('code.purchase_code');
    $url = config('constant.path.verifier')."verifier";
    $postData = array(
        'purchase_code' => $purchase_code,
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function is_connected()
{
    $connected = @fsockopen("www.google.com", 80); 
    if ($connected){
        $is_conn = true;
        fclose($connected);
    }else{
        $is_conn = false;
    }
    return $is_conn;
}

function installPurchase($purchase_code,$envato_username,$email = ''){
    $url = config('constant.path.verifier')."installer";
    $postData = array(
        'envato_username' => $envato_username,
        'purchase_code' => $purchase_code,
        'product_code' => config('constant.item_code'),
        'email' => $email,
        'api_version' => '2',
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function complete($purchase_code){
    $url = config('constant.path.verifier')."activate";
    $postData = array(
        'purchase_code' => $purchase_code,
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function releaseLicense(){
    $purchase_code = config('code.purchase_code');
    $url = config('constant.path.verifier')."license-release";
    $postData = array(
        'purchase_code' => $purchase_code,
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function getUpdate(){
    $url = config('constant.path.verifier')."update";
    $postData = array(
        'purchase_code' => config('code.purchase_code'),
        'build' => config('code.build'),
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function write2Config($data,$file){
    $filename = base_path().'/config/'.$file.'.php';
    File::put($filename,var_export($data, true));
    File::prepend($filename,'<?php return ');
    File::append($filename, ';');
}

function validateIp(){

    $ip = \Request::getClientIp();

    $wl_ips = \App\IpFilter::all();
    $allowedIps = array();
    foreach($wl_ips as $wl_ip){
        if($wl_ip->end)
            $allowedIps[] = $wl_ip->start.'-'.$wl_ip->end;
        else
            $allowedIps[] = $wl_ip->start;
    }

    foreach ($allowedIps as $allowedIp) 
    {
        if (strpos($allowedIp, '*')) 
        {
            $range = [ 
                str_replace('*', '0', $allowedIp),
                str_replace('*', '255', $allowedIp)
            ];
            if(ipExistsInRange($range, $ip)) return true;
        } 
        else if(strpos($allowedIp, '-'))
        {
            $range = explode('-', str_replace(' ', '', $allowedIp));
            if(ipExistsInRange($range, $ip)) return true;
        }
        else 
        {
            if (ip2long($allowedIp) === ip2long($ip)) return true;
        }
    }
    return false;
}

function ipExistsInRange(array $range, $ip)
{
    if (ip2long($ip) >= ip2long($range[0]) && ip2long($ip) <= ip2long($range[1])) 
        return true;
    return false;
}

function postCurl($url,$postData){
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
    ));
    $data = curl_exec($ch);
    $gresponse = json_decode($data,true);
    return $gresponse;
}