import $ from "./dom";

window.onload = () => {
    let $verticalListTrigger = $('.s-vertical-list__title.s-trigger');


    $verticalListTrigger.each(function() {
        let el = $(this);
        if (el.next().find(".s-active").length > 0) {
            el.addClass("s-active");
            el.next().toggleClass("s-active");
            el.find(".mdi-chevron-up").toggleClass("mdi-rotate-180");
        }
    });



    $verticalListTrigger.on('click', function () {
        this.nextElementSibling.classList.toggle('s-active');
        this.querySelector('.mdi-chevron-up').classList.toggle('mdi-rotate-180');
    });

    $('#app').on('click', '.burger, .burger > span', function () {
        $('.burger').toggleClass('s-active');
        let $sidebar = $('.s-sidebar')[0];
        $sidebar.classList.toggle('s-close');

        /*let logout = document.getElementById('logout');
        if (logout.classList.contains('is-extended')) {
            logout.classList.replace('btn-primary', 'btn-primary-text');
            logout.classList.replace('is-extended', 'btn-icon');
        } else {
            logout.classList.replace('btn-icon', 'is-extended');
            logout.classList.replace('btn-primary-text', 'btn-primary');
        }*/
    });

};

