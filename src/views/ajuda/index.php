<!DOCTYPE html>
 <html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Central de Ajuda</title>
  <link rel="stylesheet" href="src/assets/css/ajuda.css">
  <link rel="stylesheet" href="src/assets/css/chat.css">
</head>
 <body>
  <?php include_once './src/components/head.php'; ?>
  <?php include_once './src/components/header.php'; ?>

  <main>
    <div class="central-ajuda-container">
      <h1>Central de Ajuda</h1>

      <div class="ajuda-grid">
        <div class="ajuda-coluna">
          <h3>Minha Conta</h3>
          <button class="pergunta" onclick="abrirModal('criarConta')">Como criar uma conta no sistema?</button>
          <button class="pergunta" onclick="abrirModal('redefinirSenha')">Como redefinir minha senha?</button>
          <button class="pergunta" onclick="abrirModal('alterarPerfil')">Como alterar meus dados de perfil?</button><br>

          <h3>Permissões e Acessos</h3>
          <button class="pergunta" onclick="abrirModal('acessoAdmin')">Quem pode acessar áreas administrativas?</button>
          <button class="pergunta" onclick="abrirModal('tiposPermissao')">Quais são os tipos de permissão no
            sistema?</button><br>

          <h3>Boas Práticas</h3>
          <button class="pergunta" onclick="abrirModal('boasPraticas')">Como evitar conflitos de
            agendamento?</button><br>
        </div>

        <div class="ajuda-coluna">
          <h3>Reservas e Agendamentos</h3>
          <button class="pergunta" onclick="abrirModal('editarReserva')">Como editar ou cancelar uma reserva?</button>
          <button class="pergunta" onclick="abrirModal('historicoReservas')">Como visualizar o histórico de
            reservas?</button>
          <button class="pergunta" onclick="abrirModal('navegarCalendario')">Como navegar no calendário?</button>
          <button class="pergunta" onclick="abrirModal('navegarDisponibilidade')">Como visualizar a disponibilidade dos
            espaços?</button><br>
        <?php if (isAdmin()): ?>
          <h3>Cadastros</h3>
          <button class="pergunta" onclick="abrirModal('cadEspaco')">Como cadastrar um novo espaço?</button>
          <button class="pergunta" onclick="abrirModal('cadTipoEspaco')">Como cadastrar um tipo de espaço?</button>
          <button class="pergunta" onclick="abrirModal('cadEvento')">Como cadastrar um evento?</button>
          <button class="pergunta" onclick="abrirModal('cadDisciplina')">Como cadastrar uma disciplina?</button>
          <button class="pergunta" onclick="abrirModal('cadCurso')">Como cadastrar um curso?</button><br>
        <?php endif; ?>
          <h3>Configurações</h3>
          <button class="pergunta" onclick="abrirModal('navegarConfiguracoes')">Como acessar e usar as configurações do
            sistema?</button><br>
        </div>

        <div class="ajuda-coluna">
          <h3>Dúvidas Frequentes (FAQ)</h3>
          <button class="pergunta" onclick="abrirModal('faqEspacos')">Por que não consigo visualizar certos
            espaços?</button>
          <button class="pergunta" onclick="abrirModal('faqStatus')">O que significa o status "pendente"?</button><br>

          <h3>Suporte e Contato</h3>
          <button class="pergunta" onclick="abrirModal('reportarErro')">Como reportar um problema técnico?</button>
          <button class="pergunta" onclick="abrirModal('contatoSuporte')">Como entrar em contato com o
            administrador?</button><br>
        </div>
      </div>
    </div>
  </main>

  <div id="modal-ajuda" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-btn" onclick="fecharModal()">&times;</span>
      <h2 id="modal-titulo"></h2>
      <p id="modal-texto"></p>
    </div>
  </div>


  <button class="chatbot-toggler" onclick="toggleChat()">💬</button>

  <div class="chatbot-window">
    <div class="chat-header">
      <h3>Assistente EasyLab</h3>
      <span class="close-chat" onclick="toggleChat()">&times;</span>
    </div>

    <div class="chat-body" id="chat-box">
    </div>

    <div class="chat-footer">
      Selecione uma opção acima para interagir
    </div>
  </div>

  <?php include_once './src/components/footer.php'; ?>

  <script>
    const conteudoModal = {
      navegarCalendario: { titulo: 'Como navegar no calendário?', texto: 'Use o menu lateral para acessar o calendário e visualizar reservas.' },
      navegarDisponibilidade: { titulo: 'Como visualizar a disponibilidade?', texto: 'Vá até "Disponibilidade" no menu lateral.' },
      navegarConfiguracoes: { titulo: 'Como acessar configurações?', texto: 'Clique em "Configurações" no menu lateral.' },
      cadEspaco: { titulo: 'Como cadastrar espaço?', texto: 'Acesse "Espaços" e clique em "Adicionar Espaço".' },
      cadTipoEspaco: { titulo: 'Como cadastrar tipo de espaço?', texto: 'Vá até "Tipo Espaço" e clique em "Adicionar Tipo".' },
      cadEvento: { titulo: 'Como cadastrar evento?', texto: 'Na aba "Eventos", clique em "Novo Evento".' },
      cadDisciplina: { titulo: 'Como cadastrar disciplina?', texto: 'Acesse "Disciplinas" e clique em "Adicionar Disciplina".' },
      cadCurso: { titulo: 'Como cadastrar curso?', texto: 'Vá até "Cursos" e clique em "Adicionar Curso".' },
      criarConta: { titulo: 'Como criar conta?', texto: 'O administrador cria sua conta ou você se registra se habilitado.' },
      redefinirSenha: { titulo: 'Como redefinir senha?', texto: 'Clique em "Esqueci minha senha" na tela de login.' },
      alterarPerfil: { titulo: 'Alterar perfil?', texto: 'Clique na sua foto e acesse "Meu perfil".' },
      acessoAdmin: { titulo: 'Quem acessa o admin?', texto: 'Apenas Gerentes e Administradores.' },
      tiposPermissao: { titulo: 'Tipos de permissão', texto: 'Usuário, Gerente e Administrador.' },
      editarReserva: { titulo: 'Editar reserva?', texto: 'Clique na reserva no calendário e escolha Editar/Cancelar.' },
      historicoReservas: { titulo: 'Histórico de reservas?', texto: 'Vá ao seu perfil > "Minhas Reservas".' },
      faqEspacos: { titulo: 'Espaço não visível?', texto: 'Pode ser falta de permissão ou manutenção.' },
      faqStatus: { titulo: 'Status Pendente?', texto: 'Reserva aguardando aprovação do responsável.' },
      reportarErro: { titulo: 'Reportar erro', texto: 'Envie um print para o suporte técnico.' },
      contatoSuporte: { titulo: 'Contato admin', texto: 'Envie e-mail para admin@easylab.com.' },
      boasPraticas: { titulo: 'Evitar conflitos', texto: 'Verifique a disponibilidade antes de reservar.' }
    };

    const fluxoChat = {
      "inicio": {
        msg: "Olá, Sou o assistente virtual do EasyLab.<br>Selecione um assunto abaixo:<br>",
        opcoes: [
          { label: "Minha Conta", next: "menu_conta" },
          { label: "Reservas de Salas", next: "menu_reservas" },
          { label: "Regras e Infra", next: "menu_regras" },
          { label: "Suporte e Contato", next: "menu_suporte" }
        ]
      },

      "menu_conta": {
        msg: "O que você precisa sobre sua conta?",
        opcoes: [
          { label: "Esqueci a Senha", next: "resp_senha" },
          { label: "Criar Conta", next: "resp_criar" },
          { label: "Alterar Perfil", next: "resp_perfil" },
          { label: "Voltar", next: "inicio" }
        ]
      },
      "resp_senha": {
        msg: "<strong>Redefinir Senha:</strong><br>Na tela de login, clique no link 'Esqueci minha senha'. Um email será enviado para você redefinir.",
        opcoes: [{ label: "Voltar", next: "menu_conta" }, { label: "Início", next: "inicio" }]
      },
      "resp_criar": {
        msg: "<strong>Criar Conta:</strong><br> Clique em 'Cadastre-se' na tela de login.",
        opcoes: [{ label: "Voltar", next: "menu_conta" }]
      },
      "resp_perfil": {
        msg: "<strong>Alterar Dados:</strong><br>Faça login, clique no seu nome no topo direito e vá em 'Meu Perfil'.",
        opcoes: [{ label: "Voltar", next: "menu_conta" }]
      },

      "menu_reservas": {
        msg: "Qual sua dúvida sobre reservas?",
        opcoes: [
          { label: "Como Reservar?", next: "resp_como_reservar" },
          { label: "Cancelar Reserva", next: "resp_cancelar" },
          { label: "Status Pendente", next: "resp_pendente" },
          { label: "Voltar", next: "inicio" }
        ]
      },
      "resp_como_reservar": {
        msg: "<strong>Para Reservar:</strong><br>1. Vá ao menu Calendário.<br>2. Clique no horário livre.<br>3. Escolha a sala e confirme.",
        opcoes: [{ label: "Voltar", next: "menu_reservas" }]
      },
      "resp_cancelar": {
        msg: "<strong>Cancelar:</strong><br>Acesse 'O Calendário' no seu perfil ou clique na reserva no calendário e escolha 'Cancelar'.",
        opcoes: [{ label: "Voltar", next: "menu_reservas" }]
      },
      "resp_pendente": {
        msg: "<strong>Pendente:</strong><br>Significa que você reservou, mas o coordenador ainda precisa aprovar.",
        opcoes: [{ label: "Voltar", next: "menu_reservas" }]
      },

      "menu_regras": {
        msg: "Regras e Infraestrutura:",
        opcoes: [
          { label: "Pegar Chaves", next: "resp_chave" },
          { label: "Ar Condicionado", next: "resp_ar" },
          { label: "Proibido", next: "resp_comida" },
          { label: "Voltar", next: "inicio" }
        ]
      },
      "resp_chave": {
        msg: "<strong>Chaves:</strong><br>Sala dos Professores ou na CRADT.",
        opcoes: [{ label: "Voltar", next: "menu_regras" }]
      },
      "resp_ar": {
        msg: "❄️ <strong>Ar Condicionado:</strong><br>O controle fica fixado na parede ou na sala dos Professores.",
        opcoes: [{ label: "Voltar", next: "menu_regras" }]
      },
      "resp_comida": {
        msg: "<strong>Proibido:</strong><br>Não é permitido comer ou beber dentro dos laboratórios.",
        opcoes: [{ label: "Voltar", next: "menu_regras" }]
      },

      "menu_suporte": {
        msg: "Suporte Técnico:",
        opcoes: [
          { label: "E-mail de Suporte", next: "resp_email" },
          { label: "Telefone", next: "resp_tel" },
          { label: "Reportar Erro", next: "resp_erro" },
          { label: "Voltar", next: "inicio" }
        ]
      },
      "resp_email": {
        msg: "<strong>E-mail:</strong><br>admin@easylab.com",
        opcoes: [{ label: "Voltar", next: "menu_suporte" }]
      },
      "resp_tel": {
        msg: "<strong>Ramal:</strong> 1234",
        opcoes: [{ label: "Voltar", next: "menu_suporte" }]
      },
      "resp_erro": {
        msg: "Tire um print e envie para o e-mail de suporte.",
        opcoes: [{ label: "Voltar", next: "menu_suporte" }]
      }
    };

    function abrirModal(chave) {
      const modal = document.getElementById('modal-ajuda');
      const titulo = document.getElementById('modal-titulo');
      const texto = document.getElementById('modal-texto');
      if (conteudoModal[chave]) {
        titulo.textContent = conteudoModal[chave].titulo;
        texto.textContent = conteudoModal[chave].texto;
        modal.style.display = 'flex';
      }
    }
    function fecharModal() { document.getElementById('modal-ajuda').style.display = 'none'; }
    window.onclick = function (e) { if (e.target === document.getElementById('modal-ajuda')) fecharModal(); };


    function toggleChat() {
      document.body.classList.toggle("show-chatbot");
      const chatBox = document.getElementById('chat-box');
      if (chatBox.children.length === 0) {
        renderizarPasso("inicio");
      }
    }

    function renderizarPasso(passoId) {
      const dados = fluxoChat[passoId];
      if (!dados) return;

      const chatBox = document.getElementById('chat-box');

      const divMsg = document.createElement('div');
      divMsg.classList.add('message', 'bot-msg');
      divMsg.innerHTML = dados.msg;
      chatBox.appendChild(divMsg);

      if (dados.opcoes && dados.opcoes.length > 0) {
        const divOptions = document.createElement('div');
        divOptions.classList.add('options-container');

        dados.opcoes.forEach(opcao => {
          const btn = document.createElement('button');
          btn.classList.add('chat-option-btn');
          btn.textContent = opcao.label;

          btn.onclick = () => {
            divOptions.remove();
            adicionarMensagemUsuario(opcao.label);
            exibirDigitando();

            setTimeout(() => {
              removerDigitando();
              renderizarPasso(opcao.next);
            }, 500);
          };
          divOptions.appendChild(btn);
        });
        chatBox.appendChild(divOptions);
      }
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function adicionarMensagemUsuario(texto) {
      const chatBox = document.getElementById('chat-box');
      const div = document.createElement('div');
      div.classList.add('message', 'user-msg');
      div.textContent = texto;
      chatBox.appendChild(div);
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function exibirDigitando() {
      const chatBox = document.getElementById('chat-box');
      const div = document.createElement('div');
      div.classList.add('message', 'bot-msg');
      div.id = 'loading-dots';
      div.innerHTML = "<em>...</em>";
      chatBox.appendChild(div);
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function removerDigitando() {
      const el = document.getElementById('loading-dots');
      if (el) el.remove();
    }
  </script>
 </body>
</html>