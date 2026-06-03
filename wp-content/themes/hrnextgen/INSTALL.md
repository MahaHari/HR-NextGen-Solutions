# HR NextGen Solutions - WordPress Theme

## Installation

### Requirements
- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.3+
- Apache (XAMPP recommended for local development)

### Setup Steps

1. **Upload the theme** — Place the `hrnextgen` folder inside `/wp-content/themes/`

2. **Activate** — Go to WordPress Admin > Appearance > Themes > Activate "HR NextGen Solutions"

3. **Set homepage** — Go to Settings > Reading > Set "Your homepage displays" to "A static page" and create/select a page as the Front Page

4. **Configure settings** — Go to Appearance > Theme Options to set:
   - Contact email, phone, WhatsApp
   - Social media links
   - Hero statistics (editable, not hardcoded)
   - SEO meta description

5. **Add content** — Use the new Admin menu items to manage:
   - **Services** (with category + sub-services)
   - **Case Studies** (with problem/solution/technologies/results)
   - **Testimonials** (with client details + star rating)
   - **Industries** (with value proposition)
   - **Partners** (logos for the Trusted By marquee)

6. **View submissions** — All contact form leads are stored in the **Submissions** admin menu. New leads are also emailed to the configured admin email.

### Email (SMTP)
The theme uses WordPress `wp_mail()`. For reliable email delivery, install the free **WP Mail SMTP** plugin and configure with your SMTP provider (Gmail, SendGrid, Mailgun, etc.).

### Database
The contact submissions table (`wp_contact_submissions`) is created automatically when the theme is activated. No manual database setup required.

### Logo
The HR NextGen Solutions logo is included at `assets/images/logo.png`. You can replace it from **Appearance > Customize > Site Identity > Logo**.
