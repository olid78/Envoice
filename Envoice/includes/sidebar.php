<div class="sidebar d-flex flex-column p-3">
    <a href="index.php?page=dashboard" class="h3 text-decoration-none fw-bold text-primary mb-4"><?php echo APP_NAME; ?></a>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php?page=dashboard" class="nav-link <?php echo $page == 'dashboard' ? 'active' : 'text-dark'; ?>">
                Dashboard
            </a>
        </li>
        <li>
            <a href="index.php?page=clients" class="nav-link <?php echo $page == 'clients' || $page == 'add_client' || $page == 'edit_client' ? 'active' : 'text-dark'; ?>">
                Clients
            </a>
        </li>
        <li>
            <a href="index.php?page=invoices" class="nav-link <?php echo $page == 'invoices' || $page == 'create_invoice' || $page == 'invoice_detail' ? 'active' : 'text-dark'; ?>">
                Invoices
            </a>
        </li>
        <li>
            <a href="index.php?page=profile" class="nav-link <?php echo $page == 'profile' ? 'active' : 'text-dark'; ?>">
                Profile
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="index.php?page=logout" class="btn btn-outline-danger w-100">Logout</a>
    </div>
</div>
