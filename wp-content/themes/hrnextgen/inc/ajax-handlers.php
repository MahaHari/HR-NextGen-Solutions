<?php
/**
 * HR NextGen Solutions - AJAX Handlers
 * Contact form submission processor
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create the contact_submissions table on theme activation
 */
function hngs_create_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $charset    = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id            INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        full_name     VARCHAR(255) NOT NULL DEFAULT '',
        email         VARCHAR(255) NOT NULL DEFAULT '',
        company       VARCHAR(255) DEFAULT '',
        industry      VARCHAR(100) DEFAULT '',
        project_type  VARCHAR(100) DEFAULT '',
        budget_range  VARCHAR(100) DEFAULT '',
        message       TEXT,
        status        VARCHAR(20) NOT NULL DEFAULT 'new',
        ip_address    VARCHAR(45) DEFAULT '',
        user_agent    TEXT,
        submitted_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY   (id)
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
add_action( 'after_switch_theme', 'hngs_create_submissions_table' );

/**
 * Handle contact form AJAX submission
 * Available to both logged-in and non-logged-in users
 */
function hngs_handle_contact_submission() {
    // Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'hngs_contact_nonce' ) ) {
        wp_send_json_error( [ 'message' => 'Security check failed. Please refresh and try again.' ] );
    }

    // Collect & sanitize inputs
    $data = [
        'full_name'    => sanitize_text_field( $_POST['full_name'] ?? '' ),
        'email'        => sanitize_email( $_POST['email'] ?? '' ),
        'company'      => sanitize_text_field( $_POST['company'] ?? '' ),
        'industry'     => sanitize_text_field( $_POST['industry'] ?? '' ),
        'project_type' => sanitize_text_field( $_POST['project_type'] ?? '' ),
        'budget_range' => sanitize_text_field( $_POST['budget_range'] ?? '' ),
        'message'      => sanitize_textarea_field( $_POST['message'] ?? '' ),
    ];

    // Validate required fields
    $errors = [];
    if ( empty( $data['full_name'] ) )    $errors[] = 'Full name is required.';
    if ( empty( $data['email'] ) )        $errors[] = 'Email address is required.';
    if ( ! is_email( $data['email'] ) )  $errors[] = 'Please enter a valid email address.';
    if ( empty( $data['message'] ) )      $errors[] = 'Please include a message.';
    if ( strlen( $data['message'] ) < 10 ) $errors[] = 'Message must be at least 10 characters.';

    if ( ! empty( $errors ) ) {
        wp_send_json_error( [ 'message' => implode( ' ', $errors ) ] );
    }

    // Insert into MySQL
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';

    $ip         = hngs_get_client_ip();
    $user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

    $inserted = $wpdb->insert(
        $table_name,
        [
            'full_name'    => $data['full_name'],
            'email'        => $data['email'],
            'company'      => $data['company'],
            'industry'     => $data['industry'],
            'project_type' => $data['project_type'],
            'budget_range' => $data['budget_range'],
            'message'      => $data['message'],
            'status'       => 'new',
            'ip_address'   => $ip,
            'user_agent'   => $user_agent,
            'submitted_at' => current_time( 'mysql' ),
        ],
        [ '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' ]
    );

    if ( $inserted === false ) {
        wp_send_json_error( [ 'message' => 'There was an issue saving your request. Please try again.' ] );
    }

    // Send emails (non-blocking - wp_mail handles this synchronously)
    hngs_send_admin_notification( $data );
    hngs_send_auto_reply( $data );

    wp_send_json_success( [
        'message' => 'Thank you! Your consultation request has been received. We will be in touch within 1-2 business days.',
    ] );
}
add_action( 'wp_ajax_hngs_submit_contact',        'hngs_handle_contact_submission' );
add_action( 'wp_ajax_nopriv_hngs_submit_contact', 'hngs_handle_contact_submission' );

/**
 * Get client IP address safely
 */
function hngs_get_client_ip() {
    $ip_keys = [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ];
    foreach ( $ip_keys as $key ) {
        if ( ! empty( $_SERVER[ $key ] ) ) {
            $ip = filter_var( explode( ',', sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) ) )[0], FILTER_VALIDATE_IP );
            if ( $ip ) return $ip;
        }
    }
    return '0.0.0.0';
}

/**
 * AJAX: Update submission status (admin only)
 */
function hngs_update_submission_status() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized.' ] );
    }
    check_ajax_referer( 'hngs_admin_nonce', 'nonce' );

    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $id         = absint( $_POST['id'] ?? 0 );
    $status     = sanitize_key( $_POST['status'] ?? 'read' );

    if ( ! $id || ! in_array( $status, [ 'new', 'read', 'archived' ] ) ) {
        wp_send_json_error( [ 'message' => 'Invalid parameters.' ] );
    }

    $wpdb->update( $table_name, [ 'status' => $status ], [ 'id' => $id ], [ '%s' ], [ '%d' ] );
    wp_send_json_success( [ 'message' => 'Status updated.' ] );
}
add_action( 'wp_ajax_hngs_update_submission_status', 'hngs_update_submission_status' );

/**
 * AJAX: Delete submission (admin only)
 */
function hngs_delete_submission() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized.' ] );
    }
    check_ajax_referer( 'hngs_admin_nonce', 'nonce' );

    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $id         = absint( $_POST['id'] ?? 0 );

    if ( ! $id ) wp_send_json_error( [ 'message' => 'Invalid ID.' ] );

    $wpdb->delete( $table_name, [ 'id' => $id ], [ '%d' ] );
    wp_send_json_success( [ 'message' => 'Submission deleted.' ] );
}
add_action( 'wp_ajax_hngs_delete_submission', 'hngs_delete_submission' );
