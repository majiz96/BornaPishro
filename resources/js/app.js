import * as bootstrap from 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

import '@jalali-js/web';
import '@jalali-js/web/date-picker.css';

import { fromGregorian } from 'jalali-js';


// ======================================================
// Jalali Date Picker
// ======================================================

function initJalaliDatePickers() {

    document.querySelectorAll('[data-jalali-date-picker-wrapper]').forEach((wrapper) => {

        if (wrapper.querySelector('jalali-date-picker')) {
            return;
        }

        const value = wrapper.dataset.value;

        const picker = document.createElement('jalali-date-picker');

        picker.id = 'date_picker';
        picker.setAttribute('system', 'jalali');
        picker.setAttribute('locale', 'fa');

        if (value) {

            const [year, month, day] = value
                .split('-')
                .map(Number);

            const date = fromGregorian(
                { year, month, day },
                'jalali'
            );

            picker.defaultDate = {
                precision: 'date',
                system: 'jalali',
                year: date.year,
                month: date.month,
                day: date.day
            };
        }

        wrapper.appendChild(picker);
    });
}

document.addEventListener(
    'livewire:navigated',
    () => {
        initJalaliDatePickers();
    }
);

Livewire.on('date-picker-set', ({ value }) => {

    const wrapper = document.querySelector(
        '[data-jalali-date-picker-wrapper]'
    );

    if (!wrapper || !value) {
        return;
    }

    const [year, month, day] = value
        .split('-')
        .map(Number);

    const date = fromGregorian(
        { year, month, day },
        'jalali'
    );

    const oldPicker = wrapper.querySelector(
        'jalali-date-picker'
    );

    const picker = document.createElement(
        'jalali-date-picker'
    );

    picker.id = 'date_picker';
    picker.setAttribute('system', 'jalali');
    picker.setAttribute('locale', 'fa');

    picker.defaultDate = {
        precision: 'date',
        system: 'jalali',
        year: date.year,
        month: date.month,
        day: date.day
    };

    oldPicker?.remove();

    wrapper.appendChild(picker);

});

// Fix initial popup position
document.addEventListener('click', (event) => {

    const input = event.target.closest('[data-jalali-datepicker-input]');

    if (!input) {
        return;
    }

    requestAnimationFrame(() => {
        window.dispatchEvent(new Event('resize'));
    });

});


// Send Gregorian value to Livewire
document.addEventListener('change', (event) => {

    const picker = event.target.closest('jalali-date-picker');

    if (!picker) {
        return;
    }

    const value = event.detail.value;

    const component = picker.closest('[wire\\:id]');

    if (!component) {
        return;
    }

    Livewire.find(
        component.getAttribute('wire:id')
    ).set(
        'date_picker',
        value
    );

});

import $ from 'jquery';

window.$ = $;
window.jQuery = $;

$.now = Date.now;

import 'summernote/dist/summernote-bs5.js';
import 'summernote/dist/summernote-bs5.css';


// Bootstrap 5 ↔ Summernote compatibility
$.fn.modal = function (action) {

    return this.each(function () {

        const element = this;

        if (action === 'show') {

            if (element.parentElement !== document.body) {
                document.body.appendChild(element);
            }

            const modal = bootstrap.Modal.getOrCreateInstance(element);

            modal.show();

        }

        else if (action === 'hide') {

            const modal = bootstrap.Modal.getInstance(element);

            if (modal) {
                modal.hide();
            }

        }

        else if (action === 'toggle') {

            const modal = bootstrap.Modal.getOrCreateInstance(element);

            modal.toggle();

        }

    });

};


// ======================================================
// Summernote
// ======================================================

function initSummernote() {

    const editor = $('#summernote');

    if (!editor.length) {
        return;
    }

    // اگر قبلاً ساخته شده، دوباره نساز
    if (editor.next('.note-editor').length) {
        return;
    }

    console.log('🔥 INIT SUMMERNOTE');

    editor.summernote({

        height: 300,

        tooltip: false,

        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],

        callbacks: {

            // ==================================================
            // Image Upload
            // ==================================================

            onImageUpload: function (files) {

                const file = files[0];

                if (!file) {
                    return;
                }

                console.log('🔥 SUMMERNOTE IMAGE:', file);

                // خود textarea داخل wire:ignore است
                // پس والد Livewire را از DOM پیدا می‌کنیم
                const componentElement =
                    document.querySelector(
                        '#summernote'
                    )?.closest('[wire\\:id]')
                    ??
                    document.querySelector(
                        '#summernote'
                    )?.closest('[wire\\:id]')
                    ??
                    null;

                if (!componentElement) {

                    console.error(
                        '🔥 Livewire component not found'
                    );

                    return;
                }

                const component = Livewire.find(
                    componentElement.getAttribute('wire:id')
                );

                if (!component) {

                    console.error(
                        '🔥 Livewire component instance not found'
                    );

                    return;
                }

                console.log(
                    '🔥 COMPONENT:',
                    component.name
                );

                component.upload(
                    'summernoteImage',
                    file,

                    () => {

                        console.log(
                            '🔥 Upload finished'
                        );

                        component.call(
                            'uploadSummernoteImage'
                        );

                    },

                    (error) => {

                        console.error(
                            '🔥 Upload error:',
                            error
                        );

                    },

                    (event) => {

                        console.log(
                            '🔥 Upload progress:',
                            event.detail.progress
                        );

                    }
                );
            },


            // ==================================================
            // Content Changed
            // ==================================================

            onChange: function (contents) {

                const componentElement =
                    document
                        .querySelector('#summernote')
                        ?.closest('[wire\\:id]');

                if (!componentElement) {
                    return;
                }

                const component = Livewire.find(
                    componentElement.getAttribute('wire:id')
                );

                if (!component) {
                    return;
                }

                component.set(
                    'content',
                    contents
                );

            }

        }

    });

    console.log(
        '🔥 SUMMERNOTE CREATED'
    );
}


// ======================================================
// Livewire navigation
// ======================================================

document.addEventListener(
    'livewire:navigated',
    () => {

        console.log(
            '🔥 LIVEWIRE NAVIGATED'
        );

        // کمی صبر می‌کنیم تا DOM نهایی شود
        setTimeout(() => {

            initSummernote();

        }, 0);

    }
);


// ======================================================
// Fill editor
// ======================================================

Livewire.on(
    'summernote-fill',
    ({ content }) => {

        const editor = $('#summernote');

        if (!editor.length) {
            return;
        }

        if (!editor.next('.note-editor').length) {
            initSummernote();
        }

        editor.summernote(
            'code',
            content ?? ''
        );

    }
);


// ======================================================
// Insert uploaded image
// ======================================================

Livewire.on(
    'summernote-image-uploaded',
    ({ url }) => {

        const editor = $('#summernote');

        if (!editor.length) {
            return;
        }

        if (!editor.next('.note-editor').length) {
            initSummernote();
        }

        editor.summernote(
            'insertImage',
            url
        );

    }
);
