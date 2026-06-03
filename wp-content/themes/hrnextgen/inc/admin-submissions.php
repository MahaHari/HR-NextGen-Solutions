<?php
/**
 * HR NextGen Solutions - Admin Submissions Page
 * View and manage contact form submissions from WordPress admin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register admin menu for submissions
 */
function hngs_add_submissions_menu() {
    add_menu_page(
        __( 'Contact Submissions', 'hrnextgen' ),
        __( 'Submissions', 'hrnextgen' ),
        'manage_options',
        'hngs-submissions',
        'hngs_render_submissions_page',
        'dashicons-email-alt',
        4
    );
}
add_action( 'admin_menu', 'hngs_add_submissions_menu' );

/**
 * Add a "new submissions" badge to the menu
 */
function hngs_submissions_menu_badge() {
    global $menu, $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) return;
    $count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'new'" );
    if ( ! $count ) return;
    foreach ( $menu as $key => $item ) {
        if ( isset( $item[2] ) && $item[2] === 'hngs-submissions' ) {
            $menu[ $key ][0] .= ' <span class="awaiting-mod">' . $count . '</span>';
            break;
        }
    }
}
add_action( 'admin_menu', 'hngs_submissions_menu_badge', 20 );

/**
 * Handle CSV export
 */
function hngs_handle_export() {
    if ( ! isset( $_GET['action'] ) || $_GET['action'] !== 'hngs_export_csv' ) return;
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
    check_admin_referer( 'hngs_export_csv' );

    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $results    = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY submitted_at DESC", ARRAY_A );

    header( 'Content-Type: text/csv; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="contact-submissions-' . date('Y-m-d') . '.csv"' );
    header( 'Pragma: no-cache' );

    $output = fopen( 'php://output', 'w' );
    fputcsv( $output, [ 'ID', 'Name', 'Email', 'Company', 'Industry', 'Project Type', 'Budget Range', 'Message', 'Status', 'IP Address', 'Submitted At' ] );
    foreach ( $results as $row ) {
        fputcsv( $output, [
            $row['id'], $row['full_name'], $row['email'], $row['company'],
            $row['industry'], $row['project_type'], $row['budget_range'],
            $row['message'], $row['status'], $row['ip_address'], $row['submitted_at'],
        ] );
    }
    fclose( $output );
    exit;
}
add_action( 'admin_init', 'hngs_handle_export' );

/**
 * Render the full submissions admin page
 */
