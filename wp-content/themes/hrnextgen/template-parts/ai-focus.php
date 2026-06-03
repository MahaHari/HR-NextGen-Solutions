<?php
/**
 * Template Part: AI Startup Focus Section
 */

$ai_products = [
    ['icon'=>'robot',       'title'=>'AI Agents',             'desc'=>'Autonomous AI systems that handle complex tasks without human intervention.'],
    ['icon'=>'phone',       'title'=>'Voice AI',              'desc'=>'Conversational voice interfaces for customer service and automation.'],
    ['icon'=>'zap',         'title'=>'AI Automation',         'desc'=>'End-to-end workflow automation powered by large language models.'],
    ['icon'=>'layers',      'title'=>'RAG Systems',           'desc'=>'Retrieval-augmented generation for knowledge-grounded AI responses.'],
    ['icon'=>'brain',       'title'=>'Knowledge Assistants',  'desc'=>'AI assistants trained on your proprietary data and business processes.'],
    ['icon'=>'message',     'title'=>'AI Customer Service',   'desc'=>'24/7 intelligent support that resolves issues and escalates when needed.'],
    ['icon'=>'trending-up', 'title'=>'AI Analytics',          'desc'=>'Predictive analytics and business intelligence driven by machine learning.'],
    ['icon'=>'cpu',         'title'=>'AI Workflow Automation','desc'=>'Intelligent process orchestration that learns and improves over time.'],
];
?>

<section class="section ai-focus" id="ai-focus" aria-label="AI Solutions">

    <!-- Animated Background -->
    <div class="ai-focus-bg" aria-hidden="true">
        <div class="hex-grid"></div>
        <div class="ai-focus-glow-1"></div>
        <div class="ai-focus-glow-2"></div>
    </div>

    <!-- Decorative Node Network SVG -->
    <svg class="node-network-svg" aria-hidden="true" viewBox="0 0 1200 600" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
        <g stroke="#E91E7A" stroke-width="0.5" fill="none">
            <line x1="100" y1="100" x2="300" y2="200"/>
            <line x1="300" y1="200" x2="500" y2="100"/>
            <line x1="500" y1="100" x2="700" y2="250"/>
            <line x1="700" y1="250" x2="900" y2="150"/>
            <line x1="900" y1="150" x2="1100" y2="300"/>
            <line x1="300" y1="200" x2="400" y2="400"/>
            <line x1="400" y1="400" x2="600" y2="350"/>
            <line x1="600" y1="350" x2="800" y2="450"/>
            <line x1="800" y1="450" x2="1000" y2="400"/>
            <line x1="200" y1="500" x2="400" y2="400"/>
            <line x1="600" y1="350" x2="700" y2="250"/>
        </g>
        <g fill="#E91E7A">
            <circle cx="100" cy="100" r="4"><animate attributeName="opacity" values="0.3;1;0.3" dur="3s" repeatCount="indefinite"/></circle>
            <circle cx="300" cy="200" r="6"><animate attributeName="opacity" values="0.5;1;0.5" dur="2.5s" repeatCount="indefinite"/></circle>
            <circle cx="500" cy="100" r="4"><animate attributeName="opacity" values="0.2;0.8;0.2" dur="4s" repeatCount="indefinite"/></circle>
            <circle cx="700" cy="250" r="7"><animate attributeName="opacity" values="0.4;1;0.4" dur="3.5s" repeatCount="indefinite"/></circle>
            <circle cx="900" cy="150" r="4"><animate attributeName="opacity" values="0.3;0.9;0.3" dur="2.8s" repeatCount="indefinite"/></circle>
            <circle cx="1100" cy="300" r="5"><animate attributeName="opacity" values="0.2;0.7;0.2" dur="3.2s" repeatCount="indefinite"/></circle>
            <circle cx="400" cy="400" r="5"><animate attributeName="opacity" values="0.5;1;0.5" dur="4.5s" repeatCount="indefinite"/></circle>
            <circle cx="600" cy="350" r="6"><animate attributeName="opacity" values="0.3;1;0.3" dur="2s" repeatCount="indefinite"/></circle>
            <circle cx="800" cy="450" r="4"><animate attributeName="opacity" values="0.4;0.9;0.4" dur="3.8s" repeatCount="indefinite"/></circle>
            <circle cx="200" cy="500" r="4"><animate attributeName="opacity" values="0.2;0.8;0.2" dur="5s" repeatCount="indefinite"/></circle>
        </g>
    </svg>

    <div class="container ai-focus-content">

        <div class="section-header">
            <span class="section-label">AI Innovation</span>
            <h2>From Software Development to <span class="heading-gradient">Intelligent Business Solutions</span></h2>
            <p>We're not just a dev shop. We're building the AI infrastructure that will power the next generation of business operations — from autonomous agents to enterprise-wide automation platforms.</p>
        </div>

        <div class="ai-products-grid stagger-children">
            <?php foreach ($ai_products as $product): ?>
            <div class="ai-product-tile reveal">
                <div class="ai-tile-icon">
                    <?php echo hngs_icon($product['icon']); ?>
                </div>
                <h4><?php echo esc_html($product['title']); ?></h4>
                <p><?php echo esc_html($product['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center;margin-top:var(--space-12);">
            <p style="font-size:var(--text-lg);color:var(--text-muted);margin-bottom:var(--space-6);font-style:italic;">"Powering the Next Generation of Business with Artificial Intelligence"</p>
            <a href="#contact" class="btn btn-primary btn-lg">
                Explore AI Solutions
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </div>

    </div>
</section>
