$(document).ready(function() {
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd'
    });
    
    $('.editor').editable({
        inlineMode: true,
        minHeight: 200,
        spellcheck: true,
        placeholder: "Start writting your journal"
    });
});