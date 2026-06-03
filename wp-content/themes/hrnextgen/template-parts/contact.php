<?php
/**
 * Template Part: Contact Section
 */
$email    = hngs_get_option('hngs_contact_email', 'hello@hrnextgensolutions.com');
$phone    = hngs_get_option('hngs_contact_phone', '');
$whatsapp = hngs_get_option('hngs_contact_whatsapp', '');
$address  = hngs_get_option('hngs_contact_address', '');

$industries_list = ['Healthcare','Logistics','Real Estate','Retail','Restaurants','Salons & Beauty','Education','Finance','Other'];
$project_types   = ['Custom Software Development','Mobile App Development','AI Agent / Chatbot','Workflow Automation','Cloud & DevOps','Web Platform / SaaS','Other'];
$budget_ranges   = ['Under $5,000','$5,000 – $15,000','$15,000 – $50,000','$50,000 – $150,000','$150,000+','Let\'s discuss'];
?>

<section class="section contact" id="contact" aria-label="Contact">
    <div class="container">

        <div class="contact-grid">

            <!-- Left: Contact Info -->
            <div class="contact-info">
                <span class="section-label">Get in Touch</span>
                <h2>Let's Build Something <span class="text-gradient">Intelligent</span> Together</h2>
                <p>Tell us about your project. We'll respond within 1-2 business days with a tailored approach and honest pricing.</p>

                <?php if ($email): ?>
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <?php echo hngs_icon('email'); ?>
                    </div>
                    <div class="contact-detail-text">
                        <span>Email Us</span>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($phone): ?>
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <?php echo hngs_icon('phone'); ?>
                    </div>
                    <div class="contact-detail-text">
                        <span>Call Us</span>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($whatsapp): ?>
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <?php echo hngs_icon('whatsapp'); ?>
                    </div>
                    <div class="contact-detail-text">
                        <span>WhatsApp</span>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($address): ?>
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <?php echo hngs_icon('globe'); ?>
                    </div>
                    <div class="contact-detail-text">
                        <span>Office</span>
                        <a href="#"><?php echo nl2br(esc_html($address)); ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Social Links -->
                <div class="contact-social">
                    <?php
                    $socials = [
                        'linkedin' => ['linkedin', hngs_get_option('hngs_social_linkedin','')],
                        'twitter'  => ['twitter',  hngs_get_option('hngs_social_twitter','')],
                        'github'   => ['github',   hngs_get_option('hngs_social_github','')],
                    ];
                    foreach ($socials as $key => $social):
                        if (empty($social[1])) continue;
                    ?>
                    <a href="<?php echo esc_url($social[1]); ?>"
                       class="social-icon-btn"
                       aria-label="<?php echo esc_attr(ucfirst($key)); ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?php echo hngs_icon($social[0]); ?>
                    </a>
                    <?php endforeach; ?>
                    <?php if ($whatsapp): ?>
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>"
                       class="social-icon-btn"
                       aria-label="WhatsApp"
                       target="_blank" rel="noopener noreferrer">
                        <?php echo hngs_icon('whatsapp'); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="contact-form-card">
                <h3>Book a Free Consultation</h3>
                <p>Fill out the form and one of our AI specialists will be in touch shortly.</p>

                <!-- Success State (hidden initially) -->
                <div class="form-success" id="form-success" aria-live="polite" aria-atomic="true">
                    <div class="success-icon">
                        <?php echo hngs_icon('check'); ?>
                    </div>
                    <h3>Request Received!</h3>
                    <p>Thank you for reaching out. We'll review your project details and get back to you within 1-2 business days.</p>
                </div>

                <!-- The Form -->
                <form id="contact-form" novalidate aria-label="Consultation request form">
                    <?php wp_nonce_field('hngs_contact_nonce', 'hngs_nonce'); ?>
                    <input type="hidden" name="action" value="hngs_submit_contact">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-name" class="form-label">Full Name <span aria-hidden="true" style="color:var(--color-primary);">*</span></label>
                            <input type="text" id="contact-name" name="full_name" class="form-input"
                                   placeholder="John Smith" required autocomplete="name"
                                   aria-required="true">
                            <span class="form-error" id="error-full_name" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="contact-email" class="form-label">Work Email <span aria-hidden="true" style="color:var(--color-primary);">*</span></label>
                            <input type="email" id="contact-email" name="email" class="form-input"
                                   placeholder="john@company.com" required autocomplete="email"
                                   aria-required="true">
                            <span class="form-error" id="error-email" role="alert"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-company" class="form-label">Company Name</label>
                            <input type="text" id="contact-company" name="company" class="form-input"
                                   placeholder="Your Company" autocomplete="organization">
                        </div>
                        <div class="form-group">
                            <label for="contact-industry" class="form-label">Industry</label>
                            <select id="contact-industry" name="industry" class="form-select">
                                <option value="">Select Industry</option>
                                <?php foreach ($industries_list as $ind): ?>
                                <option value="<?php echo esc_attr($ind); ?>"><?php echo esc_html($ind); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-project" class="form-label">Project Type</label>
                            <select id="contact-project" name="project_type" class="form-select">
                                <option value="">Select Project Type</option>
                                <?php foreach ($project_types as $pt): ?>
                                <option value="<?php echo esc_attr($pt); ?>"><?php echo esc_html($pt); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact-budget" class="form-label">Budget Range</label>
                            <select id="contact-budget" name="budget_range" class="form-select">
                                <option value="">Select Budget Range</option>
                                <?php foreach ($budget_ranges as $br): ?>
                                <option value="<?php echo esc_attr($br); ?>"><?php echo esc_html($br); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact-message" class="form-label">Tell Us About Your Project <span aria-hidden="true" style="color:var(--color-primary);">*</span></label>
                        <textarea id="contact-message" name="message" class="form-textarea"
                                  placeholder="Describe your project goals, current challenges, and what success looks like to you..."
                                  required aria-required="true" minlength="10"></textarea>
                        <span class="form-error" id="error-message" role="alert"></span>
                    </div>

                    <!-- Global form error -->
                    <div id="form-global-error" class="form-error" style="font-size:var(--text-sm);margin-bottom:var(--space-4);" role="alert"></div>

                    <button type="submit" class="btn btn-primary btn-lg" id="form-submit" style="width:100%;">
                        <span id="form-submit-text">Send Consultation Request</span>
                        <span id="form-submit-loading" style="display:none;">Sending...</span>
                        <?php echo hngs_icon('arrow-right'); ?>
                    </button>

                    <p style="font-size:var(--text-xs);color:var(--text-faint);margin-top:var(--space-4);text-align:center;">
                        We respect your privacy. Your information is never shared with third parties.
                    </p>
                </form>
            </div>

        </div>
    </div>
</section>
