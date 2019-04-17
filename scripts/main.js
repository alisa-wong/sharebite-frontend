$(document).ready(() => {
    $('.section_button1').on('click', () => {
        $('.section_form').removeClass('hidden');
    });

    $('.close1').on('click', () => {
        $('.section_form').addClass('hidden');
    });

    $('.section_button2').on('click', () => {
        $('.items_form').removeClass('hidden');
    });

    $('.close2').on('click', () => {
        $('.items_form').addClass('hidden');
    });
})