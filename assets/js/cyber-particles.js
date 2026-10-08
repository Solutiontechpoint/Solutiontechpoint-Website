/* ==========================================================================
   Cyber Particle Network Background - Solution Tech Services
   High-performance canvas animation with accessibility (reduced-motion) awareness
   ========================================================================== */

(function () {
  'use strict';

  const canvas = document.getElementById('cyber-canvas');
  if (!canvas) return;

  // Respect user preference for reduced motion
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (prefersReducedMotion.matches) {
    canvas.style.display = 'none';
    return;
  }

  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];
  let animId = null;

  function resize() {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  }

  window.addEventListener('resize', resize);
  resize();

  class Particle {
    constructor() {
      this.reset();
    }

    reset() {
      this.x = Math.random() * width;
      this.y = Math.random() * height;
      this.vx = (Math.random() - 0.5) * 0.6;
      this.vy = (Math.random() - 0.5) * 0.6;
      this.radius = Math.random() * 1.8 + 1;
      this.alpha = Math.random() * 0.4 + 0.2;
    }

    update() {
      this.x += this.vx;
      this.y += this.vy;

      if (this.x < 0 || this.x > width) this.vx *= -1;
      if (this.y < 0 || this.y > height) this.vy *= -1;
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(250, 204, 21, ${this.alpha})`;
      ctx.fill();
    }
  }

  // Generate particle count based on screen size (balanced for battery & 60fps)
  const numParticles = Math.min(Math.floor(window.innerWidth / 24), 50);
  for (let i = 0; i < numParticles; i++) {
    particles.push(new Particle());
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);

    // Draw connecting neon lines
    for (let i = 0; i < particles.length; i++) {
      particles[i].update();
      particles[i].draw();

      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < 120) {
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          const lineAlpha = (1 - dist / 120) * 0.18;
          ctx.strokeStyle = `rgba(250, 204, 21, ${lineAlpha})`;
          ctx.lineWidth = 0.75;
          ctx.stroke();
        }
      }
    }

    animId = requestAnimationFrame(animate);
  }

  animate();

  prefersReducedMotion.addEventListener('change', (e) => {
    if (e.matches) {
      if (animId) cancelAnimationFrame(animId);
      ctx.clearRect(0, 0, width, height);
      canvas.style.display = 'none';
    } else {
      canvas.style.display = 'block';
      animate();
    }
  });
})();
