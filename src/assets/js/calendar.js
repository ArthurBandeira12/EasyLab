document.addEventListener('DOMContentLoaded', async function () {
    const modalContainer = document.getElementById('modalContainer');
    const calendarEl = document.getElementById('calendar');

        document.addEventListener('submit', function (e) {
        const form = e.target;

        if (form.action.includes('update-reserva')) {
            e.preventDefault(); // impede envio normal

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(json => {
                if (json.success) {
                    closeModal();               // fecha o modal
                    calendar.refetchEvents();  // atualiza o calendário
                    alert('Reserva atualizada com sucesso!');
                } else {
                    alert('Erro: ' + json.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Erro inesperado ao atualizar a reserva.');
            });
        }
    });


    const closeModal = () => {
        modalContainer.innerHTML = '';
        document.body.classList.remove('no-scroll');
    };

    const openModal = () => {
        fetch('index.php?action=list-reserva')
            .then(res => res.text())
            .then(html => {
                modalContainer.innerHTML = html;
                document.body.classList.add('no-scroll');

                document.querySelector('.modal-title').textContent = 'Nova Reserva';
                document.querySelector('.btn-submit button').textContent = 'Adicionar reserva';

                const form = document.querySelector('form');
                form.action = 'index.php?action=create-reserva';
                form.reset();

                // Remover campo hidden id se estiver presente
                const inputId = document.getElementById('reserva-id');
                if (inputId) inputId.remove();

                document.querySelector('.btn-close-modal').addEventListener('click', closeModal);
            });
    };

    const openEditModal = (event) => {
        fetch('index.php?action=list-reserva')
            .then(res => res.text())
            .then(html => {
                modalContainer.innerHTML = html;
                document.body.classList.add('no-scroll');

                // Título e botão
                document.querySelector('.modal-title').textContent = 'Editar Reserva';
                document.querySelector('.btn-submit button').textContent = 'Salvar Alterações';

                const form = document.querySelector('form');
                form.action = 'index.php?action=update-reserva';

                // Adiciona input hidden com ID
                let inputId = document.getElementById('reserva-id');
                if (!inputId) {
                    inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = 'id';
                    inputId.id = 'reserva-id';
                    form.prepend(inputId);
                }
                inputId.value = event.id;

                // Preenche os campos
                document.getElementById('data').value = event.extendedProps.data;
                document.getElementById('inicio_reserva').value = event.startStr.substring(0, 16);
                document.getElementById('fim_reserva').value = event.endStr.substring(0, 16);
                document.getElementById('espaco_id').value = event.extendedProps.espaco_id;
                document.getElementById('evento_id').value = event.extendedProps.evento_id;
                document.getElementById('disciplina_id').value = event.extendedProps.disciplina_id;
                document.getElementById('observacao').value = event.extendedProps.observacao || '';

                document.querySelector('.btn-close-modal').addEventListener('click', closeModal);
            });
    };

    // Inicializa o calendário
    const calendar = new FullCalendar.Calendar(calendarEl, {
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
        eventClick: function (info) {
            console.log('Evento clicado:', info.event);
            openEditModal(info.event);
        },
        dateClick: function (info) {
            openModal();
        },
        eventContent: function (info) {
            return {
                html: `<div class="fc-event-title">${info.event.title}</div>`
            };
        }
    });

    calendar.render();

    try {
        const res = await fetch('index.php?action=read-reserva');
        const json = await res.json();
        const eventos = json.reservas.map(function (reserva) {
            const inicio = reserva.inicio_reserva.substring(11, 16);
            const fim = reserva.fim_reserva.substring(11, 16);

            return {
                id: reserva.id,
                title: `${reserva.nome} ${inicio} ~ ${fim}`,
                start: reserva.inicio_reserva,
                end: reserva.fim_reserva,
                extendedProps: {
                    espaco_id: reserva.espaco_id,
                    evento_id: reserva.evento_id,
                    disciplina_id: reserva.disciplina_id,
                    observacao: reserva.observacao,
                    data: reserva.data
                }
            };
        });

        calendar.addEventSource(eventos);

        // Mostra as reservas do dia atual
        const hoje = new Date().toISOString().slice(0, 10);
        const reservasHoje = json.reservas.filter(r => r.inicio_reserva.startsWith(hoje));
        const reservaContainer = document.querySelector('#lista-reservas');
        if (reservaContainer) {
            if (reservasHoje.length === 0) {
                reservaContainer.innerHTML = `<p>Nenhuma reserva para hoje.</p>`;
            } else {
                let html = `<ul>`;
                reservasHoje.forEach(r => {
                    const inicio = r.inicio_reserva.substring(11, 16);
                    const fim = r.fim_reserva.substring(11, 16);
                    html += `<li><b>${r.nome}</b>: ${inicio} - ${fim}</li>`;
                });
                html += `</ul>`;
                reservaContainer.innerHTML = html;
            }
        }

    } catch (error) {
        console.log('Erro ao carregar eventos:', error);
    }
});
