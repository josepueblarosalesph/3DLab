const revealSelector = [
    '.hero-topline',
    '.hero-copy',
    '.hero-index',
    'main > section:not(.hero) > .section-index',
    '.intro-main',
    '.impact-grid',
    '.section-heading',
    '.capability-list',
    '.project-intro',
    '.project-grid',
    '.network-copy',
    '.network-lines',
    '.news-grid',
    '.contact-copy',
    '.contact-form',
    '.form-success',
    '.page-hero',
    '.article-page > header',
    '.article-cover',
    '.article-body',
    '.back-link',
    '.site-footer .footer-lead',
    '.site-footer .footer-grid',
    '.site-footer .footer-bottom',
].join(',');

const setupScrollReveal = () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let previousScrollY = window.scrollY;
    let scrollDirection = 'bottom';
    const observedElements = new WeakSet();
    const revealAnimations = new WeakMap();

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;
        scrollDirection = currentScrollY >= previousScrollY ? 'bottom' : 'top';
        previousScrollY = currentScrollY;
    }, { passive: true });

    const observer = new IntersectionObserver((entries) => {
        const enteringEntries = entries
            .filter((entry) => entry.isIntersecting)
            .sort((first, second) => first.boundingClientRect.top - second.boundingClientRect.top);

        entries.forEach((entry) => {
            const revealOrigin = scrollDirection === 'bottom' ? 'top' : 'bottom';
            entry.target.dataset.revealFrom = revealOrigin;

            revealAnimations.get(entry.target)?.cancel();

            if (!entry.isIntersecting) {
                entry.target.classList.remove('is-revealed');
                return;
            }

            entry.target.classList.add('is-revealed');

            const verticalOrder = enteringEntries.indexOf(entry);
            const delay = verticalOrder >= 0 ? verticalOrder * 160 : 0;
            const translate = prefersReducedMotion
                ? 'translate3d(0,0,0)'
                : `translate3d(0,${revealOrigin === 'top' ? '-72px' : '72px'},0)`;
            const animation = entry.target.animate([
                {
                    opacity: 0,
                    transform: translate,
                    offset: 0,
                },
                {
                    opacity: 1,
                    transform: 'translate3d(0,0,0)',
                    offset: 1,
                },
            ], {
                duration: prefersReducedMotion ? 480 : 1250,
                delay,
                easing: 'cubic-bezier(.22,1,.36,1)',
                fill: 'both',
            });

            revealAnimations.set(entry.target, animation);
            animation.finished.then(() => {
                if (entry.target.classList.contains('is-revealed')) animation.cancel();
            }).catch(() => {});
        });
    }, {
        threshold: 0.06,
        rootMargin: '0px 0px -2% 0px',
    });

    const observeElements = (root = document) => {
        const elements = root.matches?.(revealSelector)
            ? [root, ...root.querySelectorAll(revealSelector)]
            : [...root.querySelectorAll(revealSelector)];
        const newElements = [];

        elements.forEach((element) => {
            if (observedElements.has(element)) return;

            element.classList.add('scroll-reveal');
            observedElements.add(element);
            newElements.push(element);
        });

        if (!newElements.length) return;

        // Register the whole group in one frame so visible elements are delivered
        // together and can be animated in true top-to-bottom order.
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                newElements.forEach((element) => observer.observe(element));
            });
        });
    };

    observeElements();

};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupScrollReveal, { once: true });
} else {
    setupScrollReveal();
}
