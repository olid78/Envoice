<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - SaaS Invoicing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="index.php"><?php echo APP_NAME; ?></a>
            <div class="ms-auto">
                <a href="index.php?page=login" class="btn btn-link text-decoration-none">Login</a>
                <a href="index.php?page=signup" class="btn btn-primary px-4">Sign Up</a>
            </div>
        </div>
    </nav>

    <header class="py-5 bg-white">
        <div class="container py-5 text-center">
            <h1 class="display-4 fw-bold mb-4">Invoicing for Freelancers <br>Made Simple.</h1>
            <p class="lead text-muted mb-5">Create professional invoices, track payments, and manage your clients <br>all in one place with Envoice.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="index.php?page=signup" class="btn btn-primary btn-lg px-5">Get Started for Free</a>
                <a href="#features" class="btn btn-outline-secondary btn-lg px-5">Learn More</a>
            </div>
        </div>
    </header>

    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Everything you need to scale</h2>
                <p class="text-muted">Powerful features designed to help your business grow.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="h1 text-primary mb-3">📄</div>
                        <h3>Professional Invoices</h3>
                        <p class="text-muted">Create and send professional-looking invoices in seconds with our dynamic builder.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="h1 text-primary mb-3">👥</div>
                        <h3>Client Management</h3>
                        <p class="text-muted">Keep all your client information organized in one place for easy access.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="h1 text-primary mb-3">📊</div>
                        <h3>Smart Dashboard</h3>
                        <p class="text-muted">Track your revenue and payment status at a glance with our intuitive dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">How Envoice Works</h2>
                <p class="text-muted">Three simple steps to professional billing.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="step-number">1</div>
                    <h4>Set Up Profile</h4>
                    <p class="text-muted">Register and add your business details and logo for a professional look.</p>
                </div>
                <div class="col-md-4">
                    <div class="step-number">2</div>
                    <h4>Add Clients</h4>
                    <p class="text-muted">Import or manually add your clients' contact and billing information.</p>
                </div>
                <div class="col-md-4">
                    <div class="step-number">3</div>
                    <h4>Send & Get Paid</h4>
                    <p class="text-muted">Create invoices, share public links, and record payments as they arrive.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SaaS Advantage Section -->
    <section class="py-5 bg-dark-section">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4">The SaaS Advantage</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3">✨ <strong>Cloud-Based:</strong> Access your data from anywhere, anytime.</li>
                        <li class="mb-3">🔒 <strong>Secure:</strong> Your data is encrypted and backed up automatically.</li>
                        <li class="mb-3">📱 <strong>Multi-Device:</strong> Works perfectly on Desktop, Tablet, and Mobile.</li>
                        <li class="mb-3">🚀 <strong>No Installation:</strong> Run your business directly from your browser.</li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <div class="p-5 bg-primary rounded-4 shadow-lg text-white">
                        <h3>Built for Modern Freelancers</h3>
                        <p class="mb-0">Join thousands who have simplified their billing workflow with Envoice.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Simple, Transparent Pricing</h2>
                <p class="text-muted">Choose the plan that fits your business stage.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card pricing-card p-4 text-center">
                        <h4 class="fw-bold">Student</h4>
                        <h2 class="fw-bold text-primary mb-3">$0 <small class="text-muted fs-6">/mo</small></h2>
                        <ul class="list-unstyled mb-4 text-start">
                            <li>✅ Up to 5 Clients</li>
                            <li>✅ Unlimited Invoices</li>
                            <li>✅ Standard PDF Export</li>
                            <li>❌ Remove Envoice Branding</li>
                        </ul>
                        <a href="index.php?page=signup" class="btn btn-outline-primary">Get Started</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card pricing-card p-4 text-center border-primary shadow">
                        <div class="badge bg-primary mb-2 align-self-center">MOST POPULAR</div>
                        <h4 class="fw-bold">Freelancer</h4>
                        <h2 class="fw-bold text-primary mb-3">$15 <small class="text-muted fs-6">/mo</small></h2>
                        <ul class="list-unstyled mb-4 text-start">
                            <li>✅ Unlimited Clients</li>
                            <li>✅ Unlimited Invoices</li>
                            <li>✅ Premium PDF Templates</li>
                            <li>✅ Custom Logo Branding</li>
                        </ul>
                        <a href="index.php?page=signup" class="btn btn-primary">Try 14 Days Free</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card pricing-card p-4 text-center">
                        <h4 class="fw-bold">Agency</h4>
                        <h2 class="fw-bold text-primary mb-3">$45 <small class="text-muted fs-6">/mo</small></h2>
                        <ul class="list-unstyled mb-4 text-start">
                            <li>✅ Everything in Freelancer</li>
                            <li>✅ Multi-User Support</li>
                            <li>✅ Priority 24/7 Support</li>
                            <li>✅ API Access</li>
                        </ul>
                        <a href="index.php?page=signup" class="btn btn-outline-primary">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a href="index.php" class="h3 text-decoration-none fw-bold text-primary d-block mb-3"><?php echo APP_NAME; ?></a>
                    <p class="text-muted">Envoice is a leading SaaS platform built to help freelancers and small business owners streamline their billing process and manage clients with ease.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon">f</a>
                        <a href="#" class="social-icon">t</a>
                        <a href="#" class="social-icon">in</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-bold mb-3">Product</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#features" class="footer-link">Features</a></li>
                        <li class="mb-2"><a href="#pricing" class="footer-link">Pricing</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Invoice Templates</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Dashboard API</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-bold mb-3">Resources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Documentation</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h6 class="fw-bold mb-3">Join Our Community</h6>
                    <p class="text-muted small">Subscribe to get the latest updates on invoicing features and freelancer tips.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email Address">
                        <button class="btn btn-primary">Join</button>
                    </div>
                    <p class="text-muted small mb-0">Contact: support@envoice.com</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-muted mb-0">&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?> SaaS. Built by Sodiol Abdullah Olid.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="index.php?page=signup" class="btn btn-primary btn-sm px-4">Get Started for Free</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
