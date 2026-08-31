import * as bootstrap from 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

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

            // relate model to Summernote
            // Transfered to body directly
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


document.addEventListener('livewire:navigated', () => {

    console.log('🔥 LIVEWIRE NAVIGATED');

    const editor = $('#summernote');

    if (!editor.length) {
        console.log('🔥 Summernote element not found');
        return;
    }

    // جلوگیری از initialize شدن دوباره
    if ($('.note-editor').length) {
        console.log('🔥 Summernote already initialized');
        return;
    }

    console.log('🔥 BEFORE SUMMERNOTE:', editor.length);

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

            // 🖼️ Upload تصویر
            onImageUpload: function (files) {

                const file = files[0];

                console.log('🔥 Summernote file:', file);

                const component = window.Livewire
                    .all()
                    .find(component =>
                        component.name === 'dashboard.articles-management'
                    );

                console.log(
                    '🔥 Articles component:',
                    component
                );

                if (!component) {
                    console.error(
                        '🔥 Articles component not found!'
                    );

                    return;
                }

                component.$wire.upload(
                    'summernoteImage',
                    file,

                    // ✅ Upload finished
                    () => {

                        console.log(
                            '🔥 Upload finished'
                        );

                        component.$wire.call(
                            'uploadSummernoteImage'
                        );

                    },

                    // ❌ Upload error
                    (error) => {

                        console.error(
                            '🔥 Upload error:',
                            error
                        );

                    },

                    // 📊 Progress
                    (event) => {

                        console.log(
                            '🔥 Upload progress:',
                            event.detail.progress
                        );

                    }
                );
            },

            // ✏️ تغییر محتوا
            onChange: function (contents) {

                Livewire.dispatch(
                    'summernote-updated',
                    {
                        content: contents
                    }
                );

            }
        }
    });

    console.log(
        '🔥 AFTER SUMMERNOTE:',
        $('.note-editor').length
    );
});

Livewire.on('summernote-fill', ({ content }) => {

    const editor = $('#summernote');

    if (editor.length) {
        editor.summernote('code', content ?? '');
    }

});

Livewire.on('summernote-image-uploaded', ({ url }) => {

    $('#summernote').summernote('insertImage', url);

});
