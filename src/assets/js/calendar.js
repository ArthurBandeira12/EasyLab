document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        navLinks: true,
        selectable: true,
        selectMirror: true,
        editable: true,
        eventLimit: true,
        dateClick: function (info) {
            openModal()
        },
        eventClick: function (info) {
        },
        events: 'index-reserva.php',
    });
    calendar.render();

    const modal = document.getElementById('modal');

    const closeModal = () => {
        document.getElementById('modal').remove();
        document.body.classList.remove('no-scroll');

    }
    const openModal = () => {
        fetch('index.php?action=list-reserva')
            .then(res => res.text())
            .then(html => {
                document.getElementById('modalContainer').innerHTML = html;
                document.body.classList.add('no-scroll');

                document.querySelector('.btn-close-modal').addEventListener('click', closeModal);
            });
    }
});
