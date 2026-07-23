/**
 * Reviews JS — Oria Patel Theme
 * Star picker interaction, read-more toggles, form validation.
 */
(function () {
  'use strict';

  /* ── Star picker ─────────────────────────────────────────── */
  document.querySelectorAll('.oria-star-picker').forEach(function (picker) {
    var labels = picker.querySelectorAll('.oria-star-pick');
    var inputs = picker.querySelectorAll('input[type="radio"]');

    labels.forEach(function (label, idx) {
      label.addEventListener('mouseenter', function () {
        highlight(labels, idx);
      });
      label.addEventListener('mouseleave', function () {
        var checked = getCheckedIndex(inputs);
        highlight(labels, checked);
      });
      var input = label.querySelector('input');
      if (input) {
        input.addEventListener('change', function () {
          highlight(labels, idx);
        });
      }
    });

    // Keyboard accessibility
    picker.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowRight' || e.key === 'ArrowUp') {
        e.preventDefault();
        var ci = getCheckedIndex(inputs);
        var next = Math.min(inputs.length - 1, ci + 1);
        inputs[next].checked = true;
        highlight(labels, next);
      }
      if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') {
        e.preventDefault();
        var ci = getCheckedIndex(inputs);
        var prev = Math.max(0, ci - 1);
        inputs[prev].checked = true;
        highlight(labels, prev);
      }
    });
  });

  function highlight(labels, upTo) {
    labels.forEach(function (lbl, i) {
      var span = lbl.querySelector('span');
      if (!span) return;
      if (upTo >= 0 && i <= upTo) {
        lbl.classList.add('is-active');
        span.style.color = '#F3A847';
      } else {
        lbl.classList.remove('is-active');
        span.style.color = '';
      }
    });
  }

  function getCheckedIndex(inputs) {
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].checked) return i;
    }
    return -1;
  }

  /* ── Read-more toggles on review cards ──────────────────── */
  document.querySelectorAll('.oria-review-card__toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var card    = btn.closest('.oria-review-card__content');
      var full    = card && card.querySelector('.oria-review-card__full');
      var excerpt = card && card.querySelector('.oria-review-card__excerpt');
      var ellipsis = card && card.querySelector('.oria-review-card__ellipsis');
      var expanded = btn.getAttribute('aria-expanded') === 'true';

      if (expanded) {
        if (full)    full.hidden    = true;
        if (excerpt) excerpt.hidden = false;
        if (ellipsis) ellipsis.hidden = false;
        btn.textContent     = btn.dataset.more || 'Read more';
        btn.setAttribute('aria-expanded', 'false');
      } else {
        if (full)    full.hidden    = false;
        if (excerpt) excerpt.hidden = true;
        if (ellipsis) ellipsis.hidden = true;
        btn.dataset.more    = btn.textContent;
        btn.textContent     = 'Read less';
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });

  /* ── Basic form validation ──────────────────────────────── */
  var form = document.querySelector('.oria-review-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      var rating = form.querySelector('input[name="star_rating"]:checked');
      if (!rating) {
        e.preventDefault();
        var picker = form.querySelector('.oria-star-picker');
        if (picker) {
          picker.style.outline = '2px solid #C0392B';
          picker.style.borderRadius = '4px';
          picker.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        alert('Please select a star rating before submitting.');
        return false;
      }
    });
  }

  /* ── Sort select redirect ───────────────────────────────── */
  // (Already handled inline via onchange in PHP template — JS fallback)
  var sortSelect = document.getElementById('oria-sort-select');
  if (sortSelect) {
    sortSelect.addEventListener('change', function () {
      if (this.value) window.location.href = this.value;
    });
  }

})();
