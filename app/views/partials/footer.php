<!-- Boxicons JS -->
<script src='https://unpkg.com/boxicons@2.1.4/dist/boxicons.js'></script>

<!-- JS base -->
<script src="/public/js/funcion.js"></script>



<!-- Tus JS por página -->
<?php if (!empty($custom_js)): ?>
    <?php foreach ($custom_js as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
