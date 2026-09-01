const revealSelector = [
    '.site-header .brand',
    '.site-header .desktop-nav > a',
    '.site-header .nav-cta',
    '.hero-art',
    '.hero-coordinates > i',
    '.hero-topline > span',
    '.hero-copy > h1',
    '.hero-copy > p',
    '.hero-actions > a',
    '.hero-index > span',
    'main > section:not(.hero) > .section-index > span',
    '.intro-main > *',
    '.impact-grid > div > *',
    '.section-heading > *',
    '.capability-list > article > .cap-number',
    '.capability-list > article h3',
    '.capability-list > article p',
    '.capability-list > article .cap-tags',
    '.capability-list > article .focus-label',
    '.capability-list > article .cap-arrow',
    '.project-intro > *',
    '.project-card > .project-visual',
    '.project-card > .project-meta > *',
    '.network-copy > *',
    '.network-lines > *',
    '.news-card > .news-image',
    '.news-card > span',
    '.news-card > h3',
    '.news-card > p',
    '.news-card > i',
    '.empty-news > *',
    '.contact-copy > *',
    '.contact-form > label',
    '.contact-form > button',
    '.form-success > *',
    '.page-hero > *',
    '.article-page > header > *',
    '.article-cover',
    '.article-body > *',
    '.back-link',
    '.site-footer .footer-lead > .eyebrow',
    '.site-footer .footer-lead > h2',
    '.site-footer .footer-lead > .circle-link',
    '.site-footer .footer-grid > div > *',
    '.site-footer .footer-bottom > *',
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
        entries.forEach((entry) => {
            entry.target.dataset.revealFrom = scrollDirection;

            revealAnimations.get(entry.target)?.cancel();

            if (!entry.isIntersecting) {
                entry.target.classList.remove('is-revealed');
                return;
            }

            entry.target.classList.add('is-revealed');

            const delay = Number(entry.target.dataset.revealDelay ?? 0);
            const translate = prefersReducedMotion
                ? 'translate3d(0,0,0)'
                : `translate3d(0,${scrollDirection === 'bottom' ? '32px' : '-32px'},0)`;
            const animation = entry.target.animate([
                { opacity: 0, transform: translate },
                { opacity: 1, transform: 'translate3d(0,0,0)' },
            ], {
                duration: prefersReducedMotion ? 320 : 820,
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

        elements.forEach((element, index) => {
            if (observedElements.has(element)) return;

            element.classList.add('scroll-reveal');
            element.dataset.revealDelay = String(Math.min(index % 4, 3) * 70);
            observedElements.add(element);

            // Wait for the hidden state to be painted before checking visibility.
            requestAnimationFrame(() => {
                requestAnimationFrame(() => observer.observe(element));
            });
        });
    };

    observeElements();

    new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node instanceof HTMLElement) observeElements(node);
            });
        });
    }).observe(document.body, { childList: true, subtree: true });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupScrollReveal, { once: true });
} else {
    setupScrollReveal();
}
