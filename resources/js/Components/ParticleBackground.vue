<template>
    <div ref="container" class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <canvas ref="canvas" class="block w-full h-full"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const container = ref(null);
const canvas = ref(null);
let ctx = null;
let animationFrameId = null;
let particles = [];
let width = 0;
let height = 0;

// Configurations
const PARTICLE_COLORS = ['rgba(27, 67, 50, 0.6)', 'rgba(149, 213, 178, 0.6)', 'rgba(183, 183, 164, 0.5)'];
const LINE_COLOR = '164, 195, 178'; // R, G, B for rgba string construction
const MAX_CONNECTION_DISTANCE = 120;
const PARTICLE_BASE_SPEED = 0.2;

class Particle {
    constructor() {
        this.x = Math.random() * width;
        this.y = Math.random() * height;
        
        // Random velocity between -PARTICLE_BASE_SPEED and PARTICLE_BASE_SPEED
        this.vx = (Math.random() - 0.5) * 2 * PARTICLE_BASE_SPEED;
        this.vy = (Math.random() - 0.5) * 2 * PARTICLE_BASE_SPEED;
        
        // Radius between 1 and 2.5
        this.radius = Math.random() * 1.5 + 1;
        this.color = PARTICLE_COLORS[Math.floor(Math.random() * PARTICLE_COLORS.length)];
    }

    update() {
        this.x += this.vx;
        this.y += this.vy;

        // Bounce off edges smoothly
        if (this.x < 0 || this.x > width) this.vx *= -1;
        if (this.y < 0 || this.y > height) this.vy *= -1;
    }

    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
    }
}

const resizeCanvas = () => {
    if (!container.value || !canvas.value) return;
    
    // Support high-DPI displays (like 4K)
    const dpr = window.devicePixelRatio || 1;
    width = container.value.clientWidth;
    height = container.value.clientHeight;
    
    canvas.value.width = width * dpr;
    canvas.value.height = height * dpr;
    
    ctx.scale(dpr, dpr);
    
    // Adjust particle count based on screen size (minimalist)
    const area = width * height;
    const targetParticleCount = Math.floor(area / 18000); // Higher divisor = fewer particles
    
    // Re-initialize particles if count changes significantly
    if (Math.abs(particles.length - targetParticleCount) > 10) {
        initParticles(targetParticleCount);
    }
};

const initParticles = (count) => {
    particles = [];
    for (let i = 0; i < count; i++) {
        particles.push(new Particle());
    }
};

const animate = () => {
    if (!ctx) return;
    
    ctx.clearRect(0, 0, width, height);

    // Update and draw particles
    for (let i = 0; i < particles.length; i++) {
        particles[i].update();
        particles[i].draw();
        
        // Check connections
        for (let j = i + 1; j < particles.length; j++) {
            const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < MAX_CONNECTION_DISTANCE) {
                // Fade line based on distance
                const opacity = 1 - (distance / MAX_CONNECTION_DISTANCE);
                ctx.beginPath();
                ctx.strokeStyle = `rgba(${LINE_COLOR}, ${opacity * 0.4})`; // Max opacity 0.4 for subtlety
                ctx.lineWidth = 0.5;
                ctx.moveTo(particles[i].x, particles[i].y);
                ctx.lineTo(particles[j].x, particles[j].y);
                ctx.stroke();
            }
        }
    }

    animationFrameId = requestAnimationFrame(animate);
};

onMounted(() => {
    if (canvas.value) {
        ctx = canvas.value.getContext('2d');
        resizeCanvas();
        animate();
        window.addEventListener('resize', resizeCanvas);
    }
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', resizeCanvas);
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
    }
});
</script>
