/**
 * HR NextGen Solutions - Hero Canvas Particle Network
 * Draws an interactive neural-network-style particle background
 */

(function() {
    'use strict';

    var canvas, ctx, particles, animFrameId;
    var W, H;
    var mouse = { x: -9999, y: -9999 };

    var CONFIG = {
        particleCount: 80,
        maxDistance:   150,
        particleSpeed: 0.4,
        particleSize:  2,
        lineOpacity:   0.12,
        dotOpacity:    0.35,
        primaryColor:  '233, 30, 122',   // RGB for #E91E7A
        secondaryColor:'106, 27, 154',    // RGB for #6A1B9A
        mouseRadius:   180,
    };

    function Particle() {
        this.x   = Math.random() * W;
        this.y   = Math.random() * H;
        this.vx  = (Math.random() - 0.5) * CONFIG.particleSpeed;
        this.vy  = (Math.random() - 0.5) * CONFIG.particleSpeed;
        this.r   = Math.random() * CONFIG.particleSize + 0.5;
        // Mix of primary and secondary colors
        this.color = Math.random() > 0.5 ? CONFIG.primaryColor : CONFIG.secondaryColor;
    }

    Particle.prototype.update = function() {
        this.x += this.vx;
        this.y += this.vy;

        // Wrap edges
        if (this.x < 0)  this.x = W;
        if (this.x > W)  this.x = 0;
        if (this.y < 0)  this.y = H;
        if (this.y > H)  this.y = 0;

        // Gentle mouse repulsion
        var dx   = mouse.x - this.x;
        var dy   = mouse.y - this.y;
        var dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < CONFIG.mouseRadius && dist > 0) {
            var force = (CONFIG.mouseRadius - dist) / CONFIG.mouseRadius * 0.015;
            this.vx -= dx / dist * force;
            this.vy -= dy / dist * force;
        }

        // Dampen velocity
        this.vx *= 0.999;
        this.vy *= 0.999;

        // Ensure minimum speed
        var speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
        if (speed < 0.1) {
            this.vx = (Math.random() - 0.5) * CONFIG.particleSpeed;
            this.vy = (Math.random() - 0.5) * CONFIG.particleSpeed;
        }
    };

    Particle.prototype.draw = function() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(' + this.color + ', ' + CONFIG.dotOpacity + ')';
        ctx.fill();
    };

    function drawLines() {
        for (var i = 0; i < particles.length; i++) {
            for (var j = i + 1; j < particles.length; j++) {
                var dx   = particles[i].x - particles[j].x;
                var dy   = particles[i].y - particles[j].y;
                var dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < CONFIG.maxDistance) {
                    var opacity = (1 - dist / CONFIG.maxDistance) * CONFIG.lineOpacity;
                    var gradient = ctx.createLinearGradient(
                        particles[i].x, particles[i].y,
                        particles[j].x, particles[j].y
                    );
                    gradient.addColorStop(0, 'rgba(' + particles[i].color + ', ' + opacity + ')');
                    gradient.addColorStop(1, 'rgba(' + particles[j].color + ', ' + opacity + ')');

                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = gradient;
                    ctx.lineWidth   = 0.5;
                    ctx.stroke();
                }
            }
        }
    }

    function animate() {
        ctx.clearRect(0, 0, W, H);

        for (var i = 0; i < particles.length; i++) {
            particles[i].update();
        }
        drawLines();
        for (var i = 0; i < particles.length; i++) {
            particles[i].draw();
        }

        animFrameId = requestAnimationFrame(animate);
    }

    function resize() {
        W = canvas.width  = canvas.parentElement.offsetWidth  || window.innerWidth;
        H = canvas.height = canvas.parentElement.offsetHeight || window.innerHeight;

        // Recreate particles on resize to fill new dimensions
        particles = [];
        var count = Math.floor((W * H) / 14000);
        count = Math.max(40, Math.min(count, 120));
        for (var i = 0; i < count; i++) {
            particles.push(new Particle());
        }
    }

    function init() {
        canvas = document.getElementById('hero-canvas');
        if (!canvas) return;

        ctx = canvas.getContext('2d');
        if (!ctx) return;

        resize();
        animate();

        // Mouse tracking
        var hero = document.getElementById('hero');
        if (hero) {
            hero.addEventListener('mousemove', function(e) {
                var rect = canvas.getBoundingClientRect();
                mouse.x  = e.clientX - rect.left;
                mouse.y  = e.clientY - rect.top;
            });
            hero.addEventListener('mouseleave', function() {
                mouse.x = -9999;
                mouse.y = -9999;
            });
        }

        // Touch tracking
        canvas.addEventListener('touchmove', function(e) {
            var touch = e.touches[0];
            var rect  = canvas.getBoundingClientRect();
            mouse.x   = touch.clientX - rect.left;
            mouse.y   = touch.clientY - rect.top;
        }, { passive: true });

        // Resize handler
        window.addEventListener('resize', HNGS.debounce(function() {
            cancelAnimationFrame(animFrameId);
            resize();
            animate();
        }, 250));

        // Pause when tab is hidden to save resources
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                cancelAnimationFrame(animFrameId);
            } else {
                animate();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', init);

})();
