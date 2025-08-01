<?php
include_once './src/components/head.php';
include_once './src/components/header.php';
?>

<body class="no-scroll">
    <main>
    </main>


    <?php include_once './src/components/footer.php'; ?>
    <script src="./src/fullcalendar-6.1.17/dist/index.global.min.js"></script>
    <script src="./src/assets/js/calendar.js"></script>
    <div id="modal-editar" style="display:none;">
        <?php include './src/views/reserva/edit.php'; ?>
    </div>



</body>

</html>