</div> <!-- end container -->

<footer class="py-4 mt-auto">
    <div class="container">
        <div class="text-center text-muted">
            <small>
                <i class="bi bi-mortarboard me-1"></i>
                PPDB Online &copy; <?= date('Y'); ?> - Sistem Penerimaan Peserta Didik Baru
            </small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($useDataTable)): ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelPendaftar').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json'
                },
                pageLength: 10,
                responsive: true
            });
        });
    </script>
<?php endif; ?>
</body>
</html>
