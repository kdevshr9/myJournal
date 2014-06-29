$(document).ready(function() {
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd'
    });

    $('.editor').editable({
        inlineMode: false,
        minHeight: 200,
        spellcheck: true,
        imageMove: true,
        placeholder: "Start writting your journal"
    });

    $('.ui.dropdown').dropdown({
        on: 'hover'
    });
});