document.addEventListener('DOMContentLoaded', async function () {
    const modalContainer = document.getElementById('modalContainer');
    const calendarEl     = document.getElementById('calendar');

    // Captura de submit para update-reserva
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.action.includes('update-reserva')) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(json => {
                    if (json.success) {
                        closeModal();
                        calendar.refetchEvents();
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
                const inputId = document.getElementById('reserva-id');
                if (inputId) inputId.remove();
                document.querySelector('.btn-close-modal').addEventListener('click', closeModal);
            });
    };
    // Inicializa o FullCalendar UMA ÚNICA VEZ
    const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,dayGridWeek,dayGridDay'
        },
        initialView:  'dayGridMonth',
        locale:       'pt-br',
        navLinks:     true,
        selectable:   true,
        selectMirror: true,
        editable:     true,

        // Atualizado: abre edição em nova aba ao clicar no evento
        eventClick: function(info) {
            window.open(
                'index.php?action=edit-reserva&id=' + encodeURIComponent(info.event.id),
                '_blank'
            );
        },

        dateClick: function () {
            openModal();
        },
        eventContent: function (info) {
            return { html: `<div class="fc-event-title">${info.event.title}</div>` };
        },

        //Configura tooltip ao passar o mouse
        eventMouseEnter: function(info) {
            const tooltip = document.createElement('div');
            tooltip.className = 'fc-tooltip';
            tooltip.innerHTML = `
                <strong>${info.event.title}</strong><br>
                Espaço: ${info.event.extendedProps.espaco || ''}<br>
                Usuário: ${info.event.extendedProps.usuario || ''}<br>
                Início: ${info.event.start.toLocaleString()}<br>
                Fim: ${info.event.end.toLocaleString()}<br>
                Obs: ${info.event.extendedProps.observacao || '—'}
            `;
            document.body.appendChild(tooltip);
            info.el.addEventListener('mousemove', function(e) {
                tooltip.style.left = (e.pageX + 10) + 'px';
                tooltip.style.top  = (e.pageY + 10) + 'px';
            });
        },
        eventMouseLeave: function(info) {
            document.querySelectorAll('.fc-tooltip').forEach(el => el.remove());
        }
    });

    calendar.render();

    // Carrega eventos via AJAX (read-reserva) e adiciona ao calendário
    try {
        const res  = await fetch('index.php?action=read-reserva');
        const json = await res.json();
        const eventos = json.reservas.map(reserva => {
            const inicio = reserva.inicio_reserva.substring(11, 16);
            const fim    = reserva.fim_reserva.substring(11, 16);
            return {
                id: reserva.id,
                title: `${reserva.nome} ${inicio}~${fim}`,
                start: reserva.inicio_reserva,
                end:   reserva.fim_reserva,
                extendedProps: {
                    espaco_id:     reserva.espaco_id,
                    evento_id:     reserva.evento_id,
                    disciplina_id: reserva.disciplina_id,
                    observacao:    reserva.observacao,
                    data:          reserva.data,
                    espaco:        reserva.espaco,    // caso JSON retorne
                    usuario:       reserva.nome_usuario // idem
                }
            };
        });

        calendar.addEventSource(eventos);

        // Popula Lista de Reservas do Dia
        const hoje = new Date().toISOString().slice(0, 10);
        const reservasHoje = json.reservas.filter(r => r.inicio_reserva.startsWith(hoje));
        const cont = document.querySelector('#lista-reservas');
        if (cont) {
            if (!reservasHoje.length) cont.innerHTML = `<p>Nenhuma reserva para hoje.</p>`;
            else {
                let html = '<ul>';
                reservasHoje.forEach(r => {
                    const ini = r.inicio_reserva.substring(11, 16);
                    const fi  = r.fim_reserva.substring(11, 16);
                    html += `<li><b>${r.nome}</b>: ${ini} - ${fi}</li>`;
                });
                cont.innerHTML = html + '</ul>';
            }
        }

    } catch (err) {
        console.error('Erro ao carregar eventos:', err);
    }
});
