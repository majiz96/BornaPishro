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

        const modal = bootstrap.Modal.getOrCreateInstance(this);

        if (action === 'show') {
            modal.show();
        }

        if (action === 'hide') {
            modal.hide();
        }

        if (action === 'toggle') {
            modal.toggle();
        }

    });

};


$(document).ready(function () {

    $('#summernote').summernote({

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

            onChange: function (contents) {

                Livewire.dispatch('summernote-updated', {
                    content: contents
                });

            }

        }

    });


    Livewire.on('summernote-fill', ({ content }) => {

        $('#summernote').summernote('code', content);

    });

});
