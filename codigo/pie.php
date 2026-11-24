<footer class="pie-pagina text-center py-4">
    <div class="container">
        <p class="mb-1">Conservatorio de las Artes · Escuela de Música</p>
        <p class="mb-0 small">Guadalajara, Jalisco · &copy; <?= date('Y') ?></p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
// Scripts propios de cada página: la página define $scripts = ['archivo.js'] antes de
// hacer require del pie. Se cargan después de Bootstrap, desde la carpeta js/.
// $base corrige la ruta cuando la página está dentro de admin/.
foreach ($scripts ?? [] as $archivoJs):
?>
<script src="<?= $base ?? '' ?>js/<?= htmlspecialchars($archivoJs, ENT_QUOTES, 'UTF-8') ?>"></script>
<?php endforeach; ?>
</body>
</html>
