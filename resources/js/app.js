import './bootstrap';

import AOS from 'aos';

// Note: Alpine.js is bundled with Livewire 4.x — DO NOT import separately
// to avoid duplicate Alpine instances that break Livewire components.

// Initialize AOS (Animate On Scroll)
function initAOS() {
    AOS.init({
        duration: 700,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50,
    });
}

initAOS();

// Re-initialize AOS after Livewire SPA navigations (wire:navigate)
document.addEventListener('livewire:navigated', () => {
    initAOS();
    AOS.refresh();
});
