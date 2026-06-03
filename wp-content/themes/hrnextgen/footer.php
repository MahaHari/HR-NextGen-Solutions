</main><!-- /#main-content -->

<!-- =========================================
     SITE FOOTER
     ========================================= -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?> - Home">
                    <img src="<?php echo esc_url(hngs_get_logo_url()); ?>"
                         alt="<?php bloginfo('name'); ?>"
                         class="footer-logo"
                         width="160" height="40"
                         loading="lazy">
                </a>
                <p>Building intelligent software for the AI era. We help businesses automate, scale, and innovate through custom software and AI solutions.</p>
                <div class="footer-social">
                    <?php
                    $socials = [
                        'linkedin' => ['linkedin', hngs_get_option('hngs_social_linkedin','')],
                        'twitter'  => ['twitter',  hngs_get_option('hngs_social_twitter','')],
                        'github'   => ['github',   hngs_get_option('hngs_social_github','')],
                        'whatsapp' => ['whatsapp', hngs_get_option('hngs_social_whatsapp','')],
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

                    <?php
                    $whatsapp_num = hngs_get_option('hngs_contact_whatsapp','');
                    if (!empty($whatsapp_num)): ?>
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/','',$whatsapp_num)); ?>"
                       class="social-icon-btn"
                       aria-label="WhatsApp"
                       target="_blank" rel="noopener noreferrer">
                        <?php echo hngs_icon('whatsapp'); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Services Column -->
            <div class="footer-col">
                <h5>Services</h5>
                <nav class="footer-links" aria-label="Services links">
                    <a href="#services">Software Development</a>
                    <a href="#services">Mobile App Development</a>
                    <a href="#ai-focus">AI Agents &amp; Chatbots</a>
                    <a href="#ai-focus">Workflow Automation</a>
                    <a href="#services">Cloud &amp; DevOps</a>
                    <a href="#ai-focus">RAG Systems</a>
                </nav>
            </div>

            <!-- Industries Column -->
            <div class="footer-col">
                <h5>Industries</h5>
                <nav class="footer-links" aria-label="Industries links">
                    <a href="#industries">Healthcare</a>
                    <a href="#industries">Logistics</a>
                    <a href="#industries">Real Estate</a>
                    <a href="#industries">Retail</a>
                    <a href="#industries">Restaurants</a>
                    <a href="#industries">Salons &amp; Beauty</a>
                    <a href="#industries">Education</a>
                    <a href="#industries">Finance</a>
                </nav>
            </div>

            <!-- Resources Column -->
            <div class="footer-col">
                <h5>Company</h5>
                <nav class="footer-links" aria-label="Company links">
                    <a href="#vision">About Us</a>
                    <a href="#case-studies">Case Studies</a>
                    <a href="#process">Our Process</a>
                    <a href="#contact">Contact</a>
                    <?php
                    $privacy_page = get_page_by_path('privacy-policy');
                    $terms_page   = get_page_by_path('terms-of-service');
                    if ($privacy_page): ?>
                    <a href="<?php echo esc_url(get_permalink($privacy_page)); ?>">Privacy Policy</a>
                    <?php endif;
                    if ($terms_page): ?>
                    <a href="<?php echo esc_url(get_permalink($terms_page)); ?>">Terms of Service</a>
                    <?php endif; ?>
                </nav>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> HR NextGen Solutions. All rights reserved.</p>
            <div class="footer-legal-links">
                <?php
                $privacy_page = get_page_by_path('privacy-policy');
                $terms_page   = get_page_by_path('terms-of-service');
                if ($privacy_page): ?>
                <a href="<?php echo esc_url(get_permalink($privacy_page)); ?>">Privacy Policy</a>
                <?php endif;
                if ($terms_page): ?>
                <a href="<?php echo esc_url(get_permalink($terms_page)); ?>">Terms of Service</a>
                <?php endif; ?>
                <a href="#main-content">Back to Top</a>
            </div>
        </div>

    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="back-to-top" aria-label="Scroll back to top">
    <?php echo hngs_icon('up-arrow'); ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
