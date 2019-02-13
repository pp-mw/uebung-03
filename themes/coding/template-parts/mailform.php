<?php

function get_mail_address() {
	$page_id = url_to_postid( get_field( 'request_form', get_option( 'page_on_front' ) ) );
	if ( $page_id ) {
		return get_field( 'request_recipient', $page_id );
	}
}

function newsletter_send_email_to_admin() {

	$vars = filter_input_array( INPUT_POST, array(
		'n_email' => FILTER_SANITIZE_EMAIL,
		're_id' => FILTER_SANITIZE_NUMBER_INT,
	) );

	/**
	 * Filter the mail content type.
	 */
	function wpdocs_set_html_mail_content_type() {
		return 'text/html';
	}
	add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

	$to = $vars['n_email'];
	$headers[] = 'From: Aura-Hotel <' . get_mail_address() . '>';
	$subject = 'Ihre Newsletteranmeldung bei Aura-Hotel';
	$body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	$body   .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	$body   .= '<style>body { font-family: Arial, Helvetica, sans-serif; }</style></head>';
	$body   .= '<body>';
	$body    = '<p>Vielen Dank für Ihr Interesse am Newsletter.</p><p>Bitte antworten Sie auf diese E-Mail. Sie müssen keinen Text schreiben. Erst dann können wir Ihnen unseren Newsletter zuschicken.</p><p>Vielen Dank.</p>';
	$body   .= '</body></html>';

	$mail = wp_mail( $to, $subject, $body, $headers );

	if ( $mail ) {
		wp_redirect( esc_url( add_query_arg( 'nlsnt', 'y', get_permalink( $vars['re_id'] ) ) ) );
		exit;
	} else {
		wp_redirect( esc_url( add_query_arg( 'nlsnt', 'n', get_permalink( $vars['re_id'] ) ) ) );
		exit;
	}

	// Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578 .
	remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

}
	add_action( 'admin_post_nopriv_newsletter_form', 'newsletter_send_email_to_admin' );
	add_action( 'admin_post_newsletter_form', 'newsletter_send_email_to_admin' );
?>
