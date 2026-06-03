<?php
/**
 * Template Part: Company Vision Section
 */
$cta1_url = hngs_get_option('hngs_vision_cta_primary_url', '#contact');
$cta2_url = hngs_get_option('hngs_vision_cta_secondary_url', '#process');
?>

<section class="section vision" id="vision" aria-label="Company Vision">

    <div class="vision-bg" aria-hidden="true"></div>

    <!-- Circuit board decorative SVG -->
    <svg class="vision-circuit" aria-hidden="true" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
        <g stroke="#E91E7A" stroke-width="1" fill="none" opacity="1">
            <!-- Horizontal lines -->
            <line x1="0" y1="100" x2="600" y2="100"/>
            <line x1="0" y1="250" x2="600" y2="250"/>
            <line x1="0" y1="400" x2="600" y2="400"/>
            <line x1="0" y1="550" x2="600" y2="550"/>
            <!-- Vertical lines -->
            <line x1="100" y1="0" x2="100" y2="600"/>
            <line x1="250" y1="0" x2="250" y2="600"/>
            <line x1="400" y1="0" x2="400" y2="600"/>
            <line x1="550" y1="0" x2="550" y2="600"/>
            <!-- Connection nodes -->
            <circle cx="100" cy="100" r="5" fill="#E91E7A"/>
            <circle cx="250" cy="100" r="3" fill="#E91E7A"/>
            <circle cx="400" cy="250" r="5" fill="#E91E7A"/>
            <circle cx="100" cy="400" r="4" fill="#6A1B9A"/>
            <circle cx="550" cy="400" r="5" fill="#E91E7A"/>
            <circle cx="250" cy="550" r="3" fill="#6A1B9A"/>
            <!-- L-shaped connectors -->
            <path d="M100 150 L150 150 L150 250"/>
            <path d="M300 100 L300 175 L400 175"/>
            <path d="M250 300 L250 400 L400 400"/>
            <path d="M450 400 L550 400"/>
            <!-- Small component squares -->
            <rect x="120" y="90" width="20" height="20" rx="2"/>
            <rect x="370" y="240" width="20" height="20" rx="2"/>
            <rect x="520" y="390" width="20" height="20" rx="2"/>
        </g>
    </svg>

    <div class="container vision-content">

        <span class="section-label">Our Mission</span>

        <h2>Building the Future of Business with <span class="heading-gradient">Artificial Intelligence</span></h2>

        <div class="divider-gradient divider-gradient--center" style="margin:var(--space-8) auto;"></div>

        <div class="vision-body">
            <p>HR NextGen Solutions was founded on a simple but powerful belief: every business — regardless of size or industry — deserves access to world-class software and the transformative power of artificial intelligence. We started as a custom software development company, building applications that solved real problems for real businesses.</p>

            <div class="vision-divider"></div>

            <p>Today, we are evolving into something more ambitious. As AI moves from novelty to necessity, we are making the deliberate transition from a software development company to an AI innovation powerhouse. Our focus has shifted to building the intelligent systems that don't just automate tasks — they learn, adapt, and improve continuously, creating compounding value for the businesses they serve.</p>

            <div class="vision-divider"></div>

            <p>Our mission is to democratize AI-powered business transformation. Whether you're a restaurant looking to automate reservations, a hospital seeking to improve patient outcomes, or an enterprise ready to deploy autonomous AI agents across your operations — we have the engineering depth, domain expertise, and AI-first mindset to make it happen. The future of business is intelligent, and we're here to build it with you.</p>
        </div>

        <div class="vision-ctas">
            <a href="<?php echo esc_url($cta1_url); ?>" class="btn btn-primary btn-lg">
                Partner With Us
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
            <a href="<?php echo esc_url($cta2_url); ?>" class="btn btn-ghost-gradient btn-lg">
                See How We Work
            </a>
        </div>

    </div>
</section>
