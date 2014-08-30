$(document).ready(function() {
    $(".datepicker").each(function() {
        $('.datepicker').pickadate({
            format: 'yyyy-mm-dd'
        });
    });

    $(".editor").each(function() {
        $('.editor').editable({
            inlineMode: false,
            minHeight: 200,
            spellcheck: true,
            imageMove: true,
            placeholder: "Start writting your journal"
        });
    });

    $('.ui.dropdown').dropdown({
        on: 'hover'
    });

    $('.popup').popup({
        position : 'bottom right'
    });
});