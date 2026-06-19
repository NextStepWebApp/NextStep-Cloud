<?php
require_once "utils.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextStep - Alumni Tracking for Schools</title>
    <link rel="stylesheet" href="css/style_marketing.css"/>
    <link rel="stylesheet" href="css/style_navbar.css"/>
    <link rel="icon" type="image/x-icon" href="images/logo.webp"/>

       
</head>
<body class="theme-blue">

    <nav class="navbar">
        <a href="<?php echo $base_url; ?>" class="brand-name">NextStep</a>
        <div class="nav-buttons">
            <a href="<?php echo $base_url; ?>/alumni/" class="nav-btn">For Alumni</a>
            <a href="<?php echo $base_url; ?>/login/" class="nav-btn">Login</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Free for Schools — Donation Supported
            </div>
            <h1>Keep Track of Your <span>Alumni</span> After Graduation</h1>
            <p>NextStep Cloud Bridge connects your self-hosted alumni system to the web. Let graduates update their information themselves — no manual data entry needed.</p>
            <div class="hero-buttons">
                <a href="<?php echo $base_url; ?>/request/" class="btn-primary">
                    <span>Request School Access</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <a href="https://github.com/NextStepWebApp" target="_blank" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    <span>View on GitHub</span>
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-number">Self-Hosted</div>
                    <div class="hero-stat-label">Your Data Stays Local</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">Cloud Bridge</div>
                    <div class="hero-stat-label">Alumni Submit Online</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">Secure</div>
                    <div class="hero-stat-label">Access Code System</div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works" id="how">
        <div class="section-header">
            <span class="section-label">How It Works</span>
            <h2>Three Simple Steps</h2>
            <p>From setup to your first alumni submission in minutes. No complex configuration required.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Request Access</h3>
                <p>Fill out the request form with your school details. We review and create your cloud bridge account manually.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Connect Your Local System</h3>
                <p>Copy your Bridge ID and API Key into your local NextStep settings. Your system now knows where to sync from.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Share with Alumni</h3>
                <p>Generate access codes and share them with graduates. They fill out their info online — you sync it locally.</p>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-header">
            <span class="section-label">Features</span>
            <h2>Built for Schools</h2>
            <p>Everything you need to stay connected with your graduates without the complexity.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Access Code System</h3>
                <p>Generate unique codes for each graduate. Once used, the code is destroyed. No spam, no duplicates, no unauthorized access.</p>
            </div>
            <div class="feature-card">
                <h3>Self-Hosted Data</h3>
                <p>Your alumni database stays on your local server. The cloud only acts as a temporary relay — data is never stored permanently online.</p>
            </div>
            <div class="feature-card">
                <h3>One-Click Sync</h3>
                <p>Your local NextStep system fetches new submissions automatically. Review and approve before importing into your database.</p>
            </div>
            <div class="feature-card">
                <h3>Branded Forms</h3>
                <p>Each school gets a personalized form page with their name. Alumni see a professional, trustworthy interface.</p>
            </div>
            <div class="feature-card">
                <h3>Rate-Limited & Secure</h3>
                <p>Built-in protection against brute-force attacks. IP-based and per-school rate limits keep your forms safe.</p>
            </div>
            <div class="feature-card">
                <h3>Free to Use</h3>
                <p>No subscriptions, no hidden fees. NextStep is donation-supported. If it helps your school, consider a small contribution.</p>
            </div>
        </div>
    </section>

    <section class="ecosystem" id="ecosystem">
        <div class="section-header">
            <span class="section-label">The NextStep Ecosystem</span>
            <h2>More Than Just a Cloud Bridge</h2>
            <p>NextStep is a complete suite of tools designed to make alumni tracking effortless for schools of any size.</p>
        </div>
        <div class="eco-grid">
            <div class="eco-card">
                <span class="eco-tag">Web App</span>
                <h3>NextStep Local</h3>
                <p>The core alumni tracking system. Self-hosted on your school's server with full control over your data. Manage teachers, students, alumni records, and generate reports.</p>
                <div class="eco-links">
                    <a href="https://github.com/NextStepWebApp/NextStep" target="_blank" class="eco-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        View on GitHub
                    </a>
                    <a href="#" class="eco-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Documentation
                    </a>
                </div>
            </div>
            <div class="eco-card">
                <span class="eco-tag">Deploy</span>
                <h3>NextStep Deploy</h3>
                <p>A one-line bash installer that sets up Arch Linux and the NextStep web app automatically. Perfect for schools without a dedicated IT team. One command, fully configured server.</p>
                <div class="eco-links">
                    <a href="https://github.com/NextStepWebApp/NextStep-Deploy" target="_blank" class="eco-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        View on GitHub
                    </a>
                    <a href="#" class="eco-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                        Watch Setup Video
                    </a>
                </div>
            </div>
            <div class="eco-card">
                <span class="eco-tag">Package Manager</span>
                <h3>nstep</h3>
                <p>An open-source package manager written in Go. Update your NextStep web app with a single command. Roll back to previous versions instantly. Designed for non-technical users managing a self-hosted system.</p>
                <div class="eco-links">
                    <a href="https://github.com/NextStepWebApp/nstep" target="_blank" class="eco-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        View on GitHub
                    </a>
                    <a href="#" class="eco-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Documentation
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="architecture" id="architecture">
        <div class="section-header">
            <span class="section-label">Architecture</span>
            <h2>Privacy-First Design</h2>
            <p>The cloud never stores your alumni data permanently. It only acts as a temporary bridge between graduates and your local system.</p>
        </div>
        <div class="arch-diagram">
            <div class="arch-box local">
                <h4>Local NextStep</h4>
                <p>Self-hosted at your school<br>Stores all alumni data<br>Syncs via API</p>
            </div>
            <div class="arch-arrow">⇄</div>
            <div class="arch-box cloud">
                <h4>Cloud Bridge</h4>
                <p>Temporary form hosting<br>Code validation<br>JSON relay only</p>
            </div>
            <div class="arch-arrow">→</div>
            <div class="arch-box local">
                <h4>Alumni</h4>
                <p>Fill form with code<br>Data submitted<br>Auto-deleted after sync</p>
            </div>
        </div>
    </section>

    <section class="cta-section" id="request">
        <h2>Ready to Connect with Your Alumni?</h2>
        <p>Request access for your school today. We'll review your application and set up your cloud bridge within 24 hours.</p>
        <a href="<?php echo $base_url; ?>/request/" class="cta-btn">
            <span>Request School Access</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </section>

    <footer class="footer">
        <div class="footer-brand">NextStep</div>
        <p>Alumni Tracking Cloud Bridge — Part of the NextStep Ecosystem</p>
        <div class="footer-links">
            <a href="https://github.com/NextStepWebApp/NextStep" target="_blank">NextStep Local</a>
            <a href="https://github.com/NextStepWebApp/NextStep-Deploy" target="_blank">NextStep Deploy</a>
            <a href="https://github.com/NextStepWebApp/nstep" target="_blank">nstep</a>
            <a href="/alumni">For Alumni</a>
            <a href="<?php echo $base_url; ?>/request/">Request Access</a>
        </div>
    </footer>

</body>
</html>