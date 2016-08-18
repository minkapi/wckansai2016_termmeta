<?php
// フロント画面の実装方法
$categories = get_categories(); ?>
<ul>
<?php foreach ( $categories as $category ) :
	$cat_name = esc_html( $category->name );
	$cat_link = esc_url( get_category_link( $category->term_id ) );
	$cat_kana = esc_html( get_term_meta( $category->term_id, 'term_kana', true ) );
	$cat_flg  = get_term_meta( $category->term_id, 'osusume_flag', true );
	if ( $cat_flg == 1 ) {
		$cat_class = ' class="osusume"';
	} else {
		$cat_class = '';
	}
	$html  = '<li' . $cat_class . '><a href="' . $cat_link . '">';
	$html .= '<ruby>'. $cat_name . '<rt>' . $cat_kana . '</rt></ruby>';
	$html .= '</a></li>';
	echo $html;
endforeach; ?>
</ul>

<ul>
<?php foreach ( $categories as $category ) :
	$cat_name = esc_html( $category->name );
	$cat_link = esc_url( get_category_link( $category->term_id ) );
	$cat_kana = esc_html( get_registered_metadata( 'term', $category->term_id, 'term_kana' ) );
	$cat_flg  = get_registered_metadata( 'term', $category->term_id, 'osusume_flag' );
	if ( $cat_flg == 1 ) {
		$cat_class = ' class="osusume"';
	} else {
		$cat_class = '';
	}
	$html  = '<li' . $cat_class . '><a href="' . $cat_link . '">';
	$html .= '<ruby>'. $cat_name . '<rt>' . $cat_kana . '</rt></ruby>';
	$html .= '</a></li>';
	echo $html;
endforeach; ?>
</ul>

<?php foreach ( $categories as $category ) :
	var_dump( get_registered_metadata( 'term', $category->term_id ) );
endforeach; ?>
