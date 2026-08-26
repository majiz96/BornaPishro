import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';

import $ from 'jquery';

window.$ = $;
window.jQuery = $;

$.now = Date.now;

import 'summernote/dist/summernote-bs5.js';
import 'summernote/dist/summernote-bs5.css';

$(document).ready(function ()
{
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
        callbacks:
        {
            onChange: function (contents)
            {
                Livewire.dispatch('summernote-updated',
                    {
                    content: contents
                    });
            }
        }
    });

    Livewire.on('summernote-fill', ({ content }) => {
        $('#summernote').summernote('code', content);
    });
});
