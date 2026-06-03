<?php
/**
 * HR NextGen Solutions - Meta Boxes
 * Custom meta boxes for all CPTs - no ACF required
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register all meta boxes
 */
function hngs_add_meta_boxes() {
    // Service meta box
    add_meta_box( 'hngs_service_details', 'Service Details', 'hngs_service_meta_box_cb', 'hngs_service', 'normal', 'high' );

    // Case Study meta boxes
    add_meta_box( 'hngs_case_study_details', 'Case Study Details', 'hngs_case_study_meta_box_cb', 'hngs_case_study', 'normal', 'high' );
    add_meta_box( 'hngs_case_study_results', 'Results & Metrics', 'hngs_case_study_results_meta_box_cb', 'hngs_case_study', 'normal', 'high' );

    // Testimonial meta box
    add_meta_box( 'hngs_testimonial_details', 'Testimonial Details', 'hngs_testimonial_meta_box_cb', 'hngs_testimonial', 'normal', 'high' );

    // Industry meta box
    add_meta_box( 'hngs_industry_details', 'Industry Details', 'hngs_industry_meta_box_cb', 'hngs_industry', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'hngs_add_meta_boxes' );


/* ---- Render Helpers ---- */

function hngs_field( $post_id, $key ) {
    return esc_attr( get_post_meta( $post_id, '_hngs_' . $key, true ) );
}


/* ---- Service Meta Box ---- */

function hngs_service_meta_box_cb( $post ) {
    wp_nonce_field( 'hngs_service_save', 'hngs_service_nonce' );
    $category     = hngs_field( $post->ID, 'service_category' );
    $sub_services = get_post_meta( $post->ID, '_hngs_sub_services', true );
    if ( ! is_array( $sub_services ) ) $sub_services = [ '', '', '' ];
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hngs_service_category">Service Category</label></th>
            <td>
                <select id="hngs_service_category" name="hngs_service_category" class="regular-text">
                    <option value="software" <?php selected( $category, 'software' ); ?>>Software Development</option>
                    <option value="mobile" <?php selected( $category, 'mobile' ); ?>>Mobile App Development</option>
                    <option value="ai" <?php selected( $category, 'ai' ); ?>>AI Solutions</option>
                    <option value="cloud" <?php selected( $category, 'cloud' ); ?>>Cloud & DevOps</option>
                </select>
                <p class="description">Select the primary category for this service card.</p>
            </td>
        </tr>
        <tr>
            <th><label>Sub-Services (up to 5)</label></th>
            <td>
                <?php for ( $i = 0; $i < 5; $i++ ) : $val = isset( $sub_services[ $i ] ) ? esc_attr( $sub_services[ $i ] ) : ''; ?>
                <input type="text" name="hngs_sub_services[]" value="<?php echo $val; ?>" class="regular-text" placeholder="Sub-service <?php echo $i + 1; ?>" style="display:block;margin-bottom:6px;">
                <?php endfor; ?>
                <p class="description">List specific services under this category (e.g., "Enterprise Applications").</p>
            </td>
        </tr>
    </table>
    <?php
}


/* ---- Case Study Meta Box ---- */

function hngs_case_study_meta_box_cb( $post ) {
    wp_nonce_field( 'hngs_case_study_save', 'hngs_case_study_nonce' );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hngs_client_industry">Client Industry</label></th>
            <td><input type="text" id="hngs_client_industry" name="hngs_client_industry" value="<?php echo hngs_field( $post->ID, 'client_industry' ); ?>" class="regular-text" placeholder="e.g. Healthcare"></td>
        </tr>
        <tr>
            <th><label for="hngs_problem">Problem Statement</label></th>
            <td><textarea id="hngs_problem" name="hngs_problem" class="large-text" rows="3" placeholder="Describe the client's core challenge..."><?php echo esc_textarea( get_post_meta( $post->ID, '_hngs_problem', true ) ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="hngs_solution">Solution Summary</label></th>
            <td><textarea id="hngs_solution" name="hngs_solution" class="large-text" rows="3" placeholder="How did HR NextGen Solutions solve it?"><?php echo esc_textarea( get_post_meta( $post->ID, '_hngs_solution', true ) ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="hngs_technologies">Technologies Used</label></th>
            <td>
                <input type="text" id="hngs_technologies" name="hngs_technologies" value="<?php echo hngs_field( $post->ID, 'technologies' ); ?>" class="large-text" placeholder="React Native, Node.js, AWS, OpenAI">
                <p class="description">Comma-separated list of technologies.</p>
            </td>
        </tr>
    </table>
    <?php
}

function hngs_case_study_results_meta_box_cb( $post ) {
    ?>
    <table class="form-table">
        <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
        <tr>
            <th>Result <?php echo $i; ?></th>
            <td style="display:flex;gap:12px;align-items:center;">
                <input type="text" name="hngs_result_<?php echo $i; ?>_value" value="<?php echo hngs_field( $post->ID, "result_{$i}_value" ); ?>" class="regular-text" placeholder="e.g. 40%" style="width:120px;">
                <input type="text" name="hngs_result_<?php echo $i; ?>_label" value="<?php echo hngs_field( $post->ID, "result_{$i}_label" ); ?>" class="regular-text" placeholder="e.g. Faster Processing">
            </td>
        </tr>
        <?php endfor; ?>
    </table>
    <?php
}


/* ---- Testimonial Meta Box ---- */

function hngs_testimonial_meta_box_cb( $post ) {
    wp_nonce_field( 'hngs_testimonial_save', 'hngs_testimonial_nonce' );
    $rating = get_post_meta( $post->ID, '_hngs_rating', true );
    if ( ! $rating ) $rating = 5;
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hngs_client_title">Client Job Title</label></th>
            <td><input type="text" id="hngs_client_title" name="hngs_client_title" value="<?php echo hngs_field( $post->ID, 'client_title' ); ?>" class="regular-text" placeholder="e.g. CEO"></td>
        </tr>
        <tr>
            <th><label for="hngs_company_name">Company Name</label></th>
            <td><input type="text" id="hngs_company_name" name="hngs_company_name" value="<?php echo hngs_field( $post->ID, 'company_name' ); ?>" class="regular-text" placeholder="e.g. TechCorp Ltd."></td>
        </tr>
        <tr>
            <th><label for="hngs_rating">Star Rating</label></th>
            <td>
                <select id="hngs_rating" name="hngs_rating">
                    <?php for ( $r = 5; $r >= 1; $r-- ) : ?>
                    <option value="<?php echo $r; ?>" <?php selected( (int)$rating, $r ); ?>><?php echo $r; ?> Star<?php echo $r > 1 ? 's' : ''; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <p class="description" style="margin-top:8px;">The post <strong>Title</strong> = client name. Post <strong>Content</strong> = the testimonial quote. Featured Image = client avatar photo.</p>
    <?php
}


/* ---- Industry Meta Box ---- */

function hngs_industry_meta_box_cb( $post ) {
    wp_nonce_field( 'hngs_industry_save', 'hngs_industry_nonce' );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hngs_industry_stat">Industry Stat</label></th>
            <td>
                <input type="text" id="hngs_industry_stat" name="hngs_industry_stat" value="<?php echo hngs_field( $post->ID, 'industry_stat' ); ?>" class="regular-text" placeholder="e.g. 15+ Healthcare Clients">
                <p class="description">Optional stat shown on the industry tile.</p>
            </td>
        </tr>
    </table>
    <p class="description">Post <strong>Title</strong> = industry name. Post <strong>Content</strong> = value proposition text. Featured Image = industry icon.</p>
    <?php
}


/**
 * Save all meta box data
 */
function hngs_save_meta_boxes( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $post_type = get_post_type( $post_id );

    // Service
    if ( $post_type === 'hngs_service' ) {
        if ( ! isset( $_POST['hngs_service_nonce'] ) || ! wp_verify_nonce( $_POST['hngs_service_nonce'], 'hngs_service_save' ) ) return;
        if ( isset( $_POST['hngs_service_category'] ) ) {
            update_post_meta( $post_id, '_hngs_service_category', sanitize_text_field( $_POST['hngs_service_category'] ) );
        }
        if ( isset( $_POST['hngs_sub_services'] ) && is_array( $_POST['hngs_sub_services'] ) ) {
            $subs = array_map( 'sanitize_text_field', $_POST['hngs_sub_services'] );
            update_post_meta( $post_id, '_hngs_sub_services', $subs );
        }
    }

    // Case Study
    if ( $post_type === 'hngs_case_study' ) {
        if ( ! isset( $_POST['hngs_case_study_nonce'] ) || ! wp_verify_nonce( $_POST['hngs_case_study_nonce'], 'hngs_case_study_save' ) ) return;
        $text_fields = [ 'client_industry', 'technologies' ];
        foreach ( $text_fields as $field ) {
            if ( isset( $_POST[ 'hngs_' . $field ] ) ) {
                update_post_meta( $post_id, '_hngs_' . $field, sanitize_text_field( $_POST[ 'hngs_' . $field ] ) );
            }
        }
        $textarea_fields = [ 'problem', 'solution' ];
        foreach ( $textarea_fields as $field ) {
            if ( isset( $_POST[ 'hngs_' . $field ] ) ) {
                update_post_meta( $post_id, '_hngs_' . $field, sanitize_textarea_field( $_POST[ 'hngs_' . $field ] ) );
            }
        }
        for ( $i = 1; $i <= 3; $i++ ) {
            if ( isset( $_POST[ "hngs_result_{$i}_value" ] ) ) {
                update_post_meta( $post_id, "_hngs_result_{$i}_value", sanitize_text_field( $_POST[ "hngs_result_{$i}_value" ] ) );
            }
            if ( isset( $_POST[ "hngs_result_{$i}_label" ] ) ) {
                update_post_meta( $post_id, "_hngs_result_{$i}_label", sanitize_text_field( $_POST[ "hngs_result_{$i}_label" ] ) );
            }
        }
    }

    // Testimonial
    if ( $post_type === 'hngs_testimonial' ) {
        if ( ! isset( $_POST['hngs_testimonial_nonce'] ) || ! wp_verify_nonce( $_POST['hngs_testimonial_nonce'], 'hngs_testimonial_save' ) ) return;
        foreach ( [ 'client_title', 'company_name' ] as $field ) {
            if ( isset( $_POST[ 'hngs_' . $field ] ) ) {
                update_post_meta( $post_id, '_hngs_' . $field, sanitize_text_field( $_POST[ 'hngs_' . $field ] ) );
            }
        }
        if ( isset( $_POST['hngs_rating'] ) ) {
            update_post_meta( $post_id, '_hngs_rating', absint( $_POST['hngs_rating'] ) );
        }
    }

    // Industry
    if ( $post_type === 'hngs_industry' ) {
        if ( ! isset( $_POST['hngs_industry_nonce'] ) || ! wp_verify_nonce( $_POST['hngs_industry_nonce'], 'hngs_industry_save' ) ) return;
        if ( isset( $_POST['hngs_industry_stat'] ) ) {
            update_post_meta( $post_id, '_hngs_industry_stat', sanitize_text_field( $_POST['hngs_industry_stat'] ) );
        }
    }
}
add_action( 'save_post', 'hngs_save_meta_boxes' );
