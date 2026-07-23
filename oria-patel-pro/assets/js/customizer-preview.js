/**
 * Customizer live-preview bindings (postMessage transport).
 * Keeps the preview pane up-to-date without a full page refresh.
 */

(function ($) {
  'use strict';

  /* ─── Helper ─────────────────────────────────────────────────────────── */
  function bind(settingId, callback) {
    wp.customize(settingId, function (value) {
      value.bind(callback);
    });
  }

  function setCSSVar(varName, value) {
    document.documentElement.style.setProperty(varName, value);
  }

  /* ─── Colors ─────────────────────────────────────────────────────────── */
  bind('op_color_primary', function (val) { setCSSVar('--op-color-primary', val); });
  bind('op_color_accent',  function (val) { setCSSVar('--op-color-accent',  val); });
  bind('op_color_link',    function (val) { setCSSVar('--op-color-link',    val); });
  bind('op_color_muted',   function (val) { setCSSVar('--op-color-muted',   val); });

  /* ─── Top bar items ──────────────────────────────────────────────────── */
  for (var i = 1; i <= 4; i++) {
    (function (idx) {
      bind('op_topbar_item_' + idx, function (val) {
        var items = document.querySelectorAll('.op-topbar__item');
        if (items[idx - 1])     items[idx - 1].lastChild.textContent = ' ' + val;
        if (items[idx - 1 + 4]) items[idx - 1 + 4].lastChild.textContent = ' ' + val; // duplicate
      });
    })(i);
  }

  /* ─── Hero content ───────────────────────────────────────────────────── */
  bind('op_hero_badge', function (val) {
    var el = document.querySelector('.op-hero__badge');
    if (el) el.textContent = val;
  });

  bind('op_hero_title', function (val) {
    var titleEl = document.querySelector('.op-hero__title');
    if (!titleEl) return;
    var accentVal = wp.customize('op_hero_accent_word') ? wp.customize('op_hero_accent_word').get() : '';
    if (accentVal && val.indexOf(accentVal) !== -1) {
      titleEl.innerHTML = val.replace(accentVal, '<span>' + accentVal + '</span>');
    } else {
      titleEl.textContent = val;
    }
  });

  bind('op_hero_accent_word', function (val) {
    var titleEl = document.querySelector('.op-hero__title');
    if (!titleEl) return;
    var titleVal = wp.customize('op_hero_title') ? wp.customize('op_hero_title').get() : titleEl.textContent;
    if (val && titleVal.indexOf(val) !== -1) {
      titleEl.innerHTML = titleVal.replace(val, '<span>' + val + '</span>');
    } else {
      titleEl.textContent = titleVal;
    }
  });

  bind('op_hero_desc', function (val) {
    var el = document.querySelector('.op-hero__desc');
    if (el) el.textContent = val;
  });

  bind('op_hero_cta1_text', function (val) {
    var el = document.querySelector('.op-hero__actions .op-btn--primary');
    if (el) el.textContent = val;
  });

  bind('op_hero_cta1_url', function (val) {
    var el = document.querySelector('.op-hero__actions .op-btn--primary');
    if (el) el.href = val;
  });

  bind('op_hero_cta2_text', function (val) {
    var el = document.querySelector('.op-hero__actions .op-btn--ghost');
    if (el) el.textContent = val;
  });

  /* ─── Value props ────────────────────────────────────────────────────── */
  for (var p = 1; p <= 4; p++) {
    (function (idx) {
      bind('op_prop_' + idx + '_icon', function (val) {
        var el = document.querySelectorAll('.op-value-prop__icon')[idx - 1];
        if (el) el.textContent = val;
      });
      bind('op_prop_' + idx + '_title', function (val) {
        var el = document.querySelectorAll('.op-value-prop__title')[idx - 1];
        if (el) el.textContent = val;
      });
      bind('op_prop_' + idx + '_desc', function (val) {
        var el = document.querySelectorAll('.op-value-prop__desc')[idx - 1];
        if (el) el.textContent = val;
      });
    })(p);
  }

  /* ─── Category labels ────────────────────────────────────────────────── */
  for (var c = 1; c <= 8; c++) {
    (function (idx) {
      bind('op_cat_' + idx + '_label', function (val) {
        var labels = document.querySelectorAll('.op-category-card__label');
        if (labels[idx - 1]) labels[idx - 1].textContent = val;
      });
      bind('op_cat_' + idx + '_url', function (val) {
        var cards = document.querySelectorAll('.op-category-card');
        if (cards[idx - 1]) cards[idx - 1].href = val;
      });
    })(c);
  }

  /* ─── Stats ──────────────────────────────────────────────────────────── */
  for (var s = 1; s <= 4; s++) {
    (function (idx) {
      bind('op_stat_' + idx + '_icon', function (val) {
        var el = document.querySelectorAll('.op-stat__icon')[idx - 1];
        if (el) el.textContent = val;
      });
      bind('op_stat_' + idx + '_value', function (val) {
        var el = document.querySelectorAll('.op-stat__value')[idx - 1];
        if (el) { el.textContent = val; el.setAttribute('data-count', val); }
      });
      bind('op_stat_' + idx + '_label', function (val) {
        var el = document.querySelectorAll('.op-stat__label')[idx - 1];
        if (el) el.textContent = val;
      });
    })(s);
  }

  /* ─── How It Works ───────────────────────────────────────────────────── */
  for (var st = 1; st <= 3; st++) {
    (function (idx) {
      bind('op_step_' + idx + '_title', function (val) {
        var el = document.querySelectorAll('.op-step__title')[idx - 1];
        if (el) el.textContent = val;
      });
      bind('op_step_' + idx + '_desc', function (val) {
        var el = document.querySelectorAll('.op-step__desc')[idx - 1];
        if (el) el.textContent = val;
      });
    })(st);
  }

  /* ─── Footer tagline & copyright ─────────────────────────────────────── */
  bind('op_footer_tagline', function (val) {
    var el = document.querySelector('.op-footer__tagline');
    if (el) el.textContent = val;
  });
  bind('op_footer_copyright', function (val) {
    var el = document.querySelector('.op-footer__bottom p');
    if (el) el.textContent = val;
  });

  /* ─── Homepage section labels ─────────────────────────────────────────── */
  var sectionLabelMap = {
    'op_section_eyebrow_cats': '[data-op-setting="op_section_eyebrow_cats"]',
    'op_section_title_cats':   '[data-op-setting="op_section_title_cats"]',
    'op_section_eyebrow_top':  '[data-op-setting="op_section_eyebrow_top"]',
    'op_section_title_top':    '[data-op-setting="op_section_title_top"]',
    'op_cta_banner_title':     '.op-cta-banner__title',
    'op_cta_banner_desc':      '.op-cta-banner__desc',
    'op_cta_btn1_text':        '.op-cta-banner__actions .op-btn--outline',
    'op_cta_btn2_text':        '.op-cta-banner__actions .op-btn--dark',
    'op_products_page_title':  '.op-page-header__title',
    'op_products_page_sub':    '.op-page-header__sub',
  };
  Object.keys(sectionLabelMap).forEach(function (key) {
    bind(key, function (val) {
      var el = document.querySelector(sectionLabelMap[key]);
      if (el) el.textContent = val;
    });
  });

})(jQuery);
