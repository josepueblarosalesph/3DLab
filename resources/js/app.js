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
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let previousScrollY = window.scrollY;
    const observedElements = new WeakSet();

    const observer = new IntersectionObserver((entries) => {
        const scrollingDown = window.scrollY >= previousScrollY;

        entries.forEach((entry) => {
            entry.target.dataset.revealFrom = scrollingDown ? 'bottom' : 'top';
            entry.target.classList.toggle('is-revealed', entry.isIntersecting);
        });

        previousScrollY = window.scrollY;
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -5% 0px',
    });

    const observeElements = (root = document) => {
        const elements = root.matches?.(revealSelector)
            ? [root, ...root.querySelectorAll(revealSelector)]
            : [...root.querySelectorAll(revealSelector)];

        elements.forEach((element, index) => {
            if (observedElements.has(element)) return;

            element.classList.add('scroll-reveal');
            element.style.setProperty('--reveal-delay', `${Math.min(index % 4, 3) * 55}ms`);
            observedElements.add(element);
            observer.observe(element);
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
