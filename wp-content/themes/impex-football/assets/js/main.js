/**
 * IMPEX Football — Main JavaScript
 * Handles: mobile menu, search toggle, cart interactions,
 *          scroll-to-top, toast notifications, AJAX add-to-cart.
 *
 * @package ImpexFootball
 */

(function ($) {
  'use strict';

  /* =========================================================
     DOM READY
  ========================================================= */
  $(function () {
    ImpexMobileMenu.init();
    ImpexSearchToggle.init();
    ImpexScrollToTop.init();
    ImpexStickyHeader.init();
    ImpexProductCards.init();
    ImpexCartUpdater.init();
    ImpexToast.init();
  });

  /* =========================================================
     MOBILE MENU
  ========================================================= */
  const ImpexMobileMenu = {
    toggle: null,
    nav: null,

    init() {
      this.toggle = document.getElementById('mobileMenuToggle');
      this.nav    = document.getElementById('primary-nav');

      if (!this.toggle || !this.nav) return;

      this.toggle.addEventListener('click', () => this.open());

      // Close on outside click
      document.addEventListener('click', (e) => {
        if (
          this.nav.classList.contains('is-open') &&
          !this.nav.contains(e.target) &&
          !this.toggle.contains(e.target)
        ) {
          this.close();
        }
      });

      // Close on Escape
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') this.close();
      });

      // Close on nav link click (mobile)
      this.nav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
          if (window.innerWidth < 768) this.close();
        });
      });
    },

    open() {
      const isOpen = this.nav.classList.contains('is-open');
      if (isOpen) {
        this.close();
      } else {
        this.nav.classList.add('is-open');
        this.toggle.classList.add('is-active');
        this.toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
      }
    },

    close() {
      this.nav.classList.remove('is-open');
      this.toggle.classList.remove('is-active');
      this.toggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    },
  };

  /* =========================================================
     SEARCH TOGGLE
  ========================================================= */
  const ImpexSearchToggle = {
    btn: null,
    bar: null,
    input: null,

    init() {
      this.btn   = document.getElementById('searchToggle');
      this.bar   = document.getElementById('headerSearchBar');

      if (!this.btn || !this.bar) return;

      this.input = this.bar.querySelector('input[type="search"]');

      this.btn.addEventListener('click', () => this.toggle());

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') this.hide();
      });

      // Close on outside click
      document.addEventListener('click', (e) => {
        if (!this.bar.hidden && !this.bar.contains(e.target) && !this.btn.contains(e.target)) {
          this.hide();
        }
      });
    },

    toggle() {
      if (this.bar.hidden) {
        this.show();
      } else {
        this.hide();
      }
    },

    show() {
      this.bar.hidden = false;
      if (this.input) {
        this.input.focus();
      }
    },

    hide() {
      this.bar.hidden = true;
    },
  };

  /* =========================================================
     SCROLL TO TOP
  ========================================================= */
  const ImpexScrollToTop = {
    btn: null,

    init() {
      // Create button if it doesn't exist
      if (!document.getElementById('scrollToTop')) {
        const btn = document.createElement('button');
        btn.id = 'scrollToTop';
        btn.setAttribute('aria-label', 'Scroll to top');
        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>';
        document.body.appendChild(btn);
      }

      this.btn = document.getElementById('scrollToTop');

      window.addEventListener('scroll', () => this.onScroll(), { passive: true });
      this.btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    },

    onScroll() {
      if (window.scrollY > 400) {
        this.btn.classList.add('is-visible');
      } else {
        this.btn.classList.remove('is-visible');
      }
    },
  };

  /* =========================================================
     STICKY HEADER SHADOW
  ========================================================= */
  const ImpexStickyHeader = {
    header: null,

    init() {
      this.header = document.getElementById('site-header');
      if (!this.header) return;

      window.addEventListener('scroll', () => this.onScroll(), { passive: true });
    },

    onScroll() {
      if (window.scrollY > 10) {
        this.header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.9)';
      } else {
        this.header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.8)';
      }
    },
  };

  /* =========================================================
     PRODUCT CARD INTERACTIONS
  ========================================================= */
  const ImpexProductCards = {
    init() {
      // Hover image zoom effect (via CSS mostly, but we can add JS polish)
      document.querySelectorAll('.product-card').forEach((card) => {
        card.addEventListener('mouseenter', () => {
          card.style.willChange = 'transform';
        });
        card.addEventListener('mouseleave', () => {
          card.style.willChange = '';
        });
      });

      // Tab buttons on homepage
      document.querySelectorAll('.tab-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.tab-btn').forEach((b) => b.classList.remove('is-active'));
          this.classList.add('is-active');
          // Filter logic could go here if tabs target categories
        });
      });
    },
  };

  /* =========================================================
     WOOCOMMERCE CART UPDATER (AJAX)
  ========================================================= */
  const ImpexCartUpdater = {
    cartCount: null,

    init() {
      this.cartCount = document.getElementById('cartCount');

      // Listen to WooCommerce AJAX add to cart
      $(document.body).on('added_to_cart', (event, fragments, cart_hash, $button) => {
        this.updateCartCount();
        ImpexToast.show('✅ Added to cart!');
      });

      // Manual add-to-cart buttons (non-WooCommerce fallback)
      document.querySelectorAll('.add-to-cart-btn[data-product-id]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          this.addToCart(btn);
        });
      });
    },

    addToCart(btn) {
      const productId = btn.getAttribute('data-product-id');
      if (!productId || typeof impexData === 'undefined') return;

      // Show loading state
      const originalHTML = btn.innerHTML;
      btn.innerHTML = '<span class="impex-loading"></span>';
      btn.disabled = true;

      $.ajax({
        url: impexData.ajaxUrl,
        method: 'POST',
        data: {
          action: 'woocommerce_add_to_cart',
          product_id: productId,
          quantity: 1,
          nonce: impexData.nonce,
        },
        success: (response) => {
          btn.innerHTML = originalHTML;
          btn.disabled = false;
          ImpexToast.show('✅ Added to cart!');
          this.updateCartCount();
        },
        error: () => {
          btn.innerHTML = originalHTML;
          btn.disabled = false;
          ImpexToast.show('❌ Could not add to cart. Please try again.', 'error');
        },
      });
    },

    updateCartCount() {
      if (typeof impexData === 'undefined') return;

      $.ajax({
        url: impexData.ajaxUrl,
        method: 'POST',
        data: {
          action: 'impex_get_cart_count',
          nonce: impexData.nonce,
        },
        success: (response) => {
          if (response.success) {
            const count = response.data.count;
            const cartEl = document.getElementById('cartCount');
            if (count > 0) {
              if (cartEl) {
                cartEl.textContent = count;
                cartEl.hidden = false;
              } else {
                const cartBtn = document.querySelector('.header-cart');
                if (cartBtn) {
                  const span = document.createElement('span');
                  span.id = 'cartCount';
                  span.className = 'cart-count';
                  span.textContent = count;
                  cartBtn.appendChild(span);
                }
              }
            }
          }
        },
      });
    },
  };

  /* =========================================================
     TOAST NOTIFICATIONS
  ========================================================= */
  const ImpexToast = {
    container: null,
    timers: [],

    init() {
      // Container created on demand
    },

    show(message, type = 'success') {
      const toast = document.createElement('div');
      toast.className = 'impex-toast';
      toast.setAttribute('role', 'alert');
      toast.setAttribute('aria-live', 'polite');
      toast.innerHTML = `
        <span class="toast-icon">${type === 'error' ? '❌' : '✅'}</span>
        <span class="toast-message">${this.escapeHTML(message)}</span>
      `;

      document.body.appendChild(toast);

      // Trigger animation
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          toast.classList.add('is-visible');
        });
      });

      // Auto-remove
      const timer = setTimeout(() => {
        toast.classList.remove('is-visible');
        setTimeout(() => {
          if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 400);
      }, 3500);

      this.timers.push(timer);
    },

    escapeHTML(str) {
      const div = document.createElement('div');
      div.appendChild(document.createTextNode(str));
      return div.innerHTML;
    },
  };

  /* =========================================================
     LAZY IMAGE LOADING POLYFILL
  ========================================================= */
  if ('loading' in HTMLImageElement.prototype) {
    // Native lazy loading supported
  } else {
    // Minimal polyfill
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          if (img.dataset.src) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
          }
          observer.unobserve(img);
        }
      });
    });
    lazyImages.forEach((img) => observer.observe(img));
  }

  /* =========================================================
     HERO FOOTBALL ANIMATION — pause on hover
  ========================================================= */
  const heroFootball = document.querySelector('.hero-football-svg');
  if (heroFootball) {
    heroFootball.addEventListener('mouseenter', () => {
      heroFootball.style.animationPlayState = 'paused';
    });
    heroFootball.addEventListener('mouseleave', () => {
      heroFootball.style.animationPlayState = 'running';
    });
  }

  /* =========================================================
     SMOOTH ANCHOR SCROLLING
  ========================================================= */
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#') return;
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const headerHeight = document.getElementById('site-header')?.offsetHeight || 80;
        const top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

})(jQuery);
