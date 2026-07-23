/**
 * Oria Patel Enterprises — main.js
 * Handles: mobile nav, product slider (with auto-advance), scroll-reveal,
 *          stat counter animation, contact form AJAX, sticky header shadow.
 */

(function () {
  'use strict';

  /* ═══════════════════════════════════════════════════════
     MOBILE NAVIGATION
  ═══════════════════════════════════════════════════════ */
  const hamburger  = document.getElementById('op-hamburger');
  const mobileNav  = document.getElementById('op-mobile-nav');
  const mobileClose = document.getElementById('op-mobile-close');

  function openMobileNav() {
    if (!mobileNav) return;
    mobileNav.classList.add('is-open');
    hamburger && hamburger.classList.add('is-active');
    hamburger && hamburger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileNav() {
    if (!mobileNav) return;
    mobileNav.classList.remove('is-open');
    hamburger && hamburger.classList.remove('is-active');
    hamburger && hamburger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  hamburger  && hamburger.addEventListener('click', openMobileNav);
  mobileClose && mobileClose.addEventListener('click', closeMobileNav);

  // Close on outside click
  mobileNav && mobileNav.addEventListener('click', function (e) {
    if (e.target === mobileNav) closeMobileNav();
  });

  // Close on Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMobileNav();
  });

  // Close when a mobile nav link is clicked
  document.querySelectorAll('.op-mobile-nav__link').forEach(function (link) {
    link.addEventListener('click', closeMobileNav);
  });

  /* ═══════════════════════════════════════════════════════
     STICKY HEADER SHADOW
  ═══════════════════════════════════════════════════════ */
  const header = document.querySelector('.op-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.style.boxShadow = window.scrollY > 8
        ? '0 2px 12px rgba(0,0,0,.08)'
        : 'none';
    }, { passive: true });
  }

  /* ═══════════════════════════════════════════════════════
     SCROLL REVEAL (Intersection Observer)
  ═══════════════════════════════════════════════════════ */
  var revealObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '-60px 0px' });

  document.querySelectorAll('.op-reveal').forEach(function (el) {
    revealObserver.observe(el);
  });

  /* ═══════════════════════════════════════════════════════
     STAT COUNTER ANIMATION
  ═══════════════════════════════════════════════════════ */
  function animateCounter(el) {
    var raw = el.getAttribute('data-count') || el.textContent.trim();
    // Extract numeric part and suffix
    var match = raw.match(/^([0-9]+)(.*)$/);
    if (!match) return; // non-numeric (e.g. "Zero"), skip
    var target  = parseInt(match[1], 10);
    var suffix  = match[2] || '';
    var start   = 0;
    var duration = 1400;
    var startTime = null;

    function easeOut(t) { return 1 - Math.pow(1 - t, 3); }

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      el.textContent = Math.round(easeOut(progress) * target) + suffix;
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  var counterObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        counterObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  document.querySelectorAll('.op-stat__value[data-count]').forEach(function (el) {
    counterObserver.observe(el);
  });

  /* ═══════════════════════════════════════════════════════
     PRODUCT SLIDER
     Finds every .op-slider-track and hooks up its sibling
     prev/next buttons + auto-advance.
  ═══════════════════════════════════════════════════════ */
  document.querySelectorAll('.op-slider-wrap').forEach(function (wrap) {
    var track   = wrap.querySelector('.op-slider-track');
    var btnPrev = wrap.querySelector('.op-slider-btn--prev');
    var btnNext = wrap.querySelector('.op-slider-btn--next');
    if (!track) return;

    var autoTimer = null;
    var SCROLL_AMOUNT = 0; // calculated below

    function getScrollAmount() {
      return track.clientWidth * 0.75 || 280;
    }

    function updateButtons() {
      var atStart = track.scrollLeft <= 2;
      var atEnd   = track.scrollLeft >= track.scrollWidth - track.clientWidth - 2;
      if (btnPrev) btnPrev.disabled = atStart;
      if (btnNext) btnNext.disabled = atEnd;
    }

    function scrollBy(amount) {
      track.scrollBy({ left: amount, behavior: 'smooth' });
    }

    function autoAdvance() {
      var atEnd = track.scrollLeft >= track.scrollWidth - track.clientWidth - 2;
      if (atEnd) {
        track.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        scrollBy(getScrollAmount());
      }
    }

    function resetAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(autoAdvance, 3800);
    }

    if (btnPrev) {
      btnPrev.addEventListener('click', function () {
        scrollBy(-getScrollAmount());
        resetAuto();
      });
    }

    if (btnNext) {
      btnNext.addEventListener('click', function () {
        scrollBy(getScrollAmount());
        resetAuto();
      });
    }

    track.addEventListener('scroll', updateButtons, { passive: true });

    // Pause auto-advance on hover/focus
    wrap.addEventListener('mouseenter', function () { clearInterval(autoTimer); });
    wrap.addEventListener('focusin',    function () { clearInterval(autoTimer); });
    wrap.addEventListener('mouseleave', resetAuto);
    wrap.addEventListener('focusout',   resetAuto);

    // Touch drag support
    var touchStartX = 0;
    track.addEventListener('touchstart', function (e) {
      touchStartX = e.touches[0].clientX;
      clearInterval(autoTimer);
    }, { passive: true });
    track.addEventListener('touchend', function (e) {
      var diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) scrollBy(diff > 0 ? getScrollAmount() : -getScrollAmount());
      resetAuto();
    }, { passive: true });

    updateButtons();
    resetAuto();
  });

  /* ═══════════════════════════════════════════════════════
     CONTACT FORM (AJAX)
  ═══════════════════════════════════════════════════════ */
  var contactForm = document.getElementById('op-contact-form');
  if (contactForm && typeof opData !== 'undefined') {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn     = contactForm.querySelector('[type="submit"]');
      var msgEl   = document.getElementById('op-form-message');
      var origText = btn.textContent;

      btn.disabled = true;
      btn.textContent = 'Sending…';

      var formData = new FormData(contactForm);
      formData.append('action', 'op_contact_form');
      formData.append('nonce',  opData.nonce);

      fetch(opData.ajaxUrl, { method: 'POST', body: formData })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (msgEl) {
            msgEl.textContent = data.data.message;
            msgEl.style.display = 'block';
            msgEl.style.color   = data.success ? '#067D62' : '#c0392b';
          }
          if (data.success) contactForm.reset();
        })
        .catch(function () {
          if (msgEl) {
            msgEl.textContent = 'Something went wrong. Please try again.';
            msgEl.style.display = 'block';
            msgEl.style.color = '#c0392b';
          }
        })
        .finally(function () {
          btn.disabled = false;
          btn.textContent = origText;
        });
    });
  }

  /* ═══════════════════════════════════════════════════════
     CATEGORY CARD — add .op-reveal class dynamically
     (in case cards are injected after DOMContentLoaded)
  ═══════════════════════════════════════════════════════ */
  function initRevealForNewCards() {
    document.querySelectorAll('.op-reveal:not(.is-visible)').forEach(function (el) {
      revealObserver.observe(el);
    });
  }

  /* ═══════════════════════════════════════════════════════
     SMOOTH ANCHOR SCROLL (for hash links)
  ═══════════════════════════════════════════════════════ */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ═══════════════════════════════════════════════════════
     PRODUCT CARD — keyboard accessibility (Enter = click CTA)
  ═══════════════════════════════════════════════════════ */
  document.querySelectorAll('.op-product-card').forEach(function (card) {
    card.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        var cta = card.querySelector('.op-product-card__cta');
        if (cta) cta.click();
      }
    });
  });

})();
