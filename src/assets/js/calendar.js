document.addEventListener('DOMContentLoaded', async function () {
    const modalContainer = document.getElementById('modalContainer');
    const calendarEl     = document.getElementById('calendar');

    const closeModal = () => {
        modalContainer.innerHTML = '';
        document.body.classList.remove('no-scroll');
    };

    function mostrarModalConfirmacao(mensagem) {
        document.getElementById('mensagem-modal').textContent = mensagem;
        document.getElementById('modal-confirmacao').style.display = 'block';
    }

    // NOVO: modal de pergunta (confirm customizado)
    function mostrarModalPergunta(mensagem, callback) {
        const modal = document.getElementById('modal-pergunta');
        const msg   = document.getElementById('mensagem-pergunta');
        const btnSim = document.getElementById('btn-confirmar-sim');
        const btnNao = document.getElementById('btn-confirmar-nao');

        msg.textContent = mensagem;
        modal.style.display = 'flex';

        btnSim.onclick = () => {
            modal.style.display = 'none';
            callback(true);
        };
        btnNao.onclick = () => {
            modal.style.display = 'none';
            callback(false);
        };
    }

    const btnFecharConfirmacao = document.querySelector('#modal-confirmacao button');
    if (btnFecharConfirmacao) {
        btnFecharConfirmacao.addEventListener('click', function () {
            document.getElementById('modal-confirmacao').style.display = 'none';
        });
    }

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
                        mostrarModalConfirmacao('Reserva atualizada com sucesso!');
                    } else {
                        mostrarModalConfirmacao('Erro: ' + json.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    mostrarModalConfirmacao('Erro inesperado ao atualizar a reserva.');
                });
        }
    });

    function inicializarCampoData() {
        var dataInput = document.getElementById('data');
        if (dataInput) {
            var hoje = new Date();
            var yyyy = hoje.getFullYear();
            var mm = String(hoje.getMonth() + 1).padStart(2, '0');
            var dd = String(hoje.getDate()).padStart(2, '0');
            dataInput.value = yyyy + '-' + mm + '-' + dd;
        }
    }

    function inicializarFormularioReserva() {
        var dataInput = document.getElementById('data');
        if (dataInput && !dataInput.value) {
            var hoje = new Date();
            var yyyy = hoje.getFullYear();
            var mm = String(hoje.getMonth() + 1).padStart(2, '0');
            var dd = String(hoje.getDate()).padStart(2, '0');
            dataInput.value = yyyy + '-' + mm + '-' + dd;
        }

        var form = document.querySelector('#modal form');
        if (form) {
            form.addEventListener('submit', function(e) {
                var data = document.getElementById('data').value;
                var inicio = document.getElementById('inicio_hora').value;
                var fim = document.getElementById('fim_hora').value;
                document.getElementById('inicio_reserva').value = data + 'T' + inicio;
                document.getElementById('fim_reserva').value = data + 'T' + fim;
            }, { once: true });
        }
    }

    function openModal(dataSelecionada = null) {
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
                
                if (dataSelecionada) {
                    const dataInput = document.getElementById('data');
                    if (dataInput) dataInput.value = dataSelecionada;
                }
                inicializarFormularioReserva();
            });
    };

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

        eventClick: function(info) {
            window.location.href = 'index.php?action=edit-reserva&id=' + encodeURIComponent(info.event.id);
        },

        dateClick: function (info) {
            openModal(info.dateStr);
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

    try {
        const res  = await fetch('index.php?action=read-reserva');
        const json = await res.json();
        const eventos = json.reservas.map(reserva => {
            const inicio = reserva.inicio_reserva.substring(11, 16);
            const fim    = reserva.fim_reserva.substring(11, 16);
            return {
                id: reserva.id,
                title: `${reserva.evento_nome} ${inicio}~${fim}`,
                start: reserva.inicio_reserva,
                end:   reserva.fim_reserva,
                extendedProps: {
                    espaco_id:     reserva.espaco_id,
                    evento_id:     reserva.evento_id,
                    disciplina_id: reserva.disciplina_id,
                    observacao:    reserva.observacao,
                    data:          reserva.data,
                    espaco:        reserva.espaco_nome,
                    usuario:       reserva.nome_usuario
                }
            };
        });

        calendar.addEventSource(eventos);

        const hoje = new Date().toISOString().slice(0, 10);
        const reservasHoje = json.reservas.filter(r => r.inicio_reserva.startsWith(hoje));
        const cont = document.querySelector('#lista-reservas');

        if (cont) {
            if (!reservasHoje.length) {
                cont.innerHTML = `<p>Nenhuma reserva para hoje.</p>`;
            } else {
                let html = '<ul>';
                reservasHoje.forEach(r => {
                    const ini = r.inicio_reserva.substring(11, 16);
                    const fi = r.fim_reserva.substring(11, 16);
                    html += `<li><b>${r.evento_nome}</b>: ${ini} - ${fi} 
                    <button class="btn-confirmar" data-id="${r.id}">Confirmar</button></li>`; // Botão ao lado da reserva para confirmar a reserva
                });
                cont.innerHTML = html + '</ul>';

                // Configurações para confirmar reserva
                document.querySelectorAll('.btn-confirmar').forEach(botao => {
                    botao.addEventListener('click', function () {
                        const idReserva = this.dataset.id;
                        const botaoClicado = this;

                        mostrarModalPergunta("Tem certeza que deseja confirmar o uso da reserva?", async (confirmar) => {
                            if (!confirmar) return;

                            try {
                                const resposta = await fetch('index.php?action=confirm-reserva', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ id: idReserva })
                                });
                                
                                const resultado = await resposta.json();
                                console.log('Resposta:', resultado);

                                mostrarModalConfirmacao(resultado.message);

                                if (resultado.success) {
                                    botaoClicado.disabled = true;
                                    botaoClicado.textContent = 'Confirmado';
                                }

                            } catch (erro) {
                                mostrarModalConfirmacao('Erro ao confirmar reserva. Tente novamente.');
                                console.error(erro);
                            }
                        });
                    });
                });
            }
        }

    } catch (err) {
        console.error('Erro ao carregar eventos:', err);
    }
});
