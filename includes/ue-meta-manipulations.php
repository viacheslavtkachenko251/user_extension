<?php
function add_registration_errors( $errors ) {
	if (empty($_POST['user_sex'])) {
		$errors->add( 'sex_empty', '<strong>ОШИБКА</strong>: Укажите свой пол!' );
	}
	if (empty($_POST['user_family'])) {
		$errors->add( 'family_empty', '<strong>ОШИБКА</strong>: Укажите семейное положение!' );
	}
	if (empty($_POST['user_adress'])) {
		$errors->add( 'adress_empty', '<strong>ОШИБКА</strong>: Укажите свой адрес!' );
	}
	if (empty($_POST['user_telephone'])) {
		$errors->add( 'telephone_empty', '<strong>ОШИБКА</strong>: Укажите свой телефон!' );
	}
	
	return $errors;
}

function register_form_add_field() {
	?>
	<p>	
		<p>Ваш пол:</p>
		<input type="radio" name="user_sex" value="female" id="female"> <label for="female"> Женский</label><br>
		<input type="radio" name="user_sex" value="male" id="male"> <label for="male">Мужской </label><br>
		<input type="radio" name="user_sex" value="undefined" id="undefined"> <label for="undefined">Неопределился </label>
	</p>
	<p>
		<label for="family">Семейный статус:</label>
		<input type="text" name="user_family" id="family"> 
	</p>
	<p>
		<label for="adress">Ваш адрес: </label>
		<input type="text" name="user_adress" id="adress"> 
	</p>
	<p>
		<label for="telephone">Ваш телефон:</label>
		<input type="tel" name="user_telephone" id="telephone"> 
	</p>
	<br>
	<?php
}

function ue_user_registration_meta($meta, $user, $update ) {
	
	$meta['user_sex']       = ue_encode($_POST['user_sex']);
	$meta['user_family']    = ue_encode($_POST['user_family']);
	$meta['user_adress']    = ue_encode($_POST['user_adress']);
	$meta['user_telephone'] = ue_encode($_POST['user_telephone']);

	return $meta;
}

function ue_get_user_meta($user_id){
	$tempUserMeta = get_user_meta($user_id);
	if(isset($tempUserMeta['user_sex'])){
		$userMeta['user_sex'] = ue_decode($tempUserMeta['user_sex'][0]);
	} else {
		$userMeta['user_sex'] = '';
	}
	if(isset($tempUserMeta['user_family'])){
		$userMeta['user_family'] = ue_decode($tempUserMeta['user_family'][0]);
	} else {
		$userMeta['user_family'] = '';
	}
	if(isset($tempUserMeta['user_adress'])){
		$userMeta['user_adress'] = ue_decode($tempUserMeta['user_adress'][0]);
	} else {
		$userMeta['user_adress'] = '';
	}
	if(isset($tempUserMeta['user_telephone'])){
		$userMeta['user_telephone'] = ue_decode($tempUserMeta['user_telephone'][0]);
	} else {
		$userMeta['user_telephone'] = '';
	}
	return $userMeta;
}

function ue_update_user_meta($userId){
	$userMeta = ue_get_user_meta($userId);
	foreach($userMeta as $k=>$v){
		if($userMeta[$k] != $_POST[$k]){
			update_user_meta($userId, $k, ue_encode($_POST[$k]));
		}
	}
	return;
}

function ue_profile_new_fields_add($profileuser){ 
	$userMeta = ue_get_user_meta($profileuser->ID);
	
	?>
	<table class="form-table" role="presentation">
		<tbody>
	<tr>	
		<th>Ваш пол:</th>
		<td>
			<input type="radio" name="user_sex" value="female" id="female" <?=  $userMeta['user_sex'] == 'female' ? 'checked="checked"' : NULL; ?>> <label for="female"> Женский</label><br>
			<input type="radio" name="user_sex" value="male" id="male" <?= $userMeta['user_sex'] == 'male' ? 'checked="checked"' : NULL; ?>> <label for="male">Мужской </label><br>
			<input type="radio" name="user_sex" value="undefined" id="undefined" <?= $userMeta['user_sex'] == 'undefined' ? 'checked="checked"' : NULL; ?>> <label for="undefined">Неопределился </label>
		</td>
	</tr>
	<tr>
		<th><label for="family">Семейный статус:</label></th>
		<td><input type="text" name="user_family" id="family" value="<?= $userMeta['user_family'] ; ?>"> </td>
	</tr>
	<tr>
		<th><label for="adress">Ваш адрес: </label></th>
		<td><input type="text" name="user_adress" id="adress" value="<?= $userMeta['user_adress']; ?>"> </td>
	</tr>
	<tr>
		<th><label for="telephone">Ваш телефон:</label></th>
		<td><input type="tel" name="user_telephone" id="telephone" value="<?= $userMeta['user_telephone']; ?>"> </td>
	</tr>
	</tbody>
	</table>
	<?php            
}

function shortcode_users($atts) {
	
	$paginate = '';
	$userArgs = [
			'orderby'=> 'ID'
		];
	if(isset($atts['limit'])){
		$paged = get_query_var('page') ? get_query_var('page') :  1; 
		$count_user = count_users();
		$total_pages = ceil($count_user['total_users'] / $atts['limit']);
		$userArgs = [
			'number' => $atts['limit'],
			'paged'  => $paged
		];
		$paginate = '<div style="text-align:center;">'
		
		. paginate_links(array(  
          'base'      => get_pagenum_link(1) . '%_%',  
          'format'    => 'page/%#%/',  
          'current'   => $paged,  
          'total'     => $total_pages,  
          'prev_next' => true,  
          'type'      => 'plain',  
    )) . '</div>';	
	}
	
	$users = get_users($userArgs);
	$content = '<div class="wp-block-columns">';
	foreach($users as $user){
		$content .= '<div class="wp-block-column" style="paddig:5px; text-align:center;">';
		$content .= get_avatar($user->ID);
		$content .= '<a style="display:block;text-align:center;" href="'. get_author_posts_url($user->ID) . '">' . $user->user_login . '</a>';	
		$content .= '</div>';
	}
	
	$content .= '</div>';
	$content .= $paginate;	
	return $content;
}

function ue_tpl_include( $template ){
	if(is_author()){
		return UE_PLUGIN_DIR . 'template/author.php';
	} else{
			return $template;
	}
	
}

