<?php
include_once './src/components/head.php';
include_once './src/components/header.php';
?>
<html>
 <link rel="stylesheet" href="src/assets/css/welcome.css">
  <body class="no-scroll">
   <main class="welcome-page">

     <button id="welcomePlay" class="play-btn" aria-expanded="false">
      <span class="play-icon">▶</span>
      <span class="play-label">Apresentação</span>
     </button>

     <section id="welcomeCard" class="welcome-card" hidden>
      <div class="welcome-typed">
       <h1 data-type="Bem-vindo"></h1>
       <p data-type="O EasyLab é uma plataforma inteligente desenvolvida para transformar a forma como o IFPE Campus Igarassu organiza e gerencia o uso de salas e laboratórios. Criado para facilitar a vida de professores e servidores, o sistema reúne em um só lugar todas as informações necessárias para administrar os espaços de maneira simples e eficiente."></p>
       <p data-type="Com o EasyLab, é possível reservar salas e laboratórios de forma prática, evitando conflitos de horários e garantindo que cada espaço seja utilizado da melhor maneira possível. Ao centralizar o controle das reservas, a plataforma elimina a falta de informação e traz mais organização para o dia a dia acadêmico, promovendo um ambiente de trabalho mais produtivo e colaborativo para todos."></p>
      </div>
     </section>
   </main>
  </body>
 </html>

<script>
(function(){
  const btn   = document.getElementById('welcomePlay');
  const card  = document.getElementById('welcomeCard');
  const nodes = Array.from(card.querySelectorAll('[data-type]'));
  let animating = false, openedOnce = false;
  const sleep = ms => new Promise(r => setTimeout(r, ms));

  async function windyType(el, text, {
    step = 28, jitter = 35, wordGap = 160, startDelay = 80,
    caret = false                    // <— NOVO
  } = {}){
    el.textContent = '';
    el.classList.add('typeline');
    if (caret) el.classList.add('typing-caret'); else el.classList.remove('typing-caret');

    let delay = startDelay;
    const words = text.split(' ');
    for (let w = 0; w < words.length; w++){
      const word = words[w];
      const wordSpan = document.createElement('span');
      wordSpan.className = 'word';
      el.appendChild(wordSpan);

      for (let i = 0; i < word.length; i++){
        const ch = word[i];
        const span = document.createElement('span');
        span.className = 'char';
        span.textContent = ch;
        const dx  = (Math.random()*10 - 5).toFixed(1);
        const dy  = (6 + Math.random()*10).toFixed(1);
        const rot = (Math.random()*2 - 1).toFixed(2);
        span.style.setProperty('--dx', dx+'px');
        span.style.setProperty('--dy', dy+'px');
        span.style.setProperty('--rot', rot+'deg');
        span.style.animationDelay = `${delay}ms`;
        wordSpan.appendChild(span);
        delay += step + Math.random()*jitter;
      }
      delay += wordGap;
    }
    await sleep(delay + 300);
    el.classList.remove('typing-caret');
  }

  async function runSequence(){
    animating = true;
    for (const el of nodes){
      const text = el.getAttribute('data-type') || '';
      if (el.tagName === 'H1') {
        await windyType(el, text, { step: 28, jitter: 35, wordGap: 160, startDelay: 80, caret: true });
      } else {
        await windyType(el, text, { step: 10, jitter: 15, wordGap: 60, startDelay: 20, caret: false });
      }
      await sleep(120);
    }
    animating = false; openedOnce = true;
  }

  function reset(){
    nodes.forEach(el => { el.textContent = ''; el.classList.remove('typeline','typing-caret'); });
    animating = false; openedOnce = false;
  }

  btn.addEventListener('click', async () => {
    const open = btn.getAttribute('aria-expanded') === 'true';
    if (!open){
      btn.setAttribute('aria-expanded','true');
      card.hidden = false; void card.offsetHeight; card.classList.add('open');
      if (!openedOnce && !animating) await runSequence();
    } else {
      btn.setAttribute('aria-expanded','false');
      card.classList.remove('open');
      setTimeout(() => { card.hidden = true; reset(); }, 420);
    }
  });
})();
</script>
 <?php include_once './src/components/footer.php'; ?>