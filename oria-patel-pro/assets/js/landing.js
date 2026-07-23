/**
 * Oria Patel Pro — landing.js
 * Handles: FAQ accordion, sticky lead bar, exit-intent popup,
 *          lead/mockup AJAX form submissions (all forms using class .oria-lead-form),
 *          lead bar single-email form.
 */

(function () {
  'use strict';

  /* ═══════════════════════════════════════════════════════
     HELPERS
  ═══════════════════════════════════════════════════════ */
  function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
  }
  function setCookie(name, value, days) {
    var d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
  }

  /* ═══════════════════════════════════════════════════════
     FAQ ACCORDION
     Works on any .op-faq__question button inside .op-faq__item
  ═══════════════════════════════════════════════════════ */
  document.querySelectorAll('.op-faq__question').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var isOpen    = btn.getAttribute('aria-expanded') === 'true';
      var answerId  = btn.getAttribute('aria-controls');
      var answer    = answerId ? document.getElementById(answerId) : btn.nextElementSibling;
      if (!answer) return;

      // Close all siblings first (accordion behaviour — one open at a time per .op-faq group)
      var faqContainer = btn.closest('.op-faq, .op-faq-section .op-faq');
      if (faqContainer) {
        faqContainer.querySelectorAll('.op-faq__question[aria-expanded="true"]').forEach(function (openBtn) {
          if (openBtn === btn) return;
          openBtn.setAttribute('aria-expanded', 'false');
          var openAnswerId = openBtn.getAttribute('aria-controls');
          var openAnswer   = openAnswerId ? document.getElementById(openAnswerId) : openBtn.nextElementSibling;
          if (openAnswer) {
            openAnswer.classList.remove('is-open');
            openAnswer.hidden = true;
          }
        });
      }

      // Toggle clicked item
      var willOpen = !isOpen;
      btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      if (willOpen) {
        answer.hidden = false;
        // Trigger CSS transition
        requestAnimationFrame(function () {
          answer.classList.add('is-open');
        });
      } else {
        answer.classList.remove('is-open');
        // Wait for transition before hiding
        answer.addEventListener('transitionend', function hide() {
          answer.hidden = true;
          answer.removeEventListener('transitionend', hide);
        }, { once: true });
      }
    });
  });

  /* ═══════════════════════════════════════════════════════
     STICKY LEAD BAR
     Shows after 5 seconds on first visit (cookie-gated).
     Hidden by X button and sets a 7-day suppression cookie.
  ═══════════════════════════════════════════════════════ */
  var leadBar   = document.getElementById('oria-lead-bar');
  var barClose  = document.getElementById('oria-bar-close');
  var barForm   = document.getElementById('oria-bar-form');

  if (leadBar && !getCookie('oria_bar_closed')) {
    setTimeout(function () {
      leadBar.classList.add('is-visible');
    }, 5000);
  }

  if (barClose && leadBar) {
    barClose.addEventListener('click', function () {
      leadBar.classList.remove('is-visible');
      leadBar.classList.add('is-hidden');
      setCookie('oria_bar_closed', '1', 7);
    });
  }

  // Bar form — only email field; create a minimal lead
  if (barForm && typeof opData !== 'undefined') {
    barForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var emailInput = barForm.querySelector('[name="email"]');
      if (!emailInput || !emailInput.value) return;

      var fd = new FormData();
      fd.append('action',     'oria_lead_form');
      fd.append('nonce',      opData.nonce);
      fd.append('name',       'Email Bar Lead');
      fd.append('email',      emailInput.value);
      fd.append('sport',      '');
      fd.append('message',    '');
      fd.append('source_url', window.location.href);

      fetch(opData.ajaxUrl, { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) {
            leadBar.innerHTML = '<div style="text-align:center;width:100%;color:#fff;font-weight:700;font-size:15px">🎉 Great! Our designer will email you within 24 hours.</div>';
            setCookie('oria_bar_closed', '1', 30);
            if (data.data && data.data.redirect) {
              setTimeout(function () { window.location.href = data.data.redirect; }, 2000);
            }
          }
        })
        .catch(function () { /* silent fail */ });
    });
  }

  /* ═══════════════════════════════════════════════════════
     EXIT-INTENT POPUP
     Triggers when mouse leaves the browser window upward.
     Cookie-gated — shows once every 7 days.
  ═══════════════════════════════════════════════════════ */
  var exitPopup   = document.getElementById('oria-exit-popup');
  var popupClose  = document.getElementById('oria-popup-close');
  var popupBackdrop = document.getElementById('oria-popup-backdrop');
  var exitPopupShown = false;

  function showExitPopup() {
    if (!exitPopup || exitPopupShown || getCookie('oria_popup_shown')) return;
    exitPopupShown = true;
    exitPopup.hidden = false;
    document.body.style.overflow = 'hidden';
    setCookie('oria_popup_shown', '1', 7);
  }

  function closeExitPopup() {
    if (!exitPopup) return;
    exitPopup.hidden = true;
    document.body.style.overflow = '';
  }

  // Desktop: mouse exits through top of browser chrome
  document.addEventListener('mouseleave', function (e) {
    if (e.clientY <= 20) showExitPopup();
  });

  // Mobile: show after 60 seconds of inactivity (can't detect exit on mobile)
  if (/Mobi|Android/i.test(navigator.userAgent)) {
    setTimeout(showExitPopup, 60000);
  }

  if (popupClose) popupClose.addEventListener('click', closeExitPopup);
  if (popupBackdrop) popupBackdrop.addEventListener('click', closeExitPopup);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeExitPopup();
  });

  /* ═══════════════════════════════════════════════════════
     GENERIC LEAD FORM HANDLER
     Works on any <form class="oria-lead-form">:
       name, email, sport, message, source_url fields.
     Shows inline success/error message and optionally
     redirects to /thank-you/ on success.
  ═══════════════════════════════════════════════════════ */
  function handleLeadForm(form) {
    if (!form || typeof opData === 'undefined') return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var btn     = form.querySelector('[type="submit"]');
      var msgEl   = form.querySelector('.oria-lead-form__msg');
      var origText = btn ? btn.textContent : '';

      if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

      var fd = new FormData(form);
      fd.append('action', 'oria_lead_form');
      fd.append('nonce',  opData.nonce);

      fetch(opData.ajaxUrl, { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (msgEl) {
            msgEl.hidden = false;
            msgEl.textContent = data.data ? data.data.message : (data.success ? '🎉 Request received!' : 'Something went wrong.');
            msgEl.className = 'oria-lead-form__msg ' + (data.success ? 'is-success' : 'is-error');
          }
          if (data.success) {
            form.reset();
            // Redirect to thank-you page after short delay
            if (data.data && data.data.redirect) {
              setTimeout(function () { window.location.href = data.data.redirect; }, 1500);
            }
          }
        })
        .catch(function () {
          if (msgEl) {
            msgEl.hidden = false;
            msgEl.textContent = 'Something went wrong. Please try again or WhatsApp us directly.';
            msgEl.className = 'oria-lead-form__msg is-error';
          }
        })
        .finally(function () {
          if (btn) { btn.disabled = false; btn.textContent = origText; }
        });
    });
  }

  // Attach to exit popup form
  handleLeadForm(document.getElementById('oria-popup-form'));

  // Attach to all CTA section inline forms
  document.querySelectorAll('.oria-lead-form').forEach(function (form) {
    // Skip exit popup (handled above) and bar form (handled above)
    if (form.id === 'oria-popup-form' || form.id === 'oria-bar-form') return;
    handleLeadForm(form);
  });

})();