function hngs_render_submissions_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';

    // Create table if it doesn't exist yet (e.g., switched themes)
    hngs_create_submissions_table();

    // Handle bulk action
    if ( isset( $_POST['bulk_action'] ) && isset( $_POST['submission_ids'] ) ) {
        check_admin_referer( 'hngs_bulk_action' );
        $ids    = array_map( 'absint', $_POST['submission_ids'] );
        $action = sanitize_key( $_POST['bulk_action'] );
        if ( ! empty( $ids ) ) {
            $ids_placeholder = implode( ',', $ids );
            if ( $action === 'delete' ) {
                $wpdb->query( "DELETE FROM $table_name WHERE id IN ($ids_placeholder)" );
                echo '<div class="updated notice"><p>' . count($ids) . ' submission(s) deleted.</p></div>';
            } elseif ( in_array( $action, ['read', 'archived', 'new'] ) ) {
                $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET status = %s WHERE id IN ($ids_placeholder)", $action ) );
                echo '<div class="updated notice"><p>' . count($ids) . ' submission(s) updated.</p></div>';
            }
        }
    }

    // Determine view
    $view_id   = isset( $_GET['view'] ) ? absint( $_GET['view'] ) : 0;
    $status    = isset( $_GET['status'] ) ? sanitize_key( $_GET['status'] ) : 'all';
    $page_num  = isset( $_GET['paged'] ) ? max(1, absint($_GET['paged'])) : 1;
    $per_page  = 20;
    $offset    = ( $page_num - 1 ) * $per_page;

    // Counts
    $count_all      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    $count_new      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'new'" );
    $count_read     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'read'" );
    $count_archived = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'archived'" );

    // Single view
    if ( $view_id ) {
        $submission = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $view_id ), ARRAY_A );
        if ( $submission && $submission['status'] === 'new' ) {
            $wpdb->update( $table_name, ['status' => 'read'], ['id' => $view_id], ['%s'], ['%d'] );
            $submission['status'] = 'read';
        }
        hngs_render_single_submission( $submission );
        return;
    }

    // List view query
    $where = $status !== 'all' ? $wpdb->prepare( "WHERE status = %s", $status ) : '';
    $submissions = $wpdb->get_results(
        "SELECT * FROM $table_name $where ORDER BY submitted_at DESC LIMIT $per_page OFFSET $offset",
        ARRAY_A
    );
    $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $where" );
    $total_pages = ceil( $total / $per_page );

    $base_url = admin_url( 'admin.php?page=hngs-submissions' );
    $export_url = wp_nonce_url( $base_url . '&action=hngs_export_csv', 'hngs_export_csv' );
    ?>
    <div class="wrap hngs-admin-wrap">
        <h1 style="display:flex;align-items:center;gap:12px;">
            Contact Submissions
            <a href="<?php echo esc_url( $export_url ); ?>" class="button button-secondary">Export CSV</a>
        </h1>

        <!-- Status Tabs -->
        <div class="hngs-status-tabs">
            <?php
            $tabs = [
                'all'      => [ 'All', $count_all ],
                'new'      => [ 'New', $count_new ],
                'read'     => [ 'Read', $count_read ],
                'archived' => [ 'Archived', $count_archived ],
            ];
            foreach ( $tabs as $slug => $tab ) :
                $tab_url = $base_url . '&status=' . $slug;
            ?>
            <a href="<?php echo esc_url( $tab_url ); ?>" class="hngs-status-tab <?php echo $status === $slug ? 'active' : ''; ?>">
                <?php echo esc_html( $tab[0] ); ?>
                <?php if ( $tab[1] > 0 ) : ?><span class="count"><?php echo $tab[1]; ?></span><?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if ( empty( $submissions ) ) : ?>
        <p style="padding:20px;background:#fff;border:1px solid #c3c4c7;border-radius:4px;">No submissions found.</p>
        <?php else : ?>

        <!-- Bulk Actions Form -->
        <form method="post" action="">
            <?php wp_nonce_field( 'hngs_bulk_action' ); ?>
            <?php if ( ! empty( $status ) ) : ?><input type="hidden" name="status_filter" value="<?php echo esc_attr($status); ?>"><?php endif; ?>

            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <select name="bulk_action">
                    <option value="">Bulk Actions</option>
                    <option value="read">Mark as Read</option>
                    <option value="archived">Archive</option>
                    <option value="new">Mark as New</option>
                    <option value="delete">Delete</option>
                </select>
                <button type="submit" class="button button-secondary">Apply</button>
            </div>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <td style="width:32px;"><input type="checkbox" id="hngs-check-all"></td>
                        <th style="width:40px;">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Industry</th>
                        <th>Project Type</th>
                        <th style="width:80px;">Status</th>
                        <th style="width:130px;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $submissions as $sub ) :
                        $view_url   = $base_url . '&view=' . $sub['id'];
                        $read_url   = wp_nonce_url( $base_url . '&action=mark_read&id=' . $sub['id'], 'hngs_mark_read' );
                        $del_url    = wp_nonce_url( $base_url . '&action=delete_sub&id=' . $sub['id'], 'hngs_delete_sub' );
                        $is_new     = $sub['status'] === 'new';
                    ?>
                    <tr <?php echo $is_new ? 'style="font-weight:600;"' : ''; ?>>
                        <td><input type="checkbox" name="submission_ids[]" value="<?php echo $sub['id']; ?>"></td>
                        <td><?php echo $sub['id']; ?></td>
                        <td>
                            <a href="<?php echo esc_url($view_url); ?>" style="color:#2271b1;font-weight:<?php echo $is_new ? '700' : '400'; ?>;"><?php echo esc_html($sub['full_name']); ?></a>
                            <div class="row-actions" style="display:flex;gap:8px;font-size:12px;">
                                <a href="<?php echo esc_url($view_url); ?>">View</a> |
                                <a href="<?php echo esc_url($del_url); ?>" onclick="return confirm('Delete this submission?')" style="color:#b32d2e;">Delete</a>
                            </div>
                        </td>
                        <td><a href="mailto:<?php echo esc_attr($sub['email']); ?>"><?php echo esc_html($sub['email']); ?></a></td>
                        <td><?php echo esc_html($sub['company'] ?: '—'); ?></td>
                        <td><?php echo esc_html($sub['industry'] ?: '—'); ?></td>
                        <td><?php echo esc_html($sub['project_type'] ?: '—'); ?></td>
                        <td><span class="hngs-submission-status hngs-status-<?php echo esc_attr($sub['status']); ?>"><?php echo esc_html($sub['status']); ?></span></td>
                        <td><?php echo esc_html( date('M j, Y', strtotime($sub['submitted_at'])) ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>

        <!-- Pagination -->
        <?php if ( $total_pages > 1 ) : ?>
        <div style="margin-top:16px;">
            <?php
            echo paginate_links([
                'base'      => $base_url . '%_%',
                'format'    => '&paged=%#%',
                'current'   => $page_num,
                'total'     => $total_pages,
                'add_args'  => $status !== 'all' ? [ 'status' => $status ] : [],
            ]);
            ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
    document.getElementById('hngs-check-all') && document.getElementById('hngs-check-all').addEventListener('change', function() {
        document.querySelectorAll('input[name="submission_ids[]"]').forEach(function(cb) { cb.checked = this.checked; }, this);
    });
    </script>
    <?php

    // Handle row actions (mark read, delete)
    if ( isset( $_GET['action'] ) ) {
        $action = sanitize_key( $_GET['action'] );
        $id     = absint( $_GET['id'] ?? 0 );
        if ( $id ) {
            if ( $action === 'mark_read' && check_admin_referer( 'hngs_mark_read' ) ) {
                $wpdb->update( $table_name, ['status' => 'read'], ['id' => $id], ['%s'], ['%d'] );
                wp_redirect( $base_url . '&status=' . $status );
                exit;
            }
            if ( $action === 'delete_sub' && check_admin_referer( 'hngs_delete_sub' ) ) {
                $wpdb->delete( $table_name, ['id' => $id], ['%d'] );
                wp_redirect( $base_url . '&status=' . $status );
                exit;
            }
        }
    }
}

