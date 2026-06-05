/**
 * HR NextGen Solutions v2 - Video-Style Hero Canvas
 * Animated dot-connection network — mimics AI connectivity visualization
 * Features: traveling data pulses along edges, pulsing nodes, depth layers
 */

(function() {
    'use strict';

    var canvas, ctx, nodes, edges, pulses, animFrameId;
    var W, H, dpr;

    var CFG = {
        nodeCount:    55,
        minDist:      160,
        maxDist:      220,
        nodeSpeed:    0.25,
        nodeSizeMin:  2,
        nodeSizeMax:  5,
        lineWidth:    0.8,
        lineOpacity:  0.18,
        nodeOpacity:  0.6,
        pulseSpeed:   0.006,
        pulseCount:   18,
        primaryRGB:   '233, 30, 122',
        secondaryRGB: '106, 27, 154',
        accentRGB:    '180, 60, 180',
    };

    /* ---- Node ---- */
    function Node() {
        this.reset();
        this.y = Math.random() * H;
    }
    Node.prototype.reset = function() {
        this.x  = Math.random() * W;
        this.y  = Math.random() * H;
        this.vx = (Math.random() - 0.5) * CFG.nodeSpeed;
        this.vy = (Math.random() - 0.5) * CFG.nodeSpeed;
        this.r  = CFG.nodeSizeMin + Math.random() * (CFG.nodeSizeMax - CFG.nodeSizeMin);
        // Layer system: closer nodes = brighter, larger
        this.layer  = Math.random(); // 0 = back, 1 = front
        this.color  = this.layer > 0.6 ? CFG.primaryRGB : (this.layer > 0.3 ? CFG.accentRGB : CFG.secondaryRGB);
        this.opacity = 0.2 + this.layer * 0.5;
        this.pulsePhase = Math.random() * Math.PI * 2;
        this.pulseSpeed = 0.02 + Math.random() * 0.02;
    };
    Node.prototype.update = function(t) {
        this.x += this.vx;
        this.y += this.vy;
        if (this.x < -20)  this.x = W + 20;
        if (this.x > W+20) this.x = -20;
        if (this.y < -20)  this.y = H + 20;
        if (this.y > H+20) this.y = -20;
        this.pulsePhase += this.pulseSpeed;
    };
    Node.prototype.draw = function() {
        var pulse = 0.7 + 0.3 * Math.sin(this.pulsePhase);
        var r     = this.r * pulse;
        var alpha = this.opacity * pulse;

        // Outer glow ring
        var grd = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, r * 4);
        grd.addColorStop(0,   'rgba(' + this.color + ', ' + (alpha * 0.5) + ')');
        grd.addColorStop(0.4, 'rgba(' + this.color + ', ' + (alpha * 0.15) + ')');
        grd.addColorStop(1,   'rgba(' + this.color + ', 0)');
        ctx.beginPath();
        ctx.arc(this.x, this.y, r * 4, 0, Math.PI * 2);
        ctx.fillStyle = grd;
        ctx.fill();

        // Core dot
        ctx.beginPath();
        ctx.arc(this.x, this.y, r, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(' + this.color + ', ' + alpha + ')';
        ctx.fill();
    };

    /* ---- Edge (connection line) ---- */
    function Edge(a, b) {
        this.a = a;
        this.b = b;
    }
    Edge.prototype.draw = function() {
        var dx   = this.b.x - this.a.x;
        var dy   = this.b.y - this.a.y;
        var dist = Math.sqrt(dx*dx + dy*dy);
        if (dist > CFG.maxDist) return;

        var alpha = (1 - dist / CFG.maxDist) * CFG.lineOpacity;
        alpha    *= Math.min(this.a.layer, this.b.layer) + 0.3;

        var grad = ctx.createLinearGradient(this.a.x, this.a.y, this.b.x, this.b.y);
        grad.addColorStop(0, 'rgba(' + this.a.color + ', ' + alpha + ')');
        grad.addColorStop(1, 'rgba(' + this.b.color + ', ' + alpha + ')');

        ctx.beginPath();
        ctx.moveTo(this.a.x, this.a.y);
        ctx.lineTo(this.b.x, this.b.y);
        ctx.strokeStyle = grad;
        ctx.lineWidth   = CFG.lineWidth * (0.5 + Math.min(this.a.layer, this.b.layer) * 0.8);
        ctx.stroke();
    };

    /* ---- Data Pulse traveling along an edge ---- */
    function Pulse(edge) {
        this.edge     = edge;
        this.progress = Math.random();
        this.speed    = CFG.pulseSpeed + Math.random() * 0.004;
        this.size     = 3 + Math.random() * 4;
        this.reverse  = Math.random() > 0.5;
        this.color    = Math.random() > 0.5 ? CFG.primaryRGB : CFG.secondaryRGB;
    }
    Pulse.prototype.update = function() {
        if (this.reverse) {
            this.progress -= this.speed;
            if (this.progress < 0) this.progress = 1;
        } else {
            this.progress += this.speed;
            if (this.progress > 1) this.progress = 0;
        }
    };
    Pulse.prototype.draw = function() {
        var a  = this.edge.a;
        var b  = this.edge.b;
        var dx = b.x - a.x;
        var dy = b.y - a.y;
        var dist = Math.sqrt(dx*dx + dy*dy);
        if (dist > CFG.maxDist) return;

        var t = this.progress;
        var x = a.x + dx * t;
        var y = a.y + dy * t;

        var visAlpha = (1 - dist / CFG.maxDist) * 0.85;

        // Glow
        var grd = ctx.createRadialGradient(x, y, 0, x, y, this.size * 3);
        grd.addColorStop(0,   'rgba(' + this.color + ', ' + visAlpha + ')');
        grd.addColorStop(0.5, 'rgba(' + this.color + ', ' + (visAlpha * 0.3) + ')');
        grd.addColorStop(1,   'rgba(' + this.color + ', 0)');
        ctx.beginPath();
        ctx.arc(x, y, this.size * 3, 0, Math.PI * 2);
        ctx.fillStyle = grd;
        ctx.fill();

        // Core
        ctx.beginPath();
        ctx.arc(x, y, this.size * 0.6, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(' + this.color + ', ' + visAlpha + ')';
        ctx.fill();
    };

    /* ---- Build edge list from proximity ---- */
    function buildEdges() {
        edges = [];
        for (var i = 0; i < nodes.length; i++) {
            for (var j = i + 1; j < nodes.length; j++) {
                var dx   = nodes[j].x - nodes[i].x;
                var dy   = nodes[j].y - nodes[i].y;
                var dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < CFG.maxDist) {
                    edges.push(new Edge(nodes[i], nodes[j]));
                }
            }
        }
        // Assign pulses to random edges
        pulses = [];
        var numPulses = Math.min(CFG.pulseCount, edges.length);
        for (var k = 0; k < numPulses; k++) {
            var e = edges[Math.floor(Math.random() * edges.length)];
            pulses.push(new Pulse(e));
        }
    }

    /* ---- Main render loop ---- */
    function animate(t) {
        ctx.clearRect(0, 0, W, H);

        // Rebuild edges periodically as nodes move
        if (Math.floor(t / 1000) % 2 === 0) {
            // Lightweight: just redraw with existing edges; full rebuild every 3s
        }

        // Sort nodes back-to-front by layer
        nodes.sort(function(a, b) { return a.layer - b.layer; });

        // Draw edges
        for (var i = 0; i < edges.length; i++) edges[i].draw();

        // Draw pulses
        for (var j = 0; j < pulses.length; j++) {
            pulses[j].update();
            pulses[j].draw();
        }

        // Draw nodes
        for (var k = 0; k < nodes.length; k++) {
            nodes[k].update(t);
            nodes[k].draw();
        }

        // Rebuild edges every ~3 seconds
        if (!animate._lastRebuild || t - animate._lastRebuild > 3000) {
            animate._lastRebuild = t;
            buildEdges();
        }

        animFrameId = requestAnimationFrame(animate);
    }

    /* ---- Init / resize ---- */
    function resize() {
        dpr    = window.devicePixelRatio || 1;
        var parent = canvas.parentElement;
        W = parent.offsetWidth  || window.innerWidth;
        H = parent.offsetHeight || window.innerHeight;
        canvas.width  = W * dpr;
        canvas.height = H * dpr;
        canvas.style.width  = W + 'px';
        canvas.style.height = H + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        // Adjust node count for screen size
        var count = Math.floor((W * H) / 16000);
        CFG.nodeCount = Math.max(35, Math.min(count, 80));

        nodes = [];
        for (var i = 0; i < CFG.nodeCount; i++) nodes.push(new Node());
        buildEdges();
    }

    function init() {
        canvas = document.getElementById('hero-canvas');
        if (!canvas) return;
        ctx = canvas.getContext('2d');
        if (!ctx) return;

        resize();
        animate(0);

        window.addEventListener('resize', HNGS.debounce(function() {
            cancelAnimationFrame(animFrameId);
            resize();
            animate(0);
        }, 300));

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                cancelAnimationFrame(animFrameId);
            } else {
                animate(0);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', init);
})();
