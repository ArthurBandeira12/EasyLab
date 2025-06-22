document.addEventListener('DOMContentLoaded', async function () {
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
            openModal()
        },
        events: '',

        eventContent: function (info) {
            return {
                html: `<div class="fc-event-title">${info.event.title}</div>`
            };
        }
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

    try {
        fetch('index.php?action=read-reserva')
            .then(res => res.json())
            .then(json => {

                console.log(json)
                const eventos = json.reservas.map(function (reserva) {
                    const inicio = reserva.inicio_reserva.substring(11, 16);
                    const fim = reserva.fim_reserva.substring(11, 16);

                    return {
                        "title": `${reserva.nome} ${inicio} ~ ${fim}`,
                        "start": reserva.inicio_reserva,
                        "end": reserva.fim_reserva
                    }
                });

                calendar.addEventSource(eventos);
            });
    } catch (error) {
        console.log('Erro ao carregar eventos:', error);
    }
});
