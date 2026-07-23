/**
 * Oria Patel — Product Manager Admin JS
 * Handles: media uploader, gallery, tabs, tag preview, preset chips.
 */
(function ($) {
	'use strict';

	/* ─── Tab switching ──────────────────────────────────────── */
	$(document).on('click', '.opm-tab', function () {
		const $tabs = $(this).closest('.opm-tabs');
		const $card = $tabs.closest('.opm-card');
		const tabId = $(this).data('tab');

		$tabs.find('.opm-tab').removeClass('is-active');
		$(this).addClass('is-active');
		$card.find('.opm-tab-panel').removeClass('is-active');
		$card.find('#tab-' + tabId).addClass('is-active');
	});

	/* ─── Tag preview (comma-separated inputs) ───────────────── */
	function updateTagPreview($input) {
		const previewId = $input.attr('id').replace('-input', '-preview');
		const $preview  = $('#' + previewId);
		if (!$preview.length) return;

		const raw  = $input.val().trim();
		const tags = raw ? raw.split(',').map(t => t.trim()).filter(Boolean) : [];
		$preview.empty();
		tags.forEach(function (tag) {
			$preview.append('<span class="opm-tag">' + $('<span>').text(tag).html() + '</span>');
		});
	}

	$('.opm-input[id$="-input"]').each(function () { updateTagPreview($(this)); });
	$(document).on('input', '.opm-input[id$="-input"]', function () { updateTagPreview($(this)); });

	/* ─── Preset chip helpers (called inline) ────────────────── */
	window.opmAddToField = function (fieldId, value) {
		const $f   = $('#' + fieldId);
		const curr = $f.val().trim();
		const tags = curr ? curr.split(',').map(t => t.trim()).filter(Boolean) : [];
		if (!tags.includes(value)) {
			tags.push(value);
			$f.val(tags.join(', ')).trigger('input');
		}
	};

	window.opmSetField = function (fieldId, value) {
		$('#' + fieldId).val(value).trigger('input');
	};

	/* ─── WordPress Media Uploader helper ────────────────────── */
	function openMediaPicker(options) {
		if (!wp || !wp.media) return;
		const frame = wp.media({
			title:    options.title    || opmData.uploadTitle,
			button:   { text: options.button || opmData.uploadButton },
			multiple: options.multiple || false,
		});
		frame.on('select', function () {
			if (options.multiple) {
				const selection = frame.state().get('selection').toJSON();
				options.onSelect(selection);
			} else {
				const attachment = frame.state().get('selection').first().toJSON();
				options.onSelect(attachment);
			}
		});
		frame.open();
	}

	/* ─── Featured image (product) ───────────────────────────── */
	$('#opm-thumb-btn').on('click', function () {
		openMediaPicker({
			title:  opmData.uploadTitle,
			button: opmData.uploadButton,
			onSelect: function (att) {
				const url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
				$('#opm-thumb-id').val(att.id);
				$('#opm-thumb-placeholder').hide();
				if ($('#opm-thumb-preview').length) {
					$('#opm-thumb-preview').attr('src', url).show();
				} else {
					$('#opm-thumb-uploader').prepend('<img id="opm-thumb-preview" src="' + url + '" class="opm-image-uploader__preview" alt="">');
				}
				$('#opm-thumb-btn').text('🔄 Change Photo');
				$('#opm-thumb-remove').show();
			}
		});
	});

	$('#opm-thumb-remove').on('click', function () {
		$('#opm-thumb-id').val('');
		$('#opm-thumb-preview').remove();
		$('#opm-thumb-placeholder').show();
		$(this).hide();
		$('#opm-thumb-btn').text('⬆️ Upload Photo');
	});

	/* ─── Featured image (category) ─────────────────────────── */
	$('#opm-cat-thumb-btn').on('click', function () {
		openMediaPicker({
			title:  opmData.uploadTitle,
			button: opmData.uploadButton,
			onSelect: function (att) {
				const url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
				$('#opm-cat-thumb-id').val(att.id);
				$('#opm-cat-thumb-placeholder').hide();
				if ($('#opm-cat-thumb-preview').length) {
					$('#opm-cat-thumb-preview').attr('src', url).show();
				} else {
					$('#opm-cat-thumb-uploader').prepend('<img id="opm-cat-thumb-preview" src="' + url + '" class="opm-image-uploader__preview" alt="">');
				}
				$('#opm-cat-thumb-btn').text('🔄 Change Photo');
				$('#opm-cat-thumb-remove').show();
			}
		});
	});

	$('#opm-cat-thumb-remove').on('click', function () {
		$('#opm-cat-thumb-id').val('');
		$('#opm-cat-thumb-preview').remove();
		$('#opm-cat-thumb-placeholder').show();
		$(this).hide();
		$('#opm-cat-thumb-btn').text('⬆️ Upload Photo');
	});

	/* ─── Product gallery ────────────────────────────────────── */
	function syncGalleryIds() {
		const ids = [];
		$('#opm-gallery-grid .opm-gallery-item').each(function () {
			ids.push($(this).data('id'));
		});
		$('#opm-gallery-ids').val(ids.join(','));
	}

	window.opmRemoveGalleryItem = function (btn) {
		$(btn).closest('.opm-gallery-item').remove();
		syncGalleryIds();
	};

	$('#opm-gallery-btn').on('click', function () {
		openMediaPicker({
			title:    opmData.galleryTitle,
			button:   opmData.galleryButton,
			multiple: true,
			onSelect: function (attachments) {
				attachments.forEach(function (att) {
					const existing = $('#opm-gallery-grid .opm-gallery-item[data-id="' + att.id + '"]');
					if (existing.length) return; // skip duplicates

					const url = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
					const item = $('<div class="opm-gallery-item" data-id="' + att.id + '">'
						+ '<img src="' + url + '" alt="">'
						+ '<button type="button" class="opm-gallery-item__remove" onclick="opmRemoveGalleryItem(this)">×</button>'
						+ '</div>');
					$('#opm-gallery-grid').append(item);
				});
				syncGalleryIds();
			}
		});
	});

	/* ─── Confirm before leaving with unsaved changes ────────── */
	let formDirty = false;
	$('#opm-product-form, .opm-cat-form').on('input change', function () { formDirty = true; });
	$('#opm-product-form, .opm-cat-form').on('submit', function () { formDirty = false; });
	$(window).on('beforeunload', function () {
		if (formDirty) return 'You have unsaved changes. Are you sure you want to leave?';
	});

	/* ─── Auto-slug from name (category form) ────────────────── */
	$('input[name="cat_name"]').on('input', function () {
		const $slug = $('input[name="cat_slug"]');
		if ($slug.data('manually-set')) return;
		$slug.val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
	});
	$('input[name="cat_slug"]').on('input', function () {
		$(this).data('manually-set', $(this).val() !== '');
	});

})(jQuery);
