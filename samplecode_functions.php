<?php
// 必要なメタ情報とメタキー名などを決める
function return_meta_array() {
	$meta_array = array(
		'term_kana' => array(
			'name' => 'よみがな',
			'note' => 'よみがなを入力してください',
		),
		'osusume_flag' => array(
			'name' => 'おすすめマーク',
			'note' => 'おすすめマークを表示する際は表示にチェックを入れてください',
		),
	);
	return $meta_array;
}


// カテゴリー新規追加画面に入力フィールド
function add_termmeta_form() {
	$meta_array = return_meta_array();
	array_map( "esc_html", $meta_array );

$html = <<<EOM
	<div class="form-field term_kana-wrap">
		<label for="term_kana">{$meta_array['term_kana']['name']}</label>
		<input name="term_kana" id="term_kana" type="text" value="" size="40">
		<p>{$meta_array['term_kana']['note']}</p>
	</div>
	
	<div class="form-field osusume_flag-wrap">
		<label for="osusume_flag">{$meta_array['osusume_flag']['name']}</label>
		<ul>
			<li><label><input type="radio" name="osusume_flag" value="0" checked>非表示</label></li>
			<li><label><input type="radio" name="osusume_flag" value="1">表示</label></li>
		</ul>
		<p>{$meta_array['osusume_flag']['note']}</p>
	</div>
EOM;
	echo $html;
}
add_action( 'category_add_form_fields', 'add_termmeta_form' );


// カテゴリー編集画面に入力フィールド
function edit_termmeta_form( $tag, $taxonomy ) {
	$meta_array = return_meta_array();
	array_map( "esc_html", $meta_array );

	$term_kana_value = '';
	$osusume_flag_value = '';
	$term_kana_value = esc_attr( get_term_meta( $tag->term_id, 'term_kana', true ) );
	$osusume_flag_value = esc_attr( get_term_meta( $tag->term_id, 'osusume_flag', true ) );

	if ( $osusume_flag_value == 1 ) {
		$osusume_flag_1 = ' checked';
		$osusume_flag_0 = '';
	} elseif ( $osusume_flag_value == 0 ) {
		$osusume_flag_1 = '';
		$osusume_flag_0 = ' checked';
	}

$html = <<<EOM
	<tr class="form-field term_kana-wrap">
		<th scope="row"><label for="term_kana">{$meta_array['term_kana']['name']}</label></th>
		<td>
			<input name="term_kana" id="term_kana" type="text" value="{$term_kana_value}" size="40">
			<p class="description">{$meta_array['term_kana']['note']}</p>
		</td>
	</tr>
	
	<tr class="form-field osusume_flag-wrap">
		<th scope="row">{$meta_array['osusume_flag']['name']}</th>
		<td>
			<ul>
				<li><label><input type="radio" name="osusume_flag" value="0"{$osusume_flag_0}>非表示</label></li>
				<li><label><input type="radio" name="osusume_flag" value="1"{$osusume_flag_1}>表示</label></li>
			</ul>
			<p class="description">{$meta_array['osusume_flag']['note']}</p>
		</td>
	</tr>
EOM;
	echo $html;
}
add_action( 'category_edit_form_fields', 'edit_termmeta_form', 10, 2 );


// 保存と削除のプログラム
function update_term_meta_array( $term_id ) {
	$meta_array = return_meta_array();

	foreach ( $meta_array as $meta_key => $value ) {
		if ( ! isset( $_POST[$meta_key] ) || ! stripslashes_deep( $_POST[$meta_key] ) ) {
			delete_term_meta( $term_id, $meta_key, get_term_meta( $term_id, $meta_key, true ) );
		} elseif ( ! get_term_meta( $term_id, $meta_key ) ) {
			add_term_meta( $term_id, $meta_key, stripslashes_deep( $_POST[$meta_key] ), true );
		} elseif ( stripslashes_deep( $_POST[$meta_key] ) != get_term_meta( $term_id, $meta_key, true ) ) {
			update_term_meta( $term_id, $meta_key, stripslashes_deep( $_POST[$meta_key] ) );
		}
	}
}
add_action( 'created_category', 'update_term_meta_array' );
add_action( 'edited_category',  'update_term_meta_array' );
