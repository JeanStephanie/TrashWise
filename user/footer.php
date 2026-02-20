<style>
    .premium-footer {
        background: linear-gradient(135deg, #157347, #198754);
        padding: 22px 0;
        margin-top: 60px;
        color: rgba(255,255,255,0.95);
        font-size: 1rem; /* increased base font */
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .footer-brand {
        font-weight: 700;
        font-size: 1.15rem; /* bigger brand */
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: 0.5px;
    }

    .footer-brand i {
        font-size: 1.3rem;
    }

    .footer-right {
        font-size: 0.95rem; /* increased */
        opacity: 0.9;
    }
</style>

<footer class="premium-footer">
    <div class="container-fluid px-4">
        <div class="footer-content">

            <!-- LEFT -->
            <div class="footer-brand">
                <i class="bi bi-recycle"></i>
                TrashWise
            </div>

            <!-- RIGHT -->
            <div class="footer-right">
                © <?= date("Y") ?> All rights reserved.
            </div>

        </div>
    </div>
</footer>
