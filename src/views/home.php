<?php
    include_once './src/components/head.php';
?>

<body class="no-scroll">
    <div id="modalContainer"></div>

    <?php include_once './src/components/header.php'; ?>

    <main>
        <h1>Calendário de Reserva</h1>
        <div class="container">
            <section class="calendar-container">
                <div id='calendar'></div>
            </section>

            <section class="reserva-container">
                <h2>Reservas do Dia</h2>
                <! onde coloquei o botão para ir para disponibilidade !>
                <div id="lista-reservas"></div>
                <div class="btn-disponibilidade-wrapper">
                    <a href="index.php?action=disponibilidade" class="btn-disponibilidade">Ver Disponibilidade</a>
                </div>
            </section>
        </div>
    </main>


    <?php include_once './src/components/footer.php'; ?>
    <script src="./src/fullcalendar-6.1.17/dist/index.global.min.js"></script>
    <script src="./src/assets/js/calendar.js"></script>

    
</body>

</html>