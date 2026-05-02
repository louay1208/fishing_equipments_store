</main>

<!-- Footer Wave -->
<div class="footer-wave" style="position:relative;height:50px;overflow:hidden;background:transparent;">
    <svg viewBox="0 0 1200 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
         style="position:absolute;bottom:0;left:0;width:200%;height:50px;animation:wave-drift 18s linear infinite;">
        <path d="M0,25 C150,50 350,0 600,25 C850,50 1050,0 1200,25 L1200,50 L0,50Z" fill="#0c4a6e"/>
        <path d="M0,35 C200,10 400,45 600,30 C800,15 1000,45 1200,35 L1200,50 L0,50Z" fill="#0c4a6e" opacity="0.5"/>
    </svg>
</div>

<footer class="site-footer mt-auto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <p class="mb-0"><strong>Pêche Marine TN</strong></p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center gap-3" style="font-size:0.85rem;">
                    <a href="/about" class="text-decoration-none" style="color:inherit; opacity:0.8;">À propos</a>
                    <a href="/faq" class="text-decoration-none" style="color:inherit; opacity:0.8;">FAQ</a>
                    <a href="/contact" class="text-decoration-none" style="color:inherit; opacity:0.8;">Contact</a>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <p class="mb-0">&copy; <?= date('Y') ?> Pêche Marine TN</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
