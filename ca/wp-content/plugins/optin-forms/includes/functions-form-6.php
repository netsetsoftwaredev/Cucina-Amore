<?php

// FORM6: default email field
function optinforms_form6_default_email_field() {
	global $optinforms_form6_email_field;
	if(empty($optinforms_form6_email_field)) {
		$optinforms_form6_email_field = __('Email Address', 'optin-forms');
	}
	return $optinforms_form6_email_field;
}

// FORM6: default button text
function optinforms_form6_default_button_text() {
	global $optinforms_form6_button_text;
	if(empty($optinforms_form6_button_text)) {
		$optinforms_form6_button_text = __('Subscribe', 'optin-forms');
	}
	return $optinforms_form6_button_text;
}