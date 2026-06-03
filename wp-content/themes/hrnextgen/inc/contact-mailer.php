<?php
/**
 * HR NextGen Solutions - Contact Form Mailer
 * HTML email notifications via wp_mail()
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Send admin notification email when a new contact form is submitted
 *
 * @param array $data Sanitized submission data
 */
function hngs_send_admin_notification( $data ) {
    $admin_email = hngs_get_option( 'hngs_admin_email', get_option( 'admin_email' ) );
    if ( empty( $admin_email ) ) return;

    $subject = sprintf( '[HR NextGen] New Consultation Request from %s', $data['full_name'] );

    $admin_url = admin_url( 'admin.php?page=hngs-submissions' );

    $body = hngs_get_notification_email_html( $data, $admin_url );

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        sprintf( 'From: HR NextGen Solutions <%s>', get_option( 'admin_email' ) ),
    ];

    wp_mail( $admin_email, $subject, $body, $headers );
}

/**
 * Send auto-reply confirmation to the submitter
 *
 * @param array $data Sanitized submission data
 */
function hngs_send_auto_reply( $data ) {
    if ( hngs_get_option( 'hngs_auto_reply', 'yes' ) !== 'yes' ) return;
    if ( empty( $data['email'] ) || ! is_email( $data['email'] ) ) return;

    $subject = 'We received your consultation request — HR NextGen Solutions';
    $body    = hngs_get_auto_reply_email_html( $data );

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        sprintf( 'From: HR NextGen Solutions <%s>', hngs_get_option( 'hngs_contact_email', get_option( 'admin_email' ) ) ),
    ];

    wp_mail( $data['email'], $subject, $body, $headers );
}

/**
 * Build the admin notification HTML email
 */
function hngs_get_notification_email_html( $data, $admin_url ) {
    ob_start();
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>New Contact Submission</title>
</head>
<body style="margin:0;padding:0;background:#f0f0f0;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f0f0;padding:40px 20px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
      <!-- Header -->
      <tr>
        <td style="background:linear-gradient(135deg,#E91E7A,#6A1B9A);padding:32px 40px;text-align:center;">
          <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;">New Consultation Request</h1>
          <p style="color:rgba(255,255,255,0.8);margin:8px 0 0;font-size:14px;">HR NextGen Solutions</p>
        </td>
      </tr>
      <!-- Body -->
      <tr>
        <td style="padding:32px 40px;">
          <p style="color:#333;font-size:15px;margin:0 0 24px;">You have received a new consultation request from your website.</p>
          <!-- Details Table -->
          <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5;border-radius:6px;overflow:hidden;">
            <?php
            $rows = [
                'Name'         => $data['full_name'],
                'Email'        => '<a href="mailto:' . esc_attr($data['email']) . '" style="color:#E91E7A;">' . esc_html($data['email']) . '</a>',
                'Company'      => $data['company'] ?: '—',
                'Industry'     => $data['industry'] ?: '—',
                'Project Type' => $data['project_type'] ?: '—',
                'Budget Range' => $data['budget_range'] ?: '—',
                'Submitted'    => date('F j, Y g:i A'),
            ];
            $i = 0;
            foreach ( $rows as $label => $value ) :
                $bg = $i % 2 === 0 ? '#f9f9f9' : '#ffffff';
                $i++;
            ?>
            <tr>
              <td style="padding:12px 16px;background:<?php echo $bg; ?>;border-bottom:1px solid #e5e5e5;width:36%;color:#666;font-size:13px;font-weight:600;"><?php echo $label; ?></td>
              <td style="padding:12px 16px;background:<?php echo $bg; ?>;border-bottom:1px solid #e5e5e5;color:#333;font-size:14px;"><?php echo $value; ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
          <!-- Message -->
          <div style="margin-top:24px;">
            <p style="color:#666;font-size:13px;font-weight:600;margin:0 0 8px;">MESSAGE</p>
            <div style="background:#f9f9f9;border:1px solid #e5e5e5;border-radius:6px;padding:16px;color:#333;font-size:14px;line-height:1.6;white-space:pre-wrap;"><?php echo esc_html( $data['message'] ); ?></div>
          </div>
          <!-- CTA -->
          <div style="text-align:center;margin-top:32px;">
            <a href="<?php echo esc_url($admin_url); ?>" style="display:inline-block;background:linear-gradient(135deg,#E91E7A,#6A1B9A);color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:8px;font-size:15px;font-weight:600;">View in Admin Panel</a>
          </div>
        </td>
      </tr>
      <!-- Footer -->
      <tr>
        <td style="padding:20px 40px;border-top:1px solid #f0f0f0;text-align:center;color:#999;font-size:12px;">
          This is an automated notification from your HR NextGen Solutions website.
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>
    <?php
    return ob_get_clean();
}

/**
 * Build the auto-reply confirmation HTML email
 */
function hngs_get_auto_reply_email_html( $data ) {
    $site_url = home_url();
    ob_start();
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>We received your request</title>
</head>
<body style="margin:0;padding:0;background:#f0f0f0;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f0f0;padding:40px 20px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#06060A;border-radius:8px;overflow:hidden;">
      <!-- Header -->
      <tr>
        <td style="background:linear-gradient(135deg,#E91E7A,#6A1B9A);padding:32px 40px;text-align:center;">
          <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;">We Got Your Message!</h1>
          <p style="color:rgba(255,255,255,0.85);margin:8px 0 0;font-size:14px;">HR NextGen Solutions</p>
        </td>
      </tr>
      <!-- Body -->
      <tr>
        <td style="padding:32px 40px;">
          <p style="color:#e0e0e0;font-size:16px;margin:0 0 16px;">Hi <?php echo esc_html($data['full_name']); ?>,</p>
          <p style="color:#aaaaaa;font-size:15px;line-height:1.7;margin:0 0 24px;">
            Thank you for reaching out to HR NextGen Solutions. We've received your consultation request and our team will review your project requirements shortly.
          </p>
          <p style="color:#aaaaaa;font-size:15px;line-height:1.7;margin:0 0 24px;">
            You can expect a response within <strong style="color:#E91E7A;">1-2 business days</strong>. We're excited to learn more about your project and explore how we can help you achieve your goals with AI-powered solutions.
          </p>
          <!-- Summary -->
          <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:8px;padding:20px 24px;margin-bottom:24px;">
            <p style="color:#666;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 12px;">Your Request Summary</p>
            <p style="color:#cccccc;font-size:14px;margin:0 0 6px;"><strong style="color:#ffffff;">Project Type:</strong> <?php echo esc_html($data['project_type'] ?: 'General Inquiry'); ?></p>
            <p style="color:#cccccc;font-size:14px;margin:0 0 6px;"><strong style="color:#ffffff;">Industry:</strong> <?php echo esc_html($data['industry'] ?: '—'); ?></p>
            <p style="color:#cccccc;font-size:14px;margin:0;"><strong style="color:#ffffff;">Company:</strong> <?php echo esc_html($data['company'] ?: '—'); ?></p>
          </div>
          <div style="text-align:center;">
            <a href="<?php echo esc_url($site_url); ?>" style="display:inline-block;background:linear-gradient(135deg,#E91E7A,#6A1B9A);color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:8px;font-size:15px;font-weight:600;">Visit Our Website</a>
          </div>
        </td>
      </tr>
      <!-- Footer -->
      <tr>
        <td style="padding:20px 40px;border-top:1px solid rgba(255,255,255,0.08);text-align:center;color:#555;font-size:12px;">
          &copy; <?php echo date('Y'); ?> HR NextGen Solutions. All rights reserved.
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>
    <?php
    return ob_get_clean();
}