/**
 * Render single submission detail view
 */
function hngs_render_single_submission( $sub ) {
    if ( ! $sub ) {
        echo '<div class="wrap"><p>Submission not found.</p></div>';
        return;
    }
    $back_url = admin_url( 'admin.php?page=hngs-submissions' );
    ?>
    <div class="wrap hngs-admin-wrap">
        <h1>
            <a href="<?php echo esc_url($back_url); ?>" style="text-decoration:none;color:#1d2327;font-size:20px;">← </a>
            Submission #<?php echo $sub['id']; ?> — <?php echo esc_html($sub['full_name']); ?>
        </h1>
        <div class="hngs-submission-detail">
            <h2>Contact Details</h2>
            <div class="hngs-detail-grid">
                <?php
                $fields = [
                    'Full Name'    => $sub['full_name'],
                    'Email'        => '<a href="mailto:' . esc_attr($sub['email']) . '">' . esc_html($sub['email']) . '</a>',
                    'Company'      => $sub['company'] ?: '—',
                    'Industry'     => $sub['industry'] ?: '—',
                    'Project Type' => $sub['project_type'] ?: '—',
                    'Budget Range' => $sub['budget_range'] ?: '—',
                    'Status'       => '<span class="hngs-submission-status hngs-status-' . esc_attr($sub['status']) . '">' . esc_html($sub['status']) . '</span>',
                    'Submitted At' => esc_html( date('F j, Y g:i A', strtotime($sub['submitted_at'])) ),
                    'IP Address'   => esc_html( $sub['ip_address'] ),
                ];
                foreach ( $fields as $label => $value ) : ?>
                <div class="hngs-detail-item">
                    <label><?php echo esc_html($label); ?></label>
                    <p><?php echo $value; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="grid-column:1/-1;">
                <label style="display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.08em;color:#646970;margin-bottom:8px;">Message</label>
                <div class="hngs-detail-message"><?php echo esc_html( $sub['message'] ); ?></div>
            </div>
            <div class="hngs-detail-actions">
                <a href="<?php echo esc_url($back_url); ?>" class="button">← Back to List</a>
                <a href="mailto:<?php echo esc_attr($sub['email']); ?>" class="button button-primary">Reply by Email</a>
                <?php
                $archive_url = wp_nonce_url( admin_url('admin.php?page=hngs-submissions&action=mark_archived&id=' . $sub['id']), 'hngs_mark_read' );
                ?>
                <a href="<?php echo esc_url($archive_url); ?>" class="button">Archive</a>
            </div>
        </div>
    </div>
    <?php
}
